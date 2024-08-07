<?php

/**
 * Class Model_Group - Работа с отдельными группами
 */
class Model_Group extends Model
{
    public $params;
    public $id_group;
    public $groupTitle;


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
        if(!empty($this->id_group)){
            $data['groupInfo'] = $this->groupInfo();
        }
        return Class_Get_Buffer::returnBuffer($data, 'forms/group_form_view.php');
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

    public function updateGroup($posts){
        /**
         * Array (
         *  [name_group] => Group-1
         *  [dt_start] => 2024-09-09
         *  [dt_end] => 2024-09-30
         *  [weak] => Array (
         *      [0] => mon
         *      [1] => mon
         *      [2] => mon
         *  )
         *  [cost] => 1000
         *  [max_users] => 12
         *  [note] => цувцу цууц цувцу note ввцув
         *  [id_group] => 2
         *  [save_group] =>
         * )
         */
        $obj = new Model_Groups(array("where"=>"id = " . (int)$posts['id_group']));
        if(!$obj->fetchOne()) {
            Class_Alert_Message::error("Ненайдена группа");
            return false;
        }

        $obj->name      =   $posts['name_group'];
        $obj->dt_start  = strtotime($posts['dt_start']);
        $obj->dt_end    = strtotime($posts['dt_end']);
        $obj->price     = $posts['cost'];
        $obj->max_user  = $posts['max_users'];
        $obj->note      = $posts['note'];
        //очищаем дни
        $obj->mon = $obj->thu = $obj->wed = $obj->tue = $obj->fri = $obj->sat = $obj->sun = 0;
        //отмечаем новые дни недели
        foreach ($posts['weak'] AS $day){
            $obj->$day = 1;
        }
        if(!$obj->update()) {
            Class_Alert_Message::error('Группа не обновлена');
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

    public function get_group_info()
    {
        $data['url'] = "/group";
        /**
         * Данные о группе
         */
        $data['groupInfo'] = $this->groupInfo();
        return Class_Get_Buffer::returnBuffer($data, 'forms/group_info_view.php');
    }

    private function groupInfo(){
        /**
         * Данные о группе
         */
        $obj =  new Model_Groups(array("where"=>"id = ".$this->id_group));
        if(!$obj->fetchOne()) {
            Class_Alert_Message::error("Группа не найдена");
            header('Location: /groups');
            exit;
        }
        $nameGroup = $obj->name;
        //Период
        $dt_start = $obj->dt_start;
        $dt_end = $obj->dt_end;
        //Дни занятия
        $mon = $obj->mon;
        $tue = $obj->tue;
        $wed = $obj->wed;
        $thu = $obj->thu;
        $fri = $obj->fri;
        $sat = $obj->sat;
        $sun = $obj->sun;
        //Стоимость
        $price = $obj->price;
        //Количество мест
        $max_users = $obj->max_user;
        //Примечание
        $note = $obj->note;
        //Статус дален или нет
        $del = $obj->del;
        //Для названия в шапке
        $action_text = ($del == 0)? "<span class='text-success'>Активный</span>":"<span class='text-warning'>Удален</span>";
        $this->groupTitle = "Группа: " . $nameGroup . " - " . $action_text;

        return array(
            "id_group" => $this->id_group,
            "name_group" => $nameGroup,
            "period" => array(
                    "dt_start"  =>  $dt_start,
                    "dt_end"    =>  $dt_end
                ),
            "days"  => array(
                $mon, $tue, $wed, $thu, $fri, $sat, $sun
            ),
            "price" => $price,
            "max_user"  => $max_users,
            "users" => Class_Users_In_Group::getQntUsers($this->id_group),
            "note"  => $note,
            "del"   => $del
        );
    }

    public function delGroup($id_group){
        $obj = new Model_Groups(array("where"=>"id = " . (int)$id_group));
        if(!$obj->fetchOne()) {
            Class_Alert_Message::error("Ненайдена группа");
            return false;
        }
        $obj->del = 1;
        if(!$obj->update()) {
            Class_Alert_Message::error('Группа не удалена');
            return false;
        }
        return true;
    }
}