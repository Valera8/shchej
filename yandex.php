<?php /*авторизация через Яндекс*/
if (!$_GET['code']) {exit('error code');}
session_start();
//Инициализируем сеанс
$curl = curl_init();
//Устанавливаем адрес для подключения
curl_setopt($curl, CURLOPT_URL, 'https://oauth.yandex.ru/token');
//Указываем, что мы будем вызывать методом POST
curl_setopt($curl, CURLOPT_POST, 1);
//Передаем параметры методом POST
curl_setopt($curl, CURLOPT_POSTFIELDS, 'grant_type=authorization_code&code='.$_GET['code'].'&client_id=000de41cfc364b99a9a646567d4cb04d&client_secret=0acdf88757dd4a209a3ac0b713833ffd');
//Говорим, что надо возвратить результат
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//Запрещаем проверку сертификата удаленного сервера
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//Декодируем строку JSON в переменную PHP
$token = json_decode(curl_exec($curl), true);
//Закрываем CURL-соединение
curl_close($curl);
//Получаем данные пользователя
$data = json_decode(file_get_contents('https://login.yandex.ru/info?oauth_token='.$token['access_token']), true);
/*echo '$data["real_name"] = ' . $data["real_name"] . '<br>';
echo '$data["emails"][0] = ' . $data["emails"][0] . '<br>';
echo '$data["login"] = ' . $data["login"] . '<br>';
echo '$data["default_avatar_id"] = ' . $data["default_avatar_id"] . '<br>';
echo '<pre>';
var_dump($data);
echo '</pre>';
*/
//Сохраняем их в сессию
$_SESSION["name_ya"] = $data["real_name"];
$_SESSION['login_ya'] = $data["login"];
$_SESSION['email_ya'] = $data["emails"][0];
$_SESSION["avatar_id"] = $data["default_avatar_id"];
$_SESSION["avatar_empty"] = $data["is_avatar_empty"]; /*Про аватар https://snipp.ru/php/oauth-yandex*/
//Редирект на последнюю страницу
if(isset($_GET['state']))
{
    $link = 'http://' . $_SESSION['ya'] . '#newComment';
}
else $link = 'http://' . $_SESSION['ya'];

header("Location: $link");
exit();
//echo 'X' . $link;
//$manage = new Manage($db);
//$manage->redirect($link);
//echo $_SESSION['login_ya'];
//echo $_SESSION["name_ya"];
//http://localhost/
