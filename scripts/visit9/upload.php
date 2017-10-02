<?php
/*файл–обработчик формы загрузки пользовательского файла.*/
include("function.php"); // подключаем файл с функциями
// Запускаем функцию загрузки
if(!empty($_POST['load'])) // если кнопка "Загрузить файл"  нажата
{
    $valid_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $upload_dir = 'img_big';  // папка для загрузки (создать на сервере)
    $message = upload(1, $valid_extensions, $upload_dir);
    // Выводим сообщение
    echo $message['error'] ? $message['error'] : $message['info'];
    // Если загрузка файла на сервер успешная
    if(isset($_FILES["file"]))//Определяет, была ли установлена переменная значением отличным от NULL
    {
        ini_set('max_file_uploads', '3'); /*Установить максимальное количество загружаемых на сервер файлов за один раз*/
        $file = $_FILES["file"]["tmp_name"];
        $myfile_name = $_FILES["file"]["name"];
        $file_type = substr($myfile_name, strrpos($myfile_name, '.')+1); //strrpos - Возвращает позицию последнего вхождения символа
        $file_size = $_FILES["file"]["size"];
        $error_flag = $_FILES["file"]["error"];

        // Если ошибок не было
        if($error_flag == 0)
        {
            $f_thum="big/thum_" . $myfile_name;

            print("<br>" . "Имя файла на нашем сервере (во время запроса): " . $file . "<br>");
            print("Имя файла на компьютере пользователя: " . $myfile_name . "<br>");
            print("Имя thumb-файла на сервере: " . $f_thum . "<br>");
            print("MIME-тип файла: " . $file_type . "<br>");
            print("Размер файла: " . $file_size . "<br><br>");
        }
    }
    echo '<br /><br />';
    echo '<a href="index.php">Вернуться на страницу галереи</a>';
    $src = $message['destination'];

/* чтобы изменить размеры фото необходимо запустить функцию img_resize с нужными параметрами ширины и высоты нового изображения. Если нужен только один параметр, например ширина 200px, то высоту задаем равную 0 (ноль). При этом получим пропорциональное фото с шириной 200px.*/

$file_name = time() . $_FILES['file']['name'];
$dest = 'img_small/' . $file_name;

img_resize($src, $dest, 200, 0);
}
?>