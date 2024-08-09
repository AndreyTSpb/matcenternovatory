<?php
/**
 * Created by PhpStorm.
 * User: atynyanygmail.com
 * Date: 02/05/2019
 * Time: 14:11
 */

class Controller {

    public $model;
    public $view;
    public $url;
    public $data;

    public function __construct()
    {
        $this->model = new Model();

        /**
         * Для шапки
         */
        $this->url = $url = $_SERVER['REQUEST_URI'];

        $this->data['nameCompany']  = $this->model->nameCompany;
        $this->data['labelCompany'] = $this->model->labelCompany;
        $this->data['menu']         = Class_Admin_Menu::getArr();
        $this->data['url']          = $this->url;
        $this->data['view_menu_file'] = 'super_admin_menu.php';

        //Проверка заполнены ли куки и соответствуют ли они регистрационным данным
        $objChek = new Class_ChekPass();
        if(!$objChek->checkCookie($_COOKIE['id_user'], $_COOKIE['session_id'])){
            $url = $_SERVER['REQUEST_URI'];
            //Если это не страница авторизации переводим на нее
            if($url !== "/login"){
                header("Location: /login");
                exit();
            }

        }


        $this->view = new View();
        if(!empty($_COOKIE['id_user'])) $this->model->id_user = (int)$_COOKIE['id_user'];
        if(!empty($_COOKIE['session_id'])) $this->model->session_id = $_COOKIE['session_id'];

    }

}
