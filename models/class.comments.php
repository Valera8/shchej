<?php
/*    Скрипт комментариев.
 *    Версия: 1.0 (beta)
 *    Дата: 10.02.2012
 *    Автор: Чернышов Роман
 *    Сайт: https://rche.ru/835_kommentarii-na-php-ajax-mysql.html
 *    Эл.почта: houseprog@ya.ru
 */
require_once ("manage_class.php");
require_once ("database_class.php");
require_once ("config_class.php");
require_once ("mail_class.php");
require_once ("class.controller.php");
class Comments extends Controller_Base {

	public $path	= ''; // path to page on comments
	public $table	= 'comments'; // table comments
	public $prefix	= 'rch_'; // prefix table comments
	public $event	= '';
	public $key	= 'e34d9147f42016a32a9bab982492323547e221ce'; // sicret key e34d9147f42016a32a9bab982492323547e121ce
	//for ajax
	public $login	= false; // login user or email and name
	public $user	= array(); // user info if login
	public $admin	= false; // admin option
	public $gravatar = true; // avatar from gravatar.com
	public $capcha	= true; // enable Capcha
	public $paths	= array(); // path's

function index () {
	$this->event = @$_POST['eventComments'];
	if(@$_GET['eventComments'] == 'del' and @$_GET['noajax'] == 1)
		$this->event = @$_GET['eventComments'];

	if($this->event == 'save') $status = $this->saveComments();
	if($this->event=='del') $status=$this->delComments();
	if($this->event=='edit') $status=$this->editComments();
	if($this->event=='reply') $status=$this->replyComments();
	if($this->event == '') $status = NULL;
	return $status;
}

function delComments() {
	$id	= intval($_POST['id']);
	$passport = $_POST['passport'];
	if($_GET['noajax'] == 1)
	{
	$id	= intval($_GET['id']);
	$passport =$_GET['passport'];
	}
	if($passport==md5($this->key.'admin'))
	{
		$sql="SELECT {$this->prefix}{$this->table}.id, {$this->prefix}{$this->table}.reply FROM {$this->prefix}{$this->table}
		WHERE {$this->prefix}{$this->table}.url='".$this->getUrl()."' ORDER BY {$this->prefix}{$this->table}.id ASC";
		$allComm=$this->registry['DB']->getAll($sql);
		if(count($allComm)>0):
		// subcomments
		foreach($allComm as $item):
			if($item['reply']==0)$sortcomm[$item['id']]=$item;
			if($item['reply']>0)
				{
				if(isset($path[$item['reply']]))
					{
					$str='$sortcomm';
					foreach($path[$item['reply']] as $pitem):
						$rep=$item['reply'];
						$str.="[$pitem][sub]";
					endforeach;
					$str.="[{$item['reply']}][sub]";

					$str.="[{$item['id']}]";
									$str.='=$item;';

					eval($str);

					foreach($path[$item['reply']] as $pitem):
						$path[$item['id']][]=$pitem;
					endforeach;

					$path[$item['id']][]=$item['reply'];
					}
					else
					{
					$sortcomm[$item['reply']]['sub'][$item['id']]=$item;
					$path[$item['id']][]=$item['reply'];
					}
				}
			endforeach;
			endif;

		$this->tree_delComment($sortcomm,$id);

		if($_GET['noajax']==1):
		$url=explode('?',$_SERVER['REQUEST_URI']);
		header('Location: https://'.$_SERVER['HTTP_HOST'].$url[0]);
		else: echo 'OK'; endif;
	}
	if(empty($_GET['noajax'])) exit;
}

function tree_delComment(&$a_tree,&$id=0) {
	if(count($a_tree)>0)
	foreach($a_tree as $sub)
		{
		if($sub['id']<>$id and isset($sub['sub']))$this->tree_delComment($sub['sub'],$id);
		if($sub['id']==$id)
			{
			$sql="DELETE FROM {$this->prefix}{$this->table} WHERE id = '$id' LIMIT 1";
			$this->registry['DB']->execute($sql);
			if (isset($sub['sub'])) $this->tree_delComment_process($sub['sub']);
			}
		}
	}

function tree_delComment_process(&$a_tree) {
	foreach($a_tree as $sub)
	{
		$sql="DELETE FROM {$this->prefix}{$this->table} WHERE id = '{$sub['id']}' LIMIT 1";
		$this->registry['DB']->execute($sql);
		if(isset($sub['sub']))$this->tree_delComment_process($sub['sub']);
	}
}

function replyComments() {
	$replyid = intval($_POST['replyid']);
	$pass_checked = md5($this->user['password'] . $this->key);
	$post_url = htmlspecialchars(trim($_POST['posturlComment']));
	if(strlen($post_url)>50 or strlen($post_url)<10) return;
	$url = $post_url;
	$urlOpen=$this->getUrl(false, 'open');
    $db = new DataBase();
    $manage = new Manage($db);
/*
	if($this->capcha)
	{
		$capcha = '
		<br/>Введите код с картинки: <input type="text" name="capcha" id="Rcapcha" value="" class="inputComment"/><br/>
		<img src="../models/captcha.php" alt="картинка ответ" width="120" height="50"/>
		<br/>';
	}
*/  if($this->log_ya)
	{
		$name_form = $this->log_ya;
		$email_form = $this->email_ya;
	}
	else
	{
		$name_form = $_SESSION["login"];
		$email_form = $manage->getEmail($_SESSION["login"]);
	}
	$form = '
	<form method="post" id="RformComment">
		Имя: <input name="nameComment" id="nameComment" value="' . $name_form . '" type="text" class="inputComment">
		<input name="nameCommentCap" id="RnameCommentCap" value="" type="text">
		Эл. почта: <input name="emailComment" id="emailComment" value="' . $email_form . '" type="text" class="inputComment">

		<input name="replyComment" id="RreplyComment" value="'.$replyid.'" type="hidden">
		<input name="loginComment" id="RloginComment" value="'.intval($this->login).'" type="hidden">
		<input name="posturlComment" id="RposturlComment" value="'.$url.'" type="hidden">
		<input name="personaComment" id="RpersonaComment" value="'.$this->user['userID'].'" type="hidden">
		<input name="checkedComment" id="RcheckedComment" value="'. $pass_checked .'" type="hidden">
		<input name="posturlOpenComment" id="RposturlOpenComment" value="'.$urlOpen.'" type="hidden">
		<input name="eventComments" id="ReventComment" value="save" type="hidden">
		<input name="noAjax" value="1" type="hidden">
		<textarea name="textComment" id="RtextComment" class="textareaComment tinymce"></textarea>
		'.$this->commentCapcha().'
		<input value="Ответить" name="submit" type="submit" class="submitComment btn btn-success"/>
	</form>';
    $_SESSION['replyid'] = $replyid;
	echo $form;
	exit;
	}
/*----------Удалить, редактировать коммент-------------------------------------*/
function itemComments($username,$date,$text,$img,$id,$autor=false, $userid='') {
	$possport=md5($this->key.'admin');
//	if($this->login) 
	$reply = '<a href="javascript://" rel="'.$id.'" class="replyComment" title="Ответить на комментарий: '.$username.'">Ответить</a>';
	//if($autor or $this->admin) $edit=' | <a href="javascript://" rel="'.$id.'" class="editComment" title="Редактировать комметарий">Редактировать</a>';
	if($this->admin)
        $del = ' |
        <a href="?id='.$id.'&passport='.$possport.'&noajax=1&eventComments=del" onclick="return false" rel="'.$id.'" passport="'.$possport.'" class="delComment" title="Удалить комментарий">
        Удалить
        </a>';
/* -- пока ссылки на профили аватарки отключил ----
	if($userid > 0) $uslink = "/com/profile/default/$userid/";
    else $uslink = '#itemComment-' . $id;
-------------*/
	$out = '
	<div class="itemComment" id="itemComment-'.$id.'">
		<div class="avatarComment">
<!--			<a href="'.$uslink.'" title="Смотреть профиль пользователя: '.$username.'">         -->
				<img src="'.$img.'" alt="Аватар пользователя: '.$username.'"/>
<!--            </a>          -->
        </div>
		<div class="panelComment">
			<a class="userComment" href="'.$uslink.'" title="Смотреть профиль пользователя: '.$username.'">'.$username.'</a>
			<span class="dateComment" title="Дата, время комментария">'.$date.'</span>
		</div>
		<div class="bodyComment">
			'.$text.'
		</div>
		<div class="footerComment">
			'. $reply . $edit . $del.'
		</div>
	';
	return $out;
	}

function outComments() {
	echo '
    <div id="rcheComments">
        <h3 class="titleComment">Комментарии</h3>
        <div id="allComment">
        ';
	$sql = "SELECT {$this->prefix}{$this->table}.*, rch_users.photo, rch_users.username, rch_users.userID FROM {$this->prefix}{$this->table}
		LEFT JOIN rch_users ON {$this->prefix}{$this->table}.user =rch_users.userID
		WHERE {$this->prefix}{$this->table} .url='".$this->getUrl()."' ORDER BY {$this->prefix}{$this->table}.id ASC"; /*изменение сортировки - ASC меняем на DESC*/
	$allComm = $this->registry['DB']->getAll($sql);
	if(count($allComm) > 0):
	// subcomments
        foreach($allComm as $item):
            if($item['reply'] == 0) $sortcomm[$item['id']] = $item;
            if($item['reply'] > 0)
            {
                if(isset($path[$item['reply']]))
                {
                    $str = '$sortcomm';
                    foreach($path[$item['reply']] as $pitem):
                        $rep=$item['reply'];
                        $str.="[$pitem][sub]";
                    endforeach;
                    $str .= "[{$item['reply']}][sub]";

                    $str .= "[{$item['id']}]";
					$str .= '=$item;';
                    eval($str);
                    foreach($path[$item['reply']] as $pitem):
                        $path[$item['id']][]=$pitem;
                    endforeach;

                    $path[$item['id']][] = $item['reply'];
                }
				else
				{
					$sortcomm[$item['reply']]['sub'][$item['id']] = $item;
					$path[$item['id']][] = $item['reply'];
				}
            }
		endforeach;
		$this->tree_print($sortcomm);

	else: echo '<p>Пока комментарий нет</p>';
	endif;

	echo '
		</div>
		<div id="messComment"></div>
		<div id="ajaxComment"></div>';
	echo $this->pageComment();
	echo $this->formComment();
}

function tree_print(&$a_tree) {
	foreach($a_tree as $sub)
	{
		$this->outItem($sub);
		if(!empty($sub['sub'])) $this->tree_print($sub['sub']);
		echo "</div>";
	}
}

function outItem($item) {
        $autor = false;
	if(intval($item['user']) == 0)
	{
		if(!empty($item['avatar'])) $img = 'https://avatars.yandex.net/get-yapic/' . $item['avatar'] . '/islands-50';/*yandex*/
		elseif($this->gravatar)
		{
			$lowercase = strtolower(trim($item['email']));
			$image = md5( $lowercase );
			$img = 'https://www.gravatar.com/avatar/' . $image . '?size=50&default=wavatar';

		}
		else $img='images/boy48.gif';
	}
	else
	{
        $img = $item['photo'];
/*------$im = explode('/', $img);
        $img = '/images/' . $item['user'] . '/48/48/1/' . $im['4']; -для аватарки пока не использ--------- */
        $item['name'] = $item['username'];
	}
	if($item['pass'] == $_COOKIE['comment'.$item['id']] and !empty($item['pass']) and ($item['date']+120)>time()) $autor = true;

	echo $this->itemComments(
		$item['name'],
		$this->get_Date($item['date']),
		html_entity_decode($item['comment']),
		$img,
		$item['id'],
		$autor,
		$item['userID']);
}

function saveComments() {
	$name 	= trim(strip_tags($_POST['nameComment']));
	$email 	= trim($_POST['emailComment']);
	$text 	= PHP_slashes(htmlspecialchars(markhtml(trim(rawurldecode($_POST['textComment'])))));
	$post_url = htmlspecialchars(trim($_POST['posturlComment']));
	$urlOpen = htmlspecialchars(trim($_POST['posturlOpenComment']));
	$error	= false;
	$login = intval($_POST['loginComment']); /*получает целочисленное значение переменной*/
	$replyComment = intval($_POST['replyComment']);
	$cap = $_POST['nameCommentCap'];
	$db = new DataBase();
	$manage = new Manage($db);
	$config = new Config();
	$mail = new Mail($config->admemail); // Создаём экземпляр класса почты


	if($this->capcha) {
		if($_SESSION["rand_code"] != $_POST['capcha'])
        {
			echo 'ERR5';
			exit;
        }
	}
	if($login == 1)
	{
		$persona= intval($_POST['personaComment']);
		$checked= htmlspecialchars(trim($_POST['checkedComment']));
		if($persona > 0 and $checked > '')
		{
			$sql="SELECT rch_users.* FROM rch_users
				WHERE rch_users.userID='$persona' LIMIT 1";
			$user = $this->registry['DB']->getAll($sql);
			if(md5($user[0]['password'].$this->key) == $checked)
			{
				$this->login = true;
				$this->user = $user[0];
                if ($_POST['emailComment'] == '' || $_POST['emailComment'] == 'undefined') $email = $this->user['email']; //запись в БД comments
			}
		}
		else
		{
			echo 'ERR4';
			exit;
		}
	}

	if(!$this->login)
	{
		if ($manage->isExistsUser($name))
		{
			$error = true;
			$msg = 6;
		}
		if(strlen($name) < 3)
		{
			$error = true;
			$msg = 1;
		}
		if ($manage->isExistsEmail($email))
		{
			$error = true;
			$msg = 7;
		}
		if(!$this->emailCheck($email) or strlen($name)>100)
		{
			$error = true;
			$msg = 2;
		}
		if ($this->log_ya && !$_SESSION["avatar_empty"]) $img = 'https://avatars.yandex.net/get-yapic/' . $this->avatar_ya . '/islands-50';
		else $img = 'images/boy48.gif';
	}
	else
	{
        $img = $this->user['photo'];
/*------$im = explode('/',$img);
        $img = '/images/'.$this->user['userID'].'/48/48/1/'.$im['4']; -для аватарки пока не использ--*/
		$name = $this->user['username'];
		$user = $this->user['userid'];
	}
	if(strlen($text) == 0){$error = true; $msg = 3;}
	if(strlen($post_url) > 50 or strlen($post_url) < 10){$error = true; $msg = 4;}

	if($error)
	{
		echo 'ERR'.$msg;
		exit;
	}
	$pass = $this->generate_password(8);
	$date = $this->get_Date();
	$time = time();
	if($cap == 'undefined' || $cap == '') // добавил undefined
	{
		$sql = "INSERT INTO {$this->prefix}{$this->table} (`reply`,`user`,`name`,`email`,`comment`,`date`,`url`,`pass`,`urlOpen`,`avatar`)
			VALUE ('$replyComment','{$this->user['userID']}','$name','$email','$text','$time','$post_url','$pass','$urlOpen','$this->avatar_ya')";
		$this->registry['DB']->execute($sql); /*Запускает подготовленный запрос на выполнение*/
	}
	$lastId = $this->registry['DB']->id;
	setcookie('comment'.$lastId,$pass,$time+120,'/');

    if ($sql)
    {
		$mail->setFromName($config->admname); // Устанавливаем имя в обратном адресе
		$mail->send($config->admemail, 'Комментарий на сайте ' . $config->sitename, "Опубликован комментарий/ответ " . $date . " на странице " . $config->address . $urlOpen . "\r\n" . addslashes(strip_tags($_POST['textComment'])));
		if ($replyComment != "0")
		{
            $replyid = $_SESSION['replyid'];
            $email_reply = $manage->getEmailReply($replyid);
            $name_reply = $manage->getNameReply($replyid);
			$mail->send($email_reply, 'Ответ на Ваш комментарий на сайте ' . $config->sitename, "Здравствуйте, " . $name_reply . "!\r\nОпубликован ответ от " . $name . " на Ваш комментарий " . $date . " на странице " . $config->address . $urlOpen . "\r\n" . addslashes(strip_tags($_POST['textComment'])) . "\r\n\r\nС уважением, " . $config->admname . ", сайт " . $config->address . ".");
		}
    }

	if(intval($_POST['noAjax'])<>1):
	echo $this->itemComments(
		$name,
		$date,
		html_entity_decode($text),
		$img,
		$lastId,
		true,
		$user);
		exit;
	endif;
}

function formComment($replyid = 0)
{
	global $user;
	if($this->login)
	{
		$pass_checked = md5($this->user['password'] . $this->key);
	}
	$url = $this->getUrl();
	$urlOpen=$this->getUrl(false, 'open');
	/*if($this->capcha) Закомментировал после добавления метода commentCapcha()
		{
		$capcha = '
		<tr>
			<td class="section-one">Введите код с картинки:<br/>
				<img src="../models/captcha.php" alt="картинка" width="120" height="50"/>
			</td>
			<td class="section-two">
				<input type="text" name="capcha" id="capcha" value="" class="inputComment"/>
			</td>
		</tr>';
		}
	*/
	$form = '<h2 id="newComment">Оставить свой комментарий:</h2>
	<form method="post" id="formComment">
		<input name="addComment" id="addComment" value="1" type="hidden">
		<input name="loginComment" id="loginComment" value="'.intval($this->login).'" type="hidden">
		<input name="posturlComment" id="posturlComment" value="'.$url.'" type="hidden">
		<input name="posturlOpenComment" id="posturlOpenComment" value="'.$urlOpen.'" type="hidden">
		<input name="personaComment" id="personaComment" value="'.@$this->user['userID'].'" type="hidden">
		<input name="checkedComment" id="checkedComment" value="'.@$pass_checked.'" type="hidden">
		<input name="eventComments" id="eventComment" value="save" type="hidden">
		<input name="noAjax" value="1" type="hidden">
		<table id="tableComment">
		'.$this->commentName().'
		<tr>
			<td class="section-one">Текст комментария:</td>
			<td class="section-two">
				<textarea name="textComment" id="textComment" class="textareaComment tinymce"></textarea>
			</td>
		</tr>
		'.$this->commentCapcha().'
		</table>
		<input value="Комментировать" name="submit" type="submit" class="submitComment btn btn-success"/>
	</form>';
	return $form;
	}

private function commentName()
{
	if(!isset($this->log_ya))
	{
		if($this->login) $name = '';
		else $name='
		<p> <!--для хоста адрес без &redirect_uri=http://shchej/yandex.php-->
		<a href="https://oauth.yandex.ru/authorize?response_type=code&client_id=000de41cfc364b99a9a646567d4cb04d&redirect_uri=http://shchej/yandex.php&state=1"><img class="ya" src="/images/login_ya.svg" alt="Кнопка войти через Яндекс"></a>
		<a class="header-link" href="models/reg_user.php">Зарегистрироваться</a>
		</p>
		<tr>
			<td class="section-one">Имя:</td>
			<td class="section-two">
				<input name="nameComment" id="nameComment" value="" type="text" class="inputComment">
				<input name="nameCommentCap" id="nameCommentCap" value="" type="text" class="nameCommentCap">
			</td>
		</tr>
		<tr>
			<td class="section-one">Электронная почта:</td>
			<td class="section-two">
				<input name="emailComment" id="emailComment" value="" type="text" class="inputComment">
			</td>
		</tr>';
	}
	else $name = '
		<tr>
			<td class="section-two">
				<input name="nameComment" id="nameComment" value="' . $this->log_ya . '" type="hidden">
				<input name="nameCommentCap" id="nameCommentCap" value="" type="hidden">
			</td>
		</tr>
		<tr>
			<td class="section-two">
				<input name="emailComment" id="emailComment" value="' . $this->email_ya . '" type="hidden">
			</td>
		</tr>';
	return $name;
}
private function commentCapcha()
{
	if(isset($this->log_ya))
		if($_POST['replyid'])
		{
			$capcha = '<input type="hidden" name="capcha" id="Rcapcha" value="' . $_SESSION["rand_code"] . '" class="inputComment"/>';
		}
		else
		{
			$capcha = '<input type="hidden" name="capcha" id="capcha" value = "' . $_SESSION["rand_code"] . '" class="inputComment"/>';
		}
	elseif($this->capcha && $_POST['replyid'])
	{
		$capcha = '
		<br/>Введите код с картинки: <input type="text" name="capcha" id="Rcapcha" value="" class="inputComment"/><br/>
		<img src="../models/captcha.php" alt="картинка ответ" width="120" height="50"/>
		<br/>';
	}
	elseif($this->capcha)
	{
		$capcha = '
		<tr>
			<td class="section-one">Введите код с картинки:<br/>
				<img src="../models/captcha.php" alt="картинка" width="120" height="50"/>
			</td>
			<td class="section-two">
				<input type="text" name="capcha" id="capcha" value="" class="inputComment"/>
			</td>
		</tr>';
	}
	else $capcha = false;
	return $capcha;
}

function pageComment() {
	 //return $out;
	}

function getUrl($explode=false, $open = '') {
	$url=$_SERVER["REQUEST_URI"];
	if($this->admin==true) {
	   $u=explode('?',$url);
	   $e=explode('&',$u[1]);
	   $i=0;
	   $newQuery = "";
	   foreach($e as $item)
		{
		$i++;
		$data=explode('=',$item);
		if($data[0]=='pass') continue;
		$newQuery.=$item;
		if($i<count($e))$newQuery.='&';
		$newQuery='?'.$newQuery;
		if(substr($newQuery, -1)=='&')$newQuery=substr($newQuery, 0, strlen($newQuery)-1);
		}
	   $url="{$u[0]}{$newQuery}";
	}
	if($explode)
		{
		$url=explode('?',$_SERVER['REQUEST_URI']);
		$url=$url[0];
		}
	if($open=='open')return urlencode($url);
	return md5($url);
}

function emailCheck($email) {
   if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i",trim($email)))
	{
	 	return false;
	}
	else return true;
}

function get_Date($shtamp='') {
		if($shtamp=='')$shtamp=time();
		$MonthNames=array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
		$date 	= date('d',$shtamp).' '.$MonthNames[date('n',$shtamp)-1].' '.date('Y',$shtamp).'г, '.date('H',$shtamp).'ч '.date('i',$shtamp).'мин';
		return $date;
	}

	function generate_password($number)
  {
	$arr = array('a','b','c','d','e','f',
				 'g','h','i','j','k','l',
				 'm','n','o','p','r','s',
				 't','u','v','x','y','z',
				 'A','B','C','D','E','F',
				 'G','H','I','J','K','L',
				 'M','N','O','P','R','S',
				 'T','U','V','X','Y','Z',
				 '1','2','3','4','5','6',
				 '7','8','9','0'); /*,'.',',',
				 '(',')','[',']','!','?',
				 '&','^','%','@','*','$',
				 '<','>','/','|','+','-',
				 '{','}','`','~');*/
	$pass = "";
	for($i = 0; $i < $number; $i++)
	{
	  $index = rand(0, count($arr) - 1);
	  $pass .= $arr[$index];
	}
	return $pass;
  }

}
