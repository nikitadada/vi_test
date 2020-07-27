DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `price` decimal(10,2) NOT NULL COMMENT '(DC2Type:decimal)',
    `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `orders_products`;
CREATE TABLE `orders_products` (
    `order_id` bigint(20) NOT NULL,
    `product_id` bigint(20) NOT NULL,
    PRIMARY KEY (`order_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;