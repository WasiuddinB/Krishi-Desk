<?php

// Demo payment: records a payment for the order and marks it as paid.
// No real money moves - connect a payment gateway here for a real shop.

require_once __DIR__ . '/init.php';
require_once __DIR__ . '/connection.php';

if(!is_logged_in()){
    flash('warning', 'Please log in first.');
    redirect('../login.php');
}

if(!isset($_POST['pay'], $_POST['order_id'])){
    redirect('../account.php');
}

$order_id = (int)$_POST['order_id'];
$user_id = (int)$_SESSION['user_id'];
$methods = ['bkash' => 'bKash', 'nagad' => 'Nagad', 'card' => 'Card', 'cod' => 'Cash on delivery'];
$method = isset($methods[$_POST['method']]) ? $_POST['method'] : 'card';

$stmt = $conn->prepare("SELECT order_cost, order_status FROM orders WHERE order_id=? AND user_id=?");
$stmt->bind_param('ii', $order_id, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if(!$order){
    flash('danger', 'We could not find that order.');
    redirect('../account.php#orders');
}

if($order['order_status'] === 'paid'){
    flash('info', 'That order is already paid.');
    redirect('../account.php#orders');
}

$transaction_id = strtoupper('TXN' . date('ymd') . bin2hex(random_bytes(4)));
$amount = $order['order_cost'];
// Cash on delivery is confirmed now but paid later.
$new_status = ($method === 'cod') ? 'cash on delivery' : 'paid';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn->begin_transaction();
try{
    $stmt = $conn->prepare("INSERT INTO payments(order_id,user_id,transaction_id,payment_method,amount) VALUES (?,?,?,?,?)");
    $stmt->bind_param('iissd', $order_id, $user_id, $transaction_id, $methods[$method], $amount);
    $stmt->execute();

    $stmt = $conn->prepare("UPDATE orders SET order_status=? WHERE order_id=? AND user_id=?");
    $stmt->bind_param('sii', $new_status, $order_id, $user_id);
    $stmt->execute();
    $conn->commit();
}catch(Throwable $ex){
    $conn->rollback();
    flash('danger', 'The payment could not be recorded. Please try again.');
    redirect('../payment.php?order_id=' . $order_id);
}

if($method === 'cod'){
    flash('success', 'Order #' . $order_id . ' confirmed. Please pay when it is delivered.');
}else{
    flash('success', 'Payment received. Your transaction ID is ' . $transaction_id . '.');
}
redirect('../account.php#orders');

?>
