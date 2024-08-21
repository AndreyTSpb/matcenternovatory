<?php
    header('content-type: application/json');

    /**
     *  {
     *      "TerminalKey":"1723638759099",
     *      "OrderId":"12",
     *      "Success":true,
     *      "Status":"CANCELED",
     *      "PaymentId":4888723256,
     *      "ErrorCode":"0",
     *      "Amount":10000,
     *      "Token":"1db3bf61ec8791e6400d007039a02106890bb4f36a3d74d32198b3c993da80f2"
     * }
     * {
     *      "TerminalKey":"1723638759099",
     *      "OrderId":"40",
     *      "Success":true,
     *      "Status":"CONFIRMED",
     *      "PaymentId":4893139064,
     *      "ErrorCode":"0",
     *      "Amount":720000,
     *      "Pan":"+7 (926) ***-**-51",
     *      "Token":"868b59444413f8f273b102fdf0e3413dc80a6147dc0ffb672969d7a1763ce021"
     * }
     */

    $filename = 'temp/file.txt';
    //$text = date('d-m-Y H:i:s', time()) . ' url: ' . $_SERVER['HTTP_REFERER'] . $_SERVER['REMOTE_ADDR'];

    $text = file_get_contents("php://input");

    file_put_contents($filename, PHP_EOL . $text . ' HZ-HZ-HZ', FILE_APPEND);

    $input = json_decode($text, true);

    /**
     * Array(
        [TerminalKey] => 1723638759099
        [OrderId] => 40
        [Success] => 1
        [Status] => CONFIRMED
        [PaymentId] => 4893139064
        [ErrorCode] => 0
        [Amount] => 720000
        [Pan] => +7 (926) ***-**-51
        [Token] => 868b59444413f8f273b102fdf0e3413dc80a6147dc0ffb672969d7a1763ce021
        )
     */
    include 'apps/core/db.php';
    include 'apps/core/config.php';
    global $link;

    $r = $link->query('SELECT value FROM options WHERE name = "terminalKey" LIMIT  1');
    $m = $r->fetch_assoc();
    if($input['TerminalKey'] === $m['value']) {
        if(isset($input['OrderId']) AND !empty($input['OrderId'])){
            $r1 = $link->query("SELECT id, price FROM orders WHERE id = ".(int)$input['OrderId']." LIMIT 1");
            $m1 = $r1->fetch_assoc();
            if(!$m1 OR $m1['price'] <> ($input['Amount']/100)) exit('False');
            if($input['Status'] == 'CONFIRMED')  $status = 1;
            if($input['Status'] == 'CANCELED')  $status = 2;

            if($link->query("UPDATE orders SET status = ".$status.", `dt_pay` = ".time()." WHERE `orders`.`id` = ".(int)$input['OrderId'].";")){
                exit('Ok');
            }

        }
    }


    exit("False");



