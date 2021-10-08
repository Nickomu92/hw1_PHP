<ul class="nav nav-pills nav-justified">
    <li <?php echo ($page == 1) ? "class='nav-item nav-link active'" : "nav-item nav-link" ?>>
        <a href="index.php?page=1">Туры</a>
    </li>

    <li <?php echo ($page == 2) ? "class='nav-item nav-link active'" : "nav-item nav-link" ?>>
        <a href="index.php?page=2">Комментарии</a>
    </li>

    <li <?php echo ($page == 3) ? "class='nav-item nav-link active'" : "nav-item nav-link" ?>>
        <a href="index.php?page=3">Регистрация</a>
    </li>

    <li <?php echo ($page == 4) ? "class='nav-item nav-link active'" : "nav-item nav-link" ?>>
        <a href="index.php?page=4">Кабинет администратора</a>
    </li>

    <?php
        if(isset($_SESSION['radmin'])) {
            if($page == 6)
                $c = 'active';

            else
                $c = '';
            echo '<li class="' . $c .'"><a href="index.php?page=6">Приватно</a></li>';
        }
    ?>
</ul>              
    
