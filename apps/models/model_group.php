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
        return Class_Get_Buffer::returnBuffer('forms/group_form_view.php', $data);
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
                if(!Class_Add_Teachers_To_Group::addTeach($this->id_group, $id_teach, time())){
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
        $data['userToGroup'] = $this->getUsers_Group();
        return Class_Get_Buffer::returnBuffer('forms/group_info_view.php', $data);
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


    public function getUsers_Group(){
        return Class_Create_Simple_Table::html($this->headerTableUsers(), $this->getUsers());
    }

    private function headerTableUsers()
    {
        return array("ПП", "Ид", "ФИО", "Счет", "Сумма оплаты", "Дата оплаты", "Месяц", "Действия");
    }

    private function getUsers()
    {
        global $link;
        $sql = "SELECT cus.id AS id_user, ".
            "cus.name AS name, cus.email AS email, cus.phone AS phone, ".
            "ord.id_group AS id_group, ord.price AS price, ".
            "ord.dt_pay  AS dt_pay, ord.month AS `month`, ".
            "ord.id AS id_bill, ord.dt AS dt_order ".
            "FROM `customers` AS cus LEFT JOIN orders AS ord ON cus.id = ord.id_user ".
            "WHERE ord.status = 1 AND ord.id_group = ".$this->id_group." ORDER BY cus.name ASC;";

        ///exit($sql);
        $list = array();

        $obj = $link->query($sql);
        if(!$obj->num_rows){
            /**
             * Поумолчанию если нет данных
             */
            $list[] = array(
                'class_tr' => 'table-light',
                'tds' => array(
                    "pp"        => 1,
                    "id"        =>'1',
                    "period"    => 'Нет данных',
                    "bill"    => 'Нет данных',
                    "groupName" => 'Нет данных',
                    "daysWeak"  => 'Нет данных',
                    "maxUsers"  => 'Нет данных',
                    "teachers"  => 'Нет данных'
                )
            );
        }else{
            $rusMonth = Class_Rus_Name_Date::month();
            while ($item = $obj->fetch_assoc()){
                $str_month = "";
                foreach (explode(', ', $item['month']) AS $month)  $str_month .= $rusMonth[$month];
                $list[] = array(
                    'class_tr' => 'table-light',
                    'tds' => array(
                        "pp" => 1,
                        "id" => $item['id_user'],
                        "name" => "<a href='/customer/edit?id=".$item['id_user']."'>".$item['name']."</a>",
                        "order" => "<a href='/bill?id=".$item['id_bill']."'> Счет №".$item['id_bill']." от ".date("d.m.Y", strtotime($item['dt_order']))."</a>",
                        "price" => $item['price'],
                        "dt_pay" => date("d.m.Y", $item['dt_pay']),
                        "month" => $str_month,
                        "teachers" => 'Нет данных'
                    )
                );
            }
        }
        return $list;
    }


    public function getTachers_Group(){
        return Class_Create_Simple_Table::html($this->headerTableTeacher(), $this->getTeachers());
    }

    private function headerTableTeacher()
    {

    }

    private function getTeachers()
    {

    }
}