<!-- Страница с выводом полной информации об отеле -->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Информация об отеле</title>
        <link  rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/info.css">
    </head>
    <body>
        <?php
            include_once("functions.php");
            if(isset($_GET['hotel'])) {
                $hotel = $_GET['hotel'];
                $conn = connect_to_db();

                $sel = 'SELECT * FROM  `hotels`
                        WHERE id = '. $hotel;
   
                $res = mysqli_query($conn, $sel);

                $row = mysqli_fetch_array($res, MYSQLI_NUM);

                $hname = $row[1];
                $hstars = $row[4];
                $hcost = $row[5];
                $hinfo = $row[6];

                mysqli_free_result($res);

                echo '<h2 class="text-uppercase text-center">"' . $hname . '"</h2>';
                echo '<div class="row">';
                echo '<div class="text-center">';
                $conn = connect_to_db();

                $sel = 'SELECT imagepath FROM `images`
                        WHERE hotelid = ' . $hotel;

                $res = mysqli_query($conn, $sel);

                echo '<span class="label label-info">Смотреть наши фото</span>';
                echo '<div id="gallery">';
              
                while($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                    echo '<div><img src="../' . $row[0] . '"/></div>';
                }

                mysqli_free_result($res);
                echo "</div>";


                $i = 0;
                echo '<div class="col-md-12">';
                echo '<div id="stars" class="col-md-4">';
                echo '<span>Количество звезд:</span>';
                for($i = 0; $i < $hstars; $i++) {
                    echo '<image src="../images/star.png" alt="star"/>';
                }  
                echo '</div>';
                echo '<div class="col-md-4"><a href="#" class="btn btn-success">Забронировать номер</a></div>';
                echo '<div class="col-md-4"><span class="text-2x">' . $hcost . ' $</span></div>';
                echo '</div>';
                echo '<div class="col-md-12"><p class="well bold">' . $hinfo . '</p></div>';

                $sel = 'SELECT * FROM `comments`
                        WHERE hotelid = ' . $hotel;

                $res = mysqli_query($conn, $sel);

                echo '<div class="col-md-12 text-left">';
                echo '<p class="center text-2x">Отзывы о нас:</p>';

                while($row = mysqli_fetch_array($res, MYSQLI_NUM)){
                    echo '<div class="left">';
                    echo '<p class="well"><span class="bold">' . $row[3] . ' (' . $row[4] . '): </span>"' . $row[1] . '"</p></div>';
                }
                echo '</div>';
                echo '</div></main>';
            }
        ?>

        <script src="../js/jquery-3.1.0.min.js"></script>
        <script src="../js/gallery.js"></script>
        <script src="../js/info2.js"></script>
    </body>
</html>