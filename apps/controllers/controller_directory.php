<?php


class Controller_Directory extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->model = new Model_Directory();
        $this->model->url = 'directory';
    }

    public function action_index()
    {
        if($this->model->role == 2){
            $data['nameCompany']    = $this->model->nameCompany;
            $data['labelCompany']   = $this->model->labelCompany;
            $data['title']          = "Пользователи";
            $data['view_menu_file'] = 'super_admin_menu.php';
            $data['left_menu']      = $this->model->leftMenu();
            $data['buttons']        = array(
                Class_Create_Btn_Link::smallBtn(DOCUMENT_ROOT.'/directory/new_user', 'btn btn-outline-primary', 'Добавить'),

            );
            $data['content']        = $this->model->getAllUsers();
            $this->view->generate('directory_view.php', 'page.php', $data);
            exit();
        }else{
            Class_Alert_Error::warning('Отказано в доступе');
            header('Location: '.DOCUMENT_ROOT.'/login');
            exit();
        }
    }

    public function action_new_user(){
        if($this->model->role == 2){
            if(isset($_POST['save'])){
                if($this->model->saveUser($_POST)){
                    header('Location: '.DOCUMENT_ROOT.'/directory');
                    exit();
                }
            }

            $data['nameCompany']    = $this->model->nameCompany;
            $data['labelCompany']   = $this->model->labelCompany;
            $data['title']          = "Добавить нвого пользователя";
            $data['view_menu_file'] = 'super_admin_menu.php';
            $data['left_menu']      = $this->model->leftMenu();
            $data['buttons']        = array(
                Class_Create_Btn_Link::smallBtn(DOCUMENT_ROOT.'/directory', 'btn btn-outline-primary', 'Назад'),

            );
            $data['content']        = $this->model->formAddUser();
            $this->view->generate('directory_view.php', 'page.php', $data);
            exit();
        }else{
            Class_Alert_Error::warning('Отказано в доступе');
            header('Location: '.DOCUMENT_ROOT.'/login');
            exit();
        }
    }

    public function action_edit_user($params){
        if($this->model->role == 2){
            if(isset($_POST['save'])){
                $params['id'] = $_POST['id'];
                if($this->model->updateUser($_POST)){
                    header('Location: '.DOCUMENT_ROOT.'/directory');
                    exit();
                }
            }
            if(isset($_POST['updatePass'])){
                $params['id'] = $_POST['id'];
                if($this->model->updateUserPsw($_POST)){
                    header('Location: '.DOCUMENT_ROOT.'/directory');
                    exit();
                }
            }
            $data['nameCompany']    = $this->model->nameCompany;
            $data['labelCompany']   = $this->model->labelCompany;
            $data['title']          = "Редактируем пользователя";
            $data['view_menu_file'] = 'super_admin_menu.php';
            $data['left_menu']      = $this->model->leftMenu();
            $data['buttons']        = array(
                Class_Create_Btn_Link::smallBtn(DOCUMENT_ROOT.'/directory', 'btn btn-outline-primary', 'Назад'),

            );
            $data['content']        = $this->model->formEditUser($params['id']);

            $this->view->generate('directory_view.php', 'page.php', $data);
            exit();
        }else{
            Class_Alert_Error::warning('Отказано в доступе');
            header('Location: '.DOCUMENT_ROOT.'/login');
            exit();
        }

    }

    public function action_klass()
    {
        if($this->model->role == 2){
            $data['nameCompany']    = $this->model->nameCompany;
            $data['labelCompany']   = $this->model->labelCompany;
            $data['title']          = "Справочник классов проблем";
            $data['view_menu_file'] = 'super_admin_menu.php';
            $data['left_menu']      = $this->model->leftMenu('klass');
            $data['content']        = $this->model->formAddUser();
            $this->view->generate('directory_view.php', 'page.php', $data);
            exit();
        }else{
            Class_Alert_Error::warning('Отказано в доступе');
            header('Location: '.DOCUMENT_ROOT.'/login');
            exit();
        }
    }
    public function action_type()
    {
        if($this->model->role == 2){
            $data['nameCompany']    = $this->model->nameCompany;
            $data['labelCompany']   = $this->model->labelCompany;
            $data['title']          = "Справочник типов проблем";
            $data['view_menu_file'] = 'super_admin_menu.php';
            $data['left_menu']      = $this->model->leftMenu('type');
            $this->view->generate('directory_view.php', 'page.php', $data);
            exit();
        }else{
            Class_Alert_Error::warning('Отказано в доступе');
            header('Location: '.DOCUMENT_ROOT.'/login');
            exit();
        }
    }
}