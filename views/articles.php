<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="description" content="Упражнения и задачи по PHP и решения">
	<meta name="keywords" content="PHP, blog, блог на PHP, задачи, Русаков, Ляпин, курсы, html5, css3, адаптив, мобильные устройства">
	<title>Блог начинающего программиста</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/bootstrap-theme.min.css">
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
<!-- /Yandex.Metrika counter -->
<div class="container">
	<h1>Блог начинающего программиста</h1>
<!--	<a href="admin">Панель Администратора</a>-->
<!--	Реклама eTXT-->
	<figure class="etxt">
		<a href="http://www.etxt.ru/?r=vgoru" target="_blank" title="Биржа eTXT"><img src="../images/etxt.png" title="Биржа eTXT" alt="eTXT"></a>
	</figure>
	<div>
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
<footer>
	<p>Блог начинающего программиста
		<br>Copyright &copy; 2016 Валерий Егоров. Все права защищены.
	</p>
</footer>
</body>
</html>