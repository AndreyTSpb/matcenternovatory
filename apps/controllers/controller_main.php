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
        $data = $this->data;


        $data['title']      = "Главная страниц";
        $data['view_menu_file'] = 'super_admin_menu.php';
        $data['buttons']     = array(
            $this->model->btn_new_order(),
            $this->model->btn_select_admin(),
            $this->model->btn_select_date()
        );
        //$data['content']    = $this->model->get_super_admin_data();


        $this->view->generate('order_view.php', 'page.php', $data);
    }
}