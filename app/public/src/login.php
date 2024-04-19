<?php
require_once('helpers.php');

$email = $_POST['email'];
$password = $_POST['password'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo "<script>alert('Указана неправильная почта')</script>";
  echo "<script>location.replace('../login.html')</script>";
}

$pdo = getPDO();

$query = "SELECT * FROM customers WHERE `email` = :email";

$stmt = $pdo->prepare($query);
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(mode: \PDO::FETCH_ASSOC);

if (!password_verify($password, $user['password'])) {
  echo "<script>alert('Неверный пароль');</script>";
  echo "<script>location.replace('../login.html')</script>";
}

$_SESSION['customer']['id_customer'] = $user['id_customer'];
?>

<script>
  location.replace('../profile.php')
</script>