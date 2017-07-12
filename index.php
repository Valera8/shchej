<?php
// подключение файлов
	require_once ("database.php");
	require_once ("models/articles.php");

	$link = db_connect();
//создание переменной
	$articles = articles_all($link);
//подключение шаблона главной страницы блога
	include ("views/articles.php");



