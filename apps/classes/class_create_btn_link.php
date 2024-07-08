<?php

/**
 * Class Class_Create_Btn_Link - создание кнопки в виде ссылки
 */
class Class_Create_Btn_Link
{
    static function smallBtn($link = '/', $style = 'btn btn-outline-secondary', $text = 'text'){
        return '<a href="'.$link.'" class="'.$style.'  btn-sm">'.$text.'</a>';
    }
    static function btn($link = '/', $style = 'btn btn-outline-secondary', $text = 'text'){
        return '<a href="'.$link.'" class="'.$style.'">'.$text.'</a>';
    }
}