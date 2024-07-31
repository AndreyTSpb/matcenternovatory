<?php
?>
<ul class="navbar-nav me-auto mb-2 mb-md-0">
    <?php if(isset($menu) AND !empty($menu)):?>
        <?php foreach($menu AS $item_name => $item_url):?>
            <li class="nav-item">
                <a href="<?=DOCUMENT_ROOT;?>/<?=$item_url?>" class="nav-link <?=($item_url == trim($url,'/'))?'active':''?>active" aria-current="page"><?=$item_name;?></a>
            </li>
        <?php endforeach;?>
    <?php endif;?>
</ul>