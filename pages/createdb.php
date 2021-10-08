<?php
    // Подключаем скрипт functions.php
    include_once('functions.php');
    // Подключаемся к СУБД (серверу баз данных) PHPMyAdmin
    $conn_s = connect_to_server();

    // Строка текста c запросом на создание базы данных "travels"
    $crdb = 'CREATE DATABASE `travels`';
    // Выполняем запрос
    mysqli_query($conn_s, $crdb);
    // Получаем в случае возникновения ошибки её код 
    $err = mysqli_errno($conn_s);

    // Если возникла ошибка
    if($err) {
        // Выводим сообщение с кодом ошибки
        echo '<h3 style="color: red">Код ошибки создания базы данных "travels": ' . $err . '</h3><br/>';
        // Прекращаем выполнение скрипта
        exit();
    }

    // Подключаемся к базе данных "travels"
    $conn_db = connect_to_db();

    // Строка текста c запросом к базе данных на создание таблицы "countries"
    $ct1 = 'CREATE TABLE `countries`(
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            country VARCHAR(64) UNIQUE)
            DEFAULT charset = "utf8"';

    // Строка текста c запросом к базе данных на создание таблицы "cities"
    $ct2 = 'CREATE TABLE `cities`(
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            city VARCHAR(64),
            countryid INT,
            ucity VARCHAR(128),
            FOREIGN KEY (countryid) REFERENCES countries (id) ON DELETE CASCADE,
            UNIQUE INDEX ucity(city, countryid))
            DEFAULT charset = "utf8"';

    // Строка текста c запросом к базе данных на создание таблицы "hotels"        
    $ct3 = 'CREATE TABLE `hotels`(
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            hotel VARCHAR(64),
            cityid INT,
            countryid INT,
            stars INT,
            cost INT,
            info VARCHAR(1024),
            FOREIGN KEY (cityid) REFERENCES cities (id) ON DELETE CASCADE,
            FOREIGN KEY (countryid) REFERENCES countries (id) ON DELETE CASCADE)
            DEFAULT charset = "utf8"';

    // Строка текста c запросом к базе данных на создание таблицы "images"
    $ct4 = 'CREATE TABLE `images`(     
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            imagepath VARCHAR(255),
            hotelid INT,
            FOREIGN KEY (hotelid) REFERENCES hotels(id) ON DELETE CASCADE)
            DEFAULT charset = "utf8"';

    // Строка текста c запросом к базе данных на создание таблицы "roles"
    $ct5 = 'CREATE TABLE `roles`(
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            role VARCHAR(32))
            DEFAULT charset = "utf8"';

    // Строка текста c запросом к базе данных на создание таблицы "users"
    $ct6 = 'CREATE TABLE `users`(
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            login VARCHAR(32) UNIQUE,
            pass VARCHAR(32),
            email VARCHAR(32),
            discount INT,
            roleid INT,
            avatar MEDIUMBLOB,
            FOREIGN KEY (roleid) REFERENCES roles (id) ON DELETE CASCADE)
            DEFAULT charset = "utf8"';

    // Строка текста с запросом к базе данных на создании таблицы "comments"
    $ct7 = 'CREATE TABLE `comments`(
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            comment VARCHAR(1000),
            hotelid INT,
            user VARCHAR(32),
            date VARCHAR(12),
            FOREIGN KEY (hotelid) REFERENCES hotels (id) ON DELETE CASCADE)
            DEFAULT charset = "utf8"';

    // Строка текста c запросом к базе данных на добавление данных в таблицу "roles"
    $ins1 = 'INSERT INTO `roles` (role)
            VALUES ("Admin"), ("Customer")';

    // Строка текста c запросом к базе данных на добавление данных в таблицу "users"
    $ins2 = 'INSERT INTO `users` (login, email, pass, roleid)
            VALUES ("NikoMu", "nikomu@gmail.com","' . md5(1111) .'", 1)';

    // Выполняем запрос на создание таблицы "countries"
    mysqli_query($conn_db, $ct1);
    // Получаем в случае возникновения ошибки её код 
    $err = mysqli_errno($conn_db);

    // Если возникла ошибка
    if($err) {
        // Выводим сообщение с кодом ошибки
        echo '<h3 style="color: red">Код ошибки создания таблицы "countries": ' . $err . '</h3><br/>';
        // Прекращаем выполнение скрипта
        exit();
    }

    // Выполняем запрос на создание таблицы "cities"
    mysqli_query($conn_db, $ct2);
    // Получаем в случае возникновения ошибки её код 
    $err = mysqli_errno($conn_db);

    // Если возникла ошибка
    if($err) {
        // Выводим сообщение с кодом ошибки
        echo '<h3 style="color: red">Код ошибки создания таблицы "cities": ' . $err . '</h3><br/>';
        // Прекращаем выполнение скрипта
        exit();
    }

    // Выполняем запрос на создание таблицы "hotels"
    mysqli_query($conn_db, $ct3);
    // Получаем в случае возникновения ошибки её код 
    $err = mysqli_errno($conn_db);

    // Если возникла ошибка
    if($err) {
        // Выводим сообщение с кодом ошибки
        echo '<h3 style="color: red">Код ошибки создания таблицы "hotels": ' . $err . '</h3><br/>';
        // Прекращаем выполнение скрипта
        exit();
    }

    // Выполняем запрос на создание таблицы "images"
    mysqli_query($conn_db, $ct4);
    // Получаем в случае возникновения ошибки её код 
    $err = mysqli_errno($conn_db);

    // Если возникла ошибка
    if($err) {
        // Выводим сообщение с кодом ошибки
        echo '<h3 style="color: red">Код ошибки создания таблицы "images": ' . $err . '</h3><br/>';
        // Прекращаем выполнение скрипта
        exit();
    }

    // Выполняем запрос на создание таблицы "roles"
    mysqli_query($conn_db, $ct5);
    // Получаем в случае возникновения ошибки её код 
    $err = mysqli_errno($conn_db);

    // Если возникла ошибка
    if($err) {
        // Выводим сообщение с кодом ошибки
        echo '<h3 style="color: red">Код ошибки создания таблицы "roles": ' . $err . '</h3><br/>';
        // Прекращаем выполнение скрипта
        exit();
    }

    // Выполняем запрос на создание таблицы "users"
    mysqli_query($conn_db, $ct6);
    // Получаем в случае возникновения ошибки её код 
    $err = mysqli_errno($conn_db);

    // Если возникла ошибка
    if($err) {
        // Выводим сообщение с кодом ошибки
        echo '<h3 style="color: red">Код ошибки создания таблицы "users": ' . $err . '</h3><br/>';
        // Прекращаем выполнение скрипта
        exit();
    }  

    // Выполняем запрос на создание таблицы "comments"
    mysqli_query($conn_db, $ct7);
    // Получаем в случае возникновения ошибки её код 
    $err = mysqli_errno($conn_db);

    // Если возникла ошибка
    if($err) {
        // Выводим сообщение с кодом ошибки
        echo '<h3 style="color: red">Код ошибки создания таблицы "comments": ' . $err . '</h3><br/>';
        // Прекращаем выполнение скрипта
        exit();
    }  

    // Выполняем запрос на добавление ролей в таблицу "roles"
    mysqli_query($conn_db, $ins1);
    // Получаем в случае возникновения ошибки её код 
    $err = mysqli_errno($conn_db);

    // Если возникла ошибка
    if($err) {
        // Выводим сообщение с кодом ошибки
        echo '<h3 style="color: red">Код ошибки добавления данных в таблицу "roles": ' . $err . '</h3><br/>';
        // Прекращаем выполнение скрипта
        exit();
    }  

    // Выполняем запрос на добавление администратора в таблицу "users"
    mysqli_query($conn_db, $ins2);
    // Получаем в случае возникновения ошибки её код 
    $err = mysqli_errno($conn_db);

    // Если возникла ошибка
    if($err) {
        // Выводим сообщение с кодом ошибки
        echo '<h3 style="color: red">Код ошибки добавления данных в таблицу "users": ' . $err . '</h3><br/>';
        // Прекращаем выполнение скрипта
        exit();
    }  

    // Выводим сообщение, что база данных с таблицами и данными успешно создана
    echo '<h3 style="color: green">База данных успешно создана!</h3>';
?>