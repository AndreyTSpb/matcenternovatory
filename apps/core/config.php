<?php
/**
 * Created by PhpStorm.
 * User: atynyanygmail.com
 * Date: 02/05/2019
 * Time: 13:32
 * Файл для хранения констант и строки подключения
 */

//ini_set('memory_limit', '256M'); //размер памяти для загрузки

/*Константы*/
define('DS', DIRECTORY_SEPARATOR); /*Разделитель путей*/
$sitePath = realpath(dirname(__FILE__) . DS);
define('SITE_PATH', $sitePath);/*Путь ккорневой папке*/

define('TP_FOLDER', 'tp'); //Папка для шаблонов

/*Урл сайта полный для header-location*/
$protocol = (!empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS'])?"https://":"http://");
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
define('DOCUMENT_ROOT',$protocol.$host.$uri);

/*Папка для статичных изображений CSS и JS*/
define('DOCUMENT_STATIC', DOCUMENT_ROOT.DS.'web');

/*Строка подключения*/
$link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if($link->connect_errno){
    echo'ERROR CONNECT TO DB' . $link->connect_error;
}
$link->query("SET NAMES utf8");

// Соединяемся с БД
$dbObject = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
$dbObject->exec("set names utf8");

$global_sql_profile_html = '';
$global_sql_summ_time = '';

