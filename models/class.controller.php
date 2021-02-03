<?php
defined('_RCHE') or die('Restricted access');

abstract class Controller_Base {
	protected $registry;
	protected $email_ya;
	protected $log_ya;
	protected $avatar_ya;
/*final означает - метод не может быть переопределен в дочерних классах*/
	final function __construct($registry) {
		$this->registry = $registry;
		$this->email_ya = $_SESSION['email_ya'];
		$this->log_ya = $_SESSION["login_ya"];
		$this->avatar_ya = $_SESSION["avatar_id"];
	}

	function getDate ($arg='d m Y H i') {
		$line=explode(' ',$arg);
		$date=array();
		foreach($line as $l):
			$date[$l]=date($l);
		endforeach;
		return $date;
	}
	abstract function index();
}
