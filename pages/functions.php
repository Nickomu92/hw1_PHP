<?php
    // Функция для подключения к серверу баз данных (PHPMyAdmin)
    function connect_to_server( $host = 'localhost', $user = 'root', $pass = '11111111', $dbname = 'travels') {
        $conn = mysqli_connect($host, $user, $pass) or die('Ошибка соединения');
        // Возращаем обьект, который используется для подключения к серверу баз данных 
        return $conn;
    }

    // Функция для подключения непосредственно к базе данных 
    function connect_to_db( $host = 'localhost', $user = 'root', $pass = '11111111', $dbname = 'travels') {
        $conn = mysqli_connect($host, $user, $pass) or die('Ошибка соединения');
        mysqli_select_db($conn, $dbname) or die('Ошибка открытия базы данных');
        mysqli_query($conn, "set names 'utf8'");
        // Возращаем обьект, который используется для подключения к базе данных 
        return $conn;
    }

    // Функция для регистации пользователя в базе данных
    function register_user ($name, $pass, $email) {
        $name = trim(htmlspecialchars($name));
        $pass = trim(htmlspecialchars($pass));
        $email = trim(htmlspecialchars($email));

        // Если поля ввода для имени, пароля или электронной почты пустые, то: 
        if($name == "" || $pass == "" || $email == "") {
            // Выводим сообщение-предупреждение
            echo "<h3/><span style='color:red;'>Заполните все обязательные поля!</span></h3>";
            // Выходим
            return false;
        }

        // Если поля ввода имени, пароля логина или электронной почты содержат количество символов меньше 3 и больше 30, то:
        if(strlen($name) < 3 || strlen($name) > 30 || strlen($pass) < 3 || strlen($pass) > 30) {
            // Выводим сообщение-предупреждение
            echo "<h3><span style='color:red;'>Значение должно быть от 3 до 30 символов!</span></h3>";
            // Выходим
            return false;
        }
        
        // Строка текста запроса к базе данных на добавление пользователя
        $ins = 'INSERT INTO `users` (login, pass, email, roleid) 
                VALUES("' . $name . '", "' . md5($pass) . '", "' . $email . '", 2)';
        // Подключаемся к базе данных 
        $conn = connect_to_db();
        // Выполняем запрос на добавление пользователя
        mysqli_query($conn, $ins);
        // Получаем в случае возникновения ошибки её код 
        $err = mysqli_errno($conn);

        // Если возникла ошибка
        if($err) {
            if($err == 1062)
                echo "<h3><span style='color:red;'>Логин уже существует!</span></h3>";

            else
                echo "<h3><span style='color: red;'>Код ошибки: " . $err . "!</span></h3>";
            // Выходим    
            return false; 
        } 
        return true;
    }

    // Функция для авторизации на сайте
    function login($name, $pass) {
        $name = trim(htmlspecialchars($name));
        $pass = trim(htmlspecialchars($pass));

        if($name == "" || $pass == "") {
            echo "<h3><span style = 'color: red;'>Заполните все поля!</span></h3>";
            return false;
        }

        if(strlen($name) < 3 || strlen($name) > 30 || strlen($pass) < 3 || strlen($pass) > 30) {
            echo "<h3><span style='color: red;>Поля ввода должны содержать от 3 до 30 символов</span></h3>";
            return false;
        } 

        $conn = connect_to_db();
        
        $sel = 'SELECT * FROM `users`
                WHERE login = "' . $name . '" AND pass="' . md5($pass) . '"';
        
        $res = mysqli_query($conn, $sel);

        if($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            $_SESSION['ruser'] = $name;

            if($row[5] == 1) {
                $_SESSION['radmin'] = $name;
            }

            return true;
        }

        else {
            echo "<h3><span style='color: red;'>Пользователь не существует!</span></h3>";
            return false;
        }
    }
?>