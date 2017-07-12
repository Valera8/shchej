<?php
function connectDb()
{
	return new mysqli("127.0.0.1", "root", "", "blog");
}
function closeDb($mysqli)
{
	$mysqli->close();
}
function regUser($name,$login, $email,$password)
{
	$mysqli = connectDb();
	$mysqli->query("INSERT INTO user (`name`, `login`, `email`, `password`) VALUES ('$name', '$login', '$email', '$password')");
	closeDb($mysqli);
}
function checkUser ($login, $password)
{
	if (($login == "") || ($password == ""))
	{
		return false;
	}
	$mysqli = connectDb();
	$result_set = $mysqli->query("SELECT password FROM user WHERE login = '$login'");
	$user = $result_set->fetch_assoc();
	$real_pass = $user['password'];
	closeDb($mysqli);
	return $real_pass == $password;
}

//  Проверка логина на существование в БД
function checkLogin ($login)
{
	$mysqli = connectDb();
	$login = $mysqli->real_escape_string(trim($_POST['login']));
	$res = $mysqli->query("SELECT `login` FROM `user` WHERE `login` = '$login'");
	$row = $res->fetch_assoc();
	$real_log = $row['login'];
	closeDb($mysqli);
	return $real_log == $login;
}
//  Проверка email на существование в БД
function checkEmail ($email)
{
	$mysqli = connectDb();
	$email = $mysqli->real_escape_string(trim($_POST['email']));
	$res = $mysqli->query("SELECT `email` FROM `user` WHERE `email` = '$email'");
	$row = $res->fetch_assoc();
	$real_email = $row['email'];
	closeDb($mysqli);
	return $real_email == $email;
}


