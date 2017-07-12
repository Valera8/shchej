<? if (checkUser ($_SESSION['login'], $_SESSION['password'])): ?>
<!--запись в приветствие имени или логина-->
	<form class="form-horizontal clearfix">
				<label class="col-sm-4 article-hi">
					Здравствуйте,
	<? if (!empty($_SESSION["name"]))
	{
		echo (trim ($_SESSION["name"]));
	}
	else
	{
		echo (trim ($_SESSION["login"]));
	}
	?>!</label>
				<a class="btn btn-default btn-xs col-sm-1" href="logout.php" title="Выйти">Выйти</a>
			</form>
<? else: ?>
	<? if ($_SESSION['error_aut'] == 1): ?>
		<form class="form-inline">
			<label class="article-hi col-sm-4">Неверные логин и/или пароль!</label>
		</form>
		<? unset ($_SESSION['error_aut']); ?>
	<? endif ?>
	<? require_once "views/formaut.html"; ?>
<? endif ?>