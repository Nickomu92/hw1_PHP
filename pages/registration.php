<section id="registration">
    <h3 class="text-center">Регистрация</h3><hr/>
    <?php
        if(!isset($_POST['regbtn'])) {
    ?>
        <form action="index.php?page=3" method="POST" class="">

            <div class="form-group">
                <label for="login">Логин:</label>
                <input type="text" class="form-control" name="login">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email">
            </div>

            <div class="form-group">
                <label for="pass1">Пароль:</label>
                <input type="password" class="form-control" name="pass1">
            </div>

            <div class="form-group">
                <label for="pass2">Подтверждение пароля:</label>
                <input type="password" class="form-control" name="pass2">
            </div>
            
            <button type="submit" class="btn btn-primary m-b-10" name="regbtn">Зарегистрироваться</button>
            
        </form>
    <?php
        }

        else {
            if(register_user($_POST['login'], $_POST['pass1'], $_POST['email'])) {
                echo "<h3><span style='color: green;'>Добавлен новый пользователь!</span></h3>";
            }
        }
    ?>
</section>