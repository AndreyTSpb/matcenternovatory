<?php


class Controller_Bills extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Model_Bills();
    }

    public function action_index(){
        exit('tyt');
    }

    public function action_add(){

    }
}