<?php
/**
 * Created by PhpStorm.
 * User: enotpotaskun
 * Date: 10/08/2024
 * Time: 21:31
 */

class Class_Get_Name_Group
{
    static function name($id){
        $obj = new Model_Groups(array('where'=>"id = ".(int)$id));
        $obj->fetchOne();
        return $obj->name;
    }

}