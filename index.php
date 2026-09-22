<?php
session_start();
$whiteList = ['ok', 'err'];
$status = $_GET['stat'] ?? '';
$class = in_array($status, $whiteList) ? $status : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script defer src="js/script.js"></script>
    <title>Registration</title>
</head>
<body>
    <header></header>
    <main>
        <div class="regContainer">
            <div class="formWrap">
                <form action="php/reg.php" method="POST">
                    <h2>Регистрация</h2>    

                    <? if (!empty($_SESSION['message'])): ?>
                        <p class="<?=$class?>">
                            <?= htmlspecialchars($_SESSION['message']) ?>
                        </p>
                        <? unset($_SESSION['message']); ?>
                    <? endif; ?>

                    <label for="login">Введите логин</label>
                    <input type="text" required name="login" placeholder="Login" id="login">

                    <label for="fio">Введите ФИО</label>
                    <input type="text" required name="fio" placeholder="ФИО" id="fio">

                    <label for="tel">Введите телефон</label>
                    <input type="tel" required name="tel" placeholder="Телефон" id="tel">

                    <label for="email">Введите почту</label>
                    <input type="email" required name="email" placeholder="Email" id="email">

                    <label for="pass1">Введите пароль</label>
                    <input type="password" required name="password" placeholder="Пароль" id="pass1">

                    <label for="pass2">Повторите пароль</label>
                    <input type="password" required name="rePassword" placeholder="Повторите пароль" id="pass2">
                    <p id="passMessage"></p>

                    <input type="submit" value="Зарегистрироваться">

                    <div class="forgetPassword">
                    <label for="inputPassword">Есть аккаунт?</label>
                    <a href="authPage.php">Войти</a>
                </div>
                </form>
            </div>
        </div>
    </main>
    <footer></footer>
</body>
</html>