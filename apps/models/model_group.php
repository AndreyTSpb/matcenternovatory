<?php

/**
 * Class Model_Group - Работа с отдельными группами
 */
class Model_Group extends Model
{
    public $params;

    function getGroupInfo(){

    }

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

    public function get_data()
    {
        $data['url'] = "/group";
        return Class_Get_Buffer::returnBuffer($data, 'forms/new_group_form_view.php');
    }

    /**
     * Добавляем новую группу
     * @param $posts
     * @return bool
     */
    function addGroup($posts){
        /**
         * Сохраняем группу
         */
        $obj = new Model_Groups();
        $obj->name      =   $posts['name_group'];
        $obj->dt_start  = strtotime($posts['dt_start']);
        $obj->dt_end    = strtotime($posts['dt_end']);
        $obj->price     = $posts['cost'];
        $obj->max_user  = $posts['max_users'];
        $obj->note      = $posts['note'];
        //отмечаем дни недели
        foreach ($posts['weak'] AS $day){
            $obj->$day = 1;
        }
        $id_group = $obj->save();
        if(!$id_group) {
            Class_Alert_Message::error('Группа не добавлена');
            return false;
        }
        /**
         * Добавляем преподов для группы
         */
        if(isset($posts['id_teach']) AND is_array($posts['id_teach'])){
            foreach ($posts['id_teach'] AS $id_teach){
                if(!Class_Add_Teachers_To_Group::addTeach($id_group, $id_teach, time())){
                    Class_Alert_Message::error('Препод не добавлен');
                    return false;
                }
            }
        }
        return true;
    }
}