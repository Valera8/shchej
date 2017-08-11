<?php
require_once ("config_class.php");
/*рассылка РусаковАвторизация*/
function connectDb()
{
    $config = new Config();
	return new mysqli($config->host, $config->user, $config->password, $config->db);
}
function closeDb($mysqli)
{
	$mysqli->close();
}
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
	/*Проверяем наличие хотя бы одной буквы*/
	if (preg_match("/^\d*S/", $login)) return false;
    return true;
}
/*Проверяет на наличие в строке кавычек*/
function isContainQuotes($string)
{
	$array = array("\"", "'", "`", "quot;", "&apos;");
	foreach ($array as $key => $value)
	{
		if (strpos($string, $value) !== false) return true;
	}
	return false;
}
//  Проверка email на существование в БД
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


