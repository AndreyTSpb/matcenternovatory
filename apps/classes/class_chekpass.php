<?php


class Class_ChekPass
{
    private $email;
    private $password;
    private $id_user;
    private $session_id;

    function check($email, $password)
    {
        $this->email = htmlspecialchars($email);
        $this->password = htmlspecialchars($password);

        if ($this->getUsers())
        {
            setcookie('id_user', $this->id_user, time()+536000, '/');
            setcookie('id_user', $this->session_id, time() +536000, '/');

            return true;
        }
        else
        {
            setcookie('id_user', "", time(), '/');
            setcookie('id_user', "", time(), '/');
            return false;
        }




    }

    private function getUsers(){
        $objUsers = new Model_Users(array("where"=>"email = '".$this->email."' AND pass = '".md5($this->password)."' AMD del = 0"));
        if(!$objUsers->fetchOne()) return false;
        $this->id_user = $objUsers->id;
        $this->session_id = Class_Generator_Token::generator();
        if(!$objUsers->update()) return false;
        return true;
    }

    function checkCookie($id_user, $session_id)
    {
        //phone in md5
        $id = (int)$id_user;
        $objUser = new Model_Users(array("where"=> "id = ".$id));
        if(!$objUser->fetchOne()){
            setcookie('id_user', "", time(), '/');
            setcookie('session_id', "", time(), '/');
            return false;
        }

        $hash_bd = md5($$objUser->session_id);
        if ($hash_bd == md5($session_id))
        {
            return true;
        }
        else
        {
            setcookie('id_admin', "", time(), '/');
            setcookie('phone_admin', "", time(), '/');
            setcookie('password_admin', "", time(), '/');
            setcookie('roles_admin', "", time(), '/');
            return false;
        }
    }
}