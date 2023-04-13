<?php
     
if(array_key_exists('submit',$_GET)){
    if(!$_GET['city']){
        $error = "Sorry, your input field is empty";
    }
    if($_GET['city']){
        $apiData=file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=".$_GET['city']."&appid=f8f50bb31e786d71e1e5d0a8ba11f81e");
        $weatherArray = json_decode($apiData,true);

        if($weatherArray['cod'] == 200){
            $tempCelsius = $weatherArray['main']['temp'] - 273;
            $weather = "<b>".$weatherArray['name'].", ".$weatherArray['sys']['country']." : ".intval($tempCelsius)."&deg;C</b> <br>";
            $weather .= "<b>Weather Condition : </b>" .$weatherArray['weather']['0']['description']."<br>";
            $weather .= "<b>Atmospheric Pressure : </b>" .$weatherArray['main']['pressure']." hPa <br>";
            $weather .= "<b>Wind Speed : </b>" .$weatherArray['wind']['speed']." meter/sec <br>";
            $weather .= "<b>Cloudness : </b>" .$weatherArray['clouds']['all']."% <br>";
            
            date_default_timezone_set('Asia/Dhaka');
            $sunrise = $weatherArray['sys']['sunrise'];
            $weather.="<b>Sunrise : </b>".date("g:i a", $sunrise)."<br>";
            $weather.="<b>Current Time : </b>".date("F j, Y, g:i a")."<br>";
        }
        else{
            $error = "Could not be processed, Your city name is not valid";
        }
    }
}
?>




<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.rtl.min.css" integrity="sha384-T5m5WERuXcjgzF8DAb7tRkByEZQGcpraRTinjpywg37AO96WoYN9+hrhDVoM6CaT" crossorigin="anonymous">

    <title>Weather Forecast</title>

    <style>
        body{
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
            background-color: whitesmoke;
            color: black;
            font-family: poppin,'Times New Roman',Times,serif;
            font-size: large;
            background-size: cover;
            background-attachment: fixed;
        }
        .container{
            text-align: center;
            justify-content: center;
            align-items: center;
            width: 440px;
        }
        h1{
            font-weight: 700;
            margin-top: 150px;

        }
        .input{
            width: 350px;
            padding: 5px;
        }
    </style>


  </head>
  <body>
    <div class="container">
        <h1>What's the weather today?</h1>
        <form action="" method="GET">
            <p><label for="city">Enter your city name</label></p>
            <p><input type="text" name="city" id="city" placeholder="City Name"></p>
            <button type="submit" name="submit" class="btn btn-success">Submit Now</button>

            <div class="output mt-3">
                <?php 
                    if($weather){
                        echo '<div class="alert alert-success" role="alert">'.$weather.'</div>' ;
                    }
                    if($error){
                        echo '<div class="alert alert-danger" role="alert">'.$error.'</div>' ;
                    }
                    
                ?>
            </div>
        </form>
    </div>
    

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
    -->
  </body>
</html>