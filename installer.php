<?php
    $folderInstall = "install";
    if (!file_exists($folderInstall)) {
        echo "Папки установочных файлов не найдено";
        exit();
    }


    include $folderInstall."/class_connect_db.php";
    include $folderInstall ."/StringsCreateTables.php";
    include $folderInstall ."/CreateModelDbFiles.php";

    if(isset($_POST['SEND_CONNECT'])) {


        if(!isset($_POST["host"]) OR empty($_POST["host"]) OR !isset($_POST["login"]) OR empty($_POST["login"]) OR !isset($_POST["password"]) OR empty($_POST["password"]) OR !isset($_POST["dbName"]) OR empty($_POST["dbName"])){
            print_r($_POST);
            exit("Не указвнны данные для подключения");
        }
        $host = $_POST["host"];
        $user = $_POST['login'];
        $pass = $_POST['password'];
        $dbName = $_POST['dbName'];

        $objConDb = new install\connect_db\Class_Connect_DB($host, $user, $pass, $dbName);


        if (!$objConDb->link->connect_errno) {
            /**
             * Запись данных по подключению к БД в файл  core/db.php
             */
            if (!file_exists("apps")) {
                echo "Папки c приложением не нашли ";
                exit();
            }
            $text = "<?php \n";
            $text .= "/*Подключения к БД*/ \n";
            $text .= "  define(\"DB_USER\", \"" . $user . "\");\n";
            $text .= "  define(\"DB_PASS\", \"" . $pass . "\");\n";
            $text .= "  define(\"DB_HOST\", \"" . $host . "\");\n";
            $text .= "  define(\"DB_NAME\", \"" . $dbName . "\");\n";

            $filename = 'apps/core/db.php';
            file_put_contents($filename, $text);
        }

        /**
         * Создание необходимых таблиц в Базе Данных
         */
        $objStringDb = new install\StringsCreateTables();
        $objConDb->link->query($objStringDb->createTableUsers());
        $objConDb->link->query($objStringDb->createTableCustomers());
        $objConDb->link->query($objStringDb->createTableGroups());
        $objConDb->link->query($objStringDb->createTableOrders());
        $objConDb->link->query($objStringDb->createTableTeachers());
        $objConDb->link->query($objStringDb->createTableTeachersForGroups());


        $rez = $objConDb->link->query("SHOW TABLES FROM " . $dbName . ";");
        $arrTablesName = array();
        while ($row = $rez->fetch_assoc()) {
            $arrTablesName[] = $row ["Tables_in_" . $dbName];

            $rez1 = $objConDb->link->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '" . $row ["Tables_in_" . $dbName] . "' AND TABLE_SCHEMA='" . $dbName . "';");
            $arrFields = array();
            while ($row1 = $rez1->fetch_assoc()) {
                $arrFields[] = $row1['COLUMN_NAME'];
            }

            new install\CreateModelDbFiles($row ["Tables_in_" . $dbName], $objConDb->link, $arrFields);
        }
        header("Location: /installer.php");
        exit();
    }

    /**
    * Добавление админского пароля
    */
    if (isset($_POST['SEND_ADMIN'])){
        if (!file_exists("apps/core/db.php")) {
            exit("Папки c приложением не нашли ");
        }
        if(!isset($_POST["login"]) OR empty($_POST["login"]) OR !isset($_POST["password1"]) OR empty($_POST["password1"]) OR !isset($_POST["password2"]) OR empty($_POST["password2"]) ){
            print_r($_POST);
            exit("Не указвнны данные для подключения");
        }
        if($_POST["password1"] !== $_POST["password2"]) exit("Пароли не совпадают");

        include "apps/core/db.php";
        $objConDb = new install\connect_db\Class_Connect_DB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        //$rez = $objConDb->link->query("INSERT INTO `users` (`id`, `name`, `email`, `pass`, `del`) VALUES (NULL, 'Administrator', '".$_POST["login"]."', '".md5($pass)."', '0');");
        $objConDb->link->query("INSERT INTO `users` (`id`, `name`, `email`, `pass`, `del`) VALUES (NULL, 'Administrator', '".$_POST["login"]."', '".md5($_POST["password1"])."', '0');");
        header("Location: /installer.php");
        exit();
    }

    /**
     * Удаление инсталятора
     */
    if(isset($_POST['SEND_END'])){
        unlink("installer.php");
        header("Location: /");
        exit();
    }

    /**
     * Подключения
     * @return string
     */
    function testConnect(){
        if (!file_exists("apps/core/db.php")) {
            return true;
        }
        include "apps/core/db.php";
        $objConDb = new install\connect_db\Class_Connect_DB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        return $objConDb->link->connect_errno;
    }

    /**
     * Проверка наличия таблицы пользователей
     * @return bool|mysqli_result\
     */
    function testExistTableUser(){
        if (!file_exists("apps/core/db.php")) {
            exit("Папки c приложением не нашли ");
        }
        include "apps/core/db.php";
        $objConDb = new install\connect_db\Class_Connect_DB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        return $objConDb->link->query("CHECK TABLE users;");
    }

    /**
     * Проверка наличия записей в таблице пользователей
     * @return int
     */
    function testExistUserAdmin(){
        if (!file_exists("apps/core/db.php")) {
            exit("Папки c приложением не нашли ");
        }
        include "apps/core/db.php";
        $objConDb = new install\connect_db\Class_Connect_DB(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $rez = $objConDb->link->query("SELECT * FROM users WHERE name = 'Administrator';");
        return $rez->num_rows;
    }

?>
<!doctype html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Настройка приложения!</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <div class="row">
            <div class="col-6 m-auto">
                <h1>Настройка приложения!</h1>
            </div>
        </div>
        <div class="row">
            <?php if (testConnect()):?>
                <div class="col-6 m-auto">
                    <form method="post">
                        <fieldset>
                            <legend>Настройка подключения к БД</legend>
                            <div class="mb-3">
                                <label for="host" class="form-label">Хост</label>
                                <input type="text" class="form-control" name="host" id="host" aria-describedby="hostlHelp" value="localhost">
                                <div id="hostHelp" class="form-text">Имя хоста.</div>
                            </div>
                            <div class="mb-3">
                                <label for="dbName" class="form-label">Название БД</label>
                                <input type="text" class="form-control" name="dbName" id="dbName" aria-describedby="dbNameHelp" >
                                <div id="dbNameHelp" class="form-text">Название БД.</div>
                            </div>
                            <div class="mb-3">
                                <label for="login" class="form-label">Логин</label>
                                <input type="text" class="form-control" name="login" id="login" aria-describedby="emailHelp">
                                <div id="emailHelp" class="form-text">Логин для доступа к БД.</div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Пароль</label>
                                <input type="password" class="form-control" name="password" id="password" aria-describedby="passwordHelp">
                                <div id="passwordHelp" class="form-text">Пароль для доступа к БД.</div>
                            </div>
                            <button type="submit" class="btn btn-primary" name="SEND_CONNECT">Отправить</button>
                        </fieldset>
                    </form>
                </div>
            <?php elseif(testExistTableUser() AND !testExistUserAdmin()):?>
                <div class="col-6 m-auto">
                    <form method="post">
                        <fieldset>
                            <legend>Логин и пароль для администратора</legend>
                            <div class="mb-3">
                                <label for="login" class="form-label">Логин</label>
                                <input type="email" class="form-control" name="login" id="login" aria-describedby="emailHelp">
                                <div id="emailHelp" class="form-text">Вкачестве логина используйте e-mail.</div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Пароль</label>
                                <input type="password" class="form-control" name="password1" id="password1" aria-describedby="passwordHelp">
                                <div id="passwordHelp" class="form-text">Пароль для доступа к сайту.</div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Подтвердить пароль</label>
                                <input type="password" class="form-control" name="password2" id="password2" aria-describedby="passwordHelp">
                                <div id="passwordHelp" class="form-text">Подтверждение пароля.</div>
                            </div>
                            <button type="submit" class="btn btn-primary" name="SEND_ADMIN">Отправить</button>
                        </fieldset>
                    </form>
                </div>
            <?php elseif(testExistTableUser() AND testExistUserAdmin()):?>
                <div class="col-6 m-auto">
                    <form method="post">
                        <fieldset>
                            <legend>Завершение установки</legend>
                            <button type="submit" class="btn btn-primary" name="SEND_END">Отправить</button>
                        </fieldset>
                    </form>
                </div>
            <?php endif;?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
