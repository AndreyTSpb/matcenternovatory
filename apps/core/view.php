<?php
/**
 * Created by PhpStorm.
 * User: atynyanygmail.com
 * Date: 02/05/2019
 * Time: 14:21
 */

class View
{
    //public $template_view; // здесь можно указать общий вид по умолчанию.

    /*
    $content_file - виды отображающие контент страниц;
    $template_file - общий для всех страниц шаблон;
    $data - массив, содержащий элементы контента страницы. Обычно заполняется в модели.
    */
    function generate($content_view, $template_view, $data = null)
    {
        if(is_array($data)) {

            // преобразуем элементы массива в переменные
            extract($data);
        }
        /*
        динамически подключаем общий шаблон (вид),
        внутри которого будет встраиваться вид
        для отображения контента конкретной страницы.
        */
        include 'apps/'.TP_FOLDER.'/'.$template_view;
    }
}
