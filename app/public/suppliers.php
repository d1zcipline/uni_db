<?php
require_once('src/functions.php');

$pdo = getPDO();

$query = "SELECT supplier_name, supplier_country FROM `suppliers`";

$stmt = $pdo->prepare($query);
$stmt->execute();
$suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="styles/style.css">
  <title>Поставщики</title>
</head>

<body>
  <header class="header-main">
    <div class="header-main__inner container">
      <a href="index.php" class="header__logo logo">
        Customizable
      </a>
      <nav class="header__menu">
        <ul class="header__menu-list">
          <li class="header__menu-item">
            <a href="products.php" class="header__menu-link">Товары</a>
          </li>
          <li class="header__menu-item">
            <a href="suppliers.php" class="header__menu-link">Поставщики</a>
          </li>
          <li class="header__menu-item">
            <a href="cart.php" class="header__menu-link">Корзина</a>
          </li>
        </ul>
      </nav>
      <?php
      checkAuthAndRedirect();
      ?>

    </div>
  </header>

  <main class="content">
    <section class="section container">
      <div class="section__header">
        <h2 class="section__title">Наши поставщики</h2>
      </div>
      <div class="section__body">
        <div class="blog">
          <div class="blog__body">

          </div>
        </div>
    </section>
  </main>

</body>

</html>