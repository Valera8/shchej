<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Блог начинающего программиста</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="../css/ocean.css">
	<script src="../js/highlight.pack.js"></script>
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>
<body>
<div class="container">
	<h1>Блог начинающего программиста</h1>
	<div>
		<form method="post" action="index.php?action=<?=$_GET['action']?>&id=<?=$_GET['id']?>">
			<label>
				Название
				<input type="text" name="title" value="<?=$article['title']?>" class="form-item" autofocus required>
			</label>
			<label>
				Дата
				<input type="date" name="date" value="<?=$article['date']?>" class="form-item" autofocus required>
			</label>
			<label>
				Содержимое
				<textarea name="content" class="form-item" required><?=$article['content']?></textarea>
			</label>
			<input type="submit" value="Сохранить " class="btn">
		</form>
	</div>
	<footer>
		<p>Блог начинающего программиста
			<br>Copyright &copy; 2016 Валерий Егоров. Все права защищены.
		</p>
	</footer>
</div>

<script>hljs.initHighlightingOnLoad();</script>
</body>
</html>