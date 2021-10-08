<h3 class="text-center">Добавление комментария</h3><hr/>
<?php
    // Подключаем скрипт functions.php
    include_once("functions.php");
    $conn = connect_to_db();

    echo '<form action="index.php?page=2" method="POST" class="input-group" id="formhotel">';

    $sel = 'SELECT ho.id, ho.hotel, ci.id, ci.city, co.id, co.country
            FROM countries co, cities ci, hotels ho
            WHERE ho.countryid = co.id AND ho.cityid = ci.id';

    $res = mysqli_query($conn, $sel);

    echo '<select name="hid" class="">';

    while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
        echo '<option value="' . $row[0] . '">"'. $row[1] . '" ( г. '. $row[3] . ', ' .$row[5] . ')</option>';
    }

    echo '</select><br/>';
    echo '<br><textarea name="comment" placeholder="Комментарий"></textarea><br/>';
    echo '<input type="submit" name="addcomment" value="Добавить" class="btn btn-sm btn-info m-t-10 m-b-10">';
    echo '</form>';

    mysqli_free_result($res);

    // Обработка события нажатия на кнопку "Добавить" комментарий
    if(isset($_POST['addcomment'])) {
        $comment = trim(htmlspecialchars($_POST['comment']));
        $hotelid = $_POST['hid'];
        $user = "";

        // Если отель не выбран, то выходим
        if ($hotelid == "") 
            exit();

        // Если авторизированный пользователь
        if($_SESSION['ruser'] != "")
            $user = $_SESSION['ruser'];

        // Если неавторизированный пользователь
        else
            $user = "Гость";

        $ins = 'INSERT INTO `comments`(comment, hotelid, user, date) 
                VALUES ("' . $comment . '", ' . $hotelid . ', "' . $user . '", "' . date("d.m.Y") . '")';
        
        mysqli_query($conn, $ins);
        $err = mysqli_errno($conn);

        // Если возникла ошибка
        if($err) {
            // Выводим сообщение с кодом ошибки
            echo '<h3 style="color: red">Код ошибки добавления данных в таблицу "comments": ' . $err . '</h3><br/>';
            // Прекращаем выполнение скрипта
            exit();
        }  

        echo "<script>";
        echo "window.location=document.URL;";
        echo "</script>";
    }
?>           