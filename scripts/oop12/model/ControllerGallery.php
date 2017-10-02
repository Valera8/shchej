<?php
require_once('ModelGallery.php');
class ControllerGallery
{
    private $modelGalleryIcon;
    private $modelGalleryImage;
    public function __construct()
    {
        $this->modelGalleryIcon = new ModelGallery('img_small');
        $this->modelGalleryImage = new ModelGallery('img_big');
    }

    public function AddPhoto()
    {
        /*Загружаем фотографию, если пользователь отправил файл.*/
                if (isset($_FILES['file']))
                {
                    ini_set('max_file_uploads', '3'); /*Установить максимальное количество загружаемых на сервер файлов за один раз*/
            $valid_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            $myfile_name = $_FILES["file"]["name"];
            $file_size = $_FILES["file"]["size"];
            $error_flag = $_FILES["file"]["error"];

            /*Присваиваем идентификатор добавления новой фотографии и
            добавляем фото в директории*/
            $message = $this->modelGalleryImage->Add(1, $valid_extensions);
            // Выводим сообщение если ошибка
            if ($message['error'])
            {
                print("Имя файла на компьютере пользователя: " . $myfile_name . "<br>");
                print("Размер файла: " . $file_size . ' bytes' . "<br>");
                echo $message['error'] . "<br>";
            }
            // Если ошибок не было
            elseif($error_flag == 0)
            {
            /*добавление записей в таблицы больших и уменьшенных фото базы данных*/
                $this->modelGalleryImage->AddImage('big');
                $this->modelGalleryIcon->AddImage('small');
                header('Location: index.php');
                exit();
            }
        }
    }
}
?>