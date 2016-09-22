<?php

//echo 'Requested URL: "' . $_SERVER['QUERY_STRING'] . '"';

//require_once '../App/Controllers/Posts.php';

//require_once '../Core/Router.php';


require_once dirname(__DIR__) . '/vendor/Twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();


spl_autoload_register(function ($class) {
	$root = dirname(__DIR__);
	$file = $root . '/' . str_replace('\\', '/', $class) . '.php';
	if (is_readable($file)){
		require_once $root . '/' . str_replace('\\', '/', $class) . '.php';
	}
});

$router = new Core\Router();

//echo get_class($router);

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);

/*
echo '<pre>';
var_dump($router->getRoutes());
echo '</pre>';
*/

/*
$url = $_SERVER['QUERY_STRING'];

if ($router->match($url)){
	echo '<pre>';
	var_dump($router->getParams());
	echo '</pre>';
}else{
	echo "No route found for URL: '$url'";
}
*/



$router->dispatch($_SERVER['QUERY_STRING']);
