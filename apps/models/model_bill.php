<?php


class Model_Bill extends Model
{
    public $id_bill;

    public function get_data($posts = false)
    {
        $data['url'] = '/bill';
        $billInfo['title'] = 'Новый счет';
        if(!empty($this->id_bill)){
            $bill = $this->getBillInfo();
            $data = $bill;
            $billInfo['title'] = 'Счет № '.$this->id_bill.' от '.$bill['dt'].' - '.$bill['status'];

        }

        $billInfo['content'] = Class_Get_Buffer::returnBuffer($data, 'forms/bill_form_view.php');
        return $billInfo;
    }

    private function getBillInfo(){
        //"<span class='text-warning'>Удалена</span>"
        $obj = new Model_Orders(array("where"=>"id = ".$this->id_bill));
        if(!$obj->fetchOne()){
            Class_Alert_Message::error("счет не найден");
            header("Location: /bills");
            exit();
        }

        switch ($obj->status){
            case 1:
                $status = "<span class='text-success'>Оплачен</span>";
                break;
            case 2:
                $status = "<span class='text-danger'>Удален</span>";
                break;
            default:
                $status = "<span class='text-warning'>Ожидает оплаты</span>";
                break;
        }

        switch ($obj->send){
            case 0:
                $status_send = "<span class='text-danger'>Не Отправлен</span>";
                break;
            case 1:
                $status_send = "<span class='text-success'>Отправлен</span>";
                break;
        }
        //Данные о пользователе
        $objCustomer = new Class_Get_Customer_Info($obj->id_user);
        //
        $objGroup = new Class_Get_Group_Info($obj->id_group);

        return array(
            'id_bill'   => $this->id_bill,
            'status'    => $status,
            'del'       => $obj->status,
            'send_status_text'   => $status_send,
            'send_status'       => $obj->send,
            'id_cust'   => $obj->id_user,
            'name'      => $objCustomer->name,
            'phone'     => $objCustomer->phone,
            'email'     => $objCustomer->email,
            'id_group'  => $obj->id_group,
            'group_name' => $objGroup->name,
            'price'     => $obj->price,
            'fee'       => $obj->fee,
            'dtPay'    => date("Y-m-d", $obj->dt_pay),
            'dt'        => date("d.m.Y", strtotime($obj->dt)),
            'dtCreate'        => date("Y-m-d", strtotime($obj->dt)),
            'dtExt'    => date("Y-m-d", $obj->dt_ext),
            'transactionId' => $obj->transaction_id,
            'note'          => $obj->note
        );
    }

    /**
     * Сохранения счета.
     * @param $posts
     * @return bool
     */
    function saveBill($posts){

        if(!array_key_exists('id_cust', $posts) OR empty($posts['id_cust'])){
            Class_Alert_Message::error("id_cust не передано");
            return false;
        }
        if(!array_key_exists('id_group', $posts)  OR empty($posts['id_group'])){
            Class_Alert_Message::error("id_group не передано");
            return false;
        }
        /**
         * Array (
         *      [id_cust] => 2
         *      [phone] => +77778885599
         *      [email] => ppp@mail.mail
         *      [id_group] => 2
         *      [price] =>
         *      [fee] =>
         *      [dtExt] => 2024-08-11
         *      [dtCreate] =>
         *      [dtPay] =>
         *      [transactionId] =>
         *      [note] => test bill
         *      [save_invoice] =>
         * )
         */
        $obj = new Model_Orders();
        $obj->id_user   =   (int)$posts['id_cust'];
        $obj->id_group  =   (int)$posts['id_group'];
        $obj->price     =   (float)$posts['price'];
        $obj->dt_ext    =   strtotime($posts['dtExt']);
        $obj->note      =   htmlspecialchars($posts['note']);
        $id_bill = $obj->save();
        if(!$id_bill) {
            Class_Alert_Message::error('Счет не создан');
            return false;
        }
        Class_Alert_Message::succes('Счет создан');
        return $id_bill;
    }

    function del_bill(){
        $obj = new Model_Orders(array("where"=>"id = ".(int)$this->id_bill));
        if(!$obj->fetchOne()) return false;
        if($obj->status > 0 ) return false;
        $obj->status = 2;
        if(!$obj->update()) return false;
        return true;
    }

    /**
     * тправка счета клиенту
     */
    public function sendBill()
    {

    }
}