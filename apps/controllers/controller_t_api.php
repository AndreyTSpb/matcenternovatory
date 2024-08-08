<?php


class Controller_T_API extends Controller
{
    private $bearer = 'Bearer TinkoffOpenApiSandboxSecretToken';

    function action_index(){
        //curl GET 'https://business.tbank.ru/openapi/sandbox/api/v1/statement?accountNumber=40702810110011000000&from=2024-04-26T21:00:00.000Z'
        //-H 'Authorization: Bearer TinkoffOpenApiSandboxSecretToken'
        //-H 'Content-Type: application/json'

        $tBank = new Class_T_Bank_API();
        echo $tBank->sendInvoiceToCustomer('125486', time(),time()+24*60*60, array('name'=>"vasa pupkin"), array("email"=>"tynyanyi@mail.ru", "phone"=>"79991234567"),array(["name"=>"kurs", "price"=>1000.09]), 'Test invoice');

        echo $tBank->getInfoInvoice("d8327c28-4a8e-4084-93ea-a94b7bd144c5");
        exit();
    }
}