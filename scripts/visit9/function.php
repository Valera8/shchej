<?php
/**
 * Функция загрузки файла (аплоадер)
 * @param  int    $max_file_size    максимальный размер файла в мегабайтах
 * @param  array  $valid_extensions массив допустимых расширений
 * @param  string $upload_dir       директория загрузки
 * @return array                    сообщение о ходе выполнения
 */
/* В php скрипте реализованы две проверки:
так как хостер ограничивает размер загружаемого файла (на момент написания данного материала у меня на хостинге стоит ограничение в 8 Mb), то проверка максимального размера необходима;
проверка расширения файла позволяет отсеять ненужные файлы до загрузки.
URL фотографии - $destination.  return $destination  А далее вставляете URL фото куда вам надо */
function upload($max_file_size, $valid_extensions, $upload_dir)
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
                $file_name = time() . $_FILES['file']['name'];  // к имени файла добавляем метку времени, чтобы исключить одинаковые имена
                $destination = $upload_dir .'/' . $file_name;

                if (move_uploaded_file($_FILES['file']['tmp_name'], $destination))//Перемещает загруженный файл в новое место.
                    $info = 'Файл успешно загружен';
                else
                    $error = 'Не удалось загрузить файл';
            }
            else
                $error = 'Размер файла больше допустимого';
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

    return ['info' => $info, 'error' => $error, 'destination'=>$destination];
}

/*
Функция img_resize(): генерация thumbnails
Параметры:
$src             - имя исходного файла
$dest            - имя генерируемого файла
$width, $height  - ширина и высота генерируемого изображения, в пикселях
Необязательные параметры:
$rgb             - цвет фона, по умолчанию - белый
$quality         - качество генерируемого JPEG, по умолчанию - максимальное (100)
*/

function img_resize($src, $dest, $width, $height, $rgb = 0xFFFFFF, $quality = 100)
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
/* Функция для удаления лишних файлов: Текущий каталог и родительский пропускаем, не выводим файлы Thumbs.db */
function excess($files)
{
    $result = [];
    for ($i = 0; $i < count($files); $i++)
    {
        if ($files[$i] != "." && $files[$i] != ".."  && $files[$i] != "Thumbs.db")
            $result[] = $files[$i];
    }
    return $result;
}
?>