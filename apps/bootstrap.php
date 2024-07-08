<?php
/**
 * Created by PhpStorm.
 * User: atynyanygmail.com
 * Date: 02/05/2019
 * Time: 13:30
 */
// подключаем файлы ядра
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/db.php';
require_once 'core/config.php'; //фаил конфигурвции


spl_autoload_register(function ($className) {
    //echo "IWant Load ". $className; echo '<p>'; exit;
    /**
     * Создаем имя файла
     */
    $fileName = strtolower($className).'.php';
    /**
     * Узнаем в какой папке лежит файл
     */
    $expArr = explode('_', $className);
    //print_r($expArr);exit;
    if(empty($expArr[1]) or empty($expArr)){
        $folder = 'apps' . DS . 'core';
    }else{
        $filePath = strtolower($expArr[0]);
        switch ($filePath){
            case 'controller':
                $folder = 'apps' . DS . 'controllers';
                break;
            case 'model':
                $folder = 'apps' . DS . 'models';
                break;
            case 'views':
                $folder = 'apps' . DS . 'views';
                break;
            case 'class':
                $folder = 'apps' . DS . 'classes';
                break;
        }
    }
    /**
     * Полный путь до файла на сайте
     */
    $file = $folder . DS . $fileName;
    /**
     * проверяем естьли такой файл
     */
    if(!file_exists($file)){
        echo "Not File!!! ". $file;
        exit;
    }else{
        /**
         * Подключаем файл
         */
        include $file;
    }
});
/*
Здесь обычно подключаются дополнительные модули, реализующие различный функционал:
	> аутентификацию
	> кеширование
	> работу с формами
	> абстракции для доступа к данным
	> ORM
	> Unit тестирование
	> Benchmarking
	> Работу с изображениями
	> Backup
	> и др.
*/
require_once 'core/route.php';
Route::start(); // запускаем маршрутизатор
