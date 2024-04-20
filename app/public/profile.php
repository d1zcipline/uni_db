<?php

require_once('src/helpers.php');

checkAuth();
$user = currentUser();
if (currentUserAddress() == false) {
  $userAddress = false;
} else {
  $userAddress = currentUserAddress()['address'];
}
// $first_name = $user['first_name'] !== NULL ? "echo $user['first_name']";
// if ($user['first_name'] !== NULL) $first_name = "echo $user['first_name']";

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
            <h2 class="section__title">Мои данные</h2>
          </div>
          <div class="section__body">
            <div class="personal-info">
              <div class="personal-info__body">
                <form action="src/personal-info.php" method="post" class="personal-info-form">
                  <div class="personal-info-form__inner">
                    <div class="personal-info-form__field-input">
                      <label for="name" class="personal-info-form__label">Имя</label>
                      <input type="text" name="first_name" placeholder="<?php echo $user['first_name'] ?>" class="personal-info-form__input">
                    </div>
                    <div class="personal-info-form__field-input">
                      <label for="surname" class="personal-info-form__label">Фамилия</label>
                      <input type="text" name="last_name" placeholder="<?php echo $user['last_name'] ?>" class="personal-info-form__input">
                    </div>
                  </div>
                  <div class="personal-info-form__field-input">
                    <label for="phone" class="personal-info-form__label">Телефон</label>
                    <input type="tel" name="phone" placeholder="<?php echo $user['phone'] ?>" class="personal-info-form__input--long">
                  </div>
                  <div class="personal-info-form__field-input">
                    <label for="address" class="personal-info-form__label">Адрес</label>
                    <input type="text" name="address" placeholder="<?php echo $userAddress ?>" class="personal-info-form__input--long">
                  </div>
                  <div class="personal-info-form__field-input">
                    <label for="email" class="personal-info-form__label">Текущая почта</label>
                    <input type="email" name="email" class="personal-info-form__input--long" required>
                  </div>
                  <div class="personal-info-form__field-input">
                    <label for="password" class="personal-info-form__label">Текущий пароль</label>
                    <input type="password" name="password" class="personal-info-form__input--long" required>
                  </div>
                  <button type="submit" class="personal-info-form__button button">Сохранить</button>
                </form>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </main>

</body>