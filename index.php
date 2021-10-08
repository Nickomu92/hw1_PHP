<?php
    // Запускаем сессию
    session_start();
    // Подключаем скрипт functions.php
    include_once("pages/functions.php");
    $page = $_GET['page'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <title>NikoMu - Travel Agency</title>
        <!-- Подключаем стили Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet"/>
        <link href="css/style.css" rel="stylesheet"/>
    </head>
    <body>
        <div class="container">

            <div class="row">
                <header class="col-sm-12 col-md-12 col-lg-12">
                    <?php
                        // Подключаем скрипт functions.php
                        include_once("pages/login.php");
                    ?>
                </header> 
            </div>

            <div class="row">
                <nav class="col-sm-12 col-md-12 col-lg-12">
                    <?php 
                        // Подключаем скрипт functions.php
                        include_once('pages/menu.php');
                    ?>
                </nav>
            </div>
            <div class="row">
                <section class="col-sm-12 col-md-12 col-lg-12">
                    <?php 
                        if(isset($_GET['page'])) 
                        {
                            if($page == 1)
                                // Подключаем скрипт tours.php
                                include_once("pages/tours.php");

                            if($page == 2)
                                // Подключаем скрипт comments.php
                                include_once("pages/comments.php");

                            if($page == 3)
                                // Подключаем скрипт registration.php
                                include_once("pages/registration.php");

                            if($page == 4)
                                // Подключаем скрипт admin.php
                                include_once("pages/admin.php");

                            if($page == 6 && isset($_SESSION['radmin']))
                                // Подключаем скрипт private.php
                                include_once("pages/private.php");
                        } 
                    ?>
                </section>
            </div>

            <div class="row">
                <footer class="vertical-center-row text-center"><span class="text-2x m-t-10 m-b-10">2021 NikoMu&copy;</span></footer>
            </div>
        </div>

        <!-- Подключаем jQuery плагины Bootstrp's -->
        <script  src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <!-- Подключаем скрипты js Bootstrap -->
        <script src="js/bootstrap.min.js"></script>
                
    </body>
</html>