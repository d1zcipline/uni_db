<?php

require_once('helpers.php');

$first_name = $_POST['first_name'] ?? null;
$last_name = $_POST['last_name'] ?? null;
$phone = $_POST['phone'] ?? null;
$address = $_POST['address'] ?? null;
$email = $_POST['email'];
$password = $_POST['password'];

$pdo = getPDO();

$userId = $_SESSION['customer']['id_customer'];

$user = currentUser();
$userAddress = currentUserAddress();

// $stmt = $pdo->prepare("SELECT * FROM customers WHERE id_customer = :id_customer");
// $stmt->execute(['id_customer' => $userId]);
// $user = $stmt->fetch(mode: \PDO::FETCH_ASSOC);

if ($email !== $user['email']) {
  echo "<script>alert('Неправильная почта');</script>";
  echo "<script>location.replace('../profile.php')</script>";
} elseif (!password_verify($password, $user['password'])) {
  echo "<script>alert('Неверный пароль');</script>";
  echo "<script>location.replace('../profile.php')</script>";
} else {
  if ($first_name !== $user['first_name']) {
    $query = "UPDATE customers SET `first_name` = :first_name WHERE `email` = :email";
    $stmt = $pdo->prepare($query);
    try {
      $stmt->execute(['first_name' => $first_name, 'email' => $email]);
    } catch (\Exception $e) {
      die($e->getMessage());
    }
  }

  if ($last_name !== $user['last_name']) {
    $query = "UPDATE customers SET `last_name` = :last_name WHERE `email` = :email";
    $stmt = $pdo->prepare($query);
    try {
      $stmt->execute(['last_name' => $last_name, 'email' => $email]);
    } catch (\Exception $e) {
      die($e->getMessage());
    }
  }

  if ($phone !== $user['phone']) {
    $query = "UPDATE customers SET `phone` = :phone WHERE `email` = :email";
    $stmt = $pdo->prepare($query);
    try {
      $stmt->execute(['phone' => $phone, 'email' => $email]);
    } catch (\Exception $e) {
      die($e->getMessage());
    }
  }

  if (currentUserAddress() == false) {
    $foreign_key_value = $userId;
    $query = "INSERT INTO addresses (`address`, `customer_id`) VALUES (:address, :foreign_key)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':foreign_key', $foreign_key_value);
    $stmt->execute();
  } elseif ($userAddress !== NULL) {
    $foreign_key_value = $userId;
    $query = "UPDATE addresses SET `address` = :address, `customer_id` = :foreign_key";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':foreign_key', $foreign_key_value);
    $stmt->execute();
  }
  echo "<script>location.replace('../profile.php')</script>";
}
