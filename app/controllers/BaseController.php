<?php

class BaseController extends Controller {

	public $api;

	public function __construct(){
		$this->api = App::make('api');

		if(Auth::check()){
			$this->api->setAuth(Auth::user()->key);
		}
	}
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
