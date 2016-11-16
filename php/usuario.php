<?php
namespace AlejoASotelo;

use AlejoASotelo\Table;

class Usuario extends Table{

	protected static $table_name = 'usuarios';
	protected static $instance = null;

	protected static function  getInstance() {
		if (self::$instance == null) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public static function esValido($username, $password) {

		if (empty($username) || empty($password)) {
			return false;			
		}

		$sql = 'SELECT id FROM '.self::$table_name.' WHERE username = \''.$username.'\' AND password = MD5(\''.$password.'\')';

		$rows = self::getDB()->query($sql)->fetchAll();

		return count($rows) > 0 ? true : false;

	}

	public static function getUsuario($username, $password) {

		$rows = self::findBy(array('username', 'password'), array($username, md5($password)));

		return count($rows) > 0 ? (Object) $rows[0] : false;

	}

}