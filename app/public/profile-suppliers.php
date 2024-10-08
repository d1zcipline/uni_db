<?php
require_once('src/functions.php');

checkAuth();
$user = currentUser();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="styles/style.css">
  <title>Администрирование поставщиков</title>
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
            <h2 class="section__title">Запись данных о поставщике</h2>
          </div>
          <div class="section__body">
            <div class="personal-info">
              <div class="personal-info__body">
                <form action="src/input-suppliers.php" method="post" enctype="multipart/form-data" class="personal-info-form">
                  <div class="personal-info-form__field-input">
                    <label for="supplier_name" class="personal-info-form__label">Наименование поставщика</label>
                    <input type="text" name="supplier_name" class="personal-info-form__input--long" required>
                  </div>
                  <div class="personal-info-form__field-input">
                    <label for="supplier_country" class="personal-info-form__label">Cтрана поставщика</label>
                    <input type="text" name="supplier_country" class="personal-info-form__input--long" required>
                  </div>
                  <button type="submit" class="personal-info-form__button button">Добавить</button>
                </form>
              </div>
            </div>
          </div>
        </section>
        <section class="section container">
          <div class="section__header">
            <h2 class="section__title">Изменения данных поставщика</h2>
          </div>
          <div class="section__body">
            <div class="personal-info">
              <div class="personal-info__body">
                <form action="src/input-suppliers.php" method="post" enctype="multipart/form-data" class="personal-info-form">
                  <div class="personal-info-form__field-input">
                    <label for="supplier_name" class="personal-info-form__label">Наименование поставщика</label>
                    <input type="text" name="supplier_name" class="personal-info-form__input--long" required>
                  </div>
                  <div class="personal-info-form__field-input">
                    <label for="supplier_country" class="personal-info-form__label">Cтрана поставщика</label>
                    <input type="text" name="supplier_country" class="personal-info-form__input--long" required>
                  </div>
                  <button type="submit" class="personal-info-form__button button">Добавить</button>
                </form>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </main>
</body>