<?php
?>
<div class="row">
    <div class="col-8  m-auto">
        <div class="card">
            <h5 class="card-header text-bg-dark">Данные по группе</h5>
            <div class="card-body">
                <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">Название:</label>
                    <input type="text" class="form-control" id="inputEmail4" name="name_group" readonly value="<?=$groupInfo['name_group']?>">
                </div>
                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">Период:</label>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="inputPassword4" name="dt_start" readonly value="<?=date("d.m.Y", $groupInfo['period']['dt_start']);?>">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="inputPassword5" name="dt_end" readonly value="<?=date("d.m.Y", $groupInfo['period']['dt_end']);?>">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Дни недели:</label>

                    <?php $arrDay = array('Пн',"Вт","Ср","Чт","Пт","Сб","Вс"); for ($i = 0; $i < 7; $i++):?>
                    <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" <?=($groupInfo['days'][$i])?'checked':'';?>>
                            <label class="form-check-label" for="inlineCheckbox1"><?=$arrDay[$i];?></label>
                    </div>
                    <?php endfor;?>

                </div>
                <div class="col-md-6">
                    <label for="inputCost" class="form-label">Стоимость:</label>
                    <input type="text" class="form-control" id="inputCost" value="<?=$groupInfo['price']?>" readonly>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputMaxUsers" class="form-label">Количество мест:</label>
                            <input type="text" class="form-control" readonly value="<?=$groupInfo['max_user']?>">
                        </div>
                        <div class="col-md-6">
                            <label for="inputMaxUsers" class="form-label">Куплено мест:</label>
                            <input type="text" class="form-control" readonly value="<?=$groupInfo['users']?>">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Примечание: </label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" readonly><?=$groupInfo['note']?></textarea>
                </div>
                <div class="col-auto">
                    <a href="/groups" class="btn btn-primary mb-3">Назад</a>

                <?php if(isset($groupInfo['id_group']) AND !empty($groupInfo['id_group'])):?>
                        <a href="/group/edit?id=<?=$groupInfo['id_group']?>" class="btn btn-success mb-3" >Отредактировать</a>
                        <a href="/group/del?id=<?=$groupInfo['id_group']?>" class="btn btn-danger mb-3" ><?=($groupInfo['del'] == 0)?"Удалить":"Активировать";?></a>
                <?php endif;?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-8  m-auto">
        <div class="card">
            <h5 class="card-header text-bg-dark">Список оплативших</h5>
            <div class="card-body">
                <?=$userToGroup;?>
            </div>
        </div>
    </div>
</div>
