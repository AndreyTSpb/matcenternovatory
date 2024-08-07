<?php

/**
 * Class Controller_Teacher - Работа с преподом
 */
class Controller_Teacher extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Model_Teacher();
    }

    public function action_add($params){
        $data = $this->data;
        $data['url'] = "/teacher";
        $data['title']      = "Новый преподаватель";
        $data['view_menu_file'] = 'super_admin_menu.php';
        $data['buttons']     = array(
            //$this->model->btn_new_order(),
            //$this->model->btn_select_admin(),
            //$this->model->btn_select_date()
        );
        $data['actionButtons'] = false;
        $data['content']    = $this->model->get_data();

        $this->view->generate('groups_view.php', 'page.php', $data);
    }

    public function action_save(){
        /**
         * Array (
         *  [name_teacher] => Арсен Владленович Баширов
         *  [phone] => +77778885599
         *  [email] => ppp@mail.mail
         *  [edu] => rer
         *  [note] => ghh
         *  [save_teach] =>
         * )
         */
        /**
         * Нажата кнопка "сохранить" на форме
         */
        if(isset($_POST['save_teach'])){
            if(isset($_POST['id_teacher']) AND !empty($_POST['id_teacher'])){
                if(!$this->model->edit_teach($_POST)){
                    header("Location: /teacher/add");
                    exit();
                }
            }else{
                if(!$this->model->add_teach($_POST)){
                    header("Location: /teacher/add");
                    exit();
                }
            }
        }

        /**
         * Нажата кнопка "Удалить" на форме
         */
        if(isset($_POST['id_teacher']) AND !empty($_POST['id_teacher']) AND isset($_POST['del_teach'])){
            if(!$this->model->del_teacher($_POST)){
                header("Location: /teacher/edit?id=".$_POST['id_teacher']);
                exit();
            }
        }

        header("Location: /teachers");
        exit;
    }

    public function action_edit($params){
        $data = $this->data;
        $data['url'] = "/teacher";
        if(!isset($params['id']) OR empty($params['id'])){
            Class_Alert_Message::error("Id не передан!");
            header("Location: ".$_SERVER['HTTP_REFERER']);
            exit();
        }

        $teachInfo = $this->model->get_data_edit($params['id']);

        $data['title']      = $teachInfo['title'];

        $data['view_menu_file'] = 'super_admin_menu.php';
        $data['buttons']     = array(
            //$this->model->btn_new_order(),
            //$this->model->btn_select_admin(),
            //$this->model->btn_select_date()
        );
        $data['actionButtons'] = false;
        $data['content']    = $teachInfo['content'];

        $this->view->generate('groups_view.php', 'page.php', $data);
    }
}