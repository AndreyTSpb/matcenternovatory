<?php

/**
 * Class Class_Get_Name_Role - получаем имя роли
 */
class Class_Get_Name_Role
{
    static function name($id){
        $obj = new Model_Roles(['where'=>'id = '.($id)]);
        if(!$obj->fetchOne()) return 'No Role';
        return $obj->name;
    }
}