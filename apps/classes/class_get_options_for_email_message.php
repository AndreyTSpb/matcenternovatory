<?php


class Class_Get_Options_For_Email_Message
{
  public $emailLogin;
  public $passwordLogin;
  public $titleMessage;
  public $bodyMessage;
  public $footerMessage;

  public function __construct()
  {
      $obj = new Model_Options(["where"=>"name IN ('emailLogin','passwordLogin','titleMessage','bodyMessage', 'footerMessage') AND del = 0"]);
      if(!$obj->num_row) return false;
      $rows = $obj->getAllRows();
      foreach ($rows AS $m){
          if($m['name'] == 'emailLogin') $this->emailLogin = $m['value'];
          if($m['name'] == 'passwordLogin') $this->passwordLogin =  $m['value'];
          if($m['name'] == 'titleMessage') $this->titleMessage =  $m['value'];
          if($m['name'] == 'bodyMessage') $this->bodyMessage =  $m['value'];
          if($m['name'] == 'footerMessage') $this->footerMessage =  $m['value'];
      }
  }
}