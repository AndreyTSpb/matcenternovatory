<?php


class Class_ChekPass
{
    private $email;
    private $password;
    private $id_user;
    private $session_id;


    /**
     *  Проверка логина и пароля
     * @param $email - логин в формате e-mail
     * @param $password - пароль
     * @return bool
     */
    function check($email, $password)
    {
        $this->email = htmlspecialchars($email);
        $this->password = htmlspecialchars($password);

        if ($this->getUsers())
        {
            //Если проверку прошел, заполняем значения
            setcookie('id_user', $this->id_user, time()+536000, '/');
            setcookie('session_id', $this->session_id, time() +536000, '/');

            return true;
        }
        else
        {
            setcookie('id_user', "", time(), '/');
            setcookie('session_id', "", time(), '/');
            return false;
        }




    }

    /**
     * Проверяем соответствия логина и пароля при авторизации
     */
    private function getUsers(){
        $sql = array("where"=>"email = '".$this->email."' AND pass = '".md5($this->password)."' AND del = 0");
        $objUsers = new Model_Users($sql);
        if(!$objUsers->fetchOne()) return false;
        $this->id_user = $objUsers->id;
        //генерируем и записывам в БД идентификатор сесии
        $this->session_id = Class_Generator_Token::generator();
        //запись идентификатора сесии в таблицу
        $saltKey = Class_Get_Salt::get();

        $objUsers->session_id = md5($this->session_id.$saltKey);
        if(!$objUsers->update()) return false;
        return true;
    }


    /**
     * Проверка авторизации, через куки сесии
     * @param $id_user
     * @param $session_id
     * @return bool
     */
    function checkCookie($id_user, $session_id)
    {
        if(empty($session_id) OR empty($id_user)) return false;


        //phone in md5
        $id = (int)$id_user;
        $objUser = new Model_Users(array("where"=> "id = ".$id));
        if(!$objUser->fetchOne()){
            setcookie('id_user', "", time(), '/');
            setcookie('session_id', "", time(), '/');
            return false;
        }

        $hash_bd = $objUser->session_id;
        // Если хешированная переменная из БД совпадает с переданной в куках,
        // то пользователь авторизован верно
        // Иначе делаем зачистку куков
        $saltKey = Class_Get_Salt::get();

        if ($hash_bd == md5($session_id.$saltKey)) {
            return true;
        }
        else {
            setcookie('id_user', "", time(), '/');
            setcookie('session_id', "", time(), '/');
            return false;
        }
    }
}