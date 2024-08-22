<?php


class Model_All_Teachers extends Model
{

    public function get_data()
    {
        $arr =  array();
        $obj = new Model_Teachers(array("order"=>"name ASC"));
        if(!$obj->num_row) {
            /**
             * Поумолчанию если нет данных
             */
            $arr[] = array(
                'class_tr' => 'table-light',
                'tds' => array(
                    "pp"        => 1,
                    "id"        =>'1',
                    "period"    => 'Нет данных',
                    "groupName" => 'Нет данных',
                    "daysWeak"  => 'Нет данных',
                    "del"  => 'Нет данных',
                    "maxUsers"  => 'Нет данных'
                )
            );
        } else{
            $rows = $obj->getAllRows();
            //
            foreach ($rows AS $row){
                $del = ($row['del'] == 1) ? "Удален": "Действующий";
                $arr[] = array(
                    'class_tr' => 'table-light',
                    'tds' => array(
                        "pp"        => 1,
                        "id"        => $row['id'],
                        "name"      => "<a href='/teacher/edit?id=".$row['id']."'>".$row['name']."</a>",
                        "phone"     => '+'.$row['phone'],
                        "email"     => $row['email'],
                        "del"     => $del,
                        "action"    => 'Нет данных'
                    )
                );
            }
        }
        return Class_Create_Simple_Table::html($this->headerTable(), $arr);
    }

    function headerTable(){
        return array("ПП", "Ид", "Препод", "Телефон", "E-Mail", "Статус","Действия");
    }
}