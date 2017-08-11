<?php
$reg = '{^\s*( (\d\d) \s* [[:punct:]] \s*(\d\d)\s* [[:punct:]] \s*(\d\d\d\d))\s*$}xs';
$dat = $_POST['dat'];
$match = preg_match ($reg, "$dat", $pockets);
$m = $pockets[2];
$d = $pockets[3];
$y = $pockets[4];
$check = (checkdate ($m, $d, $y));
if (empty ($_POST['dat']))
    echo 'Введите дату в формате ММ.ДД.ГГГГ в форму.';
elseif ($match == 0)
    echo 'Введите корректную дату.';
elseif ($check == 0)
    echo 'Введите правильную дату.';
else
    echo "Введена корректная дата: $m.$d.$y";
?>

<!DOCTYPE html>
<html>
    <head>
            <meta charset="utf-8">
            <title>Регулярное выражение</title>
        </head>
    <body>
        <form method="post">
                <p>
                        Ввести дату в формате ММ.ДД.ГГГГ:
                    </p>
                <input type="text" name="dat">
                <input type="submit">
            </form>
    </body>
</html>