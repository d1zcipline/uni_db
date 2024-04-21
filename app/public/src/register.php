<?php

require_once('functions.php');

$email = $_POST['email'];
$password = $_POST['password'];
$passwordConfirmation = $_POST['password_confirmation'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo "<script>alert('Указана неправильная почта')</script>";
  echo "<script>location.replace('register.html')</script>";
}


if ($password == $passwordConfirmation) {
  $pdo = getPDO();

  $query = "INSERT INTO customers (`email`, `password`) VALUES (:email, :password)";
  $params = [
    'email' => $email,
    'password' => password_hash($password, PASSWORD_DEFAULT)
  ];

  $stmt = $pdo->prepare($query);

  try {
    $stmt->execute($params);
  } catch (\Exception $e) {
    die($e->getMessage());
  }

  echo "<script>location.replace('../login.html')</script>";
} else {
  echo "<script>alert('Пароли не совпадают')</script>";
  echo "<script>location.replace('../registration.html')</script>";
}
