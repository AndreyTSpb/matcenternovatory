<?php


class Controller_Order extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Model_Order();
    }

    public function action_new(){
        $data['title']      = "Мои заявки";
        $data['content']    = 'Form';
        $data['buttons']    = array(
        );
        $view_file = 'order_view.php';

        $this->view->generate($view_file, 'index.php', $data);
    }
}