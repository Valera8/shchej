<?php
//Точка входа
session_start();
if (!isset($_SESSION['username']) && isset($_COOKIE['username']))
    $_SESSION['username'] = ($_COOKIE['username']);
$username = $_SESSION['username'];
//Записываем в куки адрес этой страницы
setcookie('url', 'b.php');
if ($username == null)
{
    header("Location: login.php");
    exit;
}
?>
<html>
<head>
    <title>Страница Б</title>
</head>
<body>
<h1>Страница "Б"</h1>
<a href="a.php">А</a> и <b>Б</b> сидели на трубе.
<br>
<br>
Вы вошли как <b><?php echo $username; ?></b> | <a href="login.php">Выход</a>
</body>
</html>