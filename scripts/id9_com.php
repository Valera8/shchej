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
    </body>
</html>