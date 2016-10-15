<?php

namespace App\Controllers;

use \Core\View;

class Controller extends \Core\Controller
{

    protected $components = [
        'Auth' => [
            'allow' => [
                'indexAction',
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
