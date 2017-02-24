<?php

namespace App\Models;

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

	public function loginAction($params)
	{

		$sha1Password = $this->generatePassword($params['password']);

		$queryParams = [
			'fields' => '*',
			'where' => [
				'username' => $params['username'],
				'password' => $sha1Password
			]
		];

		if ($selectResult = $this->modelPointObj->select($queryParams)['0']){
			//echo "<pre>", var_dump($selectResult), "</pre>";	//temporary line...
			if (isset($selectResult['id']) 
				&& $sha1Password == $selectResult['password']){

				return ['result' => true];
			}else{
				return [
					'result' => false,
					'message' => 'Wrong username or password!!!',
					'username' => $params['username']
				];
			}
		}else{
			return $selectResult;
		};
		
	}
    

}