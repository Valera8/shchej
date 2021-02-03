<!DOCTYPE html>
<html>
<head>
    <style>
        table, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }
    </style>
    <title>Заказы</title>
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
        echo "<tr>" . "<td>" . 'Номер товара' . "</td>" . "<td>" .   'Заказчик' . "</td>" .  "<td>" . 'e-mail' . "</td>" . "<td>" . 'Комментарий' . "</td>" . "<td>" . 'Дата заказа' . "</td>" . "</tr>";
        foreach ($row as $app)
        {
            echo  "<tr>" . "<td>" . $app['id_product'] . "</td>" . "<td>" .   $app['client'] . "</td>" .  "<td>" . $app['e-mail'] . "</td>" . "<td>" . $app['comment'] . "</td>" . "<td>" . date('d.m.Y', $app['date_ordering']) . "</td>" . "</tr>";
        }
        echo "</table>";
    }
    /*Выборка из базы данных всех данных из таблицы ordering*/
    $result_set = $mysqli->query("SELECT * FROM `ordering`");
    $product = $_GET['product'];
    /*Выборка из базы данных только тех заказов, которые соответствуют выбранному товару из таблицы product.
    */
    $result_id = $mysqli->query("SELECT * FROM `ordering` WHERE `id_product`=$product");
    if ($product)
    {
        echo printResultSet($result_id);
    }
    else
    {
        echo printResultSet($result_set);
    }

    $mysqli->close();
    ?>
</body>
</html>
