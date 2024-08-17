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
            <h5 class="card-header text-bg-dark">Основные настройки</h5>
            <div class="card-body">
                <form class="g-3" method="post" action="<?=$url?>/save_general_option">

                    <div class="row">
                        <div class="col-md-4">
                            <label for="nameCompany" class="form-label">nameCompany:</label>
                            <input type="text" class="form-control" id="nameCompany" name="nameCompany" value="<?=(isset($nameCompany))?$nameCompany:''?>">
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-success mb-3" name="save_nameCompany">Сохранить</button>
                    </div>
                </form>

                <form class="g-3" method="post" action="<?=$url?>/save_salt">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="salt" class="form-label">Ключ:</label>
                            <input type="text" class="form-control" id="salt" name="salt" value="<?=(isset($salt))?$salt:''?>">
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-success mb-3" name="save_salt">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-8  m-auto">
        <div class="card">
            <h5 class="card-header text-bg-dark">Картинка</h5>
            <div class="card-body">

                <form class="g-3" method="post" action="<?=$url?>/save_label" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="labelCompany" class="form-label">labelCompany:</label>
                            <input type="file" class="form-control" id="labelCompany" name="labelCompany" value="<?=(isset($labelCompany))?$labelCompany:''?>">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-success mb-3" name="save_label">Сохранить</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>