<?php
$size = $_GET['size'];
setcookie("size", $size);
$size = (isset ($_COOKIE['size'])) ? $_COOKIE['size'] : $_GET['size'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Style</title>
        <style type="text/css">
            body {
                font-size: <?=$size?>%;
            }
        </style>
    </head>
    <body>
        <a href="id11_cook.php?size=200">Крупный шрифт</a>
        <br>
        <a href="id11_cook.php?size=100">Средний шрифт</a>
        <br>
        <a href="id11_cook.php?size=50">Мелкий шрифт</a>
        <p>
            Lorem ipsum ljlj dolor fmtn, amet consectetur adihisicing elit.
        </p>
    </body>
</html>
