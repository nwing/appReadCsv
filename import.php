<?php
/**
 * Antony tasayco cappillo
 * <antony.exe@gmail.com>
 */

require __DIR__.'/config/db.php';

class import{

	private $connection;
	private $fileReg;

	public function __construct() {
		$connection = new db();
		$this->connection = $connection->get_connection();
		$this->getRegFile();
	}

	public function getRegFile(){
		if (($handle = fopen("users.csv", "r")) !== FALSE) {
			$nn = 0;
			while (($data = fgetcsv($handle, 1000, "|")) !== FALSE) {
				if($nn > 0){
					$c = count($data);
					for ($x=0; $x<$c; $x++){
						$this->fileReg[$nn][$x] = $data[$x];
					}
				}
				$nn++;
			}
			fclose($handle);
			$this->setInserReg();
		}
	}

	public function setInserReg(){
		$rowInsert = '';

		$len = count($this->fileReg);
		foreach ($this->fileReg as $index => $row) {
			list($telephone, $cellphone) = explode('-', $row[3]);
			$rowInsert .= '("'. $row[0] .'", "'. $row[1] .'", "'. $row[2] .'", "'. $telephone .'", "'. $cellphone .'", "'. $row[4] .'")';
			if ($index == $len) {
				$rowInsert .= '';
	    } else {
	    	$rowInsert .= ',';
	    }
		}

		// --> Ingresamos en la DB
		$sql = 'INSERT INTO t_users (first_name, last_name, address, telephone, cellphone, avatar) VALUES '.$rowInsert;
		$query = $this->connection->prepare($sql);
		$query->execute();

		// List Db
			// $sql = "SELECT * FROM t_users";
			// $query = $this->connection->prepare($sql);
			// $query->execute();
			// while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			// 	var_dump('<pre>', $row);
			// }
	}

	public function __destruct() {
		$this->connection = null;
	}
}

$myFileImport = new import();
