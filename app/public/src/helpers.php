<?php
session_start();

function setValidationError(string $fieldName, string $message): void
{
  $_SESSION['validation'][$fieldName] = $message;
}

function getPDO(): PDO
{
  try {
    $host = "mysql";
    $username = "admin";
    $password = "admin";
    $db = "php_docker";

    return new \PDO("mysql:host=$host;dbname=$db;charset=utf8", $username, $password);
  } catch (\PDOException $e) {
    die("Connection error: {$e->getMessage()}");
  }
}

function currentUser(): array|false
{
  $pdo = getPDO();

  if (!isset($_SESSION['customer'])) {
    return false;
  }

  $userId = $_SESSION['customer']['id_customer'];

  $stmt = $pdo->prepare("SELECT * FROM customers WHERE id_customer = :id_customer");
  $stmt->execute(['id_customer' => $userId]);
  return $stmt->fetch(\PDO::FETCH_ASSOC);
}

function currentUserAddress(): array|false
{
  $pdo = getPDO();

  $userId = $_SESSION['customer']['id_customer'];
  $stmt = $pdo->prepare("SELECT * FROM addresses WHERE customer_id = $userId");
  $stmt->execute();
  return $stmt->fetch(\PDO::FETCH_ASSOC);
}

function keyboardId($keyboard_name): array|false
{
  $pdo = getPDO();

  $query = "SELECT * FROM keyboards WHERE `keyboard_name` = :keyboard_name";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':keyboard_name', $keyboard_name);
  $stmt->execute();
  return $stmt->fetch(mode: \PDO::FETCH_ASSOC);
}

function checkAuth(): void
{
  if (!isset($_SESSION['customer']['id_customer'])) {
    echo "<script>location.replace('login.html')</script>";
  }
}

function checkAuthAndRedirect(): void
{
  if (isset($_SESSION['customer']['id_customer'])) {
    echo '<a href="profile.php" class="header__button button--transparent">Личный кабинет</a>';
  } else {
    echo '<a href="login.html" class="header__button button--transparent">Личный кабинет</a>';
  }
}

function logout(): void
{
  unset($_SESSION['customer']['id_customer']);
  echo "<script>location.replace('../index.php')</script>";
}

function enterProfile(): void
{
  if (isset($_SESSION['customer']['id_customer'])) {
    echo "<script>location.replace('profile.php')</script>";
  }
}
