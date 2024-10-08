<?php
/**
 * Created by PhpStorm.
 * User: enotpotaskun
 * Date: 10/08/2024
 * Time: 23:04
 */
?>
<div class="row">
    <div class="col-8  m-auto">
        <div class="card">
            <h5 class="card-header text-bg-dark">Настройки для банка</h5>
            <div class="card-body">
                <form class="g-3" method="post" action="<?=$url?>/save_tbank_options">
                    <div class="row">
                        <div class="col-auto">
                            <label for="accountNumber" class="form-label">accountNumber:</label>
                            <input type="text" class="form-control" id="accountNumber" name="accountNumber" value="<?=(isset($accountNumber))?$accountNumber:''?>">
                        </div>
                        <div class="col-auto">
                            <label for="token" class="form-label">Token:</label>
                            <input type="text" class="form-control" id="token" name="token" value="<?=(isset($token))?$token:''?>">
                        </div>
                        <div class="col-auto">
                            <label for="name" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?=(isset($name))?$name:''?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <label for="inn" class="form-label">INN:</label>
                            <input type="text" class="form-control" id="inn" name="inn" value="<?=(isset($inn))?$inn:''?>">
                        </div>
                        <div class="col-auto">
                            <label for="kpp" class="form-label">KPP:</label>
                            <input type="text" class="form-control" id="kpp" name="kpp" value="<?=(isset($kpp))?$kpp:''?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-auto">
                            <label for="terminalKey" class="form-label">terminalKey:</label>
                            <input type="text" class="form-control" id="terminalKey" name="terminalKey" value="<?=(isset($terminalKey))?$terminalKey:''?>">
                        </div>
                        <div class="col-auto">
                            <label for="terminalPass" class="form-label">terminalPass:</label>
                            <input type="text" class="form-control" id="terminalPass" name="terminalPass" value="<?=(isset($terminalPass))?$terminalPass:''?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <label for="terminalKeyDemo" class="form-label">terminalKeyDemo:</label>
                            <input type="text" class="form-control" id="terminalKeyDemo" name="terminalKeyDemo" value="<?=(isset($terminalKeyDemo))?$terminalKeyDemo:''?>">
                        </div>
                        <div class="col-auto">
                            <label for="terminalPassDemo" class="form-label">terminalPassDemo:</label>
                            <input type="text" class="form-control" id="terminalPassDemo" name="terminalPassDemo" value="<?=(isset($terminalPassDemo))?$terminalPassDemo:''?>">
                        </div>
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-success mb-3" name="save_tbank">Сохранить</button>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <a href="<?=(empty($_SERVER['HTTP_REFERER']))?'/bills':$_SERVER['HTTP_REFERER'];?>" class="btn btn-primary mb-3">Назад</a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-8  m-auto">
        <div class="card">
            <h5 class="card-header text-bg-dark">Настройки для тправки писем</h5>
            <div class="card-body">
                <form class="g-3" method="post" action="<?=$url?>/save_email_account">
                    <div class="row">
                        <div class="col-auto">
                            <label for="accountNumber" class="form-label">email:</label>
                            <input type="text" class="form-control" id="emailLogin" name="emailLogin" value="<?=(isset($emailLogin))?$emailLogin:''?>">
                        </div>
                        <div class="col-auto">
                            <label for="token" class="form-label">password:</label>
                            <input type="text" class="form-control" id="passwordLogin" name="passwordLogin" value="<?=(isset($passwordLogin))?$passwordLogin:''?>">
                        </div>
                        <div class="col-auto">
                            <label for="titleMessage" class="form-label">Заголовок письма:</label>
                            <input type="text" class="form-control" id="title" name="titleMessage" value="<?=(isset($titleMessage))?$titleMessage:''?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="bodyMessage" class="form-label">Тело письма:</label>
                            <input type="text" class="form-control" id="bodyMessage" name="bodyMessage" value="<?=(isset($bodyMessage))?$bodyMessage:''?>">
                        </div>
                        <div class="col">
                            <label for="footerMessage" class="form-label">Окончание письма:</label>
                            <input type="text" class="form-control" id="footerMessage" name="footerMessage" value="<?=(isset($footerMessage))?$footerMessage:''?>">
                        </div>
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-success mb-3" name="save_email">Сохранить</button>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <a href="<?=(empty($_SERVER['HTTP_REFERER']))?'/bills':$_SERVER['HTTP_REFERER'];?>" class="btn btn-primary mb-3">Назад</a>
            </div>
        </div>
    </div>
</div>
