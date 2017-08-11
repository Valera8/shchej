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
    </body>
</html>