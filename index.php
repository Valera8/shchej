<?php
// подключение файлов
	require_once ("database.php");
	require_once ("models/articles.php");

	$link = db_connect();
//создание переменной
	$articles = articles_all($link);
//проверка корректности адресной строки
if (($_SERVER['REQUEST_URI']) ==  "/index.php" || ($_SERVER['REQUEST_URI']) ==  "/" || ($_SERVER['REQUEST_URI']) ==  "") //подключение шаблона главной страницы блога
{
	include ("views/articles.php");
}
else
{
    header("HTTP/1.0 404 Not Found");
    include('views/notfound.php');
    exit;
}




