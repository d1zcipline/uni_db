-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: mysql:3306
-- Время создания: Апр 23 2024 г., 07:59
-- Версия сервера: 8.3.0
-- Версия PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `php_docker`
--

-- --------------------------------------------------------

--
-- Структура таблицы `addresses`
--

CREATE TABLE `addresses` (
  `id_address` int UNSIGNED NOT NULL,
  `customer_id` int UNSIGNED NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `addresses`
--

INSERT INTO `addresses` (`id_address`, `customer_id`, `address`) VALUES
(1, 1, 'test address');

-- --------------------------------------------------------

--
-- Структура таблицы `customers`
--

CREATE TABLE `customers` (
  `id_customer` int UNSIGNED NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `customers`
--

INSERT INTO `customers` (`id_customer`, `first_name`, `last_name`, `email`, `phone`, `password`) VALUES
(1, 'Test Name', 'test surname', 'test@gmail.com', '7 900 000 00 00', '$2y$10$6IDMa64dbcfUh6L7oDVV7.lRZeD4sOQZ2AHTrqkIX6HKishJGUJ26');

-- --------------------------------------------------------

--
-- Структура таблицы `keyboards`
--

CREATE TABLE `keyboards` (
  `id_keyboard` int UNSIGNED NOT NULL,
  `keyboard_name` varchar(255) NOT NULL,
  `keyboard_description` text NOT NULL,
  `keyboard_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `keyboards`
--

INSERT INTO `keyboards` (`id_keyboard`, `keyboard_name`, `keyboard_description`, `keyboard_image`) VALUES
(1, 'Zuoya GMK67', 'The best budget keyboard', 'images/keyboard-image-1713858487.jpg'),
(2, 'Monsgeek M1', 'TEST DESC', 'images/keyboard-image-1713859125.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `keyboards_price`
--

CREATE TABLE `keyboards_price` (
  `id` int UNSIGNED NOT NULL,
  `keyboard_id` int UNSIGNED NOT NULL,
  `keyboard_price` int NOT NULL,
  `date_from` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `keyboards_price`
--

INSERT INTO `keyboards_price` (`id`, `keyboard_id`, `keyboard_price`, `date_from`) VALUES
(1, 1, 6990, '2024-04-23'),
(2, 2, 9900, '2024-04-23');

-- --------------------------------------------------------

--
-- Структура таблицы `keyboards_suppliers`
--

CREATE TABLE `keyboards_suppliers` (
  `id` int UNSIGNED NOT NULL,
  `keyboard_id` int UNSIGNED NOT NULL,
  `supplier_id` int UNSIGNED NOT NULL,
  `keyboard_quantity` int NOT NULL,
  `supplier_delivery_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `keyboards_suppliers`
--

INSERT INTO `keyboards_suppliers` (`id`, `keyboard_id`, `supplier_id`, `keyboard_quantity`, `supplier_delivery_date`) VALUES
(1, 1, 1, 50, '2024-04-23'),
(2, 2, 1, 30, '2024-04-23');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id_order` int UNSIGNED NOT NULL,
  `address_id` int UNSIGNED NOT NULL,
  `order_date` date NOT NULL,
  `order_delivery_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id_order`, `address_id`, `order_date`, `order_delivery_date`) VALUES
(1, 1, '2024-04-23', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `orders_keyboards`
--

CREATE TABLE `orders_keyboards` (
  `id` int UNSIGNED NOT NULL,
  `order_id` int UNSIGNED NOT NULL,
  `keyboard_id` int UNSIGNED NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `orders_keyboards`
--

INSERT INTO `orders_keyboards` (`id`, `order_id`, `keyboard_id`, `quantity`) VALUES
(1, 1, 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `suppliers`
--

CREATE TABLE `suppliers` (
  `id_supplier` int UNSIGNED NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_country` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `suppliers`
--

INSERT INTO `suppliers` (`id_supplier`, `supplier_name`, `supplier_country`) VALUES
(1, 'Direct Factory', 'China');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id_address`),
  ADD KEY `addresses_customer_id_foreign` (`customer_id`);

--
-- Индексы таблицы `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id_customer`);

--
-- Индексы таблицы `keyboards`
--
ALTER TABLE `keyboards`
  ADD PRIMARY KEY (`id_keyboard`);

--
-- Индексы таблицы `keyboards_price`
--
ALTER TABLE `keyboards_price`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `keyboards_suppliers`
--
ALTER TABLE `keyboards_suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `keyboards_suppliers_keyboard_id_foreign` (`keyboard_id`),
  ADD KEY `keyboards_suppliers_supplier_id_foreign` (`supplier_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `orders_address_id_foreign` (`address_id`);

--
-- Индексы таблицы `orders_keyboards`
--
ALTER TABLE `orders_keyboards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_keyboards_order_id_foreign` (`order_id`),
  ADD KEY `orders_keyboards_keyboard_id_foreign` (`keyboard_id`);

--
-- Индексы таблицы `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id_supplier`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id_address` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `customers`
--
ALTER TABLE `customers`
  MODIFY `id_customer` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `keyboards`
--
ALTER TABLE `keyboards`
  MODIFY `id_keyboard` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `keyboards_price`
--
ALTER TABLE `keyboards_price`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `keyboards_suppliers`
--
ALTER TABLE `keyboards_suppliers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `orders_keyboards`
--
ALTER TABLE `orders_keyboards`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id_supplier` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id_customer`);

--
-- Ограничения внешнего ключа таблицы `keyboards_price`
--
ALTER TABLE `keyboards_price`
  ADD CONSTRAINT `keyboards_price_id_foreign` FOREIGN KEY (`id`) REFERENCES `keyboards` (`id_keyboard`);

--
-- Ограничения внешнего ключа таблицы `keyboards_suppliers`
--
ALTER TABLE `keyboards_suppliers`
  ADD CONSTRAINT `keyboards_suppliers_keyboard_id_foreign` FOREIGN KEY (`keyboard_id`) REFERENCES `keyboards` (`id_keyboard`),
  ADD CONSTRAINT `keyboards_suppliers_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id_supplier`);

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id_address`);

--
-- Ограничения внешнего ключа таблицы `orders_keyboards`
--
ALTER TABLE `orders_keyboards`
  ADD CONSTRAINT `orders_keyboards_keyboard_id_foreign` FOREIGN KEY (`keyboard_id`) REFERENCES `keyboards` (`id_keyboard`),
  ADD CONSTRAINT `orders_keyboards_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id_order`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
