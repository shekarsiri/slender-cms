<?php

class RolesController extends BaseController {

	protected $package = 'roles'; 
    protected $displayFields = array(
                                'name' => 'Name'
                            );

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
