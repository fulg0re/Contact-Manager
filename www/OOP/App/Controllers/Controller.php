<?php

namespace App\Controllers;

use \Core\View;

class Controller extends \Core\Controller
{

	protected function before($method)
	{
		if ($_SESSION['logined'] != true){
			$allowRoute = $this->components['Auth']['allow'];
			foreach($allowRoute as $key => $val){
				if ($val == $method){
					return true;
				};
			};

            $_SESSION['params'] = [
                'message' => 'You must login first!'
            ];

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
                'authAction',
                'loginAction'
            ],
            'deny' => [
                'Contacts/index.php',
                'Contacts/edit.php',
            ]
        ]
        
    ];

    protected function getViewParams()
    {
        if (isset($_SESSION['params'])){
            $this->renderParams += $_SESSION['params'];
            unset($_SESSION['params']);
        };
    }
}
