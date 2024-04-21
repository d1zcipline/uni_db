<?php

require_once('functions.php');

$supplier_name = $_POST['supplier_name'];
$supplier_country = $_POST['supplier_country'];

$pdo = getPDO();

$query = "SELECT * FROM suppliers WHERE `supplier_name` = :supplier_name";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':supplier_name', $supplier_name);
$stmt->execute();
$supplier = $stmt->fetch(mode: \PDO::FETCH_ASSOC);

if ($supplier_name !== '' && $supplier_country !== '' && $supplier_name !== $supplier['supplier_name']) {
  $query = "INSERT INTO suppliers (`supplier_name`, `supplier_country`) VALUES (:supplier_name, :supplier_country)";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':supplier_name', $supplier_name);
  $stmt->bindParam(':supplier_country', $supplier_country);
  $stmt->execute();
} elseif ($supplier_name == '' || $supplier_country == '') {
  echo "<script>alert('Не оставляйте поля пустыми!')</script>";
  echo "<script>location.replace('../profile-suppliers.php')</script>";
} elseif ($supplier_name === $supplier['supplier_name']) {
  echo "<script>alert('Данный поставщик уже есть в базе данных')</script>";
  echo "<script>location.replace('../profile-suppliers.php')</script>";
} else {
  echo "<script>location.replace('../profile-suppliers.php')</script>";
}
