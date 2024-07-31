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
        $options = $this->getOptions();

        $this->nameCompany = (!empty($options['nameCompany']))?$options['nameCompany']:'nameCompany';
        $this->labelCompany = (!empty($options['labelCompany']))?$options['labelCompany']:'bootstrap-logo.svg';
    }

    /**
     * Получаем основные данные из опцй
     * @return array = Array ( [nameCompany] => Математический Центр г. Москва [labelCompany] => math.png )
     */
    private function getOptions(){
        $obj = new Model_Options(array("where"=>"del = 0"));
        $rows = $obj->getAllRows();
        $options = array();
        foreach ($rows AS $row){
            $options[$row['name']] = $row['value'];
        }
        return $options;
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
        return true;
    }

}
