<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Упражнения и задачи по PHP и решения">
	<meta name="keywords" content="PHP, блог, программист, задачи, курсы, куки, почта, редирект, регулярки, изображения, дата, массивы">
	<title>Блог начинающего программиста</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/bootstrap-theme.min.css">
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
			<h1 class="header-h">Блог начинающего программиста</h1>
		<!--	Реклама eTXT-->
			<figure class="etxt">
				<a href="https://www.etxt.ru/?r=vgoru" target="_blank" title="Биржа eTXT"><img src="../images/etxt.png" title="Биржа eTXT" alt="eTXT"></a>
			</figure>
			<div>
				<?php
				if ($_SESSION['reg_success'] == 1)
				{
					echo '<p class="article-hi">Успешная регистрация!</p>';
				}
				?>
				<h2 class="main-part">О блоге и обо мне</h2>
				<figure class="col-lg-4">
					<p><img src="../images/programmer.png" alt="Портрет" title="Валерий Егоров"><p>
				</figure>
				<div class="main-text col-lg-8">
					<p>Добро пожаловать на блог начинающего программиста!</p>
					<p>В блоге пока представлен единственный раздел, посвященный языку программирования <strong>PHP</strong>. Hypertext Preprocessor можно перевести как Предварительный Обработчик Гипертекста. В Рунете этот скриптовый язык самый популярный инструмент для разработки веб-приложений. На этом языке построены такие крупнейшие сайты, как BlaBlaCar, Wikipedia, Facebook, Yahoo! Bookmarks.</p>
					<p>В этом разделе будут представлены упражнения, задачи на языке программирования PHP и пути их решения. В процессе обучения PHP я выполнял домашние задания. С целью систематизации и для облегчения дальнейшего использования результатов задач, решил их хранить в одном легкодоступном месте, чтобы они были всегда под рукой. Многие упражнения пригодны для дальнейшего использования в сайтостроении, имеют практическое применение. Рассмотрены такие темы: массивы; функция даты и времени; работа с файлами, изображениями; определение цвета точки изображения; как создать файл ini; регулярные выражения; редирект; отправка и получение писем и другие.</p>
					<p>Сам блог мною изготовлен тоже на основе учебного бесплатного курса GeekBrains «PHP. Личный блог».</p>
					<p>Начальные строки всех статей выведены на этой главной странице.</p>
				</div>
				<?php foreach($articles as $a): ?>
				<article>
					<h2>
						<a href="article.php?id=<?=$a['id']?>"><?=$a['title']?></a>
					</h2>
					<em>Опубликовано: <?=$a['date']?></em>
					<p><?=articles_intro($a['content'])?></p>
				</article>
				<?php endforeach ?>
			</div>
		</div>
	</div>
	<footer>
		<p>Блог начинающего программиста
			<br>&copy; Валерий Егоров, 2016 - <?php echo date("Y"); ?>
		</p>
	</footer>
	<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter45630489 = new Ya.Metrika({ id:45630489, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/45630489" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
	<script src="../js/jquery-1.4.3.min.js"></script>
	<script src="../js/main.js"></script>
</body>
</html>