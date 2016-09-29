<?php

namespace App\Controllers;

use \Core\View;

class Home extends Controller
{

	public function indexAction()
	{
		View::render('Home/index.php');
	}

}
