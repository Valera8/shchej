<?php
require_once ('Databas.php');
require_once ('../../models/config_class.php');
class ModelGallery
{
    private $db;
    private $config;
    public $dir; //каталог фото
    public function __construct($dir)
    {
        $this->dir = $dir;
        $this->config = new Config();
        $this->db = new DataBas($this->config->host, $this->config->user, $this->config->password, $this->config->db);
    }
//Функция возвращает объект фотографии (ассоциативный массив)
    public function Item($i)
    {
        $photos = $this->Listing(); // Получаем массив фоток
        $photo = $photos[$i];
        return ($photo);
    }
    //Функция возвращает список фотографий
    public function Listing()
    {
        $photos = scandir($this->dir, SCANDIR_SORT_NONE); // Получаем список файлов из этой директории без сортировки
        $photos = $this->Excess($photos); // Удаляем лишние файлы c '.' ...
        return $photos;
    }
    /* Функция для удаления лишних файлов: Текущий каталог и родительский пропускаем, не выводим файлы Thumbs.db */
    private function Excess($files)
    {
        $result = [];
        for ($i = 0; $i < count($files); $i++)
        {
            if ($files[$i] != "." && $files[$i] != ".."  && $files[$i] != "Thumbs.db")
                $result[] = $files[$i];
        }
        return $result;
    }
    //Функция возвращает путь к уменьшенному изображению.
    public function Icon($i)
    {
        $photos = $this->Listing();
        $destination = 'img_small' . '/' . $photos[$i];
        return $destination;
    }
    //Функция возвращает путь к полноразмерному изображению.
    public function Image($i)
    {
        $photo = $this->Item($i);
        $destination = 'img_big' . '/' . $photo;
        return $destination;
    }
    //Функция добавляет в галерею новую фотографию
    public function Add($max_file_size, $valid_extensions)
    {
        setlocale(LC_ALL, 'ru_RU . UTF8');
        $error = null;
        $info  = null;
        $max_file_size *= 1048576;  // перевод размера файла в b
        if ($_FILES['file']['error'] === UPLOAD_ERR_OK)
        {
            // проверяем расширение файла
            $file_extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            if (in_array(strtolower($file_extension), $valid_extensions))
            {
                // проверяем размер файла
                if ($_FILES['file']['size'] < $max_file_size)
                {
                    $myfile_name = $_FILES["file"]["name"];
                    $destination = $this->dir . '/' . $myfile_name;
                    if (!move_uploaded_file($_FILES['file']['tmp_name'], $destination))
                    /*Перемещает загруженный файл в новое место. Файловая система почему-то? сортирует файлы в директории по возрастанию*/
                        $error = 'Не удалось загрузить файл';
                }
                else
                    $error = 'Размер файла больше допустимого 1 Mb';
            }
            else
                $error = 'У файла недопустимое расширение';
        }
        else
        {
            // массив ошибок
            $error_values = [

                UPLOAD_ERR_INI_SIZE   => 'Размер файла больше разрешенного директивой upload_max_filesize в php.ini',
                UPLOAD_ERR_FORM_SIZE  => 'Размер файла превышает указанное значение в MAX_FILE_SIZE',
                UPLOAD_ERR_PARTIAL    => 'Файл был загружен только частично',
                UPLOAD_ERR_NO_FILE    => 'Не был выбран файл для загрузки',
                UPLOAD_ERR_NO_TMP_DIR => 'Не найдена папка для временных файлов',
                UPLOAD_ERR_CANT_WRITE => 'Ошибка записи файла на диск'

            ];

            $error_code = $_FILES['file']['error'];

            if (!empty($error_values[$error_code]))
                $error = $error_values[$error_code];
            else
                $error = 'Случилось что-то непонятное';
        }
        /* чтобы изменить размеры фото необходимо запустить функцию img_resize с нужными параметрами ширины и высоты нового изображения. Если нужен только один параметр, например ширина 200px, то высоту задаем равную 0 (ноль). При этом получим пропорциональное фото с шириной 200px.*/
        $dest = 'img_small/' . $myfile_name;
        $src = $destination;

        $this->ImgResize($src, $dest, 200,0);

        return ['info' => $info, 'error' => $error, 'destination'=>$destination];
    }
    /*
    Функция уменьшения размера фотографии.
    Параметры:
    $src             - имя исходного файла
    $dest            - имя генерируемого файла
    $width, $height  - ширина и высота генерируемого изображения, в пикселях
    Необязательные параметры:
    $rgb             - цвет фона, по умолчанию - белый
    $quality         - качество генерируемого JPEG, по умолчанию - максимальное (100)
    */
    private function ImgResize($src, $dest, $width, $height, $rgb = 0xFFFFFF, $quality = 100)
    {
        if (!file_exists($src)) // Проверить наличие указанного файла или каталога.
            return false;
        $size = getimagesize($src);

        if ($size === false)
            return false;
        $format = strtolower(substr($size['mime'], strpos($size['mime'], '/') + 1));
        $icfunc = 'imagecreatefrom' . $format;

        if (!function_exists($icfunc))
            return false;

        $x_ratio = $width  / $size[0];
        $y_ratio = $height / $size[1];

        if ($height == 0)
        {
            $y_ratio = $x_ratio;
            $height  = $y_ratio * $size[1];
        }
        elseif ($width == 0)
        {
            $x_ratio = $y_ratio;
            $width   = $x_ratio * $size[0];
        }

        $ratio       = min($x_ratio, $y_ratio);
        $use_x_ratio = ($x_ratio == $ratio);

        $new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
        $new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
        $new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width)   / 2);
        $new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);

        // если не нужно увеличивать маленькую картинку до указанного размера
        if ($size[0]<$new_width && $size[1]<$new_height)
        {
            $width = $new_width = $size[0];
            $height = $new_height = $size[1];
        }

        $isrc  = $icfunc($src);
        $idest = imagecreatetruecolor($width, $height);

        imagefill($idest, 0, 0, $rgb);
        imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0, $new_width, $new_height, $size[0], $size[1]);

        $i = strrpos($dest,'.');
        if (!$i) return '';
        $l = strlen($dest) - $i;
        $ext = substr($dest,$i+1,$l);

        switch ($ext)
        {
            case 'jpeg':
            case 'jpg':
                imagejpeg($idest,$dest,$quality);
                break;
            case 'gif':
                imagegif($idest,$dest);
                break;
            case 'png':
                imagepng($idest,$dest);
                break;
        }
        imagedestroy($isrc);
        imagedestroy($idest);
        return true;
    }
    /*Добавить запись в базу данных в таблицу больших или уменьшенных фото*/
    public function AddImage($table_name)
    {
        $myfile_name = $_FILES["file"]["name"];
        $file_type = substr($myfile_name, strrpos($myfile_name, '.')+1);
        $destination = $this->dir . '/' . $myfile_name;
        //Добавление записи в базу данных тип файла и временное имя файла на нашем сервере (во время запроса)
        $sql = "INSERT INTO $table_name (typ, address, myfile_name) VALUES ('$file_type', '$destination', '$myfile_name')";
        $this->db->Execute($sql);
    }
}
?>