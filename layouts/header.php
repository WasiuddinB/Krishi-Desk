<?php

session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>


    <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
    <!--NavBar-->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 fixed-top">
        <div class="container">
          <img class="logo" src="assets/imgs/logo22.png"/>
          <h2 class="brand">কৃষিDesk</h2>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              
            <span>
              <div class="translate" id="google_translate_element"></div>
              <script type="text/javascript" >
                function googleTranslateElementInit(){ new google.translate.TranslateElement({pageLanguage: 'en'},'google_translate_element')};
              </script>
              <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
            </span>
            
              <li class="nav-item">
                <a class="nav-link" href="tutorial.php">TUTORIALS</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="shop.php">Shop</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Blog</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact Us</a>
              </li>
            </li>

            <li class="nav-item">
              <a href="cart.php">
                <i class="fas fa-shopping-bag">
                  <?php if(isset($_SESSION['quantity']) && $_SESSION['quantity'] != 0) {?>
                    <span class="cart-quantity"><?php echo $_SESSION['quantity']; ?></span>
                  <?php } ?>
                </i>
              </a>


              <a href="account.php"><i class="fas fa-user"></i></a>
              <a href="weather_forecast.php"><i class="fas fa-sun"></i></a>
            </li>
              
            </ul>
            
          </div>
        </div>
      </nav>