<?php
    $folderInstall = "install";
    if (!file_exists($folderInstall)) {
        echo "Папки установочных файлов не найдено";
        exit();
    }

    $host = "localhost";
    $user = "root";
    $pass = "root";
    $dbName = "test_bd";



    include $folderInstall."/class_connect_db.php";

    $objConDb = new install\connect_db\Class_Connect_DB($host,$user,$pass,$dbName);
    if($objConDb->link){
        /**
         * Запись данных по подключению к БД в файл  core/db.php
         */
        if (!file_exists("apps")) {
            echo "Папки c приложением не нашли ";
            exit();
        }
        $text  = "<?php";
        $text .= "/*Подключения к БД*/ \n";
        $text .= "  define('DB_USER', '".$user."');/*Логин*/\n";
        $text .= "  define('DB_PASS', '".$pass."');/*Пароль*/\n";
        $text .= "  define('DB_HOST', '".$host."');/*Сервер*/\n";
        $text .= "  define('DB_NAME', '".$dbName."');/*Имя БД*/\n";

        $filename = 'apps/core/db.php';
        file_put_contents($filename, $text);
    }

    /**
     * Создание необходимых таблиц в Базе Данных
     */

    include $folderInstall ."/StringsCreateTables.php";
    $objStringDb = new install\StringsCreateTables();
    $objConDb->link->query($objStringDb->createTableUsers());
    $objConDb->link->query($objStringDb->createTableCustomers());
    $objConDb->link->query($objStringDb->createTableGroups());
    $objConDb->link->query($objStringDb->createTableOrders());
    $objConDb->link->query($objStringDb->createTableTeachers());
    $objConDb->link->query($objStringDb->createTableTeachersForGroups());
