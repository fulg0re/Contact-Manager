<?php

namespace App\Controllers\Admin;

class Users extends \Core\Controller
{

	protected function before()
	{
		// Check if user is logined...
		// if not - return false;
	}

	public function indexAction()
	{
		echo "User admin index";
	}

}









