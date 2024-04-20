<?php

require_once('helpers.php');

$supplier_name = $_POST['supplier_name'];
$supplier_country = $_POST['supplier_country'];

$pdo = getPDO();

if ($supplier_name !== '') {
  $query = "INSERT INTO suppliers (`supplier_name`, `supplier_country`) VALUES (:supplier_name, :supplier_country)";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':supplier_name', $supplier_name);
  $stmt->bindParam(':supplier_country', $supplier_country);
  $stmt->execute();
}
echo "<script>location.replace('../profile-suppliers.php')</script>";
