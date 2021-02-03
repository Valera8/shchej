<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Упражнения и задачи по PHP и решения. Использование хостинга heroku для Алисы">
	<meta name="keywords" content="PHP, опубликовать, сайт, создать, задача, файл, число, хостинг heroku">
	<title>Блог начинающего программиста</title>
	<link rel="stylesheet" href="/css/bootstrap.css">
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
			<h1 class="header-h">Блог начинающего программиста</h1>
		<!--	Реклама eTXT-->
			<figure class="etxt">
				<a href="https://www.etxt.ru/?r=vgoru" target="_blank" title="Биржа eTXT"><img src="/images/etxt.png" title="Биржа eTXT" alt="eTXT"></a>
			</figure>
			<div>
				<?php
				if ($_SESSION['reg_success'] == 1)
				{
					echo '<p class="article-hi">Успешная регистрация!</p>';
				}
				?>
				<h2 class="main-part">О блоге и обо мне</h2>
				<figure class="col-lg-4 art_fig">
					<img src="/images/programmer.png" alt="Портрет" title="Валерий Егоров">
				</figure>
				<div class="main-text col-lg-8">
					<p>Добро пожаловать на блог начинающего программиста!</p>
					<p>В блоге пока представлен единственный раздел, посвященный языку программирования <strong>PHP</strong>. Hypertext Preprocessor можно перевести как Предварительный Обработчик Гипертекста. В Рунете этот скриптовый язык самый популярный инструмент для разработки веб-приложений. На этом языке построены такие крупнейшие сайты, как BlaBlaCar, Wikipedia, Facebook, Yahoo! Bookmarks.</p>
					<p>В этом разделе блога будут представлены упражнения, задачи на языке программирования PHP и пути их решения, выскажу свое отношение к хостингам Хостия и REG.RU. В нескольких статьях расскажу о моем опыте строительства навыков Алисы для Яндекса. В процессе обучения PHP я выполнял домашние задания. С целью систематизации и для облегчения дальнейшего использования результатов задач, решил их хранить в одном легкодоступном месте, чтобы они были всегда под рукой. Многие упражнения пригодны для дальнейшего использования в сайтостроении, имеют практическое применение. Рассмотрены такие темы: массивы; функция даты и времени; работа с файлами, изображениями; определение цвета точки изображения; как создать файл ini; регулярные выражения; редирект; отправка и получение писем и другие.</p>
					<p>Сам блог мною изготовлен тоже на основе учебного бесплатного курса GeekBrains «PHP. Личный блог».</p>
					<p>Начальные строки всех статей выведены на этой главной странице.</p>
				</div>
				<!--Реклама_Хостия
				<figure class="col-md-12 art_fig">
					<a target="_blank" href="https://hostia.ru/billing/host.php?uid=50943&bid=30"><img src="/images/hostia8.gif" alt="PHP хостинг ХостиЯ"></a>
				</figure>
				-->
				<!--Знак партнёра regru-->
				<figure class="col-md-12 art_fig">
					<a href="https://www.reg.ru?rlink=reflink-1915611" target=_blank title="Партнёр REG.RU">
						<img src="/images/comment/regru.svg" alt="партнёр reg.ru">
					</a>
				</figure>
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
			<?php include ("footer.php"); ?>
	<script src="/js/jquery-1.4.3.min.js"></script>
	<script src="/js/main.js"></script>
</body>
</html>
<link rel="stylesheet" href="/css/bootstrap-theme.min.css">