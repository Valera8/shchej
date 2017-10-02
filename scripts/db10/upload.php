<?php
/*файл–обработчик формы загрузки пользовательского файла.*/
include("function.php"); // подключаем файл с функциями
// Запускаем функцию загрузки
if(!empty($_POST['load'])) // если кнопка "Загрузить файл"  нажата
{
    ini_set('max_file_uploads', '3'); /*Установить максимальное количество загружаемых на сервер файлов за один раз*/
    $valid_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $upload_dir = 'img_big';  // папка для загрузки (создать на сервере)
    $file = $_FILES["file"]["tmp_name"];
    $myfile_name = $_FILES["file"]["name"];
    $file_type = substr($myfile_name, strrpos($myfile_name, '.') + 1); //strrpos - Возвращает позицию последнего вхождения символа
    // Если загрузка файла на сервер успешная
    if(isset($_FILES["file"]))//Определяет, была ли установлена переменная значением отличным от NULL
    {
        $file_size = $_FILES["file"]["size"];
        $error_flag = $_FILES["file"]["error"];

        // Если ошибок не было
        if($error_flag == 0)
        {
            $f_thum = "big/thum_" . $myfile_name;
            /*добавление записи в таблицу базы данных*/
            add('big', $file_type, $file, $myfile_name);
            //print("<br>" . "Имя файла на нашем сервере (во время запроса): " . $file . "<br>");
            print("<br>" . "Имя файла на компьютере пользователя: " . $myfile_name . "<br>");
            print("Размер файла: " . $file_size . ' bytes' . "<br>");
        }
    }
    $message = upload(1, $valid_extensions, $upload_dir);
    // Выводим сообщение
    echo $message['error'] ? $message['error'] : $message['info'];
    echo '<br /><br />';
    echo '<a href="index.php">Вернуться на страницу галереи</a>';
    $src = $message['destination'];

/* чтобы изменить размеры фото необходимо запустить функцию img_resize с нужными параметрами ширины и высоты нового изображения. Если нужен только один параметр, например ширина 200px, то высоту задаем равную 0 (ноль). При этом получим пропорциональное фото с шириной 200px.*/
$file_name = assignName('big', $file, $file_type);
$dest = 'img_small/' . $file_name;

img_resize($src, $dest, 200, 0);

//Добавить запись в базу данных в таблицу small
addSmall($file_type, $file_name);
}
?>