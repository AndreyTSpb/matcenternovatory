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
        print_r($_POST);
        exit;
    }

    public function action_save_salt_option(){
        print_r($_POST);
        exit;
    }

    public function action_save_tbank_option(){
        print_r($_POST);
        exit;
    }
}