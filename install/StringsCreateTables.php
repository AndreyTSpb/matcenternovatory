<?php


namespace install;

/**
 * Class StringsCreateTables - строки для создания таблиц в БД
 * @package install\strings_create_tables
 */
class StringsCreateTables
{
    /**
     * Создание таблицы с клиентами
     * @return string
     */
    function createTableCustomers(){
        return "CREATE TABLE `customers` ".
            "(`id` INT NOT NULL AUTO_INCREMENT , ".
            "`name` VARCHAR(255) NULL , ".
            "`email` VARCHAR(255) NULL , ".
            "`phone` VARCHAR(25) NULL , ".
            "`dt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , ".
            "`note` TEXT NULL , ".
            "`del` INT(1) NOT NULL DEFAULT '0' , ".
            "PRIMARY KEY (`id`)) ".
            "ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;";
    }

    /**
     * Создания таблицы с заказами
     * @return string
     */
    function createTableOrders(){
        return "CREATE TABLE `orders` ".
            "(`id` INT NOT NULL AUTO_INCREMENT , ".
            "`status` INT(1) NOT NULL DEFAULT '0' , ".
            "`send` INT(1) NOT NULL DEFAULT '0' , ".
            "`dt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , ".
            "`dt_ext` INT NOT NULL DEFAULT '0' , ".
            "`id_group` INT NULL , ".
            "`price` FLOAT NULL DEFAULT '0' , ".
            "`fee` FLOAT NULL DEFAULT '0' , ".
            "`dt_pay` INT NOT NULL DEFAULT '0' , ".
            "`transaction_id` TEXT NOT NULL , ".
            "`pdf_url` TEXT NOT NULL , ".
            "`id_user` INT NOT NULL DEFAULT '0' , ".
            "`note` TEXT NOT NULL , PRIMARY KEY (`id`))".
            " ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;";
    }

    /**
     * Создание таблици с преподами
     * @return string
     */
    function createTableTeachers(){
        return "CREATE TABLE `teachers` (`id` INT NOT NULL AUTO_INCREMENT , ".
            "`name` VARCHAR(255) NULL , ".
            "`dt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , ".
            "`email` VARCHAR(255) NULL , ".
            "`phone` INT(15) NOT NULL DEFAULT '0' , ".
            "`education` TEXT NULL , ".
            "`note` TEXT NULL , ".
            "`del` INT(1) NOT NULL DEFAULT '0' , ".
            "PRIMARY KEY (`id`)) ".
            "ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;";
    }

    /**
     * Создание таблицы с внутриними пользователями
     * @return string
     */
    function createTableUsers(){
        return "CREATE TABLE `users` ".
                    "(`id` INT NOT NULL AUTO_INCREMENT , ".
                    "`name` VARCHAR(255) NOT NULL , ".
                    "`email` VARCHAR(255) NOT NULL , ".
                    "`pass` VARCHAR(255) NOT NULL , ".
                    "`session_id` VARCHAR(255) NOT NULL , ".
                    "`del` INT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`))".
                " ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci COMMENT = 'Таблица с пользователями системы';";
    }

    /**
     * Создание таблицы с группами
     * @return string
     */
    function createTableGroups(){
        return "CREATE TABLE `groups` ".
            "(`id` INT NOT NULL AUTO_INCREMENT , ".
            "`name` VARCHAR(255) NULL , ".
            "`dt_start` INT NULL , ".
            "`dt_end` INT NULL , ".
            "`price` FLOAT NULL DEFAULT '0' , ".
            "`max_user` INT NULL DEFAULT '0' , ".
            "`mon` INT(1) NULL DEFAULT '0' , ".
            "`tue` INT(1) NULL DEFAULT '0' , ".
            "`wed` INT(1) NULL DEFAULT '0' , ".
            "`thu` INT(1) NULL DEFAULT '0' , ".
            "`fri` INT(1) NULL DEFAULT '0' , ".
            "`sat` INT(1) NULL DEFAULT '0' , ".
            "`sun` INT(1) NULL DEFAULT '0' , ".
            "`note` TEXT NULL , ".
            "`del` INT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ".
            "ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;";
    }

    /**
     * Создание таблиц со списком преподов для группы
     * @return string
     */
    function createTableTeachersForGroups(){
        return "CREATE TABLE `teachers_for_groups` ".
            "(`id` INT NOT NULL AUTO_INCREMENT , ".
            "`id_group` INT NULL , ".
            "`id_teach` INT NULL , ".
            "`dt` INT NOT NULL , ".
            "`del` INT(1) NOT NULL DEFAULT '0' , ".
            "PRIMARY KEY (`id`)) ".
            "ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci COMMENT = 'Таблица со списком преподов для группы';";
    }


    /**
     * Создание таблицы с опциями(редко меняющимися значениями)
     * @return string
     */
    function createTableOptions(){
        return "CREATE TABLE `test_bd`.`options` ".
            "(`id` INT NOT NULL AUTO_INCREMENT , ".
            "`name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , ".
            "`value` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , ".
            "`del` INT(1) NOT NULL DEFAULT '0' , ".
            "PRIMARY KEY (`id`)) ENGINE = InnoDB;";
    }


}