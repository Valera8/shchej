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
        <!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter45630489 = new Ya.Metrika({ id:45630489, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/45630489" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
    </body>
</html>
