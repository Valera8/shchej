<?php
$reg = "/^\w+([-_\.])*\w+?@\w+([-_.])*\w+\.\w{2,4}$/";
$dat = $_POST['dat'];
$match = preg_match ($reg, "$dat");
if (empty ($_POST['dat']))
{
    echo 'Введите e-mail в форму.';
}
elseif ($match == 0)
{
    echo "Введен неправильный e-mail: $dat";
}
else
{
    echo "Введен корректный e-mail: $dat";
}
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
                        Ввести e-mail:
                    </p>
                <input type="text" name="dat">
                <input type="submit">
            </form>
    </body>
</html> 