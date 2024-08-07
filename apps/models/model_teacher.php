<?php


class Model_Teacher extends Model
{
    /**
     * Список быстрых комманд на странице
     */
    function getActionButtons(){
        return array(
            "Выставить счет" => "bill/add",
            "Добавить клиента" => "customer/add",
            "Добавить препода" => "teacher/add"
        );
    }

    /**
     * @return bool|false|string
     */
    function get_data()
    {
        $data['url'] = "/teacher";
        //
        $formTeachInfo = Class_Get_Buffer::returnBuffer($data, 'forms/teacher_form_view.php');
        return $formTeachInfo;
    }

    /**
     * Вывод данных препода для редактирования
     * @param $id_teach
     * @return false|string
     */
    function get_data_edit($id_teach)
    {
        $data['url'] = "/teacher";
        //
        if(empty($id_teach)){
            Class_Alert_Message::error("Id не передан");
            return false;
        }
        $obj = new Model_Teachers();
        $row = $obj->getRowById($id_teach);
        /**
         * Array (
         *  [id] => 1
         *  [name] => Петр Владленович Баширов
         *  [dt] => 2024-08-01 16:13:55
         *  [email] => ppp@mail.mail
         *  [phone] => 77778885599
         *  [education] =>
         *  [note] => 32e23 4344 34543
         *  [del] => 0
         * )
         */
        $formTeachInfo['title'] = $this->titleTeach($row['name'], $row['del']);
        $data = array(
            "url"  => "/teacher",
            "id_teacher" => $id_teach,
            "name" => $row['name'],
            "email" => $row['email'],
            "phone" => $row['phone'],
            "education" => $row['education'],
            "note" => $row['note'],
            "del"   => $row['del']
        );
        $formTeachInfo['content'] = Class_Get_Buffer::returnBuffer($data, 'forms/teacher_form_view.php');
        return $formTeachInfo;
    }

    private function titleTeach($name, $status){
        $action_text = ($status == 0)? "<span class='text-success'>Активный</span>":"<span class='text-warning'>Удален</span>";
        return "Преподаватель: " . $name ." - " . $action_text;
    }

    /**
     * Информация о преподе
     */
    function get_info(){
        $formTeachInfo = Class_Get_Buffer::returnBuffer($data, 'forms/teacher_info_view.php');
        return $formTeachInfo;
    }

    public function add_teach($posts)
    {
        $obj = new Model_Teachers();
        $obj->name  = htmlspecialchars($posts['name_teacher']);
        $obj->phone = Class_Clear_Phone::setPhone($posts['phone']);
        $obj->email = htmlspecialchars($posts['email']);
        $obj->note  = htmlspecialchars($posts['note']);
        $obj->education = htmlspecialchars($posts['edu']);
        if(!$obj->save()) {
            Class_Alert_Message::error("Препод не добавлен");
            return false;
        }
        return true;
    }

    public function edit_teach($posts)
    {
        $obj = new Model_Teachers(array("where"=>"id = ".(int)$posts['id_teacher']));
        if(!$obj->fetchOne()) return false;
        $obj->name  = htmlspecialchars($posts['name_teacher']);
        $obj->phone = Class_Clear_Phone::setPhone($posts['phone']);
        $obj->email = htmlspecialchars($posts['email']);
        $obj->note  = htmlspecialchars($posts['note']);
        $obj->education = htmlspecialchars($posts['edu']);
        if(!$obj->update()) {
            Class_Alert_Message::error("Препод не обновлен");
            return false;
        }
        return true;
    }
    public function del_teacher($posts)
    {
        $obj = new Model_Teachers(array("where"=>"id = ".(int)$posts['id_teacher']));
        if(!$obj->fetchOne()) return false;
        if($obj->del == 0)  $obj->del = 1; else $obj->del = 0;
        if(!$obj->update()) {
            Class_Alert_Message::error("Препод не обновлен");
            return false;
        }
        return true;
    }

}