<?php
//Подключение библиотек
require_once('model/ModelGallery.php');
require_once('model/ControllerGallery.php');
//Создадим модели.
$modelGalleryIcon = new ModelGallery('img_small'); //для загрузки уменьшенных фото
$controllerGallery = new ControllerGallery();
//Загружаем фотографию, если пользователь отправил файл.
$controllerGallery->AddPhoto();

//Подготовка данных.
$photos = $modelGalleryIcon->Listing();
//Заголовок страницы.
$title = 'Галерея фотографий';
//Выбор шаблона содержимого.
$content = ($_GET['view'] == 'list') ? 'templates/content_index_list.php' : 'templates/content_index_table.php';
//Вывод HTML.
include 'templates/main.php';
?>