<?php

class Api_Controller extends Controller {

	public $restful = true;

	//TODO: remove this shit code
	// API Emulation 
	/**
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		list($method, $class) = explode('_', $method);
		$action = Request::get('action');
		$class = ucfirst($class);
		if(class_exists($class)){
			$object = new $class;

			if(in_array($action, get_class_methods($class))){
				$res = $object->$action();
				return Response::json(array(strtolower($class) => $this->getClean($res)));
			}else{
				//error

			}
		}else{
			//error
		}

		// var_dump($method, $class, $parameters, $action, $object);

	}

	private function getClean($collection){
		$res = array();
		foreach ($collection as $key => $value) {
			if(isset($value->attributes) && isset($value->attributes['_id'])){
				$value->attributes['id'] = $value->attributes['_id']->__toString();
				unset($value->attributes['_id']);
				$res[] = $value->attributes;
			}
		}
		return $res;
	}



}