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
                        <input type="text" class="form-control" id="inputEmail4" name="name_group">
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Период:</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="date" class="form-control" id="inputPassword4" name="dt_start">
                            </div>
                            <div class="col-md-6">
                                <input type="date" class="form-control" id="inputPassword5" name="dt_end">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Дни недели:</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="mon" name="weak[]">
                            <label class="form-check-label" for="inlineCheckbox1">Пн</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="tue" name="weak[]">
                            <label class="form-check-label" for="inlineCheckbox2">Вт</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="wed" name="weak[]">
                            <label class="form-check-label" for="inlineCheckbox3">Ср</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox4" value="thu" name="weak[]">
                            <label class="form-check-label" for="inlineCheckbox4">Чт</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox5" value="fri" name="weak[]">
                            <label class="form-check-label" for="inlineCheckbox5">Пт</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox6" value="sat" name="weak[]">
                            <label class="form-check-label" for="inlineCheckbox6">Сб</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox7" value="sun" name="weak[]">
                            <label class="form-check-label" for="inlineCheckbox7">Вс</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputCost" class="form-label">Стоимость:</label>
                        <input type="text" class="form-control" id="inputCost" name="cost">
                    </div>
                    <div class="col-md-6">
                        <label for="inputMaxUsers" class="form-label">Количество мест:</label>
                        <input type="text" class="form-control" id="inputMaxUsers" name="max_users">
                    </div>
                    <div class="col-md-6">
                        <label for="inputState" class="form-label">Преподаватели:</label>
                        <select id="inputState" class="form-select" multiple name="id_teach[]">
                            <option value="0">...</option>
                            <option value="1">Qaz</option>
                            <option value="2">Qaz</option>
                            <option value="3">Qaz</option>
                            <option value="4">Qaz</option>
                            <option value="5">Qaz</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Примечание: </label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="note"></textarea>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary mb-3">Назад</a>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-success mb-3" name="save_group">Сохранить</button>
                    </div
                </form>
            </div>
        </div>
    </div>
</div>
