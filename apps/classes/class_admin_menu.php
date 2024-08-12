<?php

/**
 * Class Class_Admin_Menu - Массив с меню, лень писать и копировать теги
 */
class Class_Admin_Menu
{
    static  function getArr(){
        return array(
            'Главная' => "main",
            'Счета' => "bills",
            'Клиенты' => "customers",
            'Группы' => "groups",
            'Преподы' => "teachers",
            'Учетки' => "users",
            "Настройки" => "settings"
        );
    }
}