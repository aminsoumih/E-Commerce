CREATE SCHEMA boutique;

CREATE TABLE `boutique`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NULL,
  `password` VARCHAR(100) NULL,
  PRIMARY KEY (`id`))
COMMENT = 'table for autheticated users';

CREATE TABLE `boutique`.`category` (
  `id` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL UNIQUE,
  PRIMARY KEY (`id`)
)
COMMENT='catalog categories';

CREATE TABLE `boutique`.`product` (
  `sku` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) NULL,
  `type` VARCHAR(45) NULL,
  `upc` VARCHAR(45) NULL,
  `price` FLOAT NULL,
  `shipping` FLOAT NULL,
  `description` VARCHAR(500) NULL,
  `manufacturer` VARCHAR(60) NULL,
  `model` VARCHAR(45) NULL,
  `url` VARCHAR(250) NULL,
  `image` VARCHAR(100) NULL,
  PRIMARY KEY (`sku`))
COMMENT = 'catalog products';

CREATE TABLE `boutique`.`product_category` (
  `product_id` INT NOT NULL,
  `category_id` varchar(20) NOT NULL,
  PRIMARY KEY (`product_id`, `category_id`),
  INDEX `FK_PRODUCT_idx` (`product_id` ASC),
  CONSTRAINT `FK_PRODUCT`
    FOREIGN KEY (`product_id`)
    REFERENCES `boutique`.`product` (`sku`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `FK_CATEGORY`
    FOREIGN KEY (`category_id`)
    REFERENCES `boutique`.`category` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

CREATE TABLE `boutique`.`order` (
  `number` INT NOT NULL,
  `user_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  PRIMARY KEY (`number`),
  INDEX `FK_PRODUCT_idx` (`product_id` ASC),
  INDEX `FK_USER_idx` (`user_id` ASC),
  CONSTRAINT `FK_PRODUCT`
    FOREIGN KEY (`product_id`)
    REFERENCES `boutique`.`product` (`upc`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `FK_USER`
    FOREIGN KEY (`user_id`)
    REFERENCES `boutique`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
COMMENT = 'orders table';
