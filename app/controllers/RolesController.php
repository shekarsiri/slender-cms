<?php

class RolesController extends BaseController {

	protected $package = 'roles'; 

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $response = $this->api->get("roles");
        return View::make('roles/index')->with('roles', $response->roles);
	}

   /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show($id)
    {
        $response = $this->api->get($this->package."/".$id);

        if($response = $response->{$this->package}[0]){
            $options = $this->api->options($this->package);
            $method = 'POST';
            $options = $options->PUT;
            return View::make('roles/edit')
                        ->with('data', $response)
                        ->with('package', $this->package)
                        ->with('method', $method)
                        ->with('options', $options);
        }
    }
}
