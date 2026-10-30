<?php
require_once __DIR__ . '/server/init.php';

$page_title = 'Weather Forecast';
$active = 'weather';

// Set OPENWEATHER_API_KEY in the environment (Vercel project settings) to use your own key.
$api_key = getenv('OPENWEATHER_API_KEY') ?: 'f8f50bb31e786d71e1e5d0a8ba11f81e';

$city = isset($_GET['city']) ? trim($_GET['city']) : '';
$weather = null;
$error = '';

if(isset($_GET['submit'])){
    if($city === ''){
        $error = 'Please enter a city name.';
    }else{
        $url = 'https://api.openweathermap.org/data/2.5/weather?q=' . urlencode($city) . '&units=metric&appid=' . urlencode($api_key);
        $context = stream_context_create(['http' => ['timeout' => 8, 'ignore_errors' => true]]);
        $body = @file_get_contents($url, false, $context);
        $data = $body ? json_decode($body, true) : null;

        if(!$data){
            $error = 'The weather service is not reachable right now. Please try again later.';
        }else if((int)$data['cod'] === 200){
            $weather = $data;
        }else if((int)$data['cod'] === 404){
            $error = 'We could not find "' . $city . '". Check the spelling and try again.';
        }else{
            $error = 'The weather service could not complete the request. Please try again later.';
        }
    }
}
?>
<?php include('layouts/header.php'); ?>

    <section class="page-hero">
      <div class="container">
        <h1>Weather Forecast</h1>
        <p>Check the weather before you plan your day in the field.</p>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="auth-wrap" style="max-width: 560px;">
          <form class="form-card mb-4" method="GET" action="weather_forecast.php">
            <label for="city">Enter your city name</label>
            <div class="input-group">
              <input type="text" class="form-control" name="city" id="city" value="<?php echo e($city); ?>" placeholder="e.g. Dhaka, Chattogram, Rajshahi" required>
              <button type="submit" name="submit" class="btn btn-green">Check</button>
            </div>
          </form>

          <?php if($error){ ?>
            <div class="alert alert-danger" role="alert"><?php echo e($error); ?></div>
          <?php } ?>

          <?php if($weather){
            $icon = $weather['weather'][0]['icon'];
            date_default_timezone_set('Asia/Dhaka');
          ?>
            <div class="weather-card">
              <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                  <h3 class="mb-1"><?php echo e($weather['name']); ?>, <?php echo e($weather['sys']['country']); ?></h3>
                  <p class="mb-0 text-capitalize"><?php echo e($weather['weather'][0]['description']); ?></p>
                </div>
                <img src="https://openweathermap.org/img/wn/<?php echo e($icon); ?>@2x.png" alt="" width="84" height="84"/>
              </div>
              <div class="weather-temp"><?php echo (int)round($weather['main']['temp']); ?>&deg;C</div>
              <div class="weather-grid">
                <div><small>Feels like</small><strong><?php echo (int)round($weather['main']['feels_like']); ?>&deg;C</strong></div>
                <div><small>Humidity</small><strong><?php echo (int)$weather['main']['humidity']; ?>%</strong></div>
                <div><small>Wind speed</small><strong><?php echo e($weather['wind']['speed']); ?> m/s</strong></div>
                <div><small>Cloudiness</small><strong><?php echo (int)$weather['clouds']['all']; ?>%</strong></div>
                <div><small>Pressure</small><strong><?php echo (int)$weather['main']['pressure']; ?> hPa</strong></div>
                <div><small>Sunrise</small><strong><?php echo date('g:i a', $weather['sys']['sunrise']); ?></strong></div>
              </div>
              <p class="mt-3 mb-0 small opacity-75">Times shown in Bangladesh time.</p>
            </div>
          <?php } ?>
        </div>
      </div>
    </section>

<?php include('layouts/footer.php'); ?>
