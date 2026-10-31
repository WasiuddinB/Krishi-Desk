<?php
require_once __DIR__ . '/../server/init.php';

// Pages can set $page_title and $active (home, shop, tutorials, blog, contact) before including this file.
$page_title = isset($page_title) ? $page_title . ' | ' . SITE_NAME : SITE_NAME . ' - Farming made easy';
$active = isset($active) ? $active : '';
$cart_quantity = !empty($_SESSION['quantity']) ? (int)$_SESSION['quantity'] : 0;
$nav = [
    'home' => ['index.php', 'Home'],
    'shop' => ['shop.php', 'Shop'],
    'tutorials' => ['tutorial.php', 'Videos'],
    'blog' => ['blog.php', 'Guides'],
    'contact' => ['contact.php', 'Contact'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($page_title); ?></title>
    <meta name="description" content="KrishiDesk is a one-stop online shop for vegetables, farm machines, pesticides and fertilizers, with farming tutorials and weather forecasts.">
    <link rel="icon" type="image/png" href="assets/imgs/logo22.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@500;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
    <!--NavBar-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top site-nav">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img class="logo" src="assets/imgs/logo22.png" alt="KrishiDesk logo"/>
                <span class="brand">কৃষি<span>Desk</span></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-lg-auto mb-2 mb-lg-0">
                    <?php foreach($nav as $key => $item){ ?>
                    <li class="nav-item">
                        <a class="nav-link <?php if($active === $key){echo 'active';} ?>" href="<?php echo $item[0]; ?>"><?php echo $item[1]; ?></a>
                    </li>
                    <?php } ?>
                </ul>

                <div class="nav-tools d-flex align-items-center">
                    <div class="translate" id="google_translate_element"></div>
                    <a href="weather_forecast.php" class="nav-icon <?php if($active === 'weather'){echo 'active';} ?>" title="Weather forecast" aria-label="Weather forecast"><i class="fas fa-cloud-sun"></i></a>
                    <a href="cart.php" class="nav-icon position-relative <?php if($active === 'cart'){echo 'active';} ?>" title="Cart" aria-label="Cart">
                        <i class="fas fa-shopping-bag"></i>
                        <?php if($cart_quantity > 0){ ?><span class="cart-quantity"><?php echo $cart_quantity; ?></span><?php } ?>
                    </a>
                    <?php if(is_logged_in()){ ?>
                        <a href="account.php" class="nav-icon <?php if($active === 'account'){echo 'active';} ?>" title="My account" aria-label="My account"><i class="fas fa-user"></i></a>
                        <a href="account.php?logout=1" class="nav-icon" title="Log out" aria-label="Log out"><i class="fas fa-sign-out-alt"></i></a>
                    <?php } else { ?>
                        <a href="login.php" class="btn btn-green btn-sm ms-2">Login</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>

    <!--Toasts-->
    <div class="toast-container position-fixed top-0 end-0 p-3 toast-stack">
        <?php foreach(pull_flash() as $msg){ ?>
        <div class="toast align-items-center bg-<?php echo e($msg['type']); ?> <?php echo $msg['type'] === 'warning' ? 'text-dark' : 'text-white'; ?> border-0 site-toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"><?php echo e($msg['message']); ?></div>
                <button type="button" class="btn-close <?php echo $msg['type'] === 'warning' ? '' : 'btn-close-white'; ?> me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <?php } ?>
    </div>

    <main class="page-main">
