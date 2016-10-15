<?php

namespace Core;

class View
{

	public static function render($view, $args = [])
	{
	
		ob_start();

		if (!empty($args)){
			extract($args, EXTR_SKIP);
		};

		$file = "../App/Views/$view";

		if (is_readable($file)){
			require_once $file;
		}else{
			echo "$file not found";
		}

		ob_end_flush();
		
	}

}






