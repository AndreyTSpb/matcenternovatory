<?php


class Model_Roles extends Mysql
{
    public $id;
    public $name;
    public $del;

    public function fieldsTable() {
        return array(
            'id' => 'id',
            'name' => 'name',
            'del' => 'del'
        );
    }
}