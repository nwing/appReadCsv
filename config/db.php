<?php
/**
 * Devuelve la conexión a la base de datos
  * @var PDO $db
 */
class db{
	private $connection;

	public function __construct() {
		$this->connection = new PDO('sqlite:database.sqlite') or die('Unable to open database');
		$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		// --> Creacion de la base de datos
		$this->_createUserTable();
	}

	public function get_connection() {
		return $this->connection;
	}


	private function _createUserTable(){
		$this->connection->exec("DROP TABLE IF EXISTS t_users");

		$this->connection->exec("
			CREATE TABLE t_users (
				id INTEGER PRIMARY KEY AUTOINCREMENT,
				first_name TEXT,
				last_name TEXT,
				address TEXT,
				telephone VARCHAR(10),
				cellphone VARCHAR(10),
				avatar TEXT
			)
		");
	}


}