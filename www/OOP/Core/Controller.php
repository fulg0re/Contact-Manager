<?php

namespace Core;

include_once('../App/config.php');

use \Core\View;

abstract class Controller
{

	public function __call($name, $args)
	{
		$method = $name . 'Action';

		if (method_exists($this, $method)){
			if ($this->before() !== false){
				call_user_func_array([$this, $method], $args);
				$this->after();
			}
		}else{
			echo "Method $method not found in controller " . get_class($this);
		}
	}

	protected function before()
	{
		//do the "return" function if you nead to check for user is logined...
	}

	protected function after()
	{
	}

	protected function redirect($path)
	{
		header("location: " . SITE . $path);
		exit;
	}

	protected function getLastUrl()
	{
		return $_SERVER['HTTP_REFERER'];
	}

}





