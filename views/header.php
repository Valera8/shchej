<!--	Этот файл работает только при регистрации   -->
<header>
	<a class="header-a" href="../index.php"><h1>Блог начинающего программиста</h1></a>
	<? if ($_SESSION['reg_success'] == 1): ?>
<!--запись в приветствие имени или логина-->
		<form class="form-horizontal clearfix" action="../models/reg-fun.php">
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
	<? else:
	{
		require_once "user_panel.php";
	}
	?>
	<? endif ?>
</header>