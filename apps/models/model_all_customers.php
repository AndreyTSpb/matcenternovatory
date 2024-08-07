<?php


class Model_All_Customers extends Model
{
   function get_data()
   {
       return Class_Create_Simple_Table::html($this->headerTable(), $this->bodyTable());
   }

   private function bodyTable(){
       $arr = array();

       $obj = new Model_Customers(array("where"=>"del = 0", "order"=>"name ASC"));
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
                   "maxUsers"  => 'Нет данных'
               )
           );
       }else{
           $rows = $obj->getAllRows();
           //
           foreach ($rows AS $row){
               $arr[] = array(
                   'class_tr' => 'table-light',
                   'tds' => array(
                       "pp"        => 1,
                       "id"        => $row['id'],
                       "name"      => "<a href='/customer/edit?id=".$row['id']."'>".$row['name']."</a>",
                       "phone"     => '+'.$row['phone'],
                       "email"     => $row['email'],
                       "action"    => 'Нет данных'
                   )
               );
           }
       }
       return $arr;
   }

    private function headerTable()
    {
        return array("ПП", "Ид", "Клиент", "Телефон", "E-Mail", "Действия");
    }
}