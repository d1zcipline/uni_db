<?php
require_once('src/functions.php');

$pdo = getPDO();

$name_filter = isset($_GET['keyboard_name_search']) ? $_GET['keyboard_name_search'] : '';
$min_price = isset($_GET['min_price']) ? $_GET['min_price'] : '';
$max_price = isset($_GET['max_price']) ? $_GET['max_price'] : '';

$query = "SELECT k.id_keyboard, k.keyboard_name, k.keyboard_description, k.keyboard_image, kp.keyboard_price, kp.date_from 
          FROM keyboards k
          JOIN keyboards_price kp ON k.id_keyboard = kp.keyboard_id
          WHERE 1 = 1";

if (!empty($name_filter)) {
  $query .= " AND k.keyboard_name LIKE :keyboard_name_search";
}

if (!empty($min_price)) {
  $query .= " AND kp.keyboard_price >= :min_price";
}

if (!empty($max_price)) {
  $query .= " AND kp.keyboard_price <= :max_price";
}

$stmt = $pdo->prepare($query);

if (!empty($name_filter)) {
  $stmt->bindValue(':keyboard_name_search', '%' . $name_filter . '%');
}

if (!empty($min_price)) {
  $stmt->bindValue(':min_price', $min_price, PDO::PARAM_INT);
}

if (!empty($max_price)) {
  $stmt->bindValue(':max_price', $max_price, PDO::PARAM_INT);
}
$stmt->execute();
$keyboards = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="styles/style.css">
  <title>Товары</title>
</head>

<body>
  <header class="header-main">
    <div class="header-main__inner container">
      <a href="index.php" class="header__logo logo">Customizable</a>
      <nav class="header__menu">
        <ul class="header__menu-list">
          <li class="header__menu-item">
            <a href="products.php" class="header__menu-link">Товары</a>
          </li>
          <li class="header__menu-item">
            <a href="suppliers.php" class="header__menu-link">Поставщики</a>
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
        <h2 class="section__title">Фильтр</h2>
      </div>
      <div class="section__body">
        <form action="" method="get" class="form" style="height: fit-content;">
          <div class="form__inner">
            <label for="keyboard_name_search" class="form__label">Поиск по названию</label>
            <input type="text" name="keyboard_name_search" value="<?php echo $name_filter; ?>" class="form__input">
          </div>
          <div class="form__inner">
            <label for="min_price" class="form__label">Минимальная цена</label>
            <input type="number" name="min_price" value="<?php echo $min_price; ?>" class="form__input">
          </div>
          <div class="form__inner">
            <label for="max_price" class="form__label">Максимальная цена</label>
            <input type="number" name="max_price" value="<?php echo $max_price; ?>" class="form__input">
          </div>
          <a href="?" class="form__submit button" style="padding: 20px; text-align: center">Сбросить фильтр</a>
          <button type="submit" class="form__submit button">Применить</button>
        </form>
      </div>
    </section>
    <div class="section container">
      <div class="section__header">
        <h2 class="section__title">Каталог товаров</h2>
      </div>
      <div class="section__body">
        <?php

        ?>
        <div class="blog">
          <div class="blog__body">
            <?php foreach ($keyboards as $keyboard) { ?>
              <form action="src/keyboard-order.php" method="POST">
                <input type="hidden" name="keyboard_id" value="<?php echo $keyboard['id_keyboard']; ?>">
                <div class="blog-card" style="margin: 10vh 0;">
                  <div class="blog-card__body">
                    <div class="blog-card__image">
                      <img src="<?php echo $keyboard['keyboard_image']; ?>" alt="<?php echo $keyboard['keyboard_name']; ?>">
                    </div>
                    <header class="blog-card__header">
                      <h3 class="blog-card__title"><?php echo $keyboard['keyboard_name']; ?></h3>
                    </header>
                    <div class="blog-card__description" style="margin-top: -20px;">
                      <p><?php echo $keyboard['keyboard_description']; ?></p>
                    </div>
                    <div class="blog-card__price">
                      <p>Цена: <?php echo $keyboard['keyboard_price']; ?> руб.</p>
                      <div class="form__inner">
                        <label for="quantity" class="form__label">Количество</label>
                        <input type="number" class="form__input" id="quantity" name="quantity" min="1" style="width: 150px;" required>
                      </div>
                      <button type="submit" class="button" style="padding: 10px 15px; border: 0px solid; border-radius: 0">Купить</button>
                    </div>
                  </div>
                </div>
              </form>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>