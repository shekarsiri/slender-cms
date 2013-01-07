<?php

class Base_Controller extends Controller {

	protected $whitelist = array();

	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}



	/**
	 * Initializer.
	 *
	 * @access   public
	 * @return   void
	 */
	public function __construct()
	{
		// Check if the user is logged in.
		//
		// $this->beforeFilter('auth', array('except' => $this->whitelist));
		$this->filter('before', 'auth')->except($this->whitelist);
	}

}