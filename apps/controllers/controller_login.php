<?php


class Controller_Login extends Controller
{

    function __construct()
    {
        parent::__construct();
        $this->model = new Model_Login();
    }

    function action_index()
    {
        if(isset($_POST['email']) AND isset($_POST['pass'])){
            if(!$this->model->testLogin($_POST['email'], $_POST['pass'])){
                //случай ошибки перезагружаем страницу для сброса данных
                header("Location: /login");
                exit();
            }
            //Если успех то отправляем на базовую страницу
            header("Location: /main");
            exit();
        }
        $data['title']         = "Вход";
        $data['url']           = $this->url;
        $this->view->generate('login_view.php', 'page.php', $data);
    }
}