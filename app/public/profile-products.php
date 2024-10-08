<?php
require_once('src/functions.php');

checkAuth();
$user = currentUser();

$pdo = getPDO();
$query = "SELECT `id_supplier`, `supplier_name` FROM `suppliers`";
$stmt = $pdo->prepare($query);
$stmt->execute();
$suppliers_table = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="styles/style.css">
  <title>Администрирование товаров</title>
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
            <h2 class="section__title">Запись данных о клавиатуре</h2>
          </div>
          <div class="section__body">
            <div class="personal-info">
              <div class="personal-info__body">
                <form action="src/input-keyboard.php" method="post" enctype="multipart/form-data" class="personal-info-form">
                  <div class="personal-info-form__field-input">
                    <label for="keyboard-name" class="personal-info-form__label">Название клавиатуры</label>
                    <input type="text" name="keyboard-name" class="personal-info-form__input--long" required>
                  </div>
                  <div class="personal-info-form__field-input">
                    <label for="keyboard-description" class="personal-info-form__label">Описание</label>
                    <textarea type="text" name="keyboard-description" class="personal-info-form__input--long" style="padding-top: 25px; height: 140px" required></textarea>
                  </div>
                  <div class="personal-info-form__field-input">
                    <label for="keyboard_quantity" class="personal-info-form__label">Кол-во поставляемых клавиатур</label>
                    <input type="text" name="keyboard_quantity" class="personal-info-form__input--long" required>
                  </div>
                  <div class="personal-info-form__field-input">
                    <label for="keyboard_price" class="personal-info-form__label">Цена</label>
                    <input type="text" name="keyboard_price" class="personal-info-form__input--long" required>
                  </div>
                  <div class="personal-info-form__field-input">
                    <label for="supplier" class="personal-info-form__label">Выберите поставщика</label>
                    <select name="supplier" id="supplier" class="personal-info-form__input--long" style="padding: 0 13px; padding-top: 16px;">
                      <?php foreach ($suppliers_table as $suppliers) { ?>
                        <option value="<?php echo $suppliers['supplier_name'] ?>"><?php echo $suppliers['supplier_name'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="personal-info-form__field-input">
                    <label for="image" class="personal-info-form__label">Изображение клавиатуры</label></br>
                    <input type="file" name="image" style="width: 640px; margin-top: -25px; padding: 15px 13px; padding-top: 30px; border: 2px solid; border-color: rgba(238, 238, 238, 0.3);">
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