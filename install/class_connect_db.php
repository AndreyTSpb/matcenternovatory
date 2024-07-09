<?php

namespace install\connect_db;
use mysqli;

/**
 * Class Class_Connect_DB - соединение с базой данных
 */
class Class_Connect_DB
{
    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_name;
    public $link;

    /**
     * Class_Connect_DB constructor.
     * @param $host - имя хоста
     * @param $user - имя пользователя
     * @param $pass - пароль
     * @param $tableName - название базы данных
     */
    function __construct($host, $user, $pass, $tableName)
    {
        $this->db_host  = $host;
        $this->db_user  = $user;
        $this->db_pass  = $pass;
        $this->db_name  = $tableName;
        $this->link     = $this->connectDb();
    }

    private function  connectDb(){
        /*Строка подключения*/
        $link = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        if($link->connect_errno){
            echo'ERROR CONNECT TO DB' . $link->connect_error;
            exit();
        }
        $link->query("SET NAMES utf8");
        return $link;
    }
}