<?php
require_once __DIR__ . '/server/init.php';

$page_title = 'Weather Forecast';
$active = 'weather';

// Set OPENWEATHER_API_KEY in the environment (Vercel project settings) to use your own key.
$api_key = getenv('OPENWEATHER_API_KEY') ?: 'f8f50bb31e786d71e1e5d0a8ba11f81e';

$districts = ['Dhaka', 'Chattogram', 'Rajshahi', 'Khulna', 'Sylhet', 'Rangpur', 'Barishal', 'Mymensingh', 'Pabna', 'Narayanganj'];
// Older spellings the weather service may know the place by.
$aliases = ['Chattogram' => 'Chittagong', 'Barishal' => 'Barisal', 'Cumilla' => 'Comilla', 'Jashore' => 'Jessore', 'Bogura' => 'Bogra'];

$city = isset($_GET['city']) ? trim($_GET['city']) : 'Dhaka';
if($city === ''){
    $city = 'Dhaka';
}

// Ask the weather service for $endpoint (weather or forecast). Returns [status code, data].
function weather_api($endpoint, $place, $key){
    $url = 'https://api.openweathermap.org/data/2.5/' . $endpoint . '?q=' . urlencode($place) . '&units=metric&appid=' . urlencode($key);
    $context = stream_context_create(['http' => ['timeout' => 8, 'ignore_errors' => true]]);
    $body = @file_get_contents($url, false, $context);
    $data = $body ? json_decode($body, true) : null;
    if(!is_array($data) || !isset($data['cod'])){
        return [0, null];
    }
    return [(int)$data['cod'], $data];
}

$current = null;
$forecast = null;
$error = '';

list($code, $current) = weather_api('weather', $city . ',BD', $api_key);
if($code === 404 && isset($aliases[$city])){
    list($code, $current) = weather_api('weather', $aliases[$city] . ',BD', $api_key);
}
if($code === 404){
    // Not a Bangladeshi place name we know. Try the name on its own.
    list($code, $current) = weather_api('weather', $city, $api_key);
}

if($code !== 200){
    // Do not treat an error reply as weather data.
    $current = null;
}

if($code === 200){
    list($fcode, $forecast) = weather_api('forecast', $current['name'] . ',' . $current['sys']['country'], $api_key);
    if($fcode !== 200){
        $forecast = null;
    }
}else if($code === 404){
    $error = 'We could not find "' . $city . '". Check the spelling or pick a district below.';
}else if($code === 0){
    $error = 'The weather service is not reachable right now. Please try again later.';
}else{
    $error = 'The weather service could not complete the request. Please try again later.';
}

// Group the three-hourly forecast into days and write notes for field work.
$days = [];
$notes = [];
if($forecast){
    $offset = (int)$forecast['city']['timezone'];
    foreach($forecast['list'] as $slot){
        $local = $slot['dt'] + $offset;
        $key = gmdate('Y-m-d', $local);
        if(!isset($days[$key])){
            $days[$key] = ['ts' => $local, 'min' => 100, 'max' => -100, 'pop' => 0, 'rain' => 0, 'icon' => null, 'icon_gap' => 99];
        }
        $d = &$days[$key];
        $d['min'] = min($d['min'], $slot['main']['temp_min']);
        $d['max'] = max($d['max'], $slot['main']['temp_max']);
        $d['pop'] = max($d['pop'], isset($slot['pop']) ? $slot['pop'] : 0);
        $d['rain'] += isset($slot['rain']['3h']) ? $slot['rain']['3h'] : 0;
        // Use the icon from the slot closest to midday.
        $gap = abs((int)gmdate('G', $local) - 12);
        if($gap < $d['icon_gap']){
            $d['icon_gap'] = $gap;
            $d['icon'] = $slot['weather'][0]['icon'];
            $d['text'] = $slot['weather'][0]['description'];
        }
        unset($d);
    }
    $days = array_slice($days, 0, 5, true);

    // Look at the next 48 hours (16 three-hour slots).
    $next = array_slice($forecast['list'], 0, 16);
    $rain_likely = false; $max_wind = 0; $max_temp = -100;
    foreach($next as $slot){
        if((isset($slot['pop']) && $slot['pop'] >= 0.5) || (isset($slot['rain']['3h']) && $slot['rain']['3h'] >= 2)){
            $rain_likely = true;
        }
        $max_wind = max($max_wind, $slot['wind']['speed']);
        $max_temp = max($max_temp, $slot['main']['temp_max']);
    }
    if($rain_likely){
        $notes[] = 'Rain is likely in the next two days. Consider postponing pesticide spraying and fertilizer application, and check that field drainage is clear.';
    }
    if($max_wind >= 8){
        $notes[] = 'Strong winds are expected. Avoid spraying, because the spray can drift away from the crop.';
    }
    if($max_temp >= 35){
        $notes[] = 'It will be very hot. Irrigate and work in the early morning or evening, and rest in the shade during midday.';
    }
    if(!$notes){
        $notes[] = 'Conditions look suitable for most field work over the next two days.';
    }
}
?>
<?php include('layouts/header.php'); ?>

    <section class="page-hero">
      <div class="container">
        <h1>Weather Forecast</h1>
        <p>Check the weather before you plan field work.</p>
      </div>
    </section>

    <section class="section">
      <div class="container" style="max-width: 860px;">
        <form class="form-card mb-3" method="GET" action="weather_forecast.php">
          <label for="city">District or city</label>
          <div class="input-group">
            <input type="text" class="form-control" name="city" id="city" value="<?php echo e($city); ?>" placeholder="e.g. Dhaka, Rajshahi, Pabna" required>
            <button type="submit" class="btn btn-green">Check</button>
          </div>
        </form>

        <div class="district-links text-center mb-4">
          <?php foreach($districts as $name){ ?>
            <a href="weather_forecast.php?city=<?php echo urlencode($name); ?>" class="<?php if(strcasecmp($name, $city) === 0){echo 'active';} ?>"><?php echo e($name); ?></a>
          <?php } ?>
        </div>

        <?php if($error){ ?>
          <div class="alert alert-danger" role="alert"><?php echo e($error); ?></div>
        <?php } ?>

        <?php if($current){ ?>
          <div class="weather-card mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
              <div>
                <h3 class="mb-1"><?php echo e($current['name']); ?>, <?php echo e($current['sys']['country']); ?></h3>
                <p class="mb-0 text-capitalize">Now: <?php echo e($current['weather'][0]['description']); ?></p>
              </div>
              <img src="https://openweathermap.org/img/wn/<?php echo e($current['weather'][0]['icon']); ?>@2x.png" alt="" width="84" height="84"/>
            </div>
            <div class="weather-temp"><?php echo (int)round($current['main']['temp']); ?>&deg;C</div>
            <div class="weather-grid">
              <div><small>Feels like</small><strong><?php echo (int)round($current['main']['feels_like']); ?>&deg;C</strong></div>
              <div><small>Humidity</small><strong><?php echo (int)$current['main']['humidity']; ?>%</strong></div>
              <div><small>Wind</small><strong><?php echo e($current['wind']['speed']); ?> m/s</strong></div>
              <div><small>Cloud cover</small><strong><?php echo (int)$current['clouds']['all']; ?>%</strong></div>
            </div>
          </div>

          <?php if($days){ ?>
            <h4 class="mb-3">Next 5 days</h4>
            <div class="forecast-grid mb-4">
              <?php foreach($days as $i => $day){ ?>
              <div class="forecast-day">
                <strong><?php echo $i === array_key_first($days) ? 'Today' : e(gmdate('D j M', $day['ts'])); ?></strong>
                <img src="https://openweathermap.org/img/wn/<?php echo e($day['icon']); ?>@2x.png" alt="<?php echo e($day['text']); ?>"/>
                <div><?php echo (int)round($day['max']); ?>&deg; / <?php echo (int)round($day['min']); ?>&deg;</div>
                <small>Rain chance <?php echo (int)round($day['pop'] * 100); ?>%</small>
              </div>
              <?php } ?>
            </div>

            <div class="farm-notes">
              <h5 class="mb-0"><i class="fas fa-seedling text-success"></i> Notes for field work</h5>
              <ul>
                <?php foreach($notes as $note){ ?><li><?php echo e($note); ?></li><?php } ?>
              </ul>
              <small class="text-muted">General guidance based on the next 48 hours. For advice on your crop, ask your local Department of Agricultural Extension (DAE) office.</small>
            </div>
          <?php } else { ?>
            <div class="alert alert-warning">The five-day forecast is not available right now.</div>
          <?php } ?>
        <?php } ?>
      </div>
    </section>

<?php include('layouts/footer.php'); ?>
