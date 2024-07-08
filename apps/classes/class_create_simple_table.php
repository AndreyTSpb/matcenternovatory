<?php


class Class_Create_Simple_Table
{
    static function html($header, $body){
        ob_start();
        include('./apps/views/templates/simple_table.php');
        return ob_get_clean();
    }
}