<?php
include("config.php");
//require_once "models/reg-aut.php";
require_once ("models/articles.php");
//$link = db_connect();
$db = new DataBase();
$link = $db->mysqli;
//создание переменной
$articles = articles_all($link);
session_start();
$_SESSION['ya'] = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?=$article['meta_desc']?>">
	<meta name="keywords" content="<?=$article['meta_key']?>">
	<title><?=$article['title']?></title>
	<link rel="stylesheet" href="/css/rcheComment.css">
	<link rel="stylesheet" href="/css/tinymce_content.css"> <!--загрузка стилей внутри textarea-->
<!--end -->
	<link rel="stylesheet" href="/css/bootstrap.css">

	<link rel="stylesheet" href="/css/ocean.css">
	<link rel="stylesheet" href="/css/style.css">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
	<figure id="circle">ВСЕ СТАТЬИ</figure>
	<nav class="list">
		<ul>
			<?php foreach($articles as $a): ?>
				<li><a href="article.php?id=<?=$a['id']?>"><?=$a['title']?></a></li>
			<?php endforeach ?>
		</ul>
	</nav>
	<div class="container">
		<div class="row">
			<header>
				<a class="header-a" href="/index.php" title="На главную страницу">Блог начинающего программиста</a>
				<?php if ($_SESSION['reg_success'] == 1): ?> <!--работает только при регистрации-->
<!--запись в приветствие имени или логина-->
						<form class="form-horizontal clearfix">
							<label class="col-sm-4 article-hi">
								Здравствуйте,
								<?php reply(); ?>!
							</label>
							<a class="btn btn-default btn-xs col-sm-1" href="/logout.php" title="Выйти">Выйти</a>
						</form>
				<?php elseif (isset ($_SESSION['name_ya'])): ?>
<!--запись в приветствие имени или логина-->
						<form class="form-horizontal clearfix">
							<label class="col-sm-4 article-hi">
								Здравствуйте,
								<?php replyYa(); ?>
							</label>
							<a class="btn btn-default btn-xs col-sm-1" href="/logout.php" title="Выйти">Выйти</a>
						</form>
				<?php else:
					if ($db->checkUser ($_SESSION['login'], $_SESSION['password'])): ?>
<!--запись в приветствие имени или логина-->
						<form class="form-horizontal clearfix">
							<label class="col-sm-4 article-hi">
								Здравствуйте,
								<?php reply(); ?>!
							</label>
							<a class="btn btn-default btn-xs col-sm-1" href="/logout.php" title="Выйти">Выйти</a>
						</form>
					<?php else: ?>
						<?php if ($_SESSION['error_aut'] == 1): ?>
							<form class="form-inline">
								<label class="article-hi col-sm-4">Неверные логин и/или пароль!</label>
							</form>
							<? unset ($_SESSION['error_aut']); ?>
						<? endif ?>
						<form class="form-inline" action="/login.php" method="post"> <!--для хоста адрес без &redirect_uri=http://shchej/yandex.php-->
							<a href="https://oauth.yandex.ru/authorize?response_type=code&client_id=000de41cfc364b99a9a646567d4cb04d&redirect_uri=http://shchej/yandex.php"><img class="ya" src="/images/login_ya.svg" alt="Кнопка войти через Яндекс"></a>

							<div class="form-group">
								<label class="sr-only" for="login">Логин</label>
								<input type="text" class="form-control" id="login" name="login" placeholder="Логин">
							</div>
							<div class="form-group">
								<label class="sr-only" for="password">Пароль</label>
								<input type="password" class="form-control" id="password" name="password" placeholder="Пароль">
							</div>
							<button type="submit" class="btn btn-success">Войти</button>
							<a class="header-link" href="/models/reg_user.php">Регистрация</a>
						</form>
					<?php endif	?>
				<?php endif ?>
			</header>
<!--Реклама_Хостия
			<figure class="col-md-12 art_fig">
				<a target="_blank" href="https://hostia.ru/billing/host.php?uid=50943&bid=30"><img src="/images/hostia8.gif" alt="PHP хостинг ХостиЯ"></a>
			</figure>
			-->
			<!--Реклама_Русаков-->
			<div class="rusakov-java col-sm-12 clearfix">
				<a href="https://ktcybr2448.programsite.ru/javaproject" target="_blank"><img class="col-sm-5" src="../images/rusakov-java.png" alt="Создание крупного проекта на Java с Нуля"></a>
					<div class="col-sm-7"><p class="rusakov-info">Создание крупного проекта на Java с нуля</p><p class="rusakov-info-2">Посмотри, как с нуля создаётся сложный проект на Java</p>
						<p><a href="https://ktcybr2448.programsite.ru/javaproject" target="_blank">Получить видеоуроки</a></p>
					</div>
			</div>
			<article>
				<h1>
					<?=$article['title']?>
				</h1>
				<em>Опубликовано: <?=$article['date']?></em>
				<div><?=$article['content']?></div>
			</article>
<!--Реклама_Русаков-->
			<div class="rusakov col-md-6 clearfix">
				<div class="col-sm-4">
					<img class="rusakov-img1" src="/images/geek.png" alt="Кипящий чайник с выхлопом клубов пара из носика">
				</div>
				<div  class="rusakov-info col-sm-8">
					<p>Интенсив «Основы программирования»</p>
					<p class="rusakov-info-2">Бесплатный курс по программированию</p>
					<p><a href="https://geekbrains.ru/go/kwSpvt" target="_blank">Начать обучение</a>
					</p>
				</div>
			</div>
			<div class="rusakov col-md-6 clearfix">
				<div class="col-sm-4">
					<img class="rusakov-img" src="/images/rusakov-free.png" alt="Бесплатный курс по основам PHP">
				</div>
				<div class="rusakov-info col-sm-8">
					<p>Бесплатный Видеокурс по PHP!</p>
					<p class="rusakov-info-2">Пример создания PHP-сайта!</p>
					<p><a href="https://ktcybr2448.programsite.ru/freephp" target="_blank">Подробнее</a>
					</p>
				</div>
			</div>
<!--Подключение комментов-->
			<div class="clearfix"></div>
			<div class="tinymce">
				<?php
					$comments->outComments();
				?>
			</div>
		</div>
		<?php include ("footer.php"); ?>
	<script src="/js/highlight.pack.js"></script>
	<script src="/js/jquery-1.4.3.min.js"></script>
	<script src="/js/main.js"></script>
	<script>hljs.initHighlightingOnLoad();</script>
	<!-- Подключение комментов-->
	<!-- Load TinyMCE -->
	<script src="/js/tiny_mce/jquery.tinymce.js"></script>
	<script src="/js/rcheComment.js"></script>
</body>
</html>
<link rel="stylesheet" href="/css/bootstrap-theme.min.css">