<?php


class Model_All_Users extends Model
{
    function get_data(){
        return Class_Create_Simple_Table::html($this->headerTable(), $this->bodyTable());
    }


    private function headerTable()
    {
        return array("ПП", "Пользователь", "Роль", "Логин", "Статус");
    }

    private function bodyTable(){

        $arr = array();

        $obj = new Model_Users(['order'=>"name ASC"]);
        if(!$obj->num_row) {
            /**
             * Поумолчанию если нет данных
             */
            $arr[] = array(
                'class_tr' => 'table-light',
                'tds' => array(
                    "pp"        => 1,
                    "id"        => '1',
                    "user"  => 'Нет данных',
                    "role"     => 'Нет данных',
                    "login"     => 'Нет данных',
                    "status"       => 'Нет данных'
                )
            );
        }else{
            $rows = $obj->getAllRows();
            //
            $k = 1;
            foreach ($rows AS $row){
                /**
                 * Array (
                 *  [id] => 1
                 *  [name] => Administrator
                 *  [role] => 1
                 *  [email] => test@test.ru
                 *  [pass] => 81dc9bdb52d04dc20036dbd8313ed055
                 *  [session_id] => 74b80ce42260fefeec8a1e1170812689
                 *  [del] => 0
                 * )
                 */
                if($row['role'] == 1 ) $role = "Администратор"; elseif ($row['role'] == 2) $role = "СуперАдминистратор"; else $role = "Пользователь";
                $arr[] = array(
                    'class_tr' => 'table-light',
                    'tds' => array(
                        "pp"        => $k++,
                        "name"  => "<a href='/user?id=".$row['id']."'>".$row['name']."</a>",
                        "role"     => "<a href='/user?id=".$row['id']."'>".$role."</a>",
                        "email"     => $row['email'],
                        "action"    => 'Нет данных'
                    )
                );
            }
        }
        return $arr;
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
}