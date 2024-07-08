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

    public function __construct()
    {
        $this->model = new Model();
        if(!empty($_COOKIE['id_user'])) $this->model->id_user = (int)$_COOKIE['id_user'];
        if(!empty($_COOKIE['session_id'])) $this->model->session_id = $_COOKIE['session_id'];
        $this->view = new View();
    }

    // действие (action), вызываемое по умолчанию
    public function action_index()
    {
        // todo
    }
}
