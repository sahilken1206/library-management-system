
-- Library & Book Management System
-- Database schema
-- Import into an empty MySQL database.

CREATE TABLE IF NOT EXISTS `users` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `authors` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `books` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(100) NOT NULL,
    `author` VARCHAR(100) NOT NULL,
    `category` VARCHAR(50) DEFAULT NULL,
    `quantity` INT(11) DEFAULT 1,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `members` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `loans` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `book_id` INT(11) NOT NULL,
    `member_id` INT(11) NOT NULL,
    `loan_date` DATE NOT NULL,
    `due_date` DATE DEFAULT NULL,
    `return_date` DATE DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `book_id` (`book_id`),
    KEY `member_id` (`member_id`),
    CONSTRAINT `loans_ibfk_1`
        FOREIGN KEY (`book_id`)
        REFERENCES `books` (`id`)
        ON DELETE RESTRICT
        ON UPDATE RESTRICT,
    CONSTRAINT `loans_ibfk_2`
        FOREIGN KEY (`member_id`)
        REFERENCES `members` (`id`)
        ON DELETE RESTRICT
        ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
