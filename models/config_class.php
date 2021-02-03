<?php
class Config
{
    public $sitename = "shchej"; //Название сайта на хосте щей.рф
    public $address = "http://shchej"; /*На хосте вставить адрес правильный< https://щей.рф > */
    public $host = "127.0.0.1";// адрес хоста к базе данных на Денвере
    public $db = "blog";
    public $db_prefix = "rch_";//префикс для таблиц базы данных
    public $user = "root";
    public $password = "";
    public $admname = "Валерий Егоров";
    public $admemail = "egorov@dawork.ru";
    public $min_text = 8;
    public $max_text = 1000;
}