<?php
/**
 * Created by PhpStorm.
 * User: enotpotaskun
 * Date: 10/08/2024
 * Time: 21:29
 */

class Class_Get_Name_Customer
{
    static function name($id){
        $obj = new Model_Customers(array('where'=>"id = ".(int)$id));
        $obj->fetchOne();
        return $obj->name;
    }
}