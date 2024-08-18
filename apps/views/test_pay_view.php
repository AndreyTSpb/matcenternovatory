<?php
/**
 * Created by PhpStorm.
 * User: enotpotaskun
 * Date: 17/08/2024
 * Time: 17:15
 */
?>
<main class="col-12 ms-sm-auto px-md-4">
    <div class="container-fluid">
        <div class="row">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><?=$title;?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <script src="https://securepay.tinkoff.ru/html/payForm/js/tinkoff_v2.js"></script>
                    <form class="payform-tinkoff" name="payform-tinkoff" id="payform-tinkoff">
                        <input class="payform-tinkoff-row" type="hidden" name="terminalkey" value="1723638759255DEMO">
                        <input class="payform-tinkoff-row" type="hidden" name="frame" value="false">
                        <input class="payform-tinkoff-row" type="hidden" name="language" value="ru">
                        <input class="payform-tinkoff-row" type="hidden" name="receipt" value="">
                        <input class="payform-tinkoff-row" type="text" placeholder="Сумма заказа" name="amount" required>
                        <input class="payform-tinkoff-row" type="hidden" placeholder="Номер заказа" name="order">
                        <input class="payform-tinkoff-row" type="text" placeholder="Описание заказа" name="description">
                        <input class="payform-tinkoff-row" type="text" placeholder="ФИО плательщика" name="name">
                        <input class="payform-tinkoff-row" type="email" placeholder="E-mail" name="email">
                        <input class="payform-tinkoff-row" type="tel" placeholder="Контактный телефон" name="phone">
                        <input class="payform-tinkoff-row payform-tinkoff-btn" type="submit" value="Оплатить">
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script type="text/javascript">
    const TPF = document.getElementById("payform-tinkoff");

    TPF.addEventListener("submit", function (e) {
        e.preventDefault();
        const {description, amount, email, phone, receipt} = TPF;

        if (receipt) {
            if (!email.value && !phone.value)
                return alert("Поле E-mail или Phone не должно быть пустым");

            TPF.receipt.value = JSON.stringify({
                "EmailCompany": "karn-nadezhda@yandex.ru",
                "Taxation": "usn_income",
                "FfdVersion": "1.2",
                "Items": [
                    {
                        "Name": description.value || "Оплата",
                        "Price": amount.value + '00',
                        "Quantity": 1.00,
                        "Amount": amount.value + '00',
                        "PaymentMethod": "full_prepayment",
                        "PaymentObject": "service",
                        "Tax": "none",
                        "MeasurementUnit": "pc"
                    }
                ]
            });
        }
        pay(TPF);
    })
</script>
