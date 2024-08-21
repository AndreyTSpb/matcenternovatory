<?php


class Controller_Notification extends Controller
{
    public function action_index(){
        $filename = 'temp/file.txt';
        if($_POST){

            file_put_contents($filename, PHP_EOL . 'post: ' . json_encode($_POST), FILE_APPEND);
            exit("Ok");
        }
        if($_GET){
            file_put_contents($filename, PHP_EOL . 'get: ' . json_encode($_GET), FILE_APPEND);
        }
        file_put_contents($filename, PHP_EOL . 'HZ-HZ-HZ', FILE_APPEND);
        exit("False");
    }
}