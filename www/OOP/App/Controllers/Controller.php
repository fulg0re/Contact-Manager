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

    protected function homePage($params = [])
    {
        View::render('Users/index.php', $params);
    }

    protected function mainPage($params = [])
    {
        View::render('Contacts/index.php', $params);
    }

    protected function editPage($params = [])
    {
        View::render('Contacts/edit.php', $params);
    }
}
