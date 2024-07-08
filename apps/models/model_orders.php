<?php


class Model_Orders extends Mysql
{
    public $id;
    public $dt;
    public $dt_ext;
    public $text;
    public $status;
    public $file_name;
    public $ip_comp;
    public $name_comp;
    public $klass_truble_id;
    public $type_truble_id;
    public $users_id;

    public function fieldsTable()
    {
        return array(
            'id'                => 'id',
            'dt'                => 'dt',
            'dt_ext'            => 'dt_ext',
            'text'              => 'text',
            'status'            => 'status',
            'file_name'         => 'file_name',
            'ip_comp'           => 'ip_comp',
            'name_comp'         => 'name_comp',
            'klass_truble_id'   => 'klass_truble_id',
            'type_truble_id'    => 'type_truble_id',
            'users_id'          => 'users_id'
        );
    }
}