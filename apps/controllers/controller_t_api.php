<?php


class Controller_T_API extends Controller
{
    private $bearer = 'Bearer TinkoffOpenApiSandboxSecretToken';

    function action_index(){

        //Class_Send_Mail::sendYandex('anarhia99@yandex.ru','Kykyryza99','tynyanyi@mail.ru','tynyanyi@mail.ru','Математический центр Новаторы','Ссылка на оплату занятий ');
        $obj = new Class_T_Bank_Api_Merch();
        //error
        //{"Success":false,"ErrorCode":"99","Message":"Повторите попытку позже.","Details":"pgQr.get.payload.exception"}
        /**
         * {
         *  "Success":true,
         *  "ErrorCode":"0",
         *  "Message":"OK",
         *  "TerminalKey":"1723638759099",
         *  "Data":"https://qr.nspk.ru/BD10003PNOIEHROP87BQ88PETSL1UAOE?type=02&bank=100000000004&sum=12300&cur=RUB&crc=A72B",
         *  "OrderId":"15",
         *  "PaymentId":4885043690
         * }
         **/
        echo $obj->getQR('4898237880');
        exit();
    }
}