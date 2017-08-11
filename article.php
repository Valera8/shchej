<?php
	require_once ("database.php");
	require_once ("models/articles.php");
	$link = db_connect();
//создается переменная
	$article = articles_get($link, $_GET['id']);
//подключается шаблон страницы одной статьи
	include ("views/article.php");

