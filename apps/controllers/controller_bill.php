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
            if(!$this->model->sendBill()){
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
}