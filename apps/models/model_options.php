<?php

/**
 * Модель для таблицы БД Options
 * Class Model_Options
 */
class Model_Options extends Mysql
{
    public $id;
    public $name;
    public $value;
    public $del;

    public function fieldsTable() {
        return array(
            'id' => 'id',
            'name' => 'name',
            'value' => 'value',
            'del' => 'del'
        );
    }
}