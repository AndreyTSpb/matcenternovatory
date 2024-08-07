<?php

/**
 * Class Controller_Group - работа с одной группой
 */
class Controller_Group extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Model_Group();
    }

    public function action_index($params)
    {
        $data = $this->data;
        $this->model->id_group = (int)$params['id'];
        $data['view_menu_file'] = 'super_admin_menu.php';
        $data['buttons']     = array(
            //$this->model->btn_new_order(),
            //$this->model->btn_select_admin(),
            //$this->model->btn_select_date()
        );
        $data['actionButtons'] = $this->model->getActionButtons();
        $data['content']    = $this->model->get_group_info();

        $data['title']      = $this->model->groupTitle;

        $this->view->generate('groups_view.php', 'page.php', $data);
    }

    public function action_add($params){
        $data = $this->data;
        $data['url'] = "/group";
        $data['title']      = "Новая группа";
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

    public function action_edit($params)
    {
        if (!isset($params['id']) OR empty($params['id'])) {
            Class_Alert_Message::error("Неперередан айди группы");
            header("Location: /groups");
            exit();
        }

        $data = $this->data;
        $this->model->id_group = (int)$params['id'];
        $data['view_menu_file'] = 'super_admin_menu.php';
        $data['buttons']     = array(
            //$this->model->btn_new_order(),
            //$this->model->btn_select_admin(),
            //$this->model->btn_select_date()
        );
        $data['actionButtons'] = $this->model->getActionButtons();
        $data['content']    = $this->model->get_data();

        $data['title']      = $this->model->groupTitle;

        $this->view->generate('groups_view.php', 'page.php', $data);
    }

    public function action_save_group(){
        /**
         * Массив который ожидается к получению
         * Array (
         *  [name_group] => Group-1
         *  [dt_start] => 2024-09-10
         *  [dt_end] => 2024-09-30
         *  [weak] => Array ( [0] => mon [1] => wed [2] => fri )
         *  [cost] => 1000
         *  [max_users] => 12
         *  [id_teach] => Array ( [0] => 1 [1] => 2 [2] => 3 )
         *  [note] => note
         *  [save_group] =>
         * )
         */
        /**
         * Добавление новой
         */
        if(isset($_POST['save_group']) AND !isset($_POST['id_group']) AND empty($_POST['id_group'])){
            if(!$this->model->addGroup($_POST)){
                header("Location: /group/add");
                exit();
            }
            Class_Alert_Message::succes("Група добавлена");
            header("Location: /groups");
            exit();
        }
        /**
         * Обновление данных группы
         */
        if(isset($_POST['save_group']) AND isset($_POST['id_group']) AND !empty($_POST['id_group'])){
            if(!$this->model->updateGroup($_POST)){
                header("Location: /group/edit?id=".$_POST['id_group']);
                exit();
            }
            Class_Alert_Message::succes("Група обновлена");
            header("Location: /groups");
            exit();
        }
        header("Location: /groups");
        exit();
    }

    public function action_del($params){
        if (!isset($params['id']) OR empty($params['id'])) {
            Class_Alert_Message::error("Неперередан айди группы");
            header("Location: /groups");
            exit();
        }
        if(!$this->model->delGroup($params['id'])){
            header("Location: /groups");
            exit();
        }
        Class_Alert_Message::succes("Группа удалена");
        header("Location: /groups");
        exit();
    }
}