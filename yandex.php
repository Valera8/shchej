<?php /*авторизация через Яндекс*/
if (!$_GET['code']) {exit('error code');}
session_start();
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://oauth.yandex.ru/token');
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, 'grant_type=authorization_code&code='.$_GET['code'].'&client_id=000de41cfc364b99a9a646567d4cb04d&client_secret=0acdf88757dd4a209a3ac0b713833ffd');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$token = json_decode(curl_exec($curl), true);
curl_close($curl);
$data = json_decode(file_get_contents('https://login.yandex.ru/info?oauth_token='.$token['access_token']), true);
/*echo '$data["real_name"] = ' . $data["real_name"] . '<br>';
echo '$data["emails"][0] = ' . $data["emails"][0] . '<br>';
echo '$data["login"] = ' . $data["login"] . '<br>';
echo '$data["default_avatar_id"] = ' . $data["default_avatar_id"] . '<br>';
echo '<pre>';
var_dump($data);
echo '</pre>';
*/
$_SESSION["name_ya"] = $data["real_name"];
$_SESSION['login_ya'] = $data["login"];
$_SESSION['email_ya'] = $data["emails"][0];
$_SESSION["avatar_id"] = $data["default_avatar_id"];
$_SESSION["avatar_empty"] = $data["is_avatar_empty"];

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
