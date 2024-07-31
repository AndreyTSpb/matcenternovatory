<?php

/**
 * Модель для работы со страницей /login
 * Class Model_Login
 */
class Model_Login extends Model
{
    /**
     * Проверка введенных на форме авторизации логина и пароля
     * @param $email
     * @param $pass
     * @return bool
     */
    function testLogin($email, $pass){
        if(empty($email) OR empty($pass)){
            //Отражение ошибки
            Class_Alert_Message::error("Не заполнен логин или пароль!!!");
            return false;
        }
        $objChek = new Class_ChekPass();
        if(!$objChek->check($email,$pass)){
            //Отражение ошибки
            Class_Alert_Message::error("Пара логин и пароль не совпаадют!!!");
             return false;
        }
        return true;
    }
}