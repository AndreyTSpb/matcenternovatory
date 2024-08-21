<?php
/**
 * Created by PhpStorm.
 * User: enotpotaskun
 * Date: 18/08/2024
 * Time: 18:33
 */

class Class_T_Bank_Api_Merch
{
    /**
     * @var mysqli - Подключение к БД.
     */
    private $DB_connect;

    /**
     * @var string - ИНН организации отправителя
     */
    private $innOrg;
    /**
     * @var string - КПП организации отправителя
     */
    private $kppOrg;
    /**
     * @var string - Названия организации отправителя
     */
    private $nameOrg;

    /**
     * @var string - Рублёвый расчётный счёт организации отправителя.
     * Если счёт не указан,
     * для выставления счёта будет использоваться главный счёт компании.
     */
    private $accountNumber; //

    private $taxation = 'usn_income'; //упрощенная СН;

    private $terminalKey;
    private $terminalPass;

    /**
     * @var bool - Тестовый платеж или нет
     */
    private $testQuery;

    private $UrlAPI = 'https://securepay.tinkoff.ru';
    private $testUrlAPI = 'https://rest-api-test.tinkoff.ru/v2/Init';


    public $jsonTest;

    private $token;

    public function __construct()
    {
        global $link;
        $this->DB_connect = $link;
        //SandBox Test On
        $this->testQuery =  false;
        $this->setOptionsOrganization();
    }

    /**
     * Настройки организации отправителя
     */
    private function setOptionsOrganization(){
        $r = $this->DB_connect->query("SELECT * FROM options");
        $arr = array();
        while ($m = $r->fetch_assoc()){
            $arr[$m['name']] = $m['value'];
        }
        /**Array (
         *  [nameCompany] => Математический Центр
         *  [salt] => edcfr56g!jhd3
         *  [accountNumber] => 40702810110011000000
         *  [token] => TinkoffOpenApiSandboxSecretToken
         *  [name] => ИП Егорова Н.Ф.
         *  [inn] => 691643439640
         *  [kpp] =>
         * )
         */

        $token = (array_key_exists('token', $arr))?$arr['token']:0;
        $this->bearer = 'Bearer '.$token;
        $this->innOrg = (array_key_exists('inn', $arr))?$arr['inn']:0;
        $this->kppOrg = (array_key_exists('kpp', $arr))?$arr['kpp']:0;
        $this->nameOrg = (array_key_exists('name', $arr))?$arr['name']:0;
        $this->accountNumber = (array_key_exists('accountNumber', $arr))?$arr['accountNumber']:0;



        $this->terminalKey = (array_key_exists('terminalKey', $arr))?$arr['terminalKey']:0;
        $this->terminalPass = (array_key_exists('terminalPass', $arr))?$arr['terminalPass']:0;
        if($this->testQuery){
            $this->terminalKey = (array_key_exists('terminalKeyDemo', $arr))?$arr['terminalKeyDemo']:0;
            $this->terminalPass = (array_key_exists('terminalPassDemo', $arr))?$arr['terminalPassDemo']:0;
        }

    }

    /**
     * Формирование и отправка запроса в Т-Банк
     * @param $url - адрес для запроса в Т-Банк
     * @param $method - метод запроса POST или GET
     * @param $header - заголовок запроса
     * @param $jsonData - данные запроса в формате json
     * @return bool|string - Возврат в виде json string
     */
    private function createCurl($url, $method, $header, $jsonData = false){

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        if($jsonData) curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

    /**
     *  Encoding array to json
     * @param $data - array();
     * @return false|string -json string
     */
    private function createJson($data){
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Формирования чека
     * @param $emailCustomer
     * @param $phoneCustomer
     * @param $arr_items
     * @return array
     */
    private function receipt($emailCustomer, $phoneCustomer, $items){
        /**
         * "Receipt": {
                "Email": "a@test.ru",
                "Phone": "+79031234567",
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
         */


        /**
         * Amount - Сумма в копейках
         */
        //$items = array(
        //    array("Name" => "Наименование товара 3", "Price" => 30000, "Quantity" => 3, "Amount" => 90000, "Tax" => "vat10")
        //);

        $Receipt = array(
            "Email" => $emailCustomer,
            "Phone" => "+".$phoneCustomer,
            "Taxation" => $this->taxation,
            "Items" => $items
        );

        return  $Receipt;
    }

    /**
     * Создание токена
     */
    private function createToken($amount, $orderId, $description){
        //включены параметры TerminalKey, Amount, OrderId, Description
        /**
         * [
         *  {"TerminalKey": "MerchantTerminalKey"},
         *  {"Amount": "19200"},
         *  {"OrderId": "21090"},
         *  {"Description": "Подарочная карта на 1000 рублей"}
         * ]
         */
        $arrToken = array(
                "Amount" => $amount,
                "Description" => $description,
                "OrderId" => $orderId,
                "Password" => $this->terminalPass,
                "TerminalKey" => $this->terminalKey
        );

        $str = '';
        foreach ($arrToken AS $item){
            $str .= $item;
        }

        return hash('sha256', $str);

    }


    public function createOrder($orderId, $description, $amount, $emailCustomer, $phoneCustomer, $items){

        $arr = array(
            "TerminalKey" =>    $this->terminalKey,
            "Amount"    =>  $amount,
            "OrderId"   =>  $orderId,
            "Description"   =>  $description,
            "Token" =>  $this->createToken($amount, $orderId, $description),
            "DATA"  =>  array(
                "Phone" => "+".$phoneCustomer,
                "Email" => $emailCustomer
            ),
            "Receipt" =>    $this->receipt($emailCustomer, $phoneCustomer, $items)

        );

        $this->jsonTest = $this->createJson($arr);
    }

    public function sendOrder(){
        return $this->createCurl(
            $this->UrlAPI."/v2/Init",
            'POST',
            array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
            $this->jsonTest
        );
    }

    public function getQR($paymentId){
        /**
         * {
         *  "TerminalKey": "TinkoffBankTest",
         *  "PaymentId": 10063,
         *  "DataType": "PAYLOAD",
         *  "Token": "871199b37f207f0c4f721a37cdcc71dfcea880b4a4b85e3cf852c5dc1e99a8d6"
         *  }
         */
        $arrToken = array(
            "DataType" => "PAYLOAD",
            "Password" => $this->terminalPass,
            "PaymentId" => $paymentId,
            "TerminalKey" => $this->terminalKey
        );

        $str = '';
        foreach ($arrToken AS $item){
            $str .= $item;
        }

        $query = array(
            "TerminalKey" => $this->terminalKey,
            "PaymentId" => $paymentId,
            "DataType" => "PAYLOAD",
            "Token" => hash('sha256', $str)
        );

        $this->jsonTest = $this->createJson($query);
        //https://securepay.tinkoff.ru/v2/GetQr
        return $this->createCurl(
            $this->UrlAPI."/v2/GetQr",
            'POST',
            array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
            $this->jsonTest
        );
    }
}