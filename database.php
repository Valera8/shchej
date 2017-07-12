<?php
define('MYSQL_SERVER', 'localhost'); //mysql.hostinger.ru
define('MYSQL_USER', 'root');     //u484296424_stoma
define('MYSQL_PASSWORD', '');       //moisey1958
define('MYSQL_DB', 'blog');        //u484296424_blog

function db_connect()
{
	$link = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB)
	or die("Error: " . mysqli_error($link));
	if(!mysqli_set_charset($link, "utf8"))
	{
		printf("Error: " . mysqli_error($link));
	}

	return $link;
}
