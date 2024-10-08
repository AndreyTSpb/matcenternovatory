<?php
?>

<main class="col-12 ms-sm-auto px-md-4">
    <div class="container-fluid">
        <div class="row">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><?=$title;?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <?php
                    if(isset($buttons) AND !empty($buttons)){
                        foreach ($buttons as $button){
                            echo $button;
                        }
                    }
                    ?>
                </div>
            </div>
            <!-- Быстрые команды -->
            <?php include ('./apps/views/templates/action_buttons_view.php');?>
            <!-- Вставляем файл контента -->
            <?php if(isset($content) AND !empty($content)) {echo $content;} ?>
        </div>
    </div>
</main>