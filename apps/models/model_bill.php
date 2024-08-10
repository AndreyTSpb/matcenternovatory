<?php


class Model_Bill extends Model
{
    public $id_bill;

    public function get_data($posts = false)
    {
        $data = array();
        $billInfo['title'] = 'Новый счет';
        $data['send_status'] = 0;
        if(!empty($this->id_bill)){
            $bill = $this->getBillInfo();
            $data = $bill;
            $billInfo['title'] = 'Счет № '.$this->id_bill.' от '.$bill['dt'].' - '.$bill['status'];

        }

        $data['url'] = '/bill';
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
    public function sendBill($posts)
    {
        /**
         * Array (
         *  [name] => Петр Петрович Петров
         *  [id_cust] => 2
         *  [phone] => 77778885599
         *  [email] => ppp@mail.mail
         *  [group] => Group-1
         *  [id_group] => 2
         *  [price] => 21
         *  [fee] => 0
         *  [dtExt] => 2024-08-09
         *  [dtCreate] => 2024-08-09
         *  [dtPay] => 1970-01-01
         *  [transactionId] => 0
         *  [note] => test 1
         *  [id_bill] => 1
         *  [send_bill] =>
         * )
         */
        $objTBank = new Class_T_Bank_API();

        $dtExt = strtotime($posts['dtExt']);
        if($dtExt < time()) $dtExt = time()+3*24*60*60;

        /**
         * Вернет в случае успеха {
         *  "pdfUrl":"https://example.com/qwetq",
         *  "invoiceId":"d8327c28-4a8e-4084-93ea-a94b7bd144c5"
         * }
         * Error -
         * Array (
         *      [errorId] => 455098efb4
         *      [errorMessage] => Ваш запрос невалиден: Invalid value for: body
         *      [errorCode] => INVALID_DATA
         *      [errorDetails] => Array (
         *          [Ошибка декодирования] => Illegal json at '[ROOT].items[0].price': Expected number value but found: StringValueToken
         *      )
         * )
         */
        $rez = $objTBank->sendInvoiceToCustomer(
            $posts['id_bill'],
            strtotime($posts['dtCreate']),
            $dtExt,
            array("name"=>$posts['name']),
            array(
                "email"=>$posts['email'],
                "phone"=>$posts['phone']
            ),
            array(
                ["name"=>"Оплата занятий в группе: ".$posts['group'], "price"=>(float)$posts['price']]
            ),
            $posts['note']
        );

        $rez_arr = json_decode($rez, true);
        if(array_key_exists('errorMessage', $rez_arr)){
            Class_Alert_Message::error(
                '<ul>'.
                          '<li>Сервер Т-Банка вернул ошибку</li>'.
                          '<li>errorId: '.$rez_arr['errorId'].'</li>'.
                          '<li>errorMessage: '.$rez_arr['errorMessage'].'</li>'.
                          '<li>errorCode: '.$rez_arr['errorCode'].'</li>'.
                          '<li>errorDetails: '.$rez_arr['errorDetails']['Ошибка декодирования'].'</li>'.
                      '</ul>'
            );
            return false;
        }

        /**
         * Записать адрес чека и транзакцию в системе
         */
        $objOrder  = new Model_Orders(array("where"=>"id = " . (int)$posts['id_bill']));
        if(!$objOrder->fetchOne()){
            Class_Alert_Message::error('НЕ найден счет чтобы внести внего ответ с сбанка');
            return false;
        }
        $objOrder->transaction_id = $rez_arr['invoiceId'];
        $objOrder->pdf_url  =   $rez_arr['pdfUrl'];
        //$objOrder->dt_pay   =   time();
        $objOrder->send     =   1;
        if(!$objOrder->update()) {
            Class_Alert_Message::error('Счет не обновлен');
            return false;
        }
        Class_Alert_Message::succes('Счет отправлен');
        return true;
    }
}