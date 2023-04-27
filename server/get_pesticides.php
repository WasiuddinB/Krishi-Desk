<?php
include('connection.php');

$stmt=$conn->prepare("SELECT * FROM products WHERE product_category='pesticide' LIMIT 4 ");
$stmt->execute();
$pest_products=$stmt->get_result();


?>