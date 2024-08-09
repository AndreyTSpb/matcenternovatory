<?php
?>
<div class="row">
    <div class="col-8  m-auto">
        <div class="card">
            <h5 class="card-header text-bg-dark">Редактирование преподавателя</h5>
            <div class="card-body">
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
                            <?php if(isset($id_bill) AND !empty($id_bill)):?>
                                <input type="text" class="form-control" id="group" name="group" value="<?=(isset($group_name))?$group_name:''?>">
                                <input type="hidden" name="id_group" value="<?=$id_group;?>">
                            <?php else:?>
                                <?php
                                    $dropListGroups = new Class_Droplist_Groups();
                                    echo $dropListGroups->html;
                                ?>
                            <?php endif;?>
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

                    <div class="row">
                        <div class="col-md-4 <?=(isset($id_bill) AND !empty($id_bill))?'':'d-none';?>">
                            <label for="transactionId" class="form-label">Номер транзакции:</label>
                            <input type="text" class="form-control" id="transactionId" name="transactionId" value="<?=(isset($transactionId))?$transactionId:''?>">
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
                            <?php if($del == 0):?>
                                <button type="submit" class="btn btn-danger mb-3" name="del_bill">Удалить</button>
                            <?php endif;?>
                            <?php if($send_status == 0):?>
                                <button type="submit" class="btn btn-info mb-3" name="send_bill">Отправить</button>
                            <?php endif;?>
                        <?php endif;?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
