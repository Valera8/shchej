<?php
session_start();
//Авторизация
function Login ($username, $remember)
{
    if ($username == '') return false;
    $_SESSION['username'] = $username;// Запоминаем имя в сессии
    $_SESSION['url'] = $remember;
    if ($remember)
    {
        setcookie('username', $username, time() + 3600 * 24 * 7);// Запоминаем имя в куки
    }
    return true;
}
//Точка входа
//Если пользователь авторизован с запоминанием,
// отправляем на последнюю посещенную им страницу
if ($_SESSION['username'] && $_SESSION['url'])
{
    header("Location: " . $_COOKIE['url']);
    exit;
}
//Если пользователь не авторизован,
//а производит авторизацию с запоминанием- на страницу a.php
elseif (count($_POST) > 1 && $_POST['remember'])
{
    Login($_POST['username'], $_POST['remember'] == 'on');
    header("Location: a.php");
    exit;
}
//Если пользователь не авторизован,
//а авторизуется без запоминания - отправляем на страницу b.php
elseif (count($_POST) > 0 && $_POST['remember'] == null)
{
    Login($_POST['username'], $remember = false);
    header("Location: b.php");
    exit;
}
else
{
    header("Location: login.php");
    exit;
}
?>