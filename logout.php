<?php
session_start();
if ($_SESSION['reg_success'])
{ //����� �� �����������
	unset ($_SESSION['reg_success']);
}
else
{  //����� �� �����������
	unset ($_SESSION['login']);
	unset ($_SESSION['password']);
}
header("Location: " . $_SERVER['HTTP_REFERER']);