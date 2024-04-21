<?php

require_once('functions.php');

$pdo = getPDO();

$keyboardName = $_POST["keyboard-name"];
$keyboard_price = $_POST["keyboard_price"];
$keyboardDescription = $_POST["keyboard-description"];
$image = $_FILES["image"]["name"];

$date = date("Y-m-d H:i:s");

$target_dir = "../images/";
$ext = pathinfo($image, PATHINFO_EXTENSION);
$target_file = $target_dir . 'keyboard-image' . '_' . time() . ".$ext";
$target_path = 'images/keyboard-image' . '-' . time() . ".$ext";
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (!is_dir($target_dir)) {
  mkdir($target_dir, 0777, true);
}

// Проверка файла изображения
if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    echo "Извините, только JPG, JPEG и PNG файлы разрешены.";
    $uploadOk = 0;
  }
  if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    echo "Файл " . basename($_FILES["image"]["name"]) . " был загружен.";
  } else {
    echo "Извините, произошла ошибка при загрузке вашего файла.";
    $uploadOk = 0;
  }
}

// Сохранение данных в базе данных
if ($uploadOk == 1) {
  $query = "INSERT INTO keyboards (`keyboard_name`, `keyboard_description`, `keyboard_image`) VALUES (:keyboard_name, :keyboard_description, :keyboard_image)";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':keyboard_name', $keyboardName);
  $stmt->bindParam(':keyboard_description', $keyboardDescription);
  $stmt->bindParam(':keyboard_image', $target_path);
  if ($stmt->execute()) {
    $keyboard_id = $pdo->lastInsertId();

    $query = "INSERT INTO keyboards_price (`keyboard_id`, `keyboard_price`, `date_from`) VALUES (:keyboard_id, :keyboard_price, :date_from)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':keyboard_id', $keyboard_id, PDO::PARAM_INT);
    $stmt->bindParam(':keyboard_price', $keyboard_price);
    $stmt->bindParam(':date_from', $date);
    if ($stmt->execute()) {
      echo "Данные были успешно сохранены в базе данных.";
    } else {
      echo "Ошибка при сохранении данных в базе данных.";
    }
  } else {
    echo "Ошибка при сохранении данных в базе данных.";
  }
}

echo "<script>location.replace('../profile-products.php')</script>";
