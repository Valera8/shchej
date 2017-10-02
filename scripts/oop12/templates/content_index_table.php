<strong>Таблица</strong> | <a href="index.php?view=list">Список</a>
<table>
    <tr>
        <?php $i = 0;?>
        <?php foreach ($photos as $photo): ?>

            <?php if (($i - 1) % 3 == 2): ?>
                </tr><tr>
            <?php endif; ?>
            <td>
                <a href="photo.php?id=<?= $i ?>">
                    <img src="<?=$modelGalleryIcon->Icon($i)?>" alt="Фото">
                </a>
            </td>
            <?php $i++; ?>

        <?php endforeach ?>
    </tr>
</table>
<br>
<form method="post" enctype="multipart/form-data">
    <p><input type="file" name="file"></p>
    <p><input type="submit" value="Загрузить файл!"></p>
</form>