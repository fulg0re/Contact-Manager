<?php

namespace App\Models;

//use Core\Core;

class User  extends Model
{

	protected $table = "users";

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

	public function login($params)
	{
		//$sha1Password = User::$userObj->generatePassword($params['password']);
		
		$sha1Password = $this->generatePassword($params['password']);

		$queryParams = [
			'fields' => '*',
			'where' => [
				'username' => $params['username'],
				'password' => $sha1Password
			]
		];

		if ($this->select($queryParams)){
			return ['result' => true];
		}else{
			return [
					'result' => false,
					'message' => 'Wrong username or password!!!',
					'username' => $params['username']
				];
		};
	}
    

}