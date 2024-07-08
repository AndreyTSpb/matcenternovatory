<?php

/**
 * Class Class_Alert_Message - ывод сообщения об ошибках на вверху страници
 */
class Class_Alert_Message
{
    static function error($text){
        $_SESSION['alert'] = ['text'=>$text, 'type'=>"error"];
    }

    static function succes($text){
        $_SESSION['alert'] = ['text'=>$text, 'type'=>"success"];
    }

    static function widget($text = false, $type = false){

        switch ($type){
            case 'error':
                ob_start();
                include "./apps/views/widget/error.php";
                return ob_get_clean();
            case 'success':
                ob_start();
                include "./apps/views/widget/succes.php";
                return ob_get_clean();
        }
    }

    static function clear(){
        $_SESSION['alert'] = "";
    }
}