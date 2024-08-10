<?php

/**
 * Class Class_T_Bank_API - ля работы с API TinkoffBank
 *
 */
class Class_T_Bank_API
{
    /**
     * @var mysqli - Подключение к БД.
     */
    private $DB_connect;
    /**
     * @var string - Токен для доступа в Т-Банк
     */
    private $bearer;
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

    /**
     * @var bool - Тестовый платеж или нет
     */
    private $testQuery = false;

    private $UrlAPI = 'https://business.tbank.ru/openapi/api/v1/';
    private $testUrlAPI = 'https://business.tbank.ru/openapi/sandbox/api/v1/';


    public function __construct()
    {
        global $link;
        $this->DB_connect = $link;
        //SandBox Test On
        $this->testQuery = true;
        $this->setOptionsOrganization();
    }

    /**
     * Настройки организации отправителя
     */
    private function setOptionsOrganization(){
        $this->bearer = 'Bearer TinkoffOpenApiSandboxSecretToken';
        $this->innOrg = '691643439640';
        $this->kppOrg = '0';
        $this->nameOrg = 'ИП Егорова Н.Ф.';
        $this->accountNumber = '40702810110011000000';
    }

    /**
     * Метод для получения статуса выставленного счёта
     * @param $invoiceId - Идентификатор выставленного счёта ( в системе Т-Банк)
     * @return bool|string
     */
    function getInfoInvoice($invoiceId){
        //"invoiceId":"d8327c28-4a8e-4084-93ea-a94b7bd144c5"
        //https://business.tbank.ru/openapi/sandbox/api/v1/openapi/invoice/{invoiceId}/info
        $url =($this->testQuery)?$this->testUrlAPI.'openapi/invoice/'.$invoiceId.'/info' : $this->UrlAPI.'openapi/invoice/'.$invoiceId.'/info';
        echo $url;
        $header = array(
            'Accept'=>'application/json',
            'Authorization' => $this->bearer
        );
        return $this->createCurl($url, 'GET', $header);
    }

    function getAccountingInfo($accountNumber = false, $dt = false){
        if(!$accountNumber) $accountNumber = $this->accountNumber;
        //if(!$dt) $dt =
        $url = 'https://business.tbank.ru/openapi/sandbox/api/v1/statement?accountNumber=40702810110011000000&from=2024-04-26T21:00:00.000Z';
    }

    /**
     * Позиции счёта в требуемом формате
     * @param string $name - Наименование
     * @param float $price - Цена за единицу в рублях
     * @param string $unit - Единицы измерения
     * @param string $vat - НДС. None — без НДС
     * @param float $amount - Количество единиц.
     * @return array
     */
    private function itemInvoice($name, $price, $unit = 'шт', $vat = 'None', $amount){
        return array(
            "name"      => $name,
            "price"     => $price,
            "unit"      => $unit,
            "vat"       => $vat,
            "amount"    => $amount

        );
    }

    /**
     * Метод для выставления счетов.
     * @param $invoiceNumber - Номер счета
     * @param int $dt_invoice - Дата выставления счёта.
     * @param int $dt_ext - Срок оплаты
     * @param array $payer - Информация о плательщике.[имя, ИНН, КПП]
     * @param array $contacts - Контакты для получения счёта.[phone, email]
     * @param array $arr_items - масиисв со строками заказа [Номенклатура, стоимость за ед, ед.измерения, НДС, количество]
     * @param bool|string $comment - коментарий к заказу
     */
    public function sendInvoiceToCustomer($invoiceNumber, $dt_invoice, $dt_ext, $payer, $contacts, $arr_items, $comment = false){

        $url =($this->testQuery)?$this->testUrlAPI.'invoice/send':$this->UrlAPI.'invoice/send';
        //https://business.tbank.ru/openapi/api/v1/invoice/send
        $header = array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: '.$this->bearer);

        $data = array(
            "accountNumber" => $this->accountNumber,
            "invoiceNumber" => $invoiceNumber,
            "dueDate"       => date('Y-m-d', $dt_ext),
            "invoiceDate"   => date("Y-m-d", $dt_invoice),
            "payer"         => $this->payer($payer),
            "items"         => $this->items($arr_items),
            "contacts"      => array(array("email"=>$contacts['email'])),
            "comment"       => $comment
        );
        if(array_key_exists('phone', $contacts) AND !empty($contacts['phone'])) $data['contactPhone'] = '+'.$contacts['phone'];
        $json = $this->createJson($data);
        return $this->createCurl($url,'POST',$header, $json);
    }


    private function items($arr_items){
        $arr = array();
        foreach ($arr_items AS $item){
            if (array_key_exists('name', $item)) $name = $item['name']; else $name = "NaN";
            if (array_key_exists('price', $item)) $price = $item['price']; else $price = 0;
            if (array_key_exists('unit', $item)) $unit = $item['unit']; else $unit = '';
            if (array_key_exists('vat', $item)) $vat = $item['vat']; else $vat = 'None';
            if (array_key_exists('amount', $item)) $amount = $item['amount']; else $amount = 1;
            $arr[] = $this->itemInvoice($name, $price, $unit, $vat, $amount);
        }
        return $arr;
    }

    /**
     * перерабатываем массив данных о клиенте,
     * в формат как требуется для Т
     * @param array $payer - Информация о плательщике.[имя, ИНН, КПП]
     * @return array
     */
    private function payer($payer){
        $arr = array();
        if (array_key_exists('name', $payer)) $arr['name'] = $payer['name'];
        if (array_key_exists('inn', $payer)) $arr['inn'] = $payer['inn'];
        if (array_key_exists('kpp', $payer)) $arr['kpp'] = $payer['kpp'];
        return $arr;
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
}