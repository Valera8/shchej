<?php
define( '_RCHE', 1 ); //определяет именованную константу, имя _RCHE с учётом регистра, значение 1
$AdminPass = 'moisey';
error_reporting(E_ERROR | E_WARNING | E_PARSE); //Включать в отчет простые описания ошибок
require_once('models/class.registry.php');
require_once('models/class.dbsql.php');
require_once('models/manage_class.php');
require_once('models/class.controller.php');
require_once('models/class.comments.php');
require_once('functions.php');
require_once('markhtml.php');
require_once ("models/config_class.php");

session_start();
$config = new Config();
$DB = new DB_Engine('mysql', $config->host, $config->user, $config->password, $config->db);
$manage = new Manage($db);
$registry = new Registry;

$registry->set('DB',$DB);

$comments = new Comments($registry);
$comments->admin = @($_GET['pass'] == $AdminPass) ? true : false;

if ($_SESSION['login'] && $_SESSION['password'])
{
  $comments->login = true;
  $comments->user = []; // массив с данными пользователя
  $comments->user['username'] = $_SESSION['login'];
  $comments->user['password'] = $_SESSION['password'];
  $comments->user['email'] = $manage->getEmail($_SESSION['login']);
  $comments->user['userID'] = $manage->getId($_SESSION['login']);
  $comments->user['photo'] = $manage->getPhoto($_SESSION['login']);
}
else
{
  $comments->login = false;
}
$comments->gravatar = true;
$comments->capcha = true;
$comments->index();

