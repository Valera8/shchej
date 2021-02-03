<?php
require_once "/models/reg-aut.php";
require_once ("/models/articles.php");
require_once ("/database.php");
$link = db_connect();
$articles = articles_all($link);
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Запрошенная страница не существует.">
    <meta name="keywords" content="страница не найдена, страница не существует, 404">
    <title>Страница не найдена - 404</title>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>
<body>
    <figure id="circle">ВСЕ СТАТЬИ</figure>
    <nav>
        <ul>
            <?php foreach($articles as $a): ?>
                <li><a href="../article.php?id=<?=$a['id']?>"><?=$a['title']?></a></li>
            <?php endforeach ?>
        </ul>
    </nav>
    <div class="container">
        <a class="header-a" href="../index.php" title="На главную страницу"><h1>Блог начинающего программиста</h1></a>
        <h2 class="e404">Страница не найдена</h2>
        <figure class="e404-fig">
            <img class="e404-img" src="/images/404.gif" alt="Ошибка 404">
            <figcaption>
                <p>К сожалению, запрашиваемая Вами страница не найдена...</p>
                <p>Почему?</p>
                <ol>
                    <li>Ссылка, по которой Вы пытались пройти, неверна.
                    <li>Вы неправильно указали путь или название страницы.
                    <li>Страница была удалёна со времени Вашего последнего посещения.
                </ol>
            </figcaption>
        </figure>
    </div>
    <footer>
        <p><a href="/index.php" title="Вернуться на главную">Блог начинающего программиста</a>
            <br>&copy; Валерий Егоров, 2016 - <?php echo date("Y"); ?>
        </p>
    </footer>
    <script src="/js/jquery-1.4.3.min.js"></script>
    <script src="/js/main.js"></script>
</body>
</html>