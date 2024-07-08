<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 26/09/2019
 * Time: 09:54
 */

Class Controller_Main extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->model = new Model_Main();
    }

    function action_index()
    {

        $data['nameCompany'] = $this->model->nameCompany;
        $data['labelCompany'] = $this->model->labelCompany;
        if($this->model->role == 1){
            $data['title']      = "Мои заявки";
            $data['view_menu_file'] = 'admin_menu.php';
            $data['buttons']     = array(
                $this->model->btn_new_order(),
                $this->model->btn_select_admin(),
                $this->model->btn_select_date()
            );
        }elseif ($this->model->role == 2){
            $data['title']      = "Все заявки (СуперАдмин)";
            $data['view_menu_file'] = 'super_admin_menu.php';
            $data['buttons']     = array(
                $this->model->btn_new_order(),
                $this->model->btn_select_admin(),
                $this->model->btn_select_date()
            );
            $data['content']    = $this->model->get_super_admin_data();
        }else{
            $data['title']      = "Мои заявки";
            $data['content']    = $this->model->get_user_data();
            $data['buttons']     = array(
                $this->model->btn_new_order(),
                $this->model->btn_select_date()
            );
            $data['view_menu_file'] = 'user_menu.php';
        }
        $this->view->generate('order_view.php', 'page.php', $data);
    }
}