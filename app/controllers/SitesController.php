<?php

class SitesController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $response = json_decode($this->api->get("sites"));
        echo "<pre>"; print_r($response); die();
        return View::make('sites/index')->with('sites', $response->sites);
	}
}
