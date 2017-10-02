<?php
function replaceSite ($text)
{
    $text = $_POST['text'];
    $reg = "/(http:\/\/|https:\/\/)([a-z]+[-_\.]*[a-z]*.[(ru)(com)(info)(рф)])|([a-z]+[-_\.]*[a-z]*.[(ru)(com)(info)(рф)]\/*[a-z]*.[a-z]*.[a-z]*.\w*)/i";
    return preg_replace ($reg, "<ссылка_удалена>", $text);
}
echo replaceSite($text);
echo "<br />";
$text = $_POST['text'];
$reg = "/(http:\/\/|https:\/\/)([a-z]+[-_\.]*[a-z]*.[(ru)(com)(info)(рф)])|([a-z]+[-_\.]*[a-z]*.[(ru)(com)(info)(рф)]\/*[a-z]*.[a-z]*.[a-z]*.\w*)/i";
preg_match_all ($reg, $text, $matches);
echo "<br />";
print_r ($matches);
echo "<br />";
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
                        Ввести комментарий:
                    </p>
                <p><textarea rows="10" cols="45" name="text"></textarea></p>
                <input type="submit">
        </form>
<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter45630489 = new Ya.Metrika({ id:45630489, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/45630489" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
    </body>
</html>