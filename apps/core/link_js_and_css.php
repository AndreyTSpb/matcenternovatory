<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 24/04/2021
 * Time: 09:51
 */
/**
 * масивы с сылками на файлы стилей и скрипты
 */
define("NOW", time());
const CSS_FILES = array(
    "user_css"      => array(
        DOCUMENT_STATIC.DS.'bootstrap-4.6.1-dist'.DS.'css'.DS.'bootstrap.min.css',
        CSS.DS.'style.min.css',
        CSS.DS.'card-group.min.css',
        CSS.DS.'login.css',
        CSS.DS.'custom.css'
    ),
);

const JS_FILES = array(
    "users_js" => array(
        //JS.DS."jquery-3.6.0.min.js",
        'https://code.jquery.com/jquery-3.5.1.min.js',
        'https://cdn.jsdelivr.net/npm/jquery.maskedinput@1.4.1/src/jquery.maskedinput.min.js',
        'https://api-maps.yandex.ru/2.1/?lang=ru_RU',
        //'https://unpkg.com/@popperjs/core@2/dist/umd/popper.js',
        //JS.DS."popper.min.js",
        DOCUMENT_STATIC.DS.'bootstrap-4.6.1-dist'.DS.'js'.DS."bootstrap.bundle.js",
        //'https://use.fontawesome.com/releases/v5.15.3/js/all.js',
        JS.DS."slick.min.js",
        JS.DS."jquery.validate.min.js",
        JS.DS."script.js?",
        JS.DS."group_sale.js?v=".NOW,
        JS.DS."jquery.fileinput.js"
    )
);
