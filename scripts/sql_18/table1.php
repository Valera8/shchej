<!DOCTYPE html>
<html>
<head>
    <meta name="description" content="Книги про PHP. Где можно купить. Цена, описание.">
    <meta name="keywords" content="PHP, книги, купить">
    <style>
        table, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }
    </style>
    <title>Книги о PHP</title>
</head>
<body>
    <?php
    /*Домашнее задание 5_10*/
    $mysqli = new mysqli("127.0.0.1", "bloger", "mysql","firstbase");
    $mysqli->query("SET NAMES 'utf8");
    /*Функция для вывода всей таблицы с тегом <table>*/
    function printResultSet($row)
    {
        echo "<table>";
        echo "<tr>" . "<td>" . 'Наименование товара' . "</td>" . "<td>" .   'Свойства товара' . "</td>" .  "<td>" . 'Описание товара' . "</td>" . "<td>" . 'Количество продаж' . "</td>" . "</tr>";
        foreach ($row as $app)
        {
            echo  "<tr>" . "<td>" . '<a href="table2.php?product=' . $app['id'] . '">' . $app['product_name'] . "</a>" . "</td>" . "<td>" .   $app['product_description'] . "</td>" .  "<td>" . $app['full_description'] . "</td>" . "<td>" . $app['number_sales'] . "</td>" . "</tr>";
        }
        echo "</table>";
    }
    /*Выборка из базы данных всех данных из таблицы product*/
    $result_set = $mysqli->query("SELECT * FROM `product`");
    echo printResultSet($result_set);

    $mysqli->close();
    ?>
</body>
</html>
