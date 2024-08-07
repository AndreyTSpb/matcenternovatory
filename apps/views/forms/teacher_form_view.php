<?php
?>
<div class="row">
    <div class="col-8  m-auto">
        <div class="card">
            <h5 class="card-header text-bg-dark">Редактирование преподавателя</h5>
            <div class="card-body">
                <form class="row g-3" method="post" action="<?=$url?>/save">
                    <div class="col-md-6">
                        <label for="name_teacher" class="form-label">ФИО:</label>
                        <input type="text" class="form-control" id="name_teacher" name="name_teacher" value="<?=(isset($name))?$name:''?>">
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Телефон:</label>
                                <input type="tel" class="form-control" id="inputPassword4" name="phone" value="<?=(isset($phone))?$phone:''?>">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">E-Mail:</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?=(isset($email))?$email:''?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="edu" class="form-label">Образование:</label>
                        <input type="text" class="form-control" id="edu" name="edu" value="<?=(isset($education))?$education:''?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Примечание: </label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="note" ><?=(isset($note))?$note:''?></textarea>
                    </div>
                    <div class="col-auto">
                        <a href="/teachers" class="btn btn-primary mb-3">Назад</a>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-success mb-3" name="save_teach">Сохранить</button>
                    </div>
                    <?php if(isset($id_teacher) AND !empty($id_teacher)):?>
                    <input type="hidden" name="id_teacher" value="<?=$id_teacher;?>">
                    <div class="col-auto">
                        <button type="submit" class="btn btn-danger mb-3" name="del_teach"><?=($del == 0)?"Удалить":"Активировать";?></button>
                    </div>
                    <?php endif;?>
                </form>
            </div>
        </div>
    </div>
</div>
