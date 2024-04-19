CREATE TABLE `suppliers`(
    `id_supplier` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `supplier_name` VARCHAR(255) NOT NULL
);
CREATE TABLE `orders_keyboards`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT UNSIGNED NOT NULL,
    `keyboard_id` INT UNSIGNED NOT NULL,
    `quantity` INT NOT NULL
);
CREATE TABLE `customers`(
    `id_customer` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `first_name` VARCHAR(255) NOT NULL,
    `last_name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(255) NOT NULL
);
CREATE TABLE `keyboards_price`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `keyboard_id` INT UNSIGNED NOT NULL,
    `keyboard_price` DOUBLE(8, 2) NOT NULL,
    `date_from` DATE NOT NULL
);
CREATE TABLE `orders`(
    `id_order` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `address_id` INT UNSIGNED NOT NULL,
    `order_date` DATE NOT NULL,
    `order_delivery_date` DATE NOT NULL
);
CREATE TABLE `keyboards_suppliers`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `keyboard_id` INT UNSIGNED NOT NULL,
    `supplier_id` INT UNSIGNED NOT NULL,
    `keyboard_quantity` INT NOT NULL,
    `supplier_delivery_date` DATE NOT NULL
);
CREATE TABLE `addresses`(
    `id_address` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `customer_id` INT UNSIGNED NOT NULL,
    `city_name` VARCHAR(255) NOT NULL,
    `address` VARCHAR(255) NOT NULL,
    `postcode` VARCHAR(255) NOT NULL,
    `address_default` TINYINT(1) NOT NULL
);
CREATE TABLE `keyboards`(
    `id_keyboard` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `keyboard_name` VARCHAR(255) NOT NULL,
    `keyboard_description` TEXT NOT NULL
);
ALTER TABLE
    `keyboards_price` ADD CONSTRAINT `keyboards_price_id_foreign` FOREIGN KEY(`id`) REFERENCES `keyboards`(`id_keyboard`);
ALTER TABLE
    `orders_keyboards` ADD CONSTRAINT `orders_keyboards_order_id_foreign` FOREIGN KEY(`order_id`) REFERENCES `orders`(`id_order`);
ALTER TABLE
    `orders_keyboards` ADD CONSTRAINT `orders_keyboards_keyboard_id_foreign` FOREIGN KEY(`keyboard_id`) REFERENCES `keyboards`(`id_keyboard`);
ALTER TABLE
    `addresses` ADD CONSTRAINT `addresses_customer_id_foreign` FOREIGN KEY(`customer_id`) REFERENCES `customers`(`id_customer`);
ALTER TABLE
    `keyboards_suppliers` ADD CONSTRAINT `keyboards_suppliers_keyboard_id_foreign` FOREIGN KEY(`keyboard_id`) REFERENCES `keyboards`(`id_keyboard`);
ALTER TABLE
    `orders` ADD CONSTRAINT `orders_address_id_foreign` FOREIGN KEY(`address_id`) REFERENCES `addresses`(`id_address`);
ALTER TABLE
    `keyboards_suppliers` ADD CONSTRAINT `keyboards_suppliers_supplier_id_foreign` FOREIGN KEY(`supplier_id`) REFERENCES `suppliers`(`id_supplier`);