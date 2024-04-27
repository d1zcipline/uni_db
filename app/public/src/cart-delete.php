<?php
require_once('functions.php');

$pdo = getPDO();

$cart_id = $_POST['cart_id'];

$query = "DELETE FROM cart WHERE id = :cart_id";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':cart_id', $cart_id);
$stmt->execute();
echo "<script>
alert('Товар удален из корзины')
location.replace('../cart.php')
</script>";
