<?php

/**
 * Class Class_Add_Teachers_To_Group
 * Добавление преподователя в группу
 */
class Class_Add_Teachers_To_Group
{
    static function addTeach($id_group, $id_teach, $dt){
        $obj = new Model_Teachers_for_groups();
        $obj->id_group = (int)$id_group;
        $obj->id_teach = (int)$id_teach;
        $obj->dt = $dt;
        if(!$obj->save()) return false;
        return true;
    }
}