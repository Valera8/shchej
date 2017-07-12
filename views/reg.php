<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="description" content="Упражнения и задачи по PHP и решения">
	<meta name="keywords" content="PHP, blog, блог на PHP, задачи, Русаков, Ляпин, курсы, html5, css3, адаптив, мобильные устройства">
	<title>Блог начинающего программиста</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/bootstrap-theme.min.css">
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
		<header>
			<a href="index.php"><h1>Блог начинающего программиста</h1></a>
			<form class="form-inline" role="form">
				<div class="form-group">
					<label class="sr-only" for="login">Логин</label>
					<input type="text" class="form-control" id="login" placeholder="Логин">
				</div>
				<div class="form-group">
					<label class="sr-only" for="password">Пароль</label>
					<input type="password" class="form-control" id="password" placeholder="Пароль">
				</div>
				<button type="submit" class="btn btn-success">Войти</button>
			</form>
		</header>
		<h2 class="reg-h2">Регистрация</h2>
		<form class="form-horizontal" role="form" action="reg_user.php" method="post">
			<div class="form-group">
				<label for="surname" class="col-sm-5 control-label">Имя и/или фамилия:</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="surname" name="name" value="<?=$_SESSION['name'];?>" placeholder="Имя">
				</div>
			</div>
			<div class="form-group	<?php if (($_SESSION['error_login'] == 1) ||  ($_SESSION['error_log'] == 1)) echo 'has-error'; ?>">
				<?php	if ($_SESSION['error_login'] == 1) echo '<p class="article-hi">Некорректный логин</p>';
				elseif ($_SESSION['error_log'] == 1) echo '<p class="article-hi">Этот логин уже занят</p>'
				?>
				<label for="login1" class="col-sm-5 control-label">Логин:</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="login1" name="login" value="<?=$_SESSION['login'];?>" placeholder="Логин">
				</div>
			</div>
			<div class="form-group	<?php if (($_SESSION['error_email'] == 1) || ($_SESSION['error_mail'] == 1)) echo 'has-error'; ?>">
				<?php if ($_SESSION['error_email'] == 1) echo '<p class="article-hi">Некорректный email</p>';
				elseif ($_SESSION['error_mail'] == 1) echo '<p class="article-hi">Этот email уже существует</p>';
				?>
				<label for="email" class="col-sm-5 control-label">Email:</label>
				<div class="col-sm-7">
					<input type="email" class="form-control" id="email" name="email" value="<?=$_SESSION['email'];?>" placeholder="Email">
				</div>
			</div>
			<div class="form-group <?php if ($_SESSION['error_password'] == 1) echo 'has-error'; ?>">
				<?php if ($_SESSION['error_password'] == 1) echo '<p class="article-hi">Некорректный пароль</p>'; ?>
				<label for="password1" class="col-sm-5 control-label">Пароль:</label>
				<div class="col-sm-7">
					<input type="password" class="form-control" id="password1" name="password" placeholder="Пароль">
				</div>
			</div>
			<div class="form-group <?php if ($_SESSION['error_pass2'] == 1) echo 'has-error'; ?>">
				<?php if ($_SESSION['error_pass2'] == 1) echo '<p class="article-hi">Пароли не совпадают</p>'; ?>
				<label for="password11" class="col-sm-5 control-label">Подтвердите пароль:</label>
				<div class="col-sm-7">
					<input type="password" class="form-control" id="password11" name="pass2" placeholder="Пароль">
				</div>
			</div>
			<img src="captcha.php" alt="Каптча">
			<div class="form-group">
				<label for="captcha" class="col-sm-5 control-label">Введите код с картинки:</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="captcha" placeholder="Каптча">
				</div>
			</div>
			<button type="submit" class="btn btn-success" name="reg">Регистрация</button>
		</form>
	</div>
</div>
<footer>
	<p>Блог начинающего программиста
		<br>Copyright &copy; 2016 Валерий Егоров. Все права защищены.
	</p>
</footer>
</body>
</html>