<?php
/**
 * Created by PhpStorm.
 * User: enotpotaskun
 * Date: 10/08/2024
 * Time: 22:53
 */

class Model_Settings extends Model
{
    function get_data()
    {
        $data = $this->options;
        $data['url'] = '/settings';

        $content = Class_Get_Buffer::returnBuffer('forms/general_options_form_view.php', $data);
        $content .= Class_Get_Buffer::returnBuffer('forms/bank_options_form_view.php', $data);
        return $content;
    }

    function saveOptions($name, $value){
        $obj = new Model_Options(array("where" => "name = '".$name."'", "limit"=>1));
        if(!$obj->fetchOne()){
            $obj->name = $name;
            $obj->value = $value;
            if(!$obj->save()){
                Class_Alert_Message::error("Значение не добавлено");
                return false;
            }
            Class_Alert_Message::succes("Значение добавлено");
            return true;
        }
        $obj->value = $value;
        if(!$obj->update()){
            Class_Alert_Message::error("Значение не обновлено");
            return false;
        }
        Class_Alert_Message::succes("Значение обновлено");
        return true;
    }
}