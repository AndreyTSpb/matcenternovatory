<?php
?>
<div class="container">
    <div class="py-5 text-center">
        <img class="d-block mx-auto mb-4" src="<?=DOCUMENT_ROOT?>/web/images/<?=(isset($labelCompany) AND !empty($labelCompany))?$labelCompany:''?>" alt="" width="72" height="57">
        <p class="lead">Форма для добавления и<br>
            редактирования пользователей
        </p>
    </div>
    <div class="row g-5">
        <div class="col-md-7 col-lg-8 mx-auto">
            <h4 class="mb-3">Контактные данные</h4>
            <form class="needs-validation" novalidate method="<?=(isset($method) AND !empty($method))?$method:'post'?>" action="<?=(isset($urlSave) AND !empty($urlSave))?$urlSave:''?>">
                <input type="hidden" id="id" name="id" value="<?=(isset($id) AND !empty($id))?$id:''?>">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="userName" class="form-label">Пользователь</label>
                        <div class="input-group has-validation">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                        </svg>
                                    </span>
                            <input required type="text" class="form-control" id="userName" name="userName" value="<?=(isset($userName))?$userName:''?>">
                            <div class="invalid-feedback">
                                ФИО пользователя должно быть заполнено
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="pcName" class="form-label">Компьютер</label>
                        <div class="input-group has-validation">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pc-display-horizontal" viewBox="0 0 16 16">
                                            <path d="M1.5 0A1.5 1.5 0 0 0 0 1.5v7A1.5 1.5 0 0 0 1.5 10H6v1H1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-5v-1h4.5A1.5 1.5 0 0 0 16 8.5v-7A1.5 1.5 0 0 0 14.5 0h-13Zm0 1h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .5-.5ZM12 12.5a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0Zm2 0a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0ZM1.5 12h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1ZM1 14.25a.25.25 0 0 1 .25-.25h5.5a.25.25 0 1 1 0 .5h-5.5a.25.25 0 0 1-.25-.25Z"/>
                                        </svg>
                                    </span>
                            <input required type="text" class="form-control" id="pcName" name="pcName" placeholder="" value="<?=(isset($pcName))?$pcName:''?>">
                            <div class="invalid-feedback">
                                Имя компьютера за которым работает пользователь должно быть заполнено
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="email" class="form-label">E-mail</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text">@</span>
                            <input type="email" class="form-control" id="email" name="email" placeholder="" value="<?=(isset($email))?$email:''?>">
                            <div class="invalid-feedback">
                                Адрес электронной почты для связи должен быть заполнен
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="phone" class="form-label">Телефон</label>
                        <div class="input-group has-validation">
                                    <span class="input-group-text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                                            <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                                        </svg>
                                    </span>
                            <input required type="phone" class="form-control" id="phone" name="phone" value="<?=(isset($phone))?$phone:''?>">
                            <div class="invalid-feedback">
                                Требуется указать телефон для связи
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="klass" class="form-label">Роль</label>
                        <select required class="form-select" id="role" name="role" >
                            <?php
                                $obj = new Model_Roles(['where'=>'del = 0', 'order' => 'id ASC']);
                                $rows = $obj->getAllRows();
                            ?>
                            <option>Выбрать...</option>
                            <?php foreach ($rows AS $row):?>
                                <option <?=(isset($roles_id) AND $row['id'] == $roles_id)? 'selected':'';?> value="<?=$row['id'];?>"><?=$row['name'];?></option>
                            <?php endforeach;?>
                        </select>
                        <div class="invalid-feedback">
                            Роль пользователя в системе
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="type" class="form-label">Отдел</label>
                        <select class="form-select" id="type" name="type">
                            <option value="">Выбрать...</option>
                            <option>California</option>
                        </select>
                        <div class="invalid-feedback">
                            Требуется указать тип проблемы
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="col-sm-6">
                        <label for="email" class="form-label">Пароль</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text">!</span>
                            <input type="password" class="form-control" id="pass" name="pass" placeholder="" value="<?=(isset($email))?$email:''?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="email" class="form-label">Повторить пароль</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text">!</span>
                            <input type="password" class="form-control" id="pass" name="pass1" placeholder="" value="<?=(isset($email))?$email:''?>">
                        </div>
                    </div>

                </div>

                <hr class="my-4">

                <div class="row gy-3 mb-1">
                    <div class="col-sm-4">
                        <!-- Button trigger modal -->
                        <button name="save" type="submit" class="btn btn-outline-success btn-sm w-100" data-bs-toggle="modal" data-bs-target="#nextUser">
                            Сохранить
                        </button>
                    </div>
                    <?php if(isset($id) AND !empty($id)):?>
                        <div class="col-sm-4">
                            <button name="updatePass" type="submit" class="btn btn-outline-info btn-sm w-100" data-bs-toggle="modal" data-bs-target="#nextUser">
                                Обновить Пароль
                            </button>
                        </div>
                    <?php endif;?>
                    <div class="col-sm-4">
                        <a href="<?=(isset($urlReturn))?$urlReturn:''?>" class="w-100 btn btn-secondary btn-sm">Закрыть</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
