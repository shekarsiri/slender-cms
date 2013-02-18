<?php

class SitesController extends BaseController {

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

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
        die('new site');
    }
}
