<a href="index.php">Таблица</a> | <strong>Список</strong>
<br>
<?php $i = 0;?>
<?php foreach ($photos as $photo): ?>
    <p>
        <a href="photo.php?id=<?= $i ?>">
            <img src="<?=$modelGalleryIcon->Icon($i)?>" alt="Фото">
        </a>
    </p>
    <?php $i++; ?>
<?php endforeach ?>

<form method="post" enctype="multipart/form-data">
    <p><input type="file" name="file"></p>
    <p><input type="submit" value="Загрузить файл!"></p>
</form>