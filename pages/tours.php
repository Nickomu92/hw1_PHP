<h3 class="text-center">Выбор тура</h3><hr/>

<?php 
    $conn = connect_to_db();

    echo '<form action = "index.php?page=1" method="POST">';
    echo '<div class="form-group">';
    echo '<label for="selectcountry">Выбор страны: </label>';
    echo '<select name="countryid" id="selectcountry" class="form-control col-sm-3 col-md-3 col-lg-3">';
    echo '<option value="0">Выбор страны...</option>';
    
    $sel = 'SELECT * FROM `countries`
            ORDER BY country';

    $res = mysqli_query($conn, $sel);

    while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
        echo '<option value="'. $row[0] . '">' . $row[1] . '</option>';
    }

    mysqli_free_result($res);
    echo '</select>';
    echo '</div>';
    echo '<input type="submit" name="selcountry" value="Выбор страны" class="btn btn-primary m-t-10 m-b-10">';

    if(isset($_POST['selcountry'])) {
        echo '<br/>';
        $countryid = $_POST['countryid'];

        if($countryid == 0)
            exit();
        
        $sel = 'SELECT * FROM `cities`
                WHERE countryid = ' . $countryid . ' ORDER BY city';

        $res = mysqli_query($conn, $sel);

        echo '<div class="form-group">';
        echo '<label for="selectcity">Выбор города: </label>';
        echo '<select name="cityid" id="selectcity" class="form-control d-inline-flex col-sm-3 col-md-3 col-lg-3 col-xl-3">';
        echo '<option value="0">Выбор города...</option>';

        while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo '<option value="'. $row[0] . '">' . $row[1] . '</option>';
        }

        mysqli_free_result($result);
        echo '</select>';
        echo '</div>';
        echo '<input type="submit" name="selcity" value="Выбор города" class="btn btn-primary m-t-10 m-b-10">';
    }
 
    echo '</form>';

    if(isset($_POST['selcity'])) {
        $cityid = $_POST['cityid'];
        $sel = 'SELECT co.country, ci.city, ho.hotel, ho.cost, ho.stars, ho.id
                FROM hotels ho, cities ci, countries co
                WHERE ho.cityid = ci.id AND ho.countryid = co.id AND ho.cityid = ' . $cityid;
       
        $res = mysqli_query($conn, $sel);

        echo '<table width="100%" class="table table-striped tbtours text-center">';
        echo '<thead style="font-weight: bold">';
        echo '<td>Отель</td><td>Страна</td><td>Город</td><td>Цена</td><td>Количество звезд</td><td>Ссылка</td>';
        echo '</thead>';

        while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
            echo '<tr id = "' . $row[1] . '">';
            echo '<td>' . $row[2] . '</td><td>' . $row[0] . '</td><td>' . $row[1] . '</td><td>$' . $row[3] . '</dt><td>' . $row[4] . '</td><td><a href="pages/hotelinfo.php?hotel=' . $row[5] . '" target="_blank">Подробнее</a></td>';
            echo '</tr>';
        }
                
        echo '</table><br/>';
    }