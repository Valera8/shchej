<?php
//phpinfo();
//$v = "-1kj";
//if (((int)$v) > 0) {
//    echo "Целое положительное";
//}
//else echo "none";
//
var_dump($_GET);
echo "<br>";
var_dump($_SERVER['HTTP_HOST']);
echo "<br>";
var_dump($_SERVER['REQUEST_URI']);
echo "<br>";
$value = $_GET['shchej'];
if ((preg_match('/^\+?\d+$/', $value)) == true) {
    //if ()
    echo "Целое положительное число :- $value)";
}
else echo "$value: none";
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<figure class="col-lg-4">
    <p><img src="../images/programmer.png" alt="Портрет" title="Валерий Егоров"><p>
</figure>

<table class="lyapin">
    <tr>
        <td>
            <a href="https://www.ozon.ru/context/detail/id/8465472/?partner=php_blog&from=bar" title="Книга «PHP — это просто. Начинаем с видеоуроков (+ CD-ROM)» Дмитрий Ляпин, Александр Никитин - купить на OZON.ru книгу с быстрой доставкой | 978-5-9775-0678-6" target="_blank">
                <figure>
                    <img src="../images/ozon.jpg" alt="Книга «PHP — это просто. Начинаем с видеоуроков (+ CD-ROM)» Дмитрий Ляпин, Александр Никитин - купить на OZON.ru книгу с быстрой доставкой | 978-5-9775-0678-6">
                </figure>
            </a>
        </td>
        <td class="lyapin-right">
            <a title="Книга «PHP — это просто. Начинаем с видеоуроков (+ CD-ROM)» Дмитрий Ляпин, Александр Никитин - купить на OZON.ru книгу с быстрой доставкой | 978-5-9775-0678-6" href="https://www.ozon.ru/context/detail/id/8465472/?partner=php_blog&from=bar" target="_blank">Книга «PHP — это просто. Начинаем с видеоуроков (+ CD-ROM)» Дмитрий Ляпин, Александр Никитин - купить на OZON.ru книгу с быстрой доставкой | 978-5-9775-0678-6
            </a>
        </td>
    </tr>
</table>
<a href="http://shchej/article.php?id=14"><h3>Рекурсия</h3></a>
<a href="https://xn--e1ai0c.xn--p1ai/article.php?id=13">ия</a>
<a href="scripts\visit9\index.php" target="_blank"></a>
<a href="//article.php?id=4#files"></a>
<section></section>
<figure class="col-md-6">
    <a href="images\cycle_cities_big.jpeg" title="увеличенное изображение">
        <img src="images\cycle_cities_small.jpeg" alt="Циклы городов" title="Каталоги и файлы сайта">
    </a>
    <figcaption>Блок-схема циклов вывода всех городов и областей</figcaption>
</figure>
<a href="images\cycle_cities_big.jpeg" title="увеличенное изображение"><img src="images\cycle_cities_small.jpeg" alt="Циклы городов"></a>
</body>
</html>

