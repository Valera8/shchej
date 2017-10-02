<?php
include("config.php");
require_once "models/reg-aut.php";
require_once ("models/articles.php");
$link = db_connect();
//создание переменной
$articles = articles_all($link);
session_start();
?>
<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?=$article['meta_desc']?>">
	<meta name="keywords" content="<?=$article['meta_key']?>">
	<title><?=$article['title']?></title>
	<link rel="stylesheet" href="../css/rcheComment.css">
	<link rel="stylesheet" href="../css/tinymce_content.css"> <!--загрузка стилей внутри textarea-->
<!--end -->
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="../css/ocean.css">
	<script src="../js/highlight.pack.js"></script>
    <script src="../js/jquery-1.4.3.min.js"></script>
	<script src="../js/main.js"></script>
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
	<figure id="circle">ВСЕ СТАТЬИ</figure>
	<nav>
		<ul>
			<?php foreach($articles as $a): ?>
				<li><a href="article.php?id=<?=$a['id']?>"><?=$a['title']?></a></li>
			<?php endforeach ?>
		</ul>
	</nav>
	<div class="container">
		<div class="row">
			<header>
				<a class="header-a" href="../index.php" title="На главную страницу">Блог начинающего программиста</a>
				<?php if ($_SESSION['reg_success'] == 1): ?> <!--работает только при регистрации-->
<!--запись в приветствие имени или логина-->
					<form class="form-horizontal clearfix">
						<label class="col-sm-4 article-hi">
							Здравствуйте,
							<?php if (!empty($_SESSION["name"]))
							{
								echo (trim ($_SESSION["name"]));
								if (!empty($_SESSION["family"]))
								{
									echo ' ' . (trim ($_SESSION["family"]));
								}
							}
							elseif (!empty ($_SESSION["family"]))
							{
								echo (trim ($_SESSION["family"]));
							}
							else
							{
								echo (trim ($_SESSION["login"]));
							}
							?>!</label>
						<a class="btn btn-default btn-xs col-sm-1" href="../logout.php" title="Выйти">Выйти</a>
					</form>
				<?php else:
					if (checkUser ($_SESSION['login'], $_SESSION['password'])): ?>
<!--запись в приветствие имени или логина-->
						<form class="form-horizontal clearfix">
							<label class="col-sm-4 article-hi">
								Здравствуйте,
								<?php if (!empty($_SESSION["name"]))
								{
									echo (trim ($_SESSION["name"]));
									if (!empty($_SESSION["family"]))
									{
										echo ' ' . (trim ($_SESSION["family"]));
									}
								}
								elseif (!empty ($_SESSION["family"]))
								{
									echo (trim ($_SESSION["family"]));
								}
								else
								{
									echo (trim ($_SESSION["login"]));
								}
								?>!
							</label>
							<a class="btn btn-default btn-xs col-sm-1" href="../logout.php" title="Выйти">Выйти</a>
						</form>
					<?php else: ?>
						<?php if ($_SESSION['error_aut'] == 1): ?>
							<form class="form-inline">
								<label class="article-hi col-sm-4">Неверные логин и/или пароль!</label>
							</form>
							<? unset ($_SESSION['error_aut']); ?>
						<? endif ?>
						<form class="form-inline" action="../login.php" method="post">
							<div class="form-group">
								<label class="sr-only" for="login">Логин</label>
								<input type="text" class="form-control" id="login" name="login" placeholder="Логин">
							</div>
							<div class="form-group">
								<label class="sr-only" for="password">Пароль</label>
								<input type="password" class="form-control" id="password" name="password" placeholder="Пароль">
							</div>
							<button type="submit" class="btn btn-success">Войти</button>
							<a class="header-link" href="../models/reg_user.php">Регистрация</a>
						</form>
					<?php endif	?>
				<?php endif ?>
			</header>
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
					<img class="rusakov-img1" src="../images/rusakov-cheap.png" alt="PHP и MySQL с Нуля до Гуру">
				</div>
				<div  class="rusakov-info col-sm-8">
					<p>Хочешь стать профи PHP и MySQL?</p>
					<p class="rusakov-info-2">"Более 20-ти часов видеоуроков..."</p>
					<p><a href="https://srs.myrusakov.ru/php?ref=ktcybr2448" target="_blank">Получить видеоуроки</a>
					</p>
				</div>
			</div>
			<div class="rusakov col-md-6 clearfix">
				<div class="col-sm-4">
					<img class="rusakov-img" src="../images/rusakov-free.png" alt="Бесплатный курс по основам PHP">
				</div>
				<div class="rusakov-info col-sm-8">
					<p>Бесплатный Видеокурс по PHP!</p>
					<p class="rusakov-info-2">Пример создания PHP-сайта!</p>
					<p><a href="https://srs.myrusakov.ru/freephp?ref=ktcybr2448" target="_blank">Подробнее</a>
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
	</div>
	<footer>
		<p>Блог начинающего программиста
			<br>&copy; Валерий Егоров, 2016 - <?php echo date("Y"); ?>
		</p>
	</footer>
	<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter45630489 = new Ya.Metrika({ id:45630489, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/45630489" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
	<script>hljs.initHighlightingOnLoad();</script>
	<!-- Подключение комментов-->
	<!-- Load TinyMCE -->
	<script src="../js/tiny_mce/jquery.tinymce.js"></script>
	<script src="../js/rcheComment.js"></script>
</body>
</html>