<?php
?>
<div class="row">
    <div class="col-8  m-auto">
        <div class="card">
            <h5 class="card-header text-bg-dark">Редактор группы</h5>
            <div class="card-body">
                <form class="row g-3" method="post" action="<?=$url?>/save_group">
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Название:</label>
                        <input type="text" class="form-control" id="inputEmail4" name="name_group" value="<?=(isset($groupInfo['name_group']))?$groupInfo['name_group']:''?>">
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Период:</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="date" class="form-control" id="inputPassword4" name="dt_start" value="<?=(isset($groupInfo['period']['dt_start']))?date("Y-m-d", $groupInfo['period']['dt_start']):''?>">
                            </div>
                            <div class="col-md-6">
                                <input type="date" class="form-control" id="inputPassword5" name="dt_end" value="<?=(isset($groupInfo['period']['dt_end']))?date("Y-m-d", $groupInfo['period']['dt_end']):''?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Дни недели:</label>
                        <?php $arrDay = array('Пн',"Вт","Ср","Чт","Пт","Сб","Вс"); $arrEngDay = array('mon',"tue","wed","thu","fri","sat","sun"); for ($i = 0; $i < 7; $i++):?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" <?=(isset($groupInfo['days']) AND $groupInfo['days'][$i])?'checked':'';?> value="<?=$arrEngDay[$i];?>" name="weak[]>
                                <label class="form-check-label" for="inlineCheckbox1"><?=$arrDay[$i];?></label>
                            </div>
                        <?php endfor;?>
                    </div>
                    <div class="col-md-6">
                        <label for="inputCost" class="form-label">Стоимость:</label>
                        <input type="text" class="form-control" id="inputCost" name="cost" value="<?=(isset($groupInfo['price']))?$groupInfo['price']:''?>">
                    </div>
                    <div class="col-md-6">
                        <label for="inputMaxUsers" class="form-label">Количество мест:</label>
                        <input type="text" class="form-control" id="inputMaxUsers" name="max_users" value="<?=(isset($groupInfo['max_user']))?$groupInfo['max_user']:''?>">
                    </div>
                    <div class="col-md-6">
                        <label for="inputState" class="form-label">Преподаватели:</label>
                        <?php
                            $sel = new Class_DropList_Teachers();
                            echo $sel->html;
                        ?>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Примечание: </label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="note">
                            <?=(isset($groupInfo['note']))?$groupInfo['note']:''?>
                        </textarea>
                    </div>
                    <div class="col-auto">
                        <a href="<?= (empty($_SERVER['HTTP_REFERER']))?'/groups':$_SERVER['HTTP_REFERER'];?>>" class="btn btn-primary mb-3">Назад</a>
                    </div>
                    <div class="col-auto">
                        <?php if(isset($groupInfo['id_group'])):?>
                            <input type="hidden" name="id_group" value="<?=$groupInfo['id_group']?>">
                        <?php endif;?>
                        <button type="submit" class="btn btn-success mb-3" name="save_group">Сохранить</button>
                    </div
                </form>
            </div>
        </div>
    </div>
</div>
