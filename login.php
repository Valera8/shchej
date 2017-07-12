<?php
require_once "models/reg-aut.php";
session_start();
$login = $_POST['login'];
$password = md5($_POST['password']);
//unset ($_SESSION['error_aut']);
if (checkUser($login, $password))
{
$_SESSION['login'] = $login;
$_SESSION['password'] = $password;
}
else
{
$_SESSION['error_aut'] = 1;
}
header("Location: " . $_SERVER['HTTP_REFERER']);

