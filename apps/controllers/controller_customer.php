<?php


class Controller_Customer extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Model_Customer();
    }

    public function action_add(){
        $data = $this->data;
        $data['url'] = "/customer";
        $data['title']      = "Новый клиент";
        $data['view_menu_file'] = 'super_admin_menu.php';
        $data['buttons']     = array(
            //$this->model->btn_new_order(),
            //$this->model->btn_select_admin(),
            //$this->model->btn_select_date()
        );
        $data['actionButtons'] = $this->model->getActionButtons();
        $data['content']    = $this->model->get_data();

        $this->view->generate('groups_view.php', 'page.php', $data);
        exit("tyt");
    }

    public function action_edit($params){
        if(!isset($params['id']) OR empty($params['id'])){
            Class_Alert_Message::error("Id не передан");
            header("Location: /customers");
            exit();
        }
        $this->model->id_cust = (int)$params['id'];
        $data = $this->data;
        $customerInfo =  $this->model->get_info_customer();
        $data['content'] = $customerInfo['content'];
        $data['title']  = $customerInfo['title'];

        $data['url'] = "/customer";
        $data['view_menu_file'] = 'super_admin_menu.php';
        $data['buttons']     = array(
            //$this->model->btn_new_order(),
            //$this->model->btn_select_admin(),
            //$this->model->btn_select_date()
        );
        $data['actionButtons'] = $this->model->getActionButtons();

        $this->view->generate('groups_view.php', 'page.php', $data);
        exit("tyt");
    }

    public function action_save(){
        /**
         * Array (
         *  [name_teacher] => Арсен Владленович Баширов
         *  [phone] => +77778885599
         *  [email] => ppp@mail.mail
         *  [note] => test
         *  [save_cust] =>
         * )
         */
        if(isset($_POST['save_cust'])){
            if(isset($_POST['id_cust']) AND !empty($_POST['id_cust'])){
                if(!$this->model->updateCustomer($_POST)){
                    header("Location: /customers");
                    exit();
                }
            }else{
                if(!$this->model->addCustomer($_POST)){
                    header("Location: /customer/add");
                    exit;
                }
            }
        }
        /**
         * Нажата кнопка "Удалить" на форме
         */
        if(isset($_POST['id_cust']) AND !empty($_POST['id_cust']) AND isset($_POST['del_cust'])){
            if(!$this->model->delCustomer($_POST)){
                header("Location: /customer/edit?id=".$_POST['id_cust']);
                exit();
            }
        }

        header("Location: /customers");
        exit;
    }
}