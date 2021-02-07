<?php
require_once "models/database_class.php";
require_once "models/manage_class.php";
session_start();
$login = $_POST['login'];
$password = md5($_POST['password']);
$db = new DataBase();
if ($db->checkUser($login, $password))
{
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $password;
    $manage = new Manage($db);
    $name = $manage->getName($login);
    $family = $manage->getFamily($login);
    $_SESSION['name'] = $name;
    $_SESSION['family'] = $family;
}
else
{
    $_SESSION['error_aut'] = 1;
}
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;

