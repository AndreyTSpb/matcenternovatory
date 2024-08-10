<?php


class Model_Bills extends Model
{
    public function get_data()
    {
        return Class_Create_Simple_Table::html($this->headerTable(), $this->bodyTable());
    }

    private function headerTable()
    {
        return array("ПП", "Счет", "Клиент", "Группа", "Цена", "Оплачен", "Отправлен", "Дата выставления", "Дата оплаты", "Действия");
    }

    private function bodyTable(){
        $arr = array();

        $obj = new Model_Orders(array("order"=>"id ASC"));
        if(!$obj->num_row) {
            /**
             * Поумолчанию если нет данных
             */
            $arr[] = array(
                'class_tr' => 'table-light',
                'tds' => array(
                    "pp"        => 1,
                    "id"        => '1',
                    "customer"  => 'Нет данных',
                    "group"     => 'Нет данных',
                    "price"     => 'Нет данных',
                    "pay"       => 'Нет данных',
                    "send"      => 'Нет данных',
                    "dt_create" => 'Нет данных',
                    "dt_pay"    => 'Нет данных',
                    "action"    => 'Нет данных'
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
                 *  [status] => 0
                 *  [send] => 1
                 *  [dt] => 2024-08-09 11:41:16
                 *  [dt_ext] => 1723237200
                 *  [id_group] => 2
                 *  [price] => 21
                 *  [fee] => 0
                 *  [dt_pay] => 1723313001
                 *  [transaction_id] => d8327c28-4a8e-4084-93ea-a94b7bd144c5
                 *  [pdf_url] => https://example.com/qwetq
                 *  [id_user] => 2
                 *  [note] => test 1
                 * )
                 */
                if($row['status'] == 1 ) $pay = "Оплачен"; elseif ($row['status'] == 2) $pay = "Отменен"; else $pay = "Не оплачен";
                $send = ($row['send'] == 1)?"Отправлен":"Не отправлен";
                $arr[] = array(
                    'class_tr' => 'table-light',
                    'tds' => array(
                        "pp"        => $k++,
                        "id"        => "<a href='/bill?id=".$row['id']."'>".$row['id']."</a>",
                        "customer"  => "<a href='/bill?id=".$row['id']."'>".Class_Get_Name_Customer::name($row['id_user'])."</a>",
                        "group"     => "<a href='/bill?id=".$row['id']."'>".Class_Get_Name_Group::name($row['id_group'])."</a>",
                        "price"     => $row['price'],
                        "pay"       => $pay,
                        "send"      => $send,
                        "dt_create" => date("d.m.Y", strtotime($row['dt'])),
                        "dt_pay"    => date("d.m.Y", $row['dt_pay']),
                        "action"    => 'Нет данных'
                    )
                );
            }
        }
        return $arr;
    }
}