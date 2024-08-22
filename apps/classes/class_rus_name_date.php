<?php


class Class_Rus_Name_Date
{

    static function month(){
        return array("", "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь");
    }

    static function shortDay(){
        return array("", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс");
    }

    static function fullDay(){
        return array("", "Пнедельникн", "Вторник", "Среда", "Четверг","Пятница", "Суббота", "Воскресенье");
    }

    static function shortDayEngToRus(){
        return array("", "Mon"=>"Пн", "Tue"=>"Вт", "Wed"=>"Ср", "Thu"=>"Чт", "Fri"=>"Пт", "Sat"=>"Сб", "Sun"=>"Вс");
    }
}