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
<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter45630489 = new Ya.Metrika({ id:45630489, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/45630489" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
    </body>
</html>