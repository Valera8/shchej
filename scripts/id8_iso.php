<?php
$x = $_POST['x'];
$im = imageCreateTrueColor (190, 50);
$c = imageColorAllocate ($im, 255, 255, 255);
//$x = iconv ("CP1251", "UTF-8", $x); //Преобразует набор символов строки x из кодировки CP1251 в UTF-8.
imageTtfText ($im, 20, 0, 10, 30, $c, "../fonts/verdana.ttf", $x);//Рисование текста на изображении шрифтом TrueType verdana.ttf
header ("Content-type: image/png");
imagePng ($im, "iso.png");
imageDestroy ($im);
header("Location: ".$_SERVER['HTTP_REFERER']); //редирект на предыдущую страницу id8_imo.html
