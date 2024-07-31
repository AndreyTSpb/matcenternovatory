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
        print_r($params);
        exit;
    }

    public function action_add($params){
        $data = $this->data;
        $data['url'] = "/groups";
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
        if(isset($_POST['save_group']) AND !isset($_POST['id_group']) AND empty($_POST['id_group'])){
            if(!$this->model->addGroup($_POST)){
                header("Location: /group/add");
                exit();
            }
            header("Location: /groups");
            exit();
        }
        header("Location: /groups");
        exit();
    }
}