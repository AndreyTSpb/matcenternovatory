<?php


class Class_Clear_Phone
{
    static public function setPhone($phone)
    {
        $pho = preg_replace("#[^0-9]#", "", $phone);
        return "7" . substr($pho, 1);
    }
}