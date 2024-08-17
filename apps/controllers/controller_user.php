<?php


class Controller_User extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Model_User();
    }

    public function action_index($params){
        if(isset($params['id']) AND !empty($params['id'])){
            $this->model->id_user = (int)$params['id'];
            if(!$this->model->getUser()){
                header("Location: /users");
                exit();
            }
            $data = $this->data;

            $data['view_menu_file'] = 'super_admin_menu.php';
            $data['buttons']     = array();
            $data['actionButtons'] = $this->model->getActionButtons();

            $userInfo           = $this->model->getUser();
            $data['content']    = $userInfo['content'];
            $data['title']      = $userInfo['title'];

            $this->view->generate('groups_view.php', 'page.php', $data);
            exit();
        }
        header("Location: /users");
        exit;
    }

    public function action_add(){

        $data = $this->data;

        $data['view_menu_file'] = 'super_admin_menu.php';
        $data['buttons']     = array();
        $data['actionButtons'] = $this->model->getActionButtons();

        $userInfo           = $this->model->getUser();
        $data['content']    = $userInfo['content'];
        $data['title']      = $userInfo['title'];

        $this->view->generate('groups_view.php', 'page.php', $data);
        exit();
    }

    public function action_save(){
        if(isset($_POST['save_user'])){
            if(isset($_POST['id_user']) AND !empty($_POST['id_user'])){
                if(!$this->model->updateUser($_POST)){
                    header("Location: /users");
                    exit();
                }
                header("Location: /user?id=".$_POST['id_user']);
                exit();
            }else{
                $id = $this->model->add($_POST);
                if(!$id){
                    header("Location: /user/add");
                    exit();
                }
                header("Location: /user?id=".$id);
                exit();
            }
        }
    }

    public function action_update_pass(){
        if(isset($_POST['save'])){
            if(isset($_POST['id_user']) AND !empty($_POST['id_user'])){
                $this->model->id_user = (int)$_POST['id_user'];

                if(!$this->model->updatePass($_POST['pass'])){
                    header("Location: /user?id=".$this->model->id_user);
                    exit();
                }

                header("Location: /user?id=".$this->model->id_user);
                exit();
            }
        }
        header("Location: /users");
        exit();
    }
}