<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Редирект</title>
    </head>
    <body>
        <form action="id10_scrip.php" method="post">
            <p>
                Ввести число 1: <input type="text" name="int1">
                Ввести число 2: <input type="text" name="int2">
                Сумма двух чисел:
                <?php
                    echo $_GET['x'];
                ?>  
            </p>
            <br>
            <p>
                <input type="submit">
            </p>
        </form>
<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter45630489 = new Ya.Metrika({ id:45630489, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/45630489" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->                 
    </body>
</html>