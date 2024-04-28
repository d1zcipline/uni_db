<?php

require_once('src/functions.php');

checkAuth();
$user = currentUser();
if (currentUserAddress() == false) {
} else {
  $user_address = currentUserAddress()['id_address'];

  $pdo = getPDO();

  $query = "SELECT * FROM orders WHERE `address_id` = :address_id";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':address_id', $user_address);
  $stmt->execute();
  $orders_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $query = "SELECT ok.keyboard_id, ok.quantity, kp.keyboard_price, kp.date_from 
            FROM orders_keyboards ok
            JOIN keyboards_price kp ON ok.keyboard_id = kp.keyboard_id";
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  $keyboards = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
          <li class="header__menu-item">
            <a href="cart.php" class="header__menu-link">Корзина</a>
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
                  <li class="payments-history__item">Номер заказа</li>
                  <li class="payments-history__item">Общая стоимость</li>
                  <li class="payments-history__item">Статус</li>
                </ul>
              </header>
              <div class="payments-history__body">
                <?php if (empty($orders_list)) { ?>
                  <p>У вас пока нет заказов</p>
                <?php } else { ?>
                  <?php foreach ($orders_list as $order) { ?>
                    <ul class="payments-history__list">
                      <li class="payments-history__item"><?php echo $order['order_date'] ?></li>
                      <li class="payments-history__item"><?php echo $order['id'] ?></li>
                      <li class="payments-history__item">
                        <?php
                        $query = "SELECT ok.keyboard_id, ok.order_id, ok.quantity, kp.keyboard_price
                        FROM orders_keyboards ok
                        JOIN keyboards_price kp ON ok.keyboard_id = kp.keyboard_id AND ok.order_id = :order_id";
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(':order_id', $order['id']);
                        $stmt->execute();
                        $keyboards = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $total_amount = 0;

                        foreach ($keyboards as $keyboard) {
                          $keyboard_quantity = intval($keyboard['quantity']);
                          $total_amount += $keyboard_quantity * $keyboard['keyboard_price'];
                        }
                        echo $total_amount;
                        ?> руб
                      </li>
                      <li class="payments-history__item"><?php echo $order['status'] ?></li>
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