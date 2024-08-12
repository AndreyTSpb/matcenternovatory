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
        $data = "";
        $content = Class_Get_Buffer::returnBuffer($data, 'forms/general_options_form_view.php');
        $content .= Class_Get_Buffer::returnBuffer($data, 'forms/bank_options_form_view.php');
        return $content;
    }
}