<?php
$mysqli = new mysqli("127.0.0.1", "root", "","firstbase");
$mysqli->query("SET NAMES 'utf8");

if (count($_POST) > 3)
{
    $product_name = ''; $product_description = ''; $full_description = ''; $id_product = ''; $client = ''; $mail = ''; $comment = '';
    if (isset($_POST['product']))
    {
        if (isset($_POST['product_name']))
        {
            $product_name = $_POST['product_name'];
        }
        if (isset($_POST['product_description']))
        {
            $product_description = $_POST['product_description'];
        }
        if (isset($_POST['full_description']))
        {
            $full_description = $_POST['full_description'];
        }
        $insert_product = $mysqli->query("INSERT INTO `product` (`product_name`, `product_description`, `full_description`) VALUES ('$product_name', '$product_description', '$full_description')");
        if ($insert_product == 0)
        {
            $mysqli->close();
            echo 'Ошибка! Данные не переданы в базу данных. Вернитесь обратно и повторите.';
            exit;
        }
    }
    elseif (isset($_POST['ordering']))
    {
        if (isset($_POST['num']))
        {
            $id_product = $_POST['num'];
        }
        if (isset($_POST['client']))
        {
            $client = $_POST['client'];
        }
        if (isset($_POST['mail']))
        {
            $mail = $_POST['mail'];
        }
        if (isset($_POST['comment']))
        {
            $comment = $_POST['comment'];
        }
        $insert_ordering = $mysqli->query("INSERT INTO `ordering` (`id_product`, `client`, `e-mail`, `comment`, `date_ordering`) VALUES ('$id_product', '$client', '$mail', '$comment', '".time()."')");
        if ($insert_ordering == 0)
        {
            $mysqli->close();
            echo 'Ошибка! Данные не переданы в базу данных. Вернитесь обратно и повторите.';
            exit;
        }
    }
}
else
{
    $mysqli->close();
    echo 'Ошибка! Не заполнены поля формы. Вернитесь обратно и повторите.';
    exit;
}
$mysqli->close();
header("Location: {$_SERVER['HTTP_REFERER']}");
exit;
?>


 