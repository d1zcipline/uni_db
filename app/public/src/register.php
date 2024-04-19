<?php

require_once('helpers.php');

$email = $_POST['email'];
$sex = $_POST['sex'];
$password = $_POST['password'];
$passwordConfirmation = $_POST['password_confirmation'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo "<script>alert('Указана неправильная почта')</script>";
  echo "<script>location.replace('register.html')</script>";
}


if ($password == $passwordConfirmation) {
  $pdo = getPDO();

  $query = "INSERT INTO customers (`email`, `sex`, `password`) VALUES (:email, :sex, :password)";
  $params = [
    'email' => $email,
    'sex' => $sex,
    'password' => password_hash($password, PASSWORD_DEFAULT)
  ];

  $stmt = $pdo->prepare($query);

  try {
    $stmt->execute($params);
  } catch (\Exception $e) {
    die($e->getMessage());
  }

  // $query = "INSERT INTO addresses (`address`) VALUES ('')";
  // $stmt = $pdo->prepare($query);

  // try {
  //   $stmt->execute(['address' => ];
  // } catch (\Exception $e) {
  //   die($e->getMessage());
  // }

  echo "<script>location.replace('../login.html')</script>";
} else {
  echo "<script>alert('Пароли не совпадают')</script>";
  echo "<script>location.replace('../registration.html')</script>";
}

// if (headers_sent()) {
//   die("Redirect failed. Please click on this <a href=login.html>link</a>");
// } else {
//   exit(header("Location: login.html"));
// }
