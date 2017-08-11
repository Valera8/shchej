/*
 *
 *    Скрипт комментариев.
 *    Версия: 1.0 (beta)
 *    Дата: 10.02.2012
 *    Автор: Чернышов Роман
 *    Сайт: https://rche.ru/835_kommentarii-na-php-ajax-mysql.html
 *    Эл.почта: houseprog@ya.ru
 *
 */


Установка:

1. Создайте таблицы в БД, импортировав в неё install.sql
2. Настройте подключение к БД в файле config.php
3. Вставте на страницу где требуется выводить комментарии след. код:


	<?php
	// в самом начале php скрипта
	include("config.php");
	?>

	<?php
	// где требуется выводить комментарии
	$comments->outComments();
	?>


Для администрирования коммантариев добавте в URL адрес, переменную pass=12345 (пароль задается в config.php)
Примеры:
	http://example.com/comments.php?pass=12345
	http://example.com/components/articles/?pass=12345
	http://example.com/?pass=12345

-----------------------Далее мои записи--------------------------------------------------------------------
Для замены тегов, которые неправильно форматируются в <pre> я использовал &lt; &gt;.
Вот копии:
<pre><code>

</code></pre>
<!--2. Дата и время-------------------------------------->
&lt;html&gt;
&lt;head&gt;
&lt;/head&gt;
&lt;body&gt;
&lt;form action="index.php" method="post"&gt;
  &lt;p&gt;число:
    &lt;select name="d"&gt;
      &lt;?php
                if (isset($_POST[d]))
                    echo "&lt;option&gt;$d&lt;option&gt;";
      else
      {
      echo "&lt;option&gt;";
      echo date ("d");
      echo "&lt;option&gt;";
      }
      for ($i = 1; $i < 32; $i++)
      {
      if ($i < 10)
      $i = "0" . $i;
      echo "&lt;option&gt;$i &lt;br /&gt;&lt;/option&gt;";
      }
      ?&gt;
    &lt;/select&gt;
    месяц:
    &lt;select name="m"&gt;
      &lt;?php
                if (isset($_POST[m]))
                {
                    $m = ($_POST[m]);
                    echo "&lt;option&gt;$m&lt;option&gt;";
      }
      else
      {
      echo "&lt;option&gt;";
      $month = date ("m");
      switch ($month)
      {
      case 01: $month = "январь"; break;
      case 02: $month = "февраль"; break;
      case 03: $month = "март"; break;
      case 04: $month = 'апрель'; break;
      case 05: $month = "май";    break;
      case 06: $month = "июнь";    break;
      case 07: $month = "июль";    break;
      case 08: $month = "август";    break;
      case 09: $month = "сентябрь";    break;
      case 10: $month = "октябрь";    break;
      case 11: $month = "ноябрь";    break;
      case 12: $month = "декабрь";    break;
      }
      echo $month;
      echo "&lt;option&gt;";
      }
      $m = array (1 => январь, 2 => февраль, 3 =>март, 4 => апрель, 5 => май, 6 => июнь, 7 => июль, 8 => август, 9 => сентябрь, 10 => октябрь, 11 => ноябрь, 12 => декабрь);
      foreach ($m as $key => $value)
      {
      echo "&lt;option&gt;$value &lt;br /&gt;&lt;/option&gt;";
      }
      ?&gt;
    &lt;/select&gt;
    год:
    &lt;select name="y"&gt;
      &lt;?php
                if (isset($_POST[y]))
                    echo "&lt;option&gt;$y&lt;option&gt;";
      else
      {
      echo "&lt;option&gt;";
      echo date ("Y");
      echo "&lt;option&gt;";
      }
      for ($i = 1900; $i <= (date ("Y")); $i++)
      {
      echo "&lt;option&gt;$i &lt;br /&gt;&lt;/option&gt;";
      }
      ?&gt;
    &lt;/select&gt;
  &lt;/p&gt;
  &lt;p&gt;
    &lt;input type="submit" value="Отправить"&gt;
  &lt;/p&gt;
&lt;/form&gt;
&lt;/body&gt;
&lt;/html&gt;

<!--3. Работа с файлами------------------------------------->
&lt;?php
    $fil = fopen ("com.txt", "a+t");
    if (isset ($_POST[name]) && isset ($_POST[comment]))
    {
        fwrite ($fil, $_POST[name] . "\n");
        fwrite ($fil, $_POST[comment] . "\n");
    }
    fclose ($fil);
    $lines = file ('com.txt');
?&gt;
&lt;!DOCTYPE HTML&gt;
&lt;html&gt;
&lt;head&gt;
  &lt;meta charset="utf-8"&gt;
&lt;/head&gt;
&lt;body&gt;
&lt;form method="post"&gt;
  Имя:
  &lt;input type="text" name="name"&gt;
  Комментарий:
        &lt;textarea name="comment"&gt;
        &lt;/textarea&gt;
  &lt;input type="submit"&gt;
&lt;/form&gt;
&lt;table border="1"&gt;
  &lt;tr&gt;
    &lt;td&gt;Имя&lt;/td&gt;
    &lt;td&gt;Комментарий&lt;/td&gt;
  &lt;/tr&gt;
  &lt;?php
            if (isset ($_POST[name]) && isset ($_POST[comment]))
            {
                $n = count ($lines);
                for ($i = 0; $i < $n; $i +=2)
                {
                    echo '<tr>';
  echo '&lt;td&gt;' . $lines[$i + 0] . '&lt;/td&gt;';
  echo '&lt;td&gt;' . $lines[$i + 1] . '&lt;/td&gt;';
  echo '&lt;/tr&gt;';
  }
  }
  ?>
&lt;/table&gt;
&lt;/body&gt;
&lt;/html&gt;
<!--4. Файл ini-------------------------------->
  &lt;!DOCTYPE HTML&gt;
  &lt;html&gt;
  &lt;head&gt;
    &lt;meta charset="utf-8"&gt;
    &lt;style&gt;
      p {
        &lt;?php
        $array = parse_ini_file ("config.ini");
      foreach($array as $key => $value)
      {
        echo("$key" .  ": " . "$value" . ";");
      }
      ?&gt;
      }
    &lt;/style &gt;
  &lt;/head&gt;
  &lt;body&gt;
  &lt;p&gt;Здравствуй, мир!&lt;/p&gt;
  &lt;/body&gt;
  &lt;/html&gt;

 //_______База данных для OpenServer настройки_________
 //__файл config.php________:
 // Настройки БД
 $settings = array(
   'dbName' => 'blog',
   'dbUser' => 'root',
   'dbPass' => '',
   'dbHost' => 'localhost'
  );
  _______файл .htaccess_______:
  AuthType Basic
  AuthName "Admin Panel"
  AuthUserFile D:\OpenServer\domains\blog\admin\.htpasswd
  Require valid-user
  ________файл database.php______:
  <?php
  define('MYSQL_SERVER', 'localhost'); //mysql.hostinger.ru
  define('MYSQL_USER', 'root');     //u484296424_stoma
  define('MYSQL_PASSWORD', '');       //moisey1958
  define('MYSQL_DB', 'blog');        //u484296424_blog
   //--------Файл .htaccess на сайте http://1a1.96.lt/:--------------
   AuthType Basic
   AuthName "Admin Panel"
   AuthUserFile /home/u484296424/public_html/admin/.htpasswd
   Require valid-user
  //--------Файл config.php на сайте http://1a1.96.lt/:--------------
  // Настройки БД
  $settings = array(
    'dbName' => 'u484296424_blog',
    'dbUser' => 'u484296424_stoma',
    'dbPass' => 'moisey1958',
    'dbHost' => 'mysql.hostinger.ru'
   );

