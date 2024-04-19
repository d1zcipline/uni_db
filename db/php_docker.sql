-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: mysql:3306
-- Время создания: Апр 15 2024 г., 10:47
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
  `city_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `postcode` varchar(255) NOT NULL,
  `address_default` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `customers`
--

CREATE TABLE `customers` (
  `id_customer` int UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `keyboards`
--

CREATE TABLE `keyboards` (
  `id_keyboard` int UNSIGNED NOT NULL,
  `keyboard_name` varchar(255) NOT NULL,
  `keyboard_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `keyboards_price`
--

CREATE TABLE `keyboards_price` (
  `id` int UNSIGNED NOT NULL,
  `keyboard_id` int UNSIGNED NOT NULL,
  `keyboard_price` double(8,2) NOT NULL,
  `date_from` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id_order` int UNSIGNED NOT NULL,
  `address_id` int UNSIGNED NOT NULL,
  `order_date` date NOT NULL,
  `order_delivery_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

-- --------------------------------------------------------

--
-- Структура таблицы `suppliers`
--

CREATE TABLE `suppliers` (
  `id_supplier` int UNSIGNED NOT NULL,
  `supplier_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  MODIFY `id_address` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `customers`
--
ALTER TABLE `customers`
  MODIFY `id_customer` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `keyboards`
--
ALTER TABLE `keyboards`
  MODIFY `id_keyboard` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `keyboards_price`
--
ALTER TABLE `keyboards_price`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `keyboards_suppliers`
--
ALTER TABLE `keyboards_suppliers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `orders_keyboards`
--
ALTER TABLE `orders_keyboards`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id_supplier` int UNSIGNED NOT NULL AUTO_INCREMENT;

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
