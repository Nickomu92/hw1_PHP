<h3 class="text-center">Редактирование</h3><hr/>
<?php
    // Если у нас нет прав админа, то
    if(!isset($_SESSION['radmin'])) {
        // Выводим сообщение
        echo "<h3><span style = 'color: red;'>Только для Администаторов!</span></h3>";
        // Выходим, прекращая работу скрипта
        exit();
    }         
?>

<div class="row m-b-10">
    <div class="col-sm-6 col-md-6 col-lg-6 left">
        <!-- section 1: форма для стран -->
        <h3 class="text-center">Стран</h3><hr/>
        <?php
            $conn = connect_to_db();

            $sel = 'SELECT * FROM `countries`';

            $res = mysqli_query($conn, $sel);
            echo '<form action="index.php?page=4" method="POST" class="inpu-group" id="formcountry">';
            echo '<table class="table table-striped">';

            while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                echo '<tr>';
                echo '<td>' . $row[0] . '</td>';
                echo '<td>' . $row[1] . '</td>';
                echo '<td><input type="checkbox" name="cb'. $row[0] . '"</td>';
                echo '</tr>';
            }
            echo '</table>';
            mysqli_free_result($res);

            echo '<input type="submit" name="delcountry" value="Удалить выбранные" class="btn btn-sm btn-warning"><hr/>';
            echo '<input type="text" name="country" placeholder="Страна"/><br/>';
            echo '<input type="submit" name="addcountry" value="Добавить" class="btn btn-sm btn-info m-t-10"/>';
            
            echo '</form>'; 
            // Обработка события нажатия на кнопку "Добавить" формы для стран
            if(isset($_POST['addcountry'])) {
                $country = trim(htmlspecialchars($_POST['country']));

                if($country == "") 
                    exit;

                $ins = 'INSERT INTO countries(country) 
                        VALUES("'. $country .'")';

                mysqli_query($conn, $ins);

                echo "<script>";
                echo "window.location = document.URL;";
                echo "</script>";
            }

            // Обработка события нажатия на кнопку "Удалить выбранные" формы для стран
            if(isset($_POST['delcountry'])) {
                foreach($_POST as $k => $v) {
                    if(substr($k, 0, 2) == "cb") {
                        $idc = substr($k, 2);
                        $del = 'delete from countries where id='.$idc;
                        mysqli_query($conn, $del);
                    }
                }

                echo "<script>";
                echo "window.location = document.URL;";
                echo "</script>";
            }
        ?>
    </div>  
    <div class="col-sm-6 col-md-6 col-lg-6 left">
        <!-- section 2: форма для городов -->
        <h3 class="text-center">Городов</h3><hr/>
        <?php
            echo '<form action="index.php?page=4" method="POST" class="input-group" id="formcity">';

            $sel = 'SELECT ci.id, ci.city, co.country
                    FROM countries co, cities ci
                    WHERE ci.countryid = co.id';

            $res = mysqli_query($conn, $sel);

            echo '<table class="table table-striped">';

            while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                echo '<tr>';
                echo '<td>' . $row[0] . '</td>';
                echo '<td>' . $row[1] . '</td>';
                echo '<td>' . $row[2] . '</td>';
                echo '<td><input type="checkbox" name="ci' . $row[0] . '"</td>';
                echo '</tr>';
            }
            echo '</table>';

            mysqli_free_result($res);

            echo '<input type="submit" name="delcity" value="Удалить выбранные" class="btn btn-sm btn-warning mb-2"><hr/>';

            $res = mysqli_query($conn, 'SELECT * FROM countries');
            
            echo '<select name="countryname" class="m-b-10">';

            while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
            }
            echo '</select><br/>';
          
            echo '<input type="text" name="city" placeholder="Город"><br/>';
            echo '<input type="submit" name="addcity" value="Добавить" class="btn btn-sm btn-info m-t-10">';
            echo '</form>'; 


            // Обработка события нажатия на кнопку "Добавить" формы для городов
            if(isset($_POST['addcity'])) {
                $city = trim(htmlspecialchars($_POST['city']));

                if($city == "") 
                    exit();

                $countryid = $_POST['countryname'];

                $ins = 'INSERT INTO `cities`(city, countryid) VALUES ("' . $city . '", '. $countryid . ')';

                mysqli_query($conn, $ins);
                $err = mysqli_errno($conn);

                if($err) {
                    echo '<h3 style="color: red">Код ошибки добавления данных в таблицу "cities"' . $err . '</h3><br/>';
                    exit();
                }

                echo "<script>";
                echo "window.location = document.URL;";
                echo "</script>";
            }

            // Обработка события нажатия на кнопку "Удалить выбранные" формы для городов
            if(isset($_POST['delcity'])) {
                foreach($_POST as $k => $v) {
                    if(substr($k, 0, 2) == "ci") {
                        $idc = substr($k, 2);
                        $del = 'DELETE FROM cities WHERE id =' . $idc;
                        mysqli_query($conn, $del);
                    }
                }
                echo "<script>";
                echo "window.location = document.URL;";
                echo "</script>";
            }
        ?>
    </div>  
</div>
<hr/>
<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6 left">
        <!-- section 3: форма для отелей -->
        <h3 class="text-center">Отелей</h3><hr/>
        <?php
            echo '<form action="index.php?page=4" method="POST" class="input-group" id="formhotel">';
            
            $sel = 'SELECT ci.id, ci.city, ho.id, ho.hotel, ho.cityid, ho.countryid, ho.stars, ho.info, co.id, co.country
                    FROM cities ci, hotels ho, countries co
                    WHERE ho.cityid = ci.id AND ho.countryid = co.id';

            $res = mysqli_query($conn, $sel);
            $err = mysqli_errno($conn);
            echo '<table class="table" width="100%">';

            while ($row=mysqli_fetch_array($res, MYSQLI_NUM)) {
                echo '<tr>';
                echo '<td>' . $row[2] . '</td>';
                echo '<td>' . $row[1] . "-" . $row[9] . '</td>';
                echo '<td>' . $row[3] . '</td>';
                echo '<td>' . $row[6] . '</td>';
                echo '<td><input type="checkbox" name="hb' . $row[2] . '"></td>';
                echo '</tr>';
            }
            echo '</table>';
            mysqli_free_result($res);

            echo '<input type="submit" name="delhotel" value="Удалить выбранные" class="btn btn-sm btn-warning"><hr/>';

            $sel = 'SELECT ci.id, ci.city, co.country, co.id
                    FROM countries co, cities ci
                    WHERE ci.countryid=co.id';

            $res = mysqli_query($conn, $sel);
            $csel = array();

            echo '<select name="hcity" class="">';

            while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                echo '<option value="' . $row[0] . '">г. '. $row[1] . " (". $row[2] . ')</option>';
                $csel[$row[0]] = $row[3];
            }

            echo '</select><br/>';
            echo '<input type="text" name="hotel" class="m-t-10" placeholder="Отель"><br/>';
            echo '<input type="text" name="cost" class="m-t-10 m-b-10" placeholder="Стоимость"><br/>';
            echo '<label>Количество звезд: <input type="number" name="stars" min="1" max="5" value="3"></label>';

            echo '<br><textarea name="info" placeholder="Описание"></textarea><br/>';
            echo '<input type="submit" name="addhotel" value="Добавить" class="btn btn-sm btn-info m-t-10 m-b-10">';
            echo '</form>';

            mysqli_free_result($res);

            // Обработка события нажатия на кнопку "Добавить" формы для отелей
            if(isset($_POST['addhotel'])) {
                $hotel = trim(htmlspecialchars($_POST['hotel']));
                $cost = intval(trim(htmlspecialchars($_POST['cost'])));
                $stars = intval($_POST['stars']);
                $info = trim(htmlspecialchars($_POST['info']));

                if ($hotel == "" || $cost == "" || $stars == "") 
                    exit();

                $cityid = $_POST['hcity'];
                $countryid = $csel[$cityid];
                $ins = 'INSERT INTO hotels (hotel, cityid, countryid, stars, cost, info) 
                        VALUES ("' . $hotel . '",' . $cityid . "," . $countryid .',' . $stars . ',' . $cost . ',"' . $info . '")';
                
                mysqli_query($conn, $ins);

                echo "<script>";
                echo "window.location=document.URL;";
                echo "</script>";
            }

            // Обработка события нажатия на кнопку "Удалить выбранные" формы для отелей
            if(isset($_POST['delhotel'])){
                foreach ($_POST as $k => $v) {
                    if (substr($k, 0, 2)=="hb") {
                        $idc = substr($k, 2);
                        $del='DELETE FROM hotels WHERE id = ' . $idc;

                        mysqli_query($conn, $del);

                        if ($err) {
                            echo 'Error code:' . $err . '<br>';
                            exit();
                        }
                    }
                }

                echo "<script>";
                echo "window.location = document.URL;";
                echo "</script>";
            }
        ?>
    </div>  

    <div class="col-sm-6 col-md-6 col-lg-6 left">
        <!-- section 4: форма для загрузки картинок -->
        <h3 class="text-center">Загрузка фото</h3><hr/>
        <?php
            echo '<form action="index.php?page=4" method="POST" enctype="multipart/form-data" class="input-group">';
            
            $sel = 'SELECT ho.hotel, ho.id, co.country, ci.city
                    FROM countries co, cities ci, hotels ho
                    WHERE ho.countryid = co.id AND ho.cityid = ci.id
                    ORDER BY co.country';

            $res = mysqli_query($conn, $sel);

            echo '<select name="hotelid">';
            while($row = mysqli_fetch_array($res, MYSQLI_NUM)){
                echo '<option value="' . $row[1] . '">';
                echo '"' . $row[0] . '" (г. ' . $row[3] . ', ' . $row[2] . ')</option>';
            }
            echo '</select>';

            mysqli_free_result($res);

            echo '<input type="file" name="file[]" multiple accept="image/*" class="m-t-10">';
            echo '<input type="submit" name="addimage" value="Добавить" class="btn btn-sm btn-info m-t-10">';
         
            echo '</form>';

            // Обработка события нажатия на кнопку "Добавить" формы для загрузки картинок
            if(isset($_REQUEST['addimage'])) {
                foreach($_FILES['file']['name'] as $k => $v) {
                    if($_FILES['file']['error'][$k] != 0){
                        echo '<script>alert("Ошибка загрузки файла: ' . $v . '")</script>';
                        continue;
                    }

                    if(move_uploaded_file($_FILES['file']['tmp_name'][$k],'images/'. $v)) {

                        $ins = 'INSERT INTO images(hotelid, imagepath) 
                                VALUES (' . $_REQUEST['hotelid'] . ',"images/' . $v . '")';

                        mysqli_query($conn, $ins);
                    }
                }
            }
            echo '</div>';
        ?>
    </div>  
</div>