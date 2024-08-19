<?php


class Controller_T_API extends Controller
{
    private $bearer = 'Bearer TinkoffOpenApiSandboxSecretToken';

    function action_index(){

        Class_Send_Mail::sendYandex('anarhia99@yandex.ru','Kykyryza99','tynyanyi@mail.ru','tynyanyi@mail.ru','Математический центр Новаторы','Ссылка на оплату занятий ');

        exit();
    }

    function action_test(){
        //https://rest-api-test.tinkoff.ru/v2/Init

        $Merchant_id = '200000001377699';
        $Terminal_id = '25443940';
        $rs = "40802810500006366746";
        $Merchant_name = 'matcenternovatory';
        $ter = "1723638759255DEMO";
        $TerminalKey = "Kig20h7JtaYK8HV!";


        $urlTest = "https://rest-api-test.tinkoff.ru/v2/Init";
        $json = '{
              "TerminalKey": "Kig20h7JtaYK8HV",
              "Amount": 100,
              "OrderId": "5",
              "Description": "Подарочная карта на 1000 рублей",
              "Token": "da1bf1edfa86dc122fceee9e94116f82837df089cb821103197cfd1459ed14fb",
              "DATA": {
                "Phone": "+79523752922",
                "Email": "tynyanyi@mail.ru"
              },
              "Receipt": {
                "Email": "tynyanyi@mail.ru",
                "Phone": "+79523752922",
                "Taxation": "osn",
                "Items": [
                  {
                    "Name": "Наименование товара 1",
                    "Price": 10000,
                    "Quantity": 1,
                    "Amount": 10000,
                    "Tax": "vat10",
                    "Ean13": "303130323930303030630333435"
                  },
                  {
                    "Name": "Наименование товара 2",
                    "Price": 20000,
                    "Quantity": 2,
                    "Amount": 40000,
                    "Tax": "vat20"
                  },
                  {
                    "Name": "Наименование товара 3",
                    "Price": 30000,
                    "Quantity": 3,
                    "Amount": 90000,
                    "Tax": "vat10"
                  }
                ]
              }
            }';

        $ch = curl_init($urlTest);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        if($jsonData) curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);
    }
}