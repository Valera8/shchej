<?php
//Сброс авторизации
session_start();
setcookie('username', '', time() - 1);
setcookie('url', '', time() - 1);
unset($_SESSION['username']);
unset($_SESSION['url']);
?>
<html>
<head>
    <title>Вход на сайт</title>
</head>
<body>
    <h1>Вход на сайт</h1>
    <form action="index.php" method="post">
        Введите имя:
        <br>
        <input type="text" name="username">
        <br>
        <input type="checkbox" name="remember"> Запомнить меня
        <br>
        <input type="submit" value="Войти">
    </form>
</body>
</html>
