<?php

class Model_Users extends Mysql
{
    public $id;
    public $name;
    public $pass;
    public $email;
    public $phone;
    public $roles_id;
    public $del;
    public $pc_name;

    public function fieldsTable() {
        return array(
            'id' => 'id',
            'name' => 'name',
            'pass' => 'pass',
            'email' => 'email',
            'phone' => 'phone',
            'roles_id' => 'roles_id',
            'del' => 'del',
            'pc_name' => 'pc_name',
        );
    }
}