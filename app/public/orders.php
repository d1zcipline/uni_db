<?php

require_once('src/helpers.php');

checkAuth();
$user = currentUser();
if (currentUserAddress() == false) {
} else {
  $user_address = currentUserAddress()['id_address'];

  $pdo = getPDO();

  $query = "SELECT orders.id_order, orders.address_id, orders.order_date, orders.order_delivery_date, orders_keyboards.keyboard_id, orders_keyboards.quantity FROM orders JOIN orders_keyboards ON orders.id_order = orders_keyboards.order_id WHERE `address_id` = :address_id";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':address_id', $user_address);
  $stmt->execute();
  $simple_orders_keyboards = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $query = "SELECT k.id_keyboard, k.keyboard_name, k.keyboard_description, k.keyboard_image, kp.keyboard_price, kp.date_from 
            FROM keyboards k
            JOIN keyboards_price kp ON k.id_keyboard = kp.keyboard_id";
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  $keyboards = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $query = "SELECT * FROM orders WHERE `address_id` = :address_id";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':address_id', $user_address);
  $stmt->execute();
  $orders = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="styles/style.css">
  <title>Личный кабинет</title>
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
        </ul>
      </nav>
      <form action="src/logout.php" method="post">
        <button style="border: 0px solid" class="header__button button--transparent">
          Выйти
        </button>
      </form>
    </div>
  </header>

  <main class="content">
    <div class="profile">
      <div class="profile-menu">
        <div class="profile-menu__body">
          <div class="profile-menu__image">
            <!-- <img src="" alt=""> -->
          </div>
          <div class="profile-menu__info">
            <p class="profile-menu__name"><?php echo $user['first_name'] ?></p>
            <p class="profile-menu__surname"><?php echo $user['last_name'] ?></p>
          </div>
          <ul class="profile-menu__list">
            <li class="profile-menu__item">
              <?php
              if (isset($_SESSION['customer']['id_customer'])) {
                echo '<a href="profile.php" class="profile-menu__link">Главная</a>';
              } else {
                echo '<a href="index.php" class="profile-menu__link">Главная</a>';
              }
              ?>
            </li>
            <li class="profile-menu__item">
              <a href="orders.php" class="profile-menu__link">Мои заказы</a>
            </li>
            <li class="profile-menu__item">
              <?php
              if (isset($_SESSION['customer']['id_customer'])) {
                echo '<a href="profile-products.php" class="profile-menu__link">Клавиатуры</a>';
              } else {
                echo '<a href="index.php" class="profile-menu__link">Клавиатуры</a>';
              }
              ?>
            </li>
            <li class="profile-menu__item">
              <?php
              if (isset($_SESSION['customer']['id_customer'])) {
                echo '<a href="profile-suppliers.php" class="profile-menu__link">Поставщики</a>';
              } else {
                echo '<a href="index.php" class="profile-menu__link">Поставщики</a>';
              }
              ?>
            </li>
          </ul>
        </div>
      </div>
      <div class="profile-feed">
        <section class="section container">
          <div class="section__header">
            <h2 class="section__title">Мои заказы</h2>
          </div>
          <div class="section__body">
            <div class="payments-history">
              <header class="payments-history__header">
                <ul class="payments-history__list">
                  <li class="payments-history__item">Дата</li>
                  <li class="payments-history__item">Клавиатура</li>
                  <li class="payments-history__item">Кол-во</li>
                  <li class="payments-history__item">Стоимость</li>
                  <li class="payments-history__item">Статус</li>
                </ul>
              </header>
              <div class="payments-history__body">
                <?php if (empty($orders)) { ?>
                  <p>У вас пока нет заказов.</p>
                <?php } else { ?>
                  <?php foreach ($simple_orders_keyboards as $simple_order) { ?>
                    <ul class="payments-history__list">
                      <li class="payments-history__item"><?php echo $simple_order['order_date'] ?></li>
                      <li class="payments-history__item"><?php
                                                          $pdo = getPDO();
                                                          $query = "SELECT keyboard_name FROM keyboards WHERE `id_keyboard` = :id_keyboard";
                                                          $stmt = $pdo->prepare($query);
                                                          $stmt->bindParam(':id_keyboard', $simple_order['keyboard_id']);
                                                          $stmt->execute();
                                                          $keyboard_name = $stmt->fetch(PDO::FETCH_ASSOC);
                                                          echo $keyboard_name['keyboard_name'];
                                                          ?>
                      </li>
                      <li class="payments-history__item"><?php echo $simple_order['quantity'] ?></li>
                      <li class="payments-history__item"><?php
                                                          $pdo = getPDO();
                                                          $query = "SELECT keyboard_price FROM keyboards_price WHERE `keyboard_id` = :keyboard_id";
                                                          $stmt = $pdo->prepare($query);
                                                          $stmt->bindParam(':keyboard_id', $simple_order['keyboard_id']);
                                                          $stmt->execute();
                                                          $keyboard_price = $stmt->fetch(PDO::FETCH_ASSOC);
                                                          echo $keyboard_price['keyboard_price'];
                                                          ?> руб
                      </li>
                      <li class="payments-history__item">В доставке</li>
                    </ul>
                  <?php } ?>
                <?php } ?>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </main>