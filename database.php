<?php
//define('MYSQL_SERVER', 'localhost'); //mysql.hostinger.ru
//define('MYSQL_USER', 'root');     //u484296424_stoma
//define('MYSQL_PASSWORD', '');       //moisey1958
//define('MYSQL_DB', 'blog');        //u484296424_blog
require_once ("models/config_class.php");
function db_connect()
{
    $config = new Config();
	$link = mysqli_connect($config->host, $config->user, $config->password, $config->db)
	or die("Error: " . mysqli_error($link));
	if(!mysqli_set_charset($link, "utf8"))
	{
		printf("Error: " . mysqli_error($link));
	}
	return $link;
}
