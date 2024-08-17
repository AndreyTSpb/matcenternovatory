<?php


class Model_User extends Model
{
    public $id_user;

    function getUser(){
        $data = array();

        if($this->id_user){
            $obj = new Model_Users(['where'=>"id = ".(int)$this->id_user]);
            if(!$obj->fetchOne()) {
                Class_Alert_Message::error("Не найдена такая запись");
                return false;
            }
            $data = array(
                'id' => $obj->id,
                'name' => $obj->name,
                'role' => $obj->role,
                'email' => $obj->email,
                'del'   => $obj->del
            );
            $userInfo['title'] = 'Пользователь системы: '.$obj->name;
        }

        $data['url'] = '/user';

        $userInfo['title'] = "Новый пользователь";
        $userInfo['content'] = Class_Get_Buffer::returnBuffer('forms/user_form_view.php', $data);
        return $userInfo;
    }

    function updateUser($posts){
        /**
         * Array ( [name] => Тарас Степанович Пупкин [email] => iii@mail.mail [role] => 2 [save_user] => [id_user] => 3 )
         */
        $obj = new Model_Users(['where'=>"id = ".(int)$posts['id_user']]);
        if(!$obj->fetchOne()) {
            Class_Alert_Message::error("Не найдена такая запись");
            return false;
        }
        if(!empty($posts['name'])) $obj->name = $posts['name'];
        $obj->role = $posts['role'];
        if(!empty($posts['email'])) $obj->email = $posts['email'];

        if(!$obj->update()){
            Class_Alert_Message::error("Запись не обновлена");
            return false;
        }
        Class_Alert_Message::succes("Запись обновлена");
        return true;
    }

    function delUser(){
        $obj = new Model_Users(['where'=>"id = ".(int)$this->id_user]);
        if(!$obj->fetchOne()) {
            Class_Alert_Message::error("Не найдена такая запись");
            return false;
        }
        if($obj->del == 0) $obj->del = 1; else $obj->del = 0;
        if(!$obj->update()){
            Class_Alert_Message::error("Запись не обновлена");
            return false;
        }
        Class_Alert_Message::succes("Запись обновлена");
        return true;
    }

    public function add($posts){
        /**
         * Array (
         *  [name] =>
         *  [email] => ppp@mail.mail
         *  [role] => 0
         *  [pass] => moneta-akvaA1
         *  [save_user] =>
         * )
         */
        $obj = new Model_Users();
        if(!empty($posts['name'])) $obj->name = $posts['name'];
        $obj->role = $posts['role'];
        if(!empty($posts['email'])) $obj->email = $posts['email'];
        if(!empty($posts['pass'])) $obj->pass = md5($posts['pass']);

        if(!$obj->save()){
            Class_Alert_Message::error("Запись не сохранена");
            return false;
        }
        Class_Alert_Message::succes("Запись сохранена");
        return true;
    }

    function getActionButtons(){
        return array(
            "Выставить счет"   => "bill/add",
            "Добавить клиента" => "customer/add",
            "Добавить группу"  => "group/add",
            "Добавить препода" => "teacher/add",
            "Добавить пользователя"     => "user/add"
        );
    }
    public function updatePass($pass)
    {
        $obj = new Model_Users(['where'=>"id = ".$this->id_user]);
        if(!$obj->fetchOne()) {
            Class_Alert_Message::error("Не найдена такая запись");
            return false;
        }
        $obj->pass = md5($pass);

        if(!$obj->update()){
            Class_Alert_Message::error("Пароль не обновлен");
            return false;
        }
        Class_Alert_Message::succes("Пароль обновлен");
        return true;
    }
}