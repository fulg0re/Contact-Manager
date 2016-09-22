<?php

namespace Core;

use PDO;

abstract class Model
{

	protected static function getDB()
	{
		static $db = null;

		if ($db === null){
			$host = 'localhost';
			$dbname = 'contact_manager';
			$username = 'root';
			$password = '123';

			try {
				$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8",
									$username, $password);
				
				return $db;
			}catch (PDOException $e){
				echo $e->getMessage();
			}
		}
	}

}










