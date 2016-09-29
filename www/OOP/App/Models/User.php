<?php

namespace App\Models;

//use Core\Core;

class User  extends Model
{
	
	protected function allFields()
    {

    }
	
	protected function getSortColArray()
    {

    }
	protected function getOffset($data)
    {

    }
	
	protected function selectValidation($data)
    {
		// seting default data...
		if (!isset($data['sortCol']) 
			|| !isset($data['sortOrd']) 
			|| !isset($data['page']) 
			|| !isset($data['limit'])){
		
			$data['sortCol'] = "id";
			$data['sortOrd'] = "ASC";
			$data['page'] = 1;
			$data['limit'] = 1;
		};
		
		return $data;
    }

	private function generatePassword($pass)
	{
		return sha1($pass);
	}

	public static function login($username, $password)
	{
		$user = new User(['host' => DB_HOST, 'user'=>DB_USER, 
            				'password'=>DB_PASSWORD, 'dbName'=>DB_NAME], 
							USERS_DB);

		$sha1Password = $user->generatePassword($password);

		$queryParams = [
			'fields' => '*',
			'where' => [
				'username' => $_POST['username'],
				'password' => $sha1Password
			]
		];

		if ($user->select($queryParams)){
			return ['result' => true];
		}else{
			return [
					'result' => false,
					'message' => 'Wrong username or password!!!',
					'username' => $username
				];
		};
	}
    

}