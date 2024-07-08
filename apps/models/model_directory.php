<?php


class Model_Directory extends Model
{
    public $url;

    function leftMenu($index = 'user'){
        $active = $index;
        return Class_Get_Buffer::returnBuffer(compact('active'), 'menu/sidebar_menu.php');
    }

    function getAllUsers(){
        /**
         * Все заявки пользователя
         */
        $header = array(
            '#',
            'ФИО',
            'Роль',
            'Телефон',
            'E-Mail',
            'PC Name'
        );
        $body = $this->bodyAllUsers();
        return Class_Create_Simple_Table::html($header, $body);
    }

    function bodyAllUsers(){
        $obj = new Model_Users(
            ['where' => 'del = 0',
                "order" => 'name ASC'
            ]);
        if(!$obj->num_row){
            return array(
                0 => array(
                    'class_tr' => 'table-light',
                    'tds' => array(
                        '1',
                        'Нет данных',
                        'Нет данных',
                        'Нет данных',
                        'Нет данных',
                        'Нет данных'
                    )
                )
            );
        }
        $arr = array();
        $rows = $obj->getAllRows();
        foreach ($rows as $row){
            $arr[$row['id']]['class_tr'] = '';
            $arr[$row['id']]['tds'] = array(
                $row['id'],
                "<a href='".DOCUMENT_ROOT."/".$this->url."/edit_user?id=".$row['id']."'>".$row['name']."</a>",
                Class_Get_Name_Role::name($row['roles_id']),
                $row['phone'],
                $row['email'],
                $row['pc_name']
            );
        }

        return $arr;
    }

    function formAddUser(){
        $data = array(
            'labelCompany'  => $this->labelCompany,
            'urlSave'       => DOCUMENT_ROOT.'/directory/new_user',
            'urlReturn'     => DOCUMENT_ROOT.'/directory',
            'method'        => 'post'
        );
        return Class_Get_Buffer::returnBuffer($data,'add_user_view.php');
    }

    function formEditUser($id_user){
        $obj = new Model_Users(['where'=>'id = '.(int)$id_user]);
        if(!$obj->fetchOne()) {
            return false;
        }
        $data = array(
            'labelCompany'  => $this->labelCompany,
            'urlSave'       => DOCUMENT_ROOT.'/directory/edit_user',
            'urlReturn'     => DOCUMENT_ROOT.'/directory',
            'method'        => 'post',
            'id'            => $id_user,
            'userName'      => $obj->name,
            'pcName'        => $obj->pc_name,
            'email'         => $obj->email,
            'phone'         => $obj->phone,
            'roles_id'      => $obj->roles_id
        );
        return Class_Get_Buffer::returnBuffer($data,'add_user_view.php');
    }

    function saveUser($post){
        /**
         * Array (
         *      [id] =>
         *      [userName] =>
         *      [pcName] =>
         *      [email] =>
         *      [phone] =>
         *      [role] =>
         *      [pass] =>
         *      [pass1] =>
         *      [otdel] =>
         * )
         * Array (
         *  [id] =>
         *  [userName] => Иванов Петр Сергеивич
         *  [pcName] => pc1-opt.spb.local
         *  [email] => spb.ips@company.ru
         *  [phone] => 78100
         *  [role] => 0
         *  [type] => California
         *  [pass] => 1111
         *  [pass1] => 1111
         *  [save] =>
         * )
         */

        if($post['pass'] !== $post['pass1']){
            Class_Alert_Message::error('Пароли не совпадают');
            return false;
        }
        $obj = new Model_Users();
        $obj->name = $post['userName'];
        $obj->pass = md5($post['pass']);
        $obj->pc_name = $post['pcName'];
        $obj->email = $post['email'];
        $obj->phone = (int)$post['phone'];
        $obj->roles_id = (int)$post['role'];
        if(!$obj->save()) {
            Class_Alert_Message::error('Не сохранено в БД');
            return false;
        }
        Class_Alert_Message::succes('Новый пользователь '.$post['userName'].'добавлен!');
        return true;
    }

    function updateUser($post){
        /**
         * Array (
         *      [id] =>
         *      [userName] =>
         *      [pcName] =>
         *      [email] =>
         *      [phone] =>
         *      [role] =>
         *      [otdel] =>
         * )
         */
        $obj = new Model_Users(['where'=>'id = '.(int)$post['id']]);
        if(!$obj->fetchOne()){
            Class_Alert_Message::error('Не найдена запись в БД');
            return false;
        }
        $obj->name = $post['userName'];
        $obj->pass = md5($post['pass']);
        $obj->pc_name = $post['pcName'];
        $obj->email = $post['email'];
        $obj->phone = (int)$post['phone'];
        $obj->roles_id = (int)$post['role'];
        if(!$obj->update()) {
            Class_Alert_Message::error('Не обновлено в БД');
            return false;
        }
        Class_Alert_Message::succes('Пользователь '.$post['userName'].' обновлен!');
        return true;
    }

    function updateUserPsw($post){
        $obj = new Model_Users(['where'=>'id = '.(int)$post['id']]);
        if(!$obj->fetchOne()){
            Class_Alert_Message::error('Не найдена запись в БД');
            return false;
        }
        if($post['pass'] !== $post['pass1']){
            Class_Alert_Message::error('Пароли не совпадают');
            return false;
        }
        $obj->pass = md5($post['pass']);
        if(!$obj->update()) {
            Class_Alert_Message::error('Не обновлено в БД');
            return false;
        }
        Class_Alert_Message::succes('Пароль пользователя '.$post['userName'].' обновлен!');
        return true;
    }
}