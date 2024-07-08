<?php
/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 26/09/2019
 * Time: 10:05
 */
?>
<!doctype html>
<html lang="ru">
    <head>
        <!-- Обязательные метатеги -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="web/css/customs.css">
        <title>Привет мир!</title>
    </head>
    <body class="text-left">
        <!--Сообщения об ошибках-->
        <!-- Alert Notes -->
        <?php if(!empty($_SESSION['alert'])):?>
            <section class="alert-notis">
                <div class="row">
                    <div class="col-12 mt-5">
                        <?= Class_Alert_Message::widget($_SESSION['alert']['text'], $_SESSION['alert']['type']);?>
                    </div>
                </div>
            </section>
        <?php endif;?>
        <!-- ./End Alert Notes -->
        <section class="content">
            <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
                <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Company name</a>
                <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
                <ul class="navbar-nav px-3">
                    <li class="nav-item text-nowrap">
                        <a class="nav-link" href="#">Sign out</a>
                    </li>
                </ul>
            </header>
            <div class="container-fluid">
                <div class="row">
                    <!-- MENU -->
                    <?php include('./apps/views/menu/admin_menu.php');?>
                    <!-- Вставляем файл контента -->
                    <?php if(isset($content_view)) {include 'apps/views/'.$content_view;} ?>
                </div>
            </div>
        </section>

        <!-- Clear alert message -->
        <?php Class_Alert_Message::clear();?>
        <!-- ./End Clear alert message -->
        <section class="alert-notis">
            <?php var_dump($_SESSION);?>
        </section>

        <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>

        <!-- Дополнительный JavaScript; выберите один из двух! -->
        <!-- Вариант 1: Bootstrap в связке с Popper
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        -->
        <!-- Вариант 2: Bootstrap JS отдельно от Popper -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    </body>
</html>