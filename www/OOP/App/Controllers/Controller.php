<?php

namespace App\Controllers;

use \Core\View;

class Controller extends \Core\Controller
{

	protected function before($route)
	{
		if (isset($_SESSION['logined']) && $_SESSION['logined'] != true){
			$allowRoutes = $this->components['Auth']['allow'];
			foreach($allowRoutes as $allowRoute){
				if ($route == $allowRoute){
					return true;
				};
			};
            
            $_SESSION['message'] = 'You must login first!';

			$this->redirect("/");
		}else{
            return true;
        }
	}

	protected function after()
	{
	}

    protected $components = [
        'Auth' => [
            'allow' => [
                'Users/index'
            ],
            'deny' => [
                'Contacts/index',
                'Contacts/edit',
                'Contacts/add',
                'Contacts/selection'
            ]
        ]
        
    ];

    protected function getViewParams()
    {
        if (isset($_SESSION['message'])){
            $this->renderParams['message'] = $_SESSION['message'];
            unset($_SESSION['message']);
        };
        
    }

    protected function db($variable)
    {
        echo "<pre>", var_dump($variable), "</pre>";
        die;
    }
}
