<?php


class Class_Bill_Status_Update
{
    static function update($id_bill, $status){
        if(empty($id_bill)) return false;
        $obj = new Model_Orders(array("where"=>"id = ".(int)$id_bill));
        if(!$obj->fetchOne()) return false;
        $obj->status = $status;
        if($status == 1) $obj->dt_pay = time();
        if(!$obj->update()) return false;
        return true;
    }
}