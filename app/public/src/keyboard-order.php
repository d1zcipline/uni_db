<?php

require_once('helpers.php');

$pdo = getPDO();

$user_address = currentUserAddress()['id_address'];
$date = date("Y-m-d H:i:s");

$query = "INSERT INTO orders (`address_id`, `order_date`) VALUES (:address_id, :order_date)";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':address_id', $user_address);
$stmt->bindParam(':order_date', $date);
$stmt->execute();

echo "<script>alert('Заказ оформлен')</script>";
echo "<script>location.replace('../products.php')</script>";
