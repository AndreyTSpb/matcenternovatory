<?php


class Class_Droplist_Groups
{
    public $html;

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
        $this->html = $this->html($data);
    }

    private function html($data){
        $options = '<option value="0">...</option>';
        foreach ($data AS $id=>$name){
            $options .= '<option value="'.$id.'">'.$name.'</option>';
        }
        return '<select id="id_group" class="form-select"  name="id_group">' .$options. '</select>';
    }
}