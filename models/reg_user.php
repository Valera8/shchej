<?php
if (isset ($_POST['reg']))
{
	require_once "reg-aut.php";
	require_once "captcha_class.php";
	session_start();
	$prevPg = $_SESSION['prevPg'];
	unset ($_SESSION['error_name']);
	unset ($_SESSION['error_login']);
	unset ($_SESSION['error_log']);
	unset ($_SESSION['error_email']);
	unset ($_SESSION['error_mail']);
	unset ($_SESSION['error_password']);
	unset ($_SESSION['error_pass2']);
	unset ($_SESSION['reg_success']);
	unset ($_SESSION['error_captcha']);

	$name = htmlspecialchars($_POST['name']);
	$login = htmlspecialchars($_POST['login']);
	$email = htmlspecialchars($_POST['email']);
	$password = htmlspecialchars($_POST['password']);
	$pass2 = htmlspecialchars($_POST['pass2']);
	$family = htmlspecialchars($_POST['family']);
	if ($_POST['photo'] == '')
	{
        $photo = 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($email))) . '?size=50&default=wavatar" alt="аватар';
	}
    else $photo = htmlspecialchars($_POST['photo']);

	$_SESSION["name"] = $name;
	$_SESSION["login"] = $login;
	$_SESSION["email"] = $email;
	$_SESSION["password"] = $password;
	$_SESSION["pass2"] = $pass2;
	$_SESSION["photo"] = $photo;
	$_SESSION["family"] = $family;
	$captcha = new Captcha;
	$bad = false;
	if ((strlen($login) < 3) || (strlen($login) > 32))
	{
		$_SESSION['error_login'] = 1;
		$bad = true;
	}
	if (!validLogin ($login))
	{
		$_SESSION['error_login'] = 1;
		$bad = true;
	}
	if (checkLogin ($login))
	{
		$_SESSION['error_log'] = 1;
		$bad = true;
	}
	if ((strlen($password) < 6) || (strlen($password) > 32))
	{
		$_SESSION['error_password'] = 1;
		$bad = true;
	}
	/*Проверяем на совподение пароли*/
	if($_POST['password'] != $_POST['pass2'])
	{
		$_SESSION['error_pass2'] = 1;
		$bad = true;
	}
	if (!preg_match("/^[a-z0-9][a-z0-9\.-_]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i", $_SESSION["email"]))
	{
		$_SESSION['error_email'] = 1;
		$bad = true;
	}
	if (!validEmail ($email))
	{
		$_SESSION['error_email'] = 1;
		$bad = true;
	}
	if (checkEmail ($email))
	{
		$_SESSION['error_mail'] = 1;
		$bad = true;
	}
	if (!$captcha->check($_POST['captcha']))
	{
		$_SESSION['error_captcha'] = 1;
		$bad = true;
	}
	if (!$bad)
	{
		if (regUser($family, $name, $login, $email, md5($password), $photo))
		{
			$_SESSION['reg_success'] = 1;
			$lastUrl = ($prevPg == 'http://shchej/models/reg_user.php') ? 'http://shchej/' : $prevPg;
			header("Location: " . $lastUrl);
			exit;
		}
		else echo 'Ошибка базы данных! Пожалуйста, повторите позже.';
	}
}
include('../views/reg.php');
