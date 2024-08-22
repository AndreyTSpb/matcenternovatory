<?php


class Controller_Bill extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Model_Bill();
    }

    public function action_add(){
        $data = $this->data;
        $data['url'] = "/bill";
        $data['view_menu_file'] = 'super_admin_menu.php';
        $data['buttons']     = array(
            //$this->model->btn_new_order(),
            //$this->model->btn_select_admin(),
            //$this->model->btn_select_date()
        );
        $data['actionButtons'] = $this->model->getActionButtons();
        $billInfo           = $this->model->get_data();
        $data['content']    = $billInfo['content'];
        $data['title']      = $billInfo['title'];

        $this->view->generate('groups_view.php', 'page.php', $data);
    }

    public function action_index($params){
        if(!array_key_exists('id', $params) OR empty($params['id'])){
            header("Location: /bills");
            exit();
        }
        $this->model->id_bill = (int)$params['id'];
        $data = $this->data;
        $data['url'] = "/bill";

        $data['buttons']     = array(
            //$this->model->btn_new_order(),
            //$this->model->btn_select_admin(),
            //$this->model->btn_select_date()
        );
        $data['actionButtons'] = $this->model->getActionButtons();
        $billInfo           = $this->model->get_data();
        $data['content']    = $billInfo['content'];
        $data['title']      = $billInfo['title'];

        $this->view->generate('groups_view.php', 'page.php', $data);
    }

    public function action_save(){

        if(isset($_POST['id_bill']) AND !empty($_POST['id_bill'])) $this->model->id_bill = (int)$_POST['id_bill'];
        /**
         * Сохраняем счет
         */
        if(isset($_POST['save_invoice'])){
            $id_bill = $this->model->saveBill($_POST);
            if(!$id_bill){
                header('Location: /bill/add');
                exit();
            }
            header('Location: /bill?id='.$id_bill);
            exit();
        }
        /**
         * Отправляем счет на оплату
         */
        if(isset($_POST['send_bill'])){
            if(!$this->model->sendBill($_POST)){
                header('Location: /bill?id='.$this->model->id_bill);
                exit();
            }
        }
        /**
         * Удаляем счет
         */
        if(isset($_POST['del_bill'])){
            if(!$this->model->del_bill()){
                header('Location: /bill?id='.$this->model->id_bill);
                exit();
            }
        }
        header("Location: /bills");
        exit;
    }

    /**
     * Проверка счета на оплату
     * @return bool
     */
    public function action_test_bill(){
        /**
         * Array ( [id_bill] => 3 [send] => )
         */
        if(isset($_POST['send']) AND isset($_POST['id_bill']) AND !empty($_POST['id_bill'])){

            $objOrder = new Model_Orders(array("where" => "id = ".(int)$_POST['id_bill']));
            $objOrder->fetchOne();
            $obj = new Class_T_Bank_API();
            $ivoiseInfo = $obj->getInfoInvoice($objOrder->transaction_id);
            $rez_arr = json_decode($ivoiseInfo, true);
            print_r($rez_arr);
            exit;
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
            if(array_key_exists('status', $rez_arr)){
                switch($rez_arr['status']){
                    case 'SUBMITTED':
                        $text = "<strong>Счет отправлен, но не оплачен</strong>";
                        break;
                    case 'EXECUTED':
                        $text = "<strong>Счет оплачен</strong>";
                        Class_Bill_Status_Update::update($_POST['id_bill'], 1);
                        break;
                    default:
                        $text = "<strong>Черновик</strong>";
                }
                Class_Alert_Message::succes($text);
            }
            header("Location: /bill?id=".(int)$_POST['id_bill']);
            exit();
        }
        header("Location: /bills");
        exit();
    }
}