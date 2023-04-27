<?php
include('connection.php');

$stmt=$conn->prepare("SELECT * FROM products WHERE product_category='machine' LIMIT 4 ");
$stmt->execute();
$machine_products=$stmt->get_result();


?>