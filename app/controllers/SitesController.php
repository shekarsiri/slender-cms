<?php

class SitesController extends BaseController {

    protected $package = 'sites'; 
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $response = $this->api->get("sites");
        return View::make('sites/index')->with('sites', $response->sites);
	}

}
