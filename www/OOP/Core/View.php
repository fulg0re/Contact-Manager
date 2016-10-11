<?php

namespace Core;

class View
{

	public static function render($view, $args = [])
	{
	/*	
		ob_start();

		extract($args, EXTR_SKIP);

		$file = "../App/Views/$view";

		if (is_readable($file)){
			require_once $file;
		}else{
			echo "$file not found";
		}

		$var=ob_get_contents(); 

		ob_flush();

		ob_clean();
*/

		if (!empty($args)){
			extract($args, EXTR_SKIP);
		};		

		$file = "../App/Views/$view";

		if (is_readable($file)){
			require_once $file;
		}else{
			echo "$file not found";
		}
		
	}

}






