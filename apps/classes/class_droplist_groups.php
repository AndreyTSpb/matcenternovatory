<?php


class Class_Droplist_Groups
{
    private $data;
    public $id_group;

    function __construct()
    {
        $this->getData();
    }

    private function getData(){
        $obj = new Model_Groups(array('where'=>"del = 0", "order"=>"name ASC"));
        if(!$obj->num_row) return false;
        $data = array();
        $rows = $obj->getAllRows();
        foreach ($rows AS $row){
            $data[$row['id']] = $row['name'];
        }
        $this->data = $data;
    }

    public function html(){
        $options = '<option value="0">...</option>';

        foreach ($this->data AS $id=>$name){
            $selected = "";
            if($this->id_group == $id) $selected = "selected";
            $options .= '<option value="'.$id.'" '.$selected.'>'.$name.'</option>';
        }

        return '<select id="id_group" class="form-select"  name="id_group">' .$options. '</select>';
    }
}