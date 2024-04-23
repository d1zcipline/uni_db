<?php

require_once('functions.php');

$pdo = getPDO();

$name = $_POST['keyboard_name_search'] ?? '';
$minPrice = $_POST['min_price'] ?? 0;
$maxPrice = $_POST['max_price'] ?? PHP_INT_MAX;

$query = "SELECT k.id_keyboard, k.keyboard_name, k.keyboard_description, k.keyboard_image, kp.keyboard_price, kp.date_from
          FROM keyboards k
          JOIN keyboards_price kp ON k.id_keyboard = kp.keyboard_id
          WHERE k.keyboard_name LIKE :name
          AND kp.keyboard_price BETWEEN :minPrice AND :maxPrice";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':name', '%' . $name . '%', PDO::PARAM_STR);
$stmt->bindValue(':minPrice', $minPrice, PDO::PARAM_INT);
$stmt->bindValue(':maxPrice', $maxPrice, PDO::PARAM_INT);
$stmt->execute();
$keyboards = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<script>
  location.replace('../products.php')
</script>