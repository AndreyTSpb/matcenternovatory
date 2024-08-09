<?php


class Class_Get_Group_Info
{
    public $name;
    public $dt_start;
    public $dt_end;
    public $price;
    public $max_user;
    public $days;

    public function __construct($id)
    {
        $obj = new Model_Groups(array("where"=>"id = ".(int)$id));
        if(!$obj->fetchOne()) return false;
        $this->name = $obj->name;
        $this->dt_start = $obj->dt_start;
        $this->dt_end   = $obj->dt_end;
        $this->price    = $obj->price;
        $this->max_user = $obj->max_user;
        $this->days = array(
            $obj->mon, $obj->tue, $obj->wed, $obj->thu, $obj->fri, $obj->sat, $obj->sun
        );
    }
}