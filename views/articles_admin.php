<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Блог начинающего программиста</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="../css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>
<body>
<div class="container">
	<a href="../index.php"><h1>Блог начинающего программиста</h1></a>
	<div>
		<a href="index.php?action=add">Добавить статью</a>
			<table class="table">
				<tr>
					<th>Дата</th>
					<th>Заголовок</th>
					<th></th>
					<th></th>
				</tr>
				<?php foreach($articles as $a): ?>
				<tr>
					<td><?=$a['date']?></td>
					<td><?=$a['title']?></td>
					<td>
						<a href="index.php?action=edit&id=<?=$a['id']?>">Редактировать</a>
					</td>
					<td>
						<a href="index.php?action=delete&id=<?=$a['id']?>">Удалить</a>
					</td>
				</tr>
				<?php endforeach ?>
			</table>
	</div>
</div>
<footer>
	<p>Блог начинающего программиста
		<br>&copy; Валерий Егоров, 2016 - <?php echo date("Y"); ?>
	</p>
</footer>
</body>
</html>