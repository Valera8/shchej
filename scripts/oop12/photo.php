<?php
//Подключение библиотек
require_once('model/ModelGallery.php');
$modelGalleryImage = new ModelGallery('img_big');
//Подготовка данных.
$i = $_GET['id'];
//Заголовок страницы.
$title = 'Просмотр фотографии';
//Выбор шаблона содержимого.
$content = 'templates/content_photo.php';
//Вывод HTML.
include 'templates/main.php';
?>