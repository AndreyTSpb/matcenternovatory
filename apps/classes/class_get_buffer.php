<?php

/**
 * Class Class_Get_Buffer - возвращаем из буфера переработаное представление
 * Шаблоны для обработки ишем в папке apps/views
 */

class Class_Get_Buffer
{
    static function returnBuffer($data, $path){
        if(empty($data)){
            return '<div class="alert alert-danger" role="alert">
                      нет данных в переменной $data
                    </div>';
        }
        if(empty($path)){
            return '<div class="alert alert-danger" role="alert">
                      не указан путь в переменной $data
                    </div>';
        }
        ob_start();
        extract($data);
        include('./apps/views/'.$path);
        return ob_get_clean();
    }
}