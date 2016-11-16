<?php
namespace AlejoASotelo;

class Table {

	protected static $db;
	protected static $table_name;

	public static function getDB() {

		if (self::$db == null) {
			self::$db = new \medoo([
			'database_type' => 'mysql',
			'database_name' => 'tp_laboratorio_4',
			'server' => 'localhost',
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8'
			]);
		}

		return self::$db;

	}

	protected static function insert($data) {

		return self::getDB()->insert(static::$table_name, $data);

	}

	protected static function select($columns = '*', $where = null) {

		return self::getDB()->select(static::$table_name, $columns, $where);

	}

	public static function findBy($key, $value) {

		if (!is_array($key) && !is_array($value)){
			$key = array($key);
			$value = array($value);
		}

		$where = array();

		foreach ($key as $i => $v) {
			$where[] = $v.'='.(is_string($value[$i]) ? '\''.$value[$i].'\'' : $value[$i]);
		}

		$sql = 'SELECT * FROM '.static::$table_name.' WHERE '.implode(' AND ', $where);

		return self::getDB()->query($sql)->fetchAll();

	}

}