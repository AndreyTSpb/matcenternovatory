<?php
/**
 * Created by PhpStorm.
 * User: enotpotaskun
 * Date: 10/08/2024
 * Time: 22:50
 */

class Controller_Settings extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Model_Settings();
    }

    public function action_index(){

        $data = $this->data;
        $data['url'] = "/settings";

        $data['buttons']     = array(
            //$this->model->btn_new_order(),
            //$this->model->btn_select_admin(),
            //$this->model->btn_select_date()
        );
        $data['actionButtons'] = $this->model->getActionButtons();
        $setting            = $this->model->get_data();
        $data['content']    = $setting;
        $data['title']      = 'Настройки';

        $this->view->generate('groups_view.php', 'page.php', $data);
    }

    public function action_save_general_option(){
        ///Array ( [nameCompany] => fsdf [save_nameCompany] => )
        if(isset($_POST['save_nameCompany'])){
            print_r($_POST['nameCompany']);
            $this->model->saveOptions('nameCompany', $_POST['nameCompany']);
        }
        header("Location: /settings");
        exit();
    }

    public function action_save_salt(){
        //Array ( [salt] => fdsfdsgfgfsdg [save_salt] => )
        $this->model->saveOptions('salt', $_POST['salt']);
        header("Location: /settings");
        exit();
    }

    public function action_save_tbank_options(){
        //Array ( [accountNumber] => 325435435436 [token] => 54365463546 [name] => 65765765 [inn] => 7576 [kpp] => 657657 [save_tbank] => )
        if(isset($_POST['save_tbank'])){
            array_pop($_POST);
            foreach ($_POST AS $key => $value)
                $this->model->saveOptions($key, $value);
        }

        header("Location: /settings");
        exit();
    }

    public function action_save_email_account(){

        /**
         * Array (
         *  [emailLogin] => tynyanyi@mail.ru
         *  [passwordLogin] => gfdgfdg
         *  [titleMessage] => fdgfgfdsg
         *  [bodyMessage] => sfdgsfgd
         *  [footerMessage] => sfgfsdg
         *  [save_email] =>
         * )
         */
        if(isset($_POST['save_email'])){
            array_pop($_POST); //ткидываем последний элемент
            foreach ($_POST AS $key => $value)
                $this->model->saveOptions($key, $value);
        }

        header("Location: /settings");
        exit();
    }
}