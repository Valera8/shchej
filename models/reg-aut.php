<?php
require_once ("config_class.php");
/*рассылка РусаковАвторизация Этот файл больше не использутся с 02.08.2020*/
function connectDb()
{
    $config = new Config();
    $mysqli = new mysqli($config->host, $config->user, $config->password, $config->db);
    $mysqli->set_charset("utf8");
    return $mysqli;
}
function closeDb($mysqli)
{
	$mysqli->close();
}
/*
function regUser($family, $name, $login, $email, $password, $photo)
{
	$mysqli = connectDb();
	$result = $mysqli->query("INSERT INTO rch_users (`family`, `name`, `username`, `email`, `password`, `photo`) VALUES ('$family','$name', '$login', '$email', '$password', '$photo')");
	closeDb($mysqli);
    return $result == true;
}

function checkUser ($login, $password)
{
	if (($login == "") || ($password == ""))
	{
		return false;
	}
	$mysqli = connectDb();
	$result_set = $mysqli->query("SELECT password FROM rch_users WHERE username = '$login'");
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
	$res = $mysqli->query("SELECT username FROM rch_users WHERE username = '$login'");
	$row = $res->fetch_assoc();
	$real_log = $row['username'];
	closeDb($mysqli);
	return $real_log == $login;
}

//  Проверка логина на корректность
function validLogin ($login) {
	if (isContainQuotes($login)) return false;
	/*Проверяем наличие хотя бы одной буквы
	if (preg_match("/^\d*S/", $login)) return false;
    return true;
}
/*Проверяет на наличие в строке кавычек
function isContainQuotes($string)
{
	$array = array("\"", "'", "`", "quot;", "&apos;");
	foreach ($array as $key => $value)
	{
		if (strpos($string, $value) !== false) return true;
	}
	return false;
}
/*  Проверка email на существование в БД
function checkEmail ($email)
{
	$mysqli = connectDb();
	$email = $mysqli->real_escape_string(trim($_POST['email']));
	$res = $mysqli->query("SELECT `email` FROM `rch_users` WHERE `email` = '$email'");
	$row = $res->fetch_assoc();
	$real_email = $row['email'];
	closeDb($mysqli);
	return $real_email == $email;
}
//  Проверка email на корректность
function validEmail ($email) {
    if (isContainQuotes($email)) return false;
    return true;
}
function validText($string)
{
	$config = new Config();
	/*Проверить на корректность
	return validString($string, $config->min_text, $config->max_text);
}
/*Проверка на валидность строки
function validString($string, $min_length, $max_length)
{
	if (!is_string($string)) return false;
	if (strlen($string) < $min_length) return false;
	if (strlen($string) > $max_length) return false;
	return true;
}
function isIntNumber ($number)
{
	if (!is_int($number) && !is_string($number)) return false;
	if (!preg_match("/^-?(([1-9][0-9]*|0))$/", $number)) return false;
	return true;
}*/
/*Проверка на неотрицательность числа
function isNoNegativeInteger($number)
{
	if (!isIntNumber($number)) return false;
	if ($number < 0) return false;
	return true;
}*/