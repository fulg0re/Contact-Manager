<?php

// testing git new branch...

include_once('../App/config.php');

session_start();

spl_autoload_register(function ($class) {
	$root = dirname(__DIR__);
	$file = $root . '/' . str_replace('\\', '/', $class) . '.php';
	if (is_readable($file)){
		require_once $root . '/' . str_replace('\\', '/', $class) . '.php';
	}
});

$router = new Core\Router();

$router->dispatch($_SERVER['QUERY_STRING']);
