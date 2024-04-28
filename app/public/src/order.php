<?php

require_once('functions.php');

$pdo = getPDO();

$status = 'Собирается';

$query = "SELECT * FROM cart WHERE customer_id = :customer_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':customer_id', $_SESSION['customer']['id_customer']);
$stmt->execute();
$carts = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (currentUserAddress() == false) {
  echo "<script>alert('Для оформления заказа нужно добавить адрес в личном кабинете')</script>";
  echo "<script>location.replace('../cart.php')</script>";
} else {
  $user_address = currentUserAddress()['id_address'];
  $date = date("Y-m-d H:i:s");

  $query = "INSERT INTO orders (`address_id`, `order_date`, `status`) VALUES (:address_id, :order_date, :status)";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':address_id', $user_address);
  $stmt->bindParam(':order_date', $date);
  $stmt->bindParam(':status', $status);
  if ($stmt->execute()) {
    $order_id = $pdo->lastInsertId();
    foreach ($carts as $cart) {
      $query = "INSERT INTO orders_keyboards (`order_id`, `keyboard_id`, `quantity`, `created_at`) VALUES (:order_id, :keyboard_id, :quantity, :created_at)";
      $stmt = $pdo->prepare($query);
      $stmt->bindParam(":order_id", $order_id);
      $stmt->bindParam(":keyboard_id", $cart['keyboard_id']);
      $stmt->bindParam(':quantity', $cart['quantity']);
      $stmt->bindParam(':created_at', $date);
      $stmt->execute();
    }
    $queryDeleteCart = "DELETE FROM cart WHERE customer_id = :customer_id";
    $stmtDeleteCart = $pdo->prepare($queryDeleteCart);
    $stmtDeleteCart->bindParam(':customer_id', $_SESSION['customer']['id_customer']);
    $stmtDeleteCart->execute();
    echo "<script>alert('Заказ успешно оформлен')</script>";
  }
  echo "<script>location.replace('../cart.php')</script>";
}
