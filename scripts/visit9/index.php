<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Галерея фото</title>
    </head>
    <body>
        <h1>Галерея фотографий</h1>
        <?php
        require_once ('function.php');
        //вывод изображений
        $dir = "img_small"; // Путь к директории, в которой лежат малые изображения
        $dir_big = "img_big"; // Путь к директории, в которой лежат большые изображения
        $files = scandir($dir); // Получаем список файлов из этой директории
        $files = excess($files); // Удаляем лишние файлы c '.' ...
        /* Дальше происходит вывод изображений на страницу сайта */
        for ($i = 0; $i < count($files); $i++)
        {
        ?>
        <!-- Делаем ссылку на большую картинку, вывод малых картинок -->
            <a href="<?=$dir_big . "/" . $files[$i]?>" target="_blank"><img src="<?=$dir."/".$files[$i]?>" alt="Фото галереи" /></a>
        <?php
        }
        ?>
        <h2>Загрузить фотографию</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <p><input type="file" name="file"></p>
            <p><input type="submit" name="load" value="Загрузить файл"></p>
            <br>
        </form>
    </body>
</html>
