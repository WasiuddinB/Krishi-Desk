<?php

require_once __DIR__ . '/init.php';
require_once __DIR__ . '/connection.php';

if(!is_logged_in()){
    $_SESSION['after_login'] = 'checkout.php';
    flash('warning', 'Please login or register to place an order.');
    redirect('../login.php');
}

if(!isset($_POST['place_order']) || empty($_SESSION['cart'])){
    redirect('../cart.php');
}

$phone = trim($_POST['phone']);
$city = trim($_POST['city']);
$address = trim($_POST['address']);

if($phone === '' || $city === '' || $address === ''){
    flash('danger', 'Please fill in all delivery details.');
    redirect('../checkout.php');
}

$user_id = (int)$_SESSION['user_id'];
$order_status = 'not paid';
$order_date = date('Y-m-d H:i:s');

// Work out the total on the server from the cart, using prices stored in the database.
$order_cost = 0;
$lines = [];
foreach($_SESSION['cart'] as $item){
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id=?");
    $stmt->bind_param('i', $item['product_id']);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
    if(!$product){
        continue;
    }
    $price = final_price($product);
    $qty = (int)$item['product_quantity'];
    $order_cost += $price * $qty;
    $lines[] = [$product['product_id'], $product['product_name'], $product['product_image'], $price, $qty];
}

if(empty($lines)){
    unset($_SESSION['cart']);
    recalc_cart();
    flash('danger', 'The items in your cart are no longer available.');
    redirect('../shop.php');
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn->begin_transaction();
try{
    $stmt = $conn->prepare("INSERT INTO orders(order_cost,order_status,user_id,user_phone,user_city,user_address,order_date) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param('dsissss', $order_cost, $order_status, $user_id, $phone, $city, $address, $order_date);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    $stmt1 = $conn->prepare("INSERT INTO order_items(order_id,product_id,product_name,product_image,product_price,product_quantity,user_id,order_date) VALUES (?,?,?,?,?,?,?,?)");
    foreach($lines as $line){
        $stmt1->bind_param('isssdiis', $order_id, $line[0], $line[1], $line[2], $line[3], $line[4], $user_id, $order_date);
        $stmt1->execute();
    }
    $conn->commit();
}catch(Throwable $ex){
    $conn->rollback();
    flash('danger', 'Sorry, we could not place your order. Please try again.');
    redirect('../checkout.php');
}

// The order is saved, so the cart can be emptied.
unset($_SESSION['cart']);
recalc_cart();

flash('success', 'Order #' . $order_id . ' placed successfully. Complete the payment to confirm it.');
redirect('../payment.php?order_id=' . $order_id);

?>
