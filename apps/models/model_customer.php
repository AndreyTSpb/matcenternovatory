<?php


class Model_Customer extends Model
{
    public $id_cust;

    function get_data(){
        $data['url'] = '/customer';
        return Class_Get_Buffer::returnBuffer($data, 'forms/customer_form_view.php');
    }

    public function addCustomer($posts)
    {
        /**
         * Array (
         *  [name] => Арсен Владленович Баширов
         *  [phone] => +77778885599
         *  [email] => ppp@mail.mail
         *  [note] => test
         *  [save_cust] =>
         * )
         */
        $obj = new Model_Customers();
        $obj->name  = htmlspecialchars($posts['name']);
        $obj->email = htmlspecialchars($posts['email']);
        $obj->phone = Class_Clear_Phone::setPhone($posts['phone']);
        $obj->note  =   $posts['note'];
        if(!$obj->save()){
            Class_Alert_Message::error("Клиент не добавлен");
            return false;
        }
        Class_Alert_Message::succes("Клиент добавлен");
        return true;
    }

    public function get_info_customer()
    {
        $obj =  new Model_Customers(array("where"=>"id = ".$this->id_cust));
        if(!$obj->fetchOne()) {
            Class_Alert_Message::error("Клиент не найден");
            header('Location: /groups');
            exit;
        }
        $formInfo['title'] = $this->titleCustomer($obj->name, $obj->del);
        $data = array(
            "url"  => "/customer",
            "id_cust" => $obj->id,
            "name" => $obj->name,
            "email" => $obj->email,
            "phone" => $obj->phone,
            "del"   => $obj->del
        );
        $formInfo['content'] = Class_Get_Buffer::returnBuffer($data, 'forms/customer_form_view.php');
        return $formInfo;
    }

    private function titleCustomer($name, $status){
        $action_text = ($status == 0)? "<span class='text-success'>Активная</span>":"<span class='text-warning'>Удалена</span>";
        return "Клиент: " . $name ." - " . $action_text;
    }

    public function updateCustomer($posts)
    {
        $obj = new Model_Customers(array("where"=>"id = ".(int)$posts['id_cust']));
        if(!$obj->fetchOne()) return false;
        $obj->name  = htmlspecialchars($posts['name']);
        $obj->phone = Class_Clear_Phone::setPhone($posts['phone']);
        $obj->email = htmlspecialchars($posts['email']);
        $obj->note  = htmlspecialchars($posts['note']);
        if(!$obj->update()) {
            Class_Alert_Message::error("Клиент не обновлен");
            return false;
        }
        return true;
    }

    public function delCustomer($posts)
    {
        $obj = new Model_Customers(array("where"=>"id = ".(int)$posts['id_cust']));
        if(!$obj->fetchOne()) return false;
        if($obj->del == 0)  $obj->del = 1; else $obj->del = 0;
        if(!$obj->update()) {
            Class_Alert_Message::error("Клиент не обновлен");
            return false;
        }
        return true;
    }
}