<?php


class Class_Get_Customer_Info
{
    public $name;
    public $email;
    public $phone;

    public function __construct($id)
    {
        $obj = new Model_Customers(array("where"=>"id = ".(int)$id));
        if(!$obj->fetchOne()) return false;
        $this->name = $obj->name;
        $this->email = $obj->email;
        $this->phone = $obj->phone;
    }
}