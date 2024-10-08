<?php
?>
<div class="row">
    <div class="col-8  m-auto">
        <div class="card" id="form_bill">
            <h5 class="card-header text-bg-dark">Счет</h5>
            <div class="card-body">
                <?php if(isset($id_bill) AND !empty($id_bill)):?>
                    <form id="test_form" method="post" action="<?=$url?>/test_bill">
                        <input type="hidden" name="id_bill" value="<?=$id_bill?>">
                    </form>
                <?php endif;?>
                <form class="g-3" method="post" action="<?=$url?>/save">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="id_customer" class="form-label">Клиент:</label>
                            <?php if(isset($id_bill) AND !empty($id_bill)):?>
                                <input type="text" class="form-control" id="name" name="name" value="<?=(isset($name))?$name:''?>">
                                <input type="hidden" name="id_cust" value="<?=$id_cust;?>">
                            <?php else:?>
                                <?php
                                    $dropListCust = new Class_Droplist_Customer();
                                    echo $dropListCust->html;
                                ?>
                            <?php endif;?>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Телефон:</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="<?=(isset($phone))?$phone:''?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">E-Mail:</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?=(isset($email))?$email:''?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="id_group" class="form-label">Группа:</label>
                            <?php
                                $dropListGroups = new Class_Droplist_Groups();
                                if(isset($id_bill) AND !empty($id_bill)){
                                    $dropListGroups->id_group = $id_group;
                                }
                                echo $dropListGroups->html();
                            ?>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="price" class="form-label">Стоимость:</label>
                                    <input type="text" class="form-control" id="price" name="price" value="<?=(isset($price))?$price:''?>" required>
                                </div>
                                <div class="col-md-6 <?=(isset($id_bill) AND !empty($id_bill))?'':'d-none';?>">
                                    <label for="fee" class="form-label">Коммисия:</label>
                                    <input type="text" class="form-control" id="fee" name="fee" value="<?=(isset($fee))?$fee:''?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <label class="form-label">Месяцы:</label>
                            <?php $months = Class_Rus_Name_Date::month(); for ($i = 1; $i < count($months); $i++):?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" <?=(isset($monthes) AND $monthes[$i])?'checked':'';?> value="<?=$i;?>" name="monthes[]>
                                    <label class="form-check-label" for="inlineCheckbox1"><?=$months[$i];?></label>
                                </div>
                            <?php endfor;?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="dtExt" class="form-label">Срок оплаты:</label>
                            <input type="date" class="form-control" id="dtExt" name="dtExt" value="<?=(isset($dtExt))?$dtExt:''?>">
                        </div>

                        <div class="col-md-4 <?=(isset($id_bill) AND !empty($id_bill))?'':'d-none';?>">
                            <label for="dtCreate" class="form-label">Дата создание:</label>
                            <input type="date" class="form-control" id="dtCreate" name="dtCreate" value="<?=(isset($dtCreate))?$dtCreate:''?>">
                        </div>
                        <div class="col-md-4 <?=(isset($id_bill) AND !empty($id_bill))?'':'d-none';?>">
                            <label for="dtPay" class="form-label">Дата оплаты:</label>
                            <input type="date" class="form-control" id="dtPay" name="dtPay" value="<?=(isset($dtPay))?$dtPay:''?>">
                        </div>
                    </div>

                    <div class="row  <?=(isset($id_bill) AND !empty($id_bill))?'':'d-none';?>">
                        <div class="col-md-4">
                            <label for="transactionId" class="form-label">Номер транзакции:</label>
                            <input type="text" class="form-control" id="transactionId" name="transactionId" value="<?=(isset($transactionId))?$transactionId:''?>">
                        </div>
                        <div class="col-md-4">
                            <label for="payUrl" class="form-label">Ссылка на плату картой:</label>
                            <input type="text" class="form-control" id="payUrl" name="payUrl" value="<?=(isset($pdfUrl))?$pdfUrl:''?>">
                        </div>
                        <div class="col-md-4">
                            <label for="qr_link" class="form-label">Ссылка на оплату QR-code:</label>
                            <input type="text" class="form-control" id="qr_link" name="qr_link" value="<?=(isset($qr_link))?$qr_link:''?>">
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Примечание: </label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="note" ><?=(isset($note))?$note:''?></textarea>
                    </div>
                    <div class="col-auto">
                        <a href="<?=(empty($_SERVER['HTTP_REFERER']))?'/bills':$_SERVER['HTTP_REFERER'];?>" class="btn btn-primary mb-3">Назад</a>

                        <?php if(isset($id_bill) AND !empty($id_bill)):?>

                            <input type="hidden" name="id_bill" value="<?=$id_bill;?>">
                            <?php if($del == 0 AND $send_status == 0):?>
                                <button type="submit" class="btn btn-danger mb-3" name="del_bill">Удалить</button>
                            <?php endif;?>
                            <?php if(empty($send_status)):?>
                                <button type="submit" class="btn btn-info mb-3" name="send_bill">Отправить</button>
                            <?php else:?>
                                <button form="test_form" type="submit" class="btn btn-info mb-3" name="send">Проверить</button>
                            <?php endif;?>
                            <button type="submit" class="btn btn-success mb-3" name="update_invoice">Обновить</button>
                        <?php else:?>
                            <button type="submit" class="btn btn-success mb-3" name="save_invoice">Сохранить</button>
                        <?php endif;?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
