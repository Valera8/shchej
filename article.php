<?php
//require_once ("database.php");
require_once ("models/articles.php");
require_once('models/database_class.php');
//это файл контроллера
//$link = db_connect();
//создается переменная
//require_once('models/database_class.php');
$db = new DataBase();
$link = $db->mysqli;
$article = articles_get($link, $_GET['id']);
//проверка корректности адресной строки с id
$peak = $db->getLastID ('articles');
if (((preg_match('/^\+?\d+$/', $_GET['id'])) == false) || $_GET['id'] < 2 || $_GET['id'] > $peak || strpos($_SERVER['REQUEST_URI'], '&', 11))
{
    header("HTTP/1.0 404 Not Found");
    include('views/notfound.php');
    exit;
}
//подключается шаблон страницы одной статьи
else include ("views/article.php");

