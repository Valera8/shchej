<?php
require_once ('function.php');
$dir_big = "img_big"; // Путь к директории, в которой лежат большие изображения
click('big', $_GET['id']);//Подсчитываем количество просмотров
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Крупно</title>
    </head>
    <body>
    <figure>
        <img src="<?=$dir_big . "/" . $_GET['id']?>" alt="Фото <?=$_GET['id']?>">
        <figcaption>Количество просмотров: <strong><?=getClicks($_GET['id'])?></strong></figcaption>
    </figure>
    <a href="index.php">Вернуться на страницу галереи</a>
    </body>
</html>