<?php
require_once('src/functions.php');

$pdo = getPDO();

// $query = "SELECT ok.keyboard_id, ok.quantity, k.keyboard_name FROM orders_keyboards ok JOIN keyboards k ON ok.keyboard_id = k.id_keyboard";

$query = "SELECT * FROM cart WHERE customer_id = :customer_id";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':customer_id', $_SESSION['customer']['id_customer']);
$stmt->execute();
$carts = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="styles/style.css">
  <style>
    th,
    td {
      border: 1px solid;
      padding: 5px;
    }
  </style>
  <title>Корзина</title>
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
    <section class="section container">
      <div class="section__header">
        <h2 class="section__title">Корзина</h2>
      </div>
      <div class="section__body">
        <div class="payments-history" style="width: 1120px;">
          <header class="payments-history-2__header">
            <ul class="payments-history__list" style="column-gap: 120px;">
              <li class="payments-history__item">Клавиатура</li>
              <li class="payments-history__item">Кол-во</li>
              <li class="payments-history__item">Стоимость</li>
            </ul>
          </header>
          <div class="payments-history__body">
            <?php if (empty($carts)) { ?>
              <p>Корзина пуста</p>
            <?php } else { ?>
              <?php foreach ($carts as $cart) { ?>
                <ul class="payments-history__list" style="column-gap: 120px;">
                  <li class="payments-history__item">
                    <?php
                    $query = "SELECT k.id_keyboard, k.keyboard_name, kp.keyboard_price, kp.date_from 
                    FROM keyboards k
                    JOIN keyboards_price kp ON k.id_keyboard = kp.keyboard_id
                    WHERE kp.keyboard_id = :keyboard_id";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':keyboard_id', $cart['keyboard_id']);
                    $stmt->execute();
                    $keyboard = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo $keyboard['keyboard_name'];
                    ?>
                  </li>
                  <li class="payments-history__item">
                    <?php
                    echo $cart['quantity'];
                    ?>
                  </li>
                  <li class="payments-history__item">
                    <?php
                    echo $keyboard['keyboard_price'] * $cart['quantity'];
                    ?>
                  </li>
                  <form action="src/cart-delete.php" method="post">
                    <input type="hidden" name="cart_id" value="<?php echo $cart['id'] ?>">
                    <li class="payments-history__item"><button type="submit" class="button" style="padding: 5px 15px; border: 0px solid">Удалить</button></li>
                  </form>
                </ul>
              <?php } ?>
            <?php } ?>
          </div>
        </div>
      </div>
    </section>
  </main>
</body>