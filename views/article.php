<?php
include("config.php");
require_once "models/reg-aut.php";
session_start();
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="description" content="Упражнения и задачи по PHP и решения">
	<meta name="keywords" content="PHP, blog, блог на PHP, задачи, Русаков, Ляпин, курсы, html5, css3, адаптив, мобильные устройства">
	<title>Блог начинающего программиста</title>
	<!-- Подключение комментов------------------------------------->
	<script src="../js/jquery-1.4.3.min.js"></script>
	<!-- Load TinyMCE -->
	<script src="../js/tiny_mce/jquery.tinymce.js"></script>
	<script src="../js/rcheComment.js"></script>
	<link rel="stylesheet" href="../css/rcheComment.css">
	<link rel="stylesheet" href="../css/tinymce_content.css"> <!--загрузка стилей внутри textarea-->
	<!-------------------------------------------------------------->
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="../css/ocean.css">
	<script src="../js/highlight.pack.js"></script>
	<script src="../js/main.js"></script>
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>

<body>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
	(function (d, w, c) {
		(w[c] = w[c] || []).push(function() {
			try {
				w.yaCounter40141050 = new Ya.Metrika({
					id:40141050,
					clickmap:true,
					trackLinks:true,
					accurateTrackBounce:true,
					webvisor:true
				});
			} catch(e) { }
		});

		var n = d.getElementsByTagName("script")[0],
			s = d.createElement("script"),
			f = function () { n.parentNode.insertBefore(s, n); };
		s.type = "text/javascript";
		s.async = true;
		s.src = "https://mc.yandex.ru/metrika/watch.js";

		if (w.opera == "[object Opera]") {
			d.addEventListener("DOMContentLoaded", f, false);
		} else { f(); }
	})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/40141050" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter ------------------->
	<div class="container">
		<div class="row">
			<?php
			include("header.php");
			?>
			<article>
				<h2>
					<?=$article['title']?>
				</h2>
				<em>Опубликовано: <?=$article['date']?></em>
				<p><?=$article['content']?></p>
			</article>
	<!--Реклама_Русаков------------------------------------------------>
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
	<!-- Подключение опроса тут нужен JS
			<div class="clearfix">
				<h3>Отзывы</h3>
				<hr>
				<form action="/php/vote.php" method="get" target="_blank">
					<input type="Hidden" name=id value=1>
					<p>Была ли эта статья полезной?
						<input type="Radio" name=vote value=1 checked>Отлично!
						<input type="Radio" name=vote value=2>Так себе, потянет...
						<input type="Radio" name=vote value=3>Ужасно!!!
						<input type="Submit" value=" Голосовать! ">
					</p>
					<p>
						<a href="/php/vote.php?id=1" target="_blank">Текущие результаты</a>
				</form>
			</div>
	  -->

	 <!------Подключение комментов---------------->
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
			<br>Copyright &copy; 2016 Валерий Егоров. Все права защищены.
		</p>
	</footer>
	<script>hljs.initHighlightingOnLoad();</script>
</body>
</html>