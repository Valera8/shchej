<?php
session_start();
$_SESSION['prevPg'] = $_SERVER['HTTP_REFERER'];
include("../config.php");
require_once "reg-aut.php";
require_once ("../models/articles.php");
require_once ("../database.php");
$link = db_connect();
$articles = articles_all($link);
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Регистрация пользователя на сайте щей.рф для комментирования">
	<meta name="keywords" content="имя, фамилия, логин, Email, пароль, регистрация">
	<title>Регистрация на сайте щей.рф</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/bootstrap-theme.min.css">
<!--	<script src="../js/main.js"></script>-->
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
            <li><a href="../article.php?id=<?=$a['id']?>"><?=$a['title']?></a></li>
        <?php endforeach ?>
    </ul>
</nav>
<div class="container">
	<div class="row">
		<header>
			<a class="header-a" href="../index.php"><h1>Блог начинающего программиста</h1></a>
		</header>
		<h2 class="reg-h2">Регистрация</h2>
		<div class="reg-p">
			<strong>Пожалуйста, обязательно заполните поля со знаком</strong><i class="glyphicon glyphicon-asterisk"></i>.
		</div>
		<form class="form-horizontal" role="form" action="reg_user.php" method="post">
			<div class="form-group has-success has-feedback <?php if (($_SESSION['error_login'] == 1) ||  ($_SESSION['error_log'] == 1)) echo 'has-error'; ?>">
				<?php	if ($_SESSION['error_login'] == 1) echo '<p class="article-hi">Некорректный логин</p>';
				elseif ($_SESSION['error_log'] == 1) echo '<p class="article-hi">Этот логин уже занят</p>'
				?>
				<label for="login1" class="col-sm-5 control-label">Логин:</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="login1" name="login" value="<?=$_SESSION['login'];?>" placeholder="Логин"><span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
				</div>
			</div>
			<div class="form-group has-success has-feedback	<?php if (($_SESSION['error_email'] == 1) || ($_SESSION['error_mail'] == 1)) echo 'has-error'; ?>">
				<?php if ($_SESSION['error_email'] == 1) echo '<p class="article-hi">Некорректный email</p>';
				elseif ($_SESSION['error_mail'] == 1) echo '<p class="article-hi">Этот email уже существует</p>';
				?>
				<label for="email" class="col-sm-5 control-label">Email:</label>
				<div class="col-sm-7">
					<input type="email" class="form-control" id="email" name="email" value="<?=$_SESSION['email'];?>" placeholder="Email"><span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
				</div>
			</div>
			<div class="form-group has-success has-feedback <?php if ($_SESSION['error_password'] == 1) echo 'has-error'; ?>">
				<?php if ($_SESSION['error_password'] == 1) echo '<p class="article-hi">Некорректный пароль</p>'; ?>
				<label for="password1" class="col-sm-5 control-label">Пароль:</label>
				<div class="col-sm-7">
					<input type="password" class="form-control" id="password1" name="password" placeholder="Пароль"><span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
				</div>
			</div>
			<div class="form-group has-success has-feedback <?php if ($_SESSION['error_pass2'] == 1) echo 'has-error'; ?>">
				<?php if ($_SESSION['error_pass2'] == 1) echo '<p class="article-hi">Пароли не совпадают</p>'; ?>
				<label for="password11" class="col-sm-5 control-label">Подтвердите пароль:</label>
				<div class="col-sm-7">
					<input type="password" class="form-control" id="password11" name="pass2" placeholder="Пароль"><span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
				</div>
			</div>
			<div class="form-group has-success">
				<label for="surname" class="col-sm-5 control-label">Имя:</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="surname" name="name" value="<?=$_SESSION['name'];?>" placeholder="Имя">
				</div>
			</div>
			<div class="form-group has-success">
				<label for="family" class="col-sm-5 control-label">Фамилия:</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="family" name="family" value="<?=$_SESSION['family'];?>" placeholder="Фамилия">
				</div>
			</div>
			<input type="hidden" name="photo" value="">
			<img src="captcha.php" alt="Каптча">
			<div class="form-group has-success has-feedback <?php if ($_SESSION['error_captcha'] == 1) echo 'has-error'; ?>">
				<?php if ($_SESSION['error_captcha'] == 1) echo '<p class="article-hi">Введён неправильный код с картинки</p>'; ?>
				<label for="captcha" class="col-sm-5 control-label">Введите код с картинки:</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="captcha" name="captcha" placeholder="Каптча"><span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
				</div>
			</div>
			<button type="submit" class="btn btn-success" name="reg">Регистрация</button>
		</form>
	</div>
</div>
<footer>
	<p>Блог начинающего программиста
		<br>&copy; Валерий Егоров, 2016 - <?php echo date("Y"); ?>
	</p>
</footer>
<script src="../js/jquery-1.4.3.min.js"></script>
<script src="../js/main.js"></script>
</body>
</html>