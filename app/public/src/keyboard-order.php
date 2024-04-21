<?php

require_once('helpers.php');

$pdo = getPDO();

$keyboard_id = $_POST['keyboard_id'];
$quantity = $_POST['quantity'];

if (!isset($_SESSION['customer']['id_customer'])) {
  echo "<script>alert('Для оформления заказа сперва нужно войти в личный кабинет или зарегистрироваться')</script>";
  echo "<script>location.replace('../products.php')</script>";
} elseif (currentUserAddress() == false) {
  echo "<script>alert('Для оформления заказа нужно добавить адрес в личном кабинете')</script>";
  echo "<script>location.replace('../profile.php')</script>";
} else {
  $user_address = currentUserAddress()['id_address'];
  $date = date("Y-m-d H:i:s");

  $query = "INSERT INTO orders (`address_id`, `order_date`) VALUES (:address_id, :order_date)";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':address_id', $user_address);
  $stmt->bindParam(':order_date', $date);
  $stmt->execute();

  $query = "SELECT k.id_keyboard, k.keyboard_name, k.keyboard_description, k.keyboard_image, kp.keyboard_price, kp.date_from 
          FROM keyboards k
          JOIN keyboards_price kp ON k.id_keyboard = kp.keyboard_id
          WHERE kp.keyboard_id = :keyboard_id";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':keyboard_id', $keyboard_id);
  $stmt->execute();
  $keyboards = $stmt->fetch(PDO::FETCH_ASSOC);

  $query = "SELECT id_order, address_id FROM orders WHERE address_id = :user_address";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':user_address', $user_address);
  $stmt->execute();
  $orders = $stmt->fetch(PDO::FETCH_ASSOC);

  $query = "INSERT INTO orders_keyboards (`order_id`, `keyboard_id`, `quantity`) VALUE (:order_id, :keyboard_id, :quantity)";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':order_id', $orders['id_order']);
  $stmt->bindParam(':keyboard_id', $keyboard_id);
  $stmt->bindParam(':quantity', $quantity);
  $stmt->execute();

  echo "<script>alert('Заказ оформлен')</script>";
  echo "<script>location.replace('../products.php')</script>";
}
