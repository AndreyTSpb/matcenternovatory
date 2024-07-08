<?php
/**
 *Created by LigthMVC. 
 * date: 02.01.2020
 * user: tynyanyi@mail.ru 
 * создано автоматически 
 * через модуль администратора
*/
class Model_Admin_users extends Mysql {
  public $id; 
  public $name; 
  public $pass; 
  public $email; 
  public $hash_key; 
  public $dt_visit; 
  public $active;

  public function fieldsTable() {
    return array(
      'id' => 'id', 
      'name' => 'name', 
      'pass' => 'pass', 
      'email' => 'email', 
      'hash_key' => 'hash_key', 
      'dt_visit' => 'dt_visit', 
      'active' => 'active', 
    );
  }
}