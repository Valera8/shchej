<?php
// отсюда картина страницы блога
//возвращает все статьи
function articles_all($link)
{
//Запрос
	$query = "SELECT * FROM rch_articles ORDER BY id DESC";
	$result = mysqli_query($link, $query);

	if (!$result)
		die(mysqli_error($link));

//Извлечение из БД
	$n = mysqli_num_rows($result);
	$articles = array();

	for ($i = 0; $i < $n; $i++)
	{
		$row = mysqli_fetch_assoc($result);
		$articles[] = $row;
	}
	return $articles;
}
//возвращает одну статью по указанному адресу
function articles_get ($link, $id_article)
{
//Запрос
	$query = sprintf("SELECT * FROM rch_articles WHERE id=%d", (int)$id_article);
	$result = mysqli_query($link, $query);

	if (!$result) die(mysqli_error($link));

	$article = mysqli_fetch_assoc($result);

	return $article;
}
function articles_new ($link, $title, $date, $meta_desc, $meta_key, $content)
{
//Подготовка
	$title = trim($title);
	$content = trim($content);
	$meta_desc = trim($meta_desc);
	$meta_key = trim($meta_key);
//Проверка
	if ($title == '')
		return false;
//Запрос
	$t = "INSERT INTO rch_articles (title, date, meta_desc, meta_key, content) VALUES ('%s', '%s', '%s', '%s', '%s')";

	$query = sprintf($t,
		mysqli_real_escape_string($link, $title),
		mysqli_real_escape_string($link, $date),
		mysqli_real_escape_string($link, $meta_desc),
		mysqli_real_escape_string($link, $meta_key),
		mysqli_real_escape_string($link, $content));

	$result = mysqli_query($link, $query);

	if (!$result)
		die(mysqli_error($link));

	return true;
}
function articles_edit ($link, $id, $title, $date, $meta_desc, $meta_key, $content)
{
// 	Подготовка
	$title = trim($title);
	$meta_desc = trim($meta_desc);
	$meta_key = trim($meta_key);
	$content = trim($content);
	$date = trim($date);
	$id = (int)$id;

//	Проверка
	if ($title == '')
	{
		return false;
	}

//	Запрос
	$sql = "UPDATE rch_articles SET title='%s', meta_desc='%s', meta_key='%s', content='%s', date='%s' WHERE  id='%s'";

	$query = sprintf($sql,
		mysqli_real_escape_string($link, $title),
		mysqli_real_escape_string($link, $meta_desc),
		mysqli_real_escape_string($link, $meta_key),
		mysqli_real_escape_string($link, $content),
		mysqli_real_escape_string($link, $date),
		$id);

	$result = mysqli_query($link, $query);
	if (!$result)
	{
		die(mysqli_error($link));
	}
	return mysqli_affected_rows($link);
}
function articles_delete($link, $id)
{
	$id = (int)$id;
// Проверка
	if ($id == 0)
		return false;

// Запрос
	$query = sprintf("DELETE FROM rch_articles WHERE id='%d'", $id);
	$result = mysqli_query($link, $query);

	if (!$result)
		die(mysqli_error($link));

	return mysqli_affected_rows($link);
}
function articles_intro($text, $len = 300)
{
	return (mb_substr($text, 0, $len,  'UTF-8') . '...');
}
function  reply()
{
	if (!empty($_SESSION["name"]))
	{
		echo (trim ($_SESSION["name"]));
		if (!empty($_SESSION["family"]))
		{
			echo ' ' . (trim ($_SESSION["family"]));
		}
	}
	elseif (!empty ($_SESSION["family"]))
	{
		echo (trim ($_SESSION["family"]));
	}
	else
	{
		echo (trim ($_SESSION["login"]));
	}
}
function  replyYa()
{
	if (!empty($_SESSION["name_ya"]))
	{
		echo ($_SESSION["name_ya"] . '!');
	}
	elseif (!empty ($_SESSION["login_ya"]))
	{
		echo ($_SESSION["login_ya"] . '!');
	}
	if ($_SESSION["avatar_empty"] == false)
	{
		echo '<img src="https://avatars.yandex.net/get-yapic/' . $_SESSION["avatar_id"] . '/islands-50" alt="Аватар из Яндекса">';
	}
}
