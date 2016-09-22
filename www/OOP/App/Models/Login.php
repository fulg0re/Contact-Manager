<?php

namespace App\Models;

use Core\Core;

class Login  extends \Core\Core\Table
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
    

}