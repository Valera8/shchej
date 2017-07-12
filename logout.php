<?php
session_start();
if ($_SESSION['reg_success'])
{ //выход из регистрации
	unset ($_SESSION['reg_success']);
}
else
{  //выход из авторизации
	unset ($_SESSION['login']);
	unset ($_SESSION['password']);
}
header("Location: " . $_SERVER['HTTP_REFERER']);