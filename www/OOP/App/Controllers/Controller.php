<?php

namespace App\Controllers;

use \Core\View;

class Controller extends \Core\Controller
{

    protected $component = [
        'allow' => [
            'route1' => 'indexAction',
            'route2' => 'loginAction'
        ],
        'deny' => [
            'route1' => 'Contacts/index.php',
            'route2' => 'Contacts/edit.php',
        ]
    ];

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
