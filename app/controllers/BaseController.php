<?php

use Dws\Slender\Api\ApiException;

class BaseController extends Controller {

	public $api;
	protected $package; 

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

	/**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $options = $this->api->options($this->package);
        if(isset($options->PUT)){
        	// $method = 'PUT';
        	$method = 'POST'; //
        	$options = $options->PUT;
        }elseif(isset($options->POST)){
        	$method = 'POST';
        	$options = $options->POST;
        }

        return View::make('base/new')
        				->with('package', $this->package)
        				->with('method', $method)
        				->with('options', $options);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    { 
    	$data = Input::all();

        try {
            $response = $this->api->post($this->package, $data);
        } catch (ApiException $e) {
            $errors = new MessageBag;
            $messages = $e->getMessages();
            foreach ($messages[0] as $key => $value) {
                foreach ($value as $msg) {
                    $errors->add($key, $msg);
                }
            }
            return Redirect::to($this->package."/create")->withErrors($errors);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show($id)
    {
        $response = $this->api->get($this->package."/".$id);

        if($response = $response->sites[0]){
            $options = $this->api->options($this->package);
            $method = 'POST';
            $options = $options->PUT;
            return View::make('base/edit')
                        ->with('data', $response)
                        ->with('package', $this->package)
                        ->with('method', $method)
                        ->with('options', $options);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update($id)
    {
        $data = Input::all();
        
        try {
            $response = $this->api->put($this->package."/".$id, $data);
        } catch (ApiException $e) {
            $errors = new MessageBag;
            $messages = $e->getMessages();
            foreach ($messages[0] as $key => $value) {
                foreach ($value as $msg) {
                    $errors->add($key, $msg);
                }
            }
            return Redirect::to($this->package."/".$id)->withErrors($errors);
        }
        
        return Redirect::to($this->package)->with('success', 'The data successfully saved!');;
    }

}
