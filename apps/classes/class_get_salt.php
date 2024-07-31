<?php

/**
 * Class Class_Get_Salt - получение соли
 */
class Class_Get_Salt
{
    static function get(){
        $obj = new Model_Options(["where"=>"name = 'saltKey'"]);
        if(!$obj->fetchOne()) return false;
        return $obj->value;
    }
}