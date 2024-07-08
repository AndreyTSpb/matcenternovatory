<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 26/12/2019
 * Time: 23:12
 */

class Controller_Signin extends Controller
{
    function action_index()
    {
        $data['title']         = "Вход";
        $this->view->generate('login_view.php', 'index.php', $data);
    }
}