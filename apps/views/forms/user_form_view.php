<?php
?>
<div class="row">
    <div class="col-8  m-auto">
        <div class="card">
            <h5 class="card-header text-bg-dark">Редактирование ользователя системы</h5>
            <div class="card-body">
                <form class="row g-3" method="post" action="<?=$url?>/save">
                    <div class="col-md-6">
                        <label for="name_teacher" class="form-label">ФИО:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?=(isset($name))?$name:''?>">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">E-Mail:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?=(isset($email))?$email:''?>">
                    </div>
                    <div class="col-md-6">
                        <label for="role" class="form-label">Роль:</label>
                        <select id="role" class="form-select" name="role">
                            <option value="0" <?=(isset($role) AND $role==0)?'selected':''?>>Пользователь</option>
                            <option value="1" <?=(isset($role) AND $role==1)?'selected':''?>>Администратор</option>
                            <option value="2" <?=(isset($role) AND $role==2)?'selected':''?>>СуперАдминистратор</option>
                        </select>
                    </div>
                    <?php if(!isset($id) OR empty($id)):?>
                        <div class="col-md-6">
                            <label for="pass" class="form-label">Пароль:</label>
                            <input type="text" class="form-control" id="pass" name="pass" value="">
                        </div>
                    <?php endif;?>
                    <div class="row mt-3">
                        <div class="col-auto">
                            <button type="submit" class="btn btn-success mb-3" name="save_user">Сохранить</button>
                        </div>
                        <?php if(isset($id) AND !empty($id)):?>
                            <input type="hidden" name="id_user" value="<?=$id;?>">
                            <div class="col-auto">
                                <button type="submit" class="btn btn-danger mb-3" name="del_user"><?=($del == 0)?"Удалить":"Активировать";?></button>
                            </div>
                        <?php endif;?>
                    </div>

                </form>
                <?php if(isset($id) AND !empty($id)):?>

                    <form class="row g-3 mt-3" method="post" action="<?=$url?>/update_pass">
                        <input type="hidden" name="id_user" value="<?=$id;?>">


                        <div class="col-auto">
                            <label for="pass" class="form-label">Новый пароль:</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" class="form-control" id="pass" name="pass" value="">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-success mb-3" name="save">Сохранить</button>
                        </div>
                    </form>
                <?php endif;?>
            </div>
            <div class="car-footer">

            </div>
        </div>
    </div>
</div>
