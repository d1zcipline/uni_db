CREATE TABLE `suppliers`(
    `id_supplier` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `supplier_name` VARCHAR(255) NOT NULL,
    `supplier_country` VARCHAR(255) NULL
);
CREATE TABLE `cart`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `customer_id` INT UNSIGNED NOT NULL,
    `keyboard_id` INT UNSIGNED NOT NULL,
    `quantity` INT NOT NULL
);
CREATE TABLE `customers`(
    `id_customer` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `first_name` VARCHAR(255) NULL,
    `last_name` VARCHAR(255) NULL,
    `email` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(255) NULL,
    `password` VARCHAR(255) NOT NULL
);
CREATE TABLE `keyboards_price`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `keyboard_id` INT UNSIGNED NOT NULL,
    `keyboard_price` INT NOT NULL,
    `date_from` DATE NOT NULL
);
CREATE TABLE `orders`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `address_id` INT UNSIGNED NOT NULL,
    `order_date` DATE NOT NULL,
    `order_delivery_date` DATE NULL
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
    `address` VARCHAR(255) NOT NULL
);
CREATE TABLE `keyboards`(
    `id_keyboard` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `keyboard_name` VARCHAR(255) NOT NULL,
    `keyboard_description` TEXT NOT NULL,
    `keyboard_image` VARCHAR(255) NULL
);
ALTER TABLE
    `cart` ADD CONSTRAINT `cart_customer_id_foreign` FOREIGN KEY(`customer_id`) REFERENCES `customers`(`id_customer`);
ALTER TABLE
    `cart` ADD CONSTRAINT `cart_keyboard_id_foreign` FOREIGN KEY(`keyboard_id`) REFERENCES `keyboards`(`id_keyboard`);
ALTER TABLE
    `addresses` ADD CONSTRAINT `addresses_customer_id_foreign` FOREIGN KEY(`customer_id`) REFERENCES `customers`(`id_customer`);
ALTER TABLE
    `keyboards_suppliers` ADD CONSTRAINT `keyboards_suppliers_keyboard_id_foreign` FOREIGN KEY(`keyboard_id`) REFERENCES `keyboards`(`id_keyboard`);
ALTER TABLE
    `orders` ADD CONSTRAINT `orders_address_id_foreign` FOREIGN KEY(`address_id`) REFERENCES `addresses`(`id_address`);
ALTER TABLE
    `keyboards_price` ADD CONSTRAINT `keyboards_price_keyboard_id_foreign` FOREIGN KEY(`keyboard_id`) REFERENCES `keyboards`(`id_keyboard`);
ALTER TABLE
    `keyboards_suppliers` ADD CONSTRAINT `keyboards_suppliers_supplier_id_foreign` FOREIGN KEY(`supplier_id`) REFERENCES `suppliers`(`id_supplier`);