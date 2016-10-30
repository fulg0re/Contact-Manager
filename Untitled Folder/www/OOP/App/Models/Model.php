<?php

namespace App\Models;

class Model  extends \Core\Models\Table
{

    public function __construct($table)
    {
        parent::__construct();
        $this->table = lcfirst($table);
    }

	public function __call($name, $args)
	{

        $this->modelPointObj = $args['0'];

        array_shift($args);

		$method = $name . 'Action';

		if (method_exists($this, $method)){
			return call_user_func_array([$this, $method], $args);
		}else{
			echo "Method $method not found in controller " . get_class($this);
		}
		
	}

	protected function allFields()
    {}
	
	protected function getSortColArray()
    {}
	
	protected function getOffset($data)
    {}
	
	protected function selectValidation($data)
    {}

}