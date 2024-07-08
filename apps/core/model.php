<?php
/**
 * Created by PhpStorm.
 * User: atynyanygmail.com
 * Date: 02/05/2019
 * Time: 14:18
 */

class Model
{
    public $model;
    public $view;
    public $id_user;
    public $session_id;
    public $role;
    public $nameCompany;
    public $labelCompany;

    function __construct()
    {
        $this->role = 2;
        $this->nameCompany = 'nameCompany';
        $this->labelCompany = 'bootstrap-logo.svg';
    }

    /*
        Модель обычно включает методы выборки данных, это могут быть:
            > методы нативных библиотек pgsql или mysql;
            > методы библиотек, реализующих абстракицю данных. Например, методы библиотеки PEAR MDB2;
            > методы ORM;
            > методы для работы с NoSQL;
            > и др.
    */
    // метод выборки данных
    public function get_data()
    {
        // todo
        return true;
    }

}
