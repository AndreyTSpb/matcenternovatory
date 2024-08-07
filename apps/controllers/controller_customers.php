<?php


class Controller_Customers extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Model_All_Customers();
    }
    public function action_index(){
        $data = $this->data;
        $data['url'] = "/customer";
        $data['title']      = "Список клиентов";
        $data['view_menu_file'] = 'super_admin_menu.php';
        $data['buttons']     = array(
            //$this->model->btn_new_order(),
            //$this->model->btn_select_admin(),
            //$this->model->btn_select_date()
        );
        $data['actionButtons'] = $this->model->getActionButtons();
        $data['content']    = $this->model->get_data();

        $this->view->generate('groups_view.php', 'page.php', $data);
    }
}