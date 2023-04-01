<?php
include('connection.php');

$stmt=$conn->prepare("SELECT * FROM products WHERE product_category='vegetable' LIMIT 4 ");
$stmt->execute();
$veg_products=$stmt->get_result();


?>