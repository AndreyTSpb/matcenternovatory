<?php if(isset($actionButtons) AND !empty($actionButtons)):?>
    <div class="col">
        <h4 class="h4">Быстрые команды</h4>
            <div class="d-flex justify-content-evenly flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <?php foreach ($actionButtons AS $button_name => $button_url):?>
                    <div><a class="btn btn-outline-primary btn-sm" href="/<?=$button_url?>" role="button"><?=$button_name?></a></div>
                <?php endforeach;?>
            </div>
    </div>
<?php endif;?>
