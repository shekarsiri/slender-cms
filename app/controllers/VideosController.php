<?php

class VideosController extends BaseController {

	protected $package = 'videos';

    protected $displayFields = array(
                                'title' => 'Title',
                                'season' => 'Season',
                                'episode_number' => 'Episode'

                            );

    public function __construct(){
        parent::__construct();

        $this->api->setSite('ai');
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

            return View::make('videos/edit')
                        ->with('package', $this->package)
                        ->with('method', $method)
                        ->with('options', $options);
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
            $method = 'POST'; //
            $options = $options->PUT;
        }elseif(isset($options->POST)){
            $method = 'POST';
            $options = $options->POST;
        }

        return View::make('videos/new')
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
        return Redirect::to($this->package)->with('success', 'The data successfully saved!');;
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update($id)
    {
        // Declare the rules for the form validation.
        //
        $rules = array();

        // Get all the inputs.
        //
        $inputs = Input::all();

        // Validate the inputs.
        //
        $validator = Validator::make($inputs, $rules);

        // Check if the form validates with success.
        //
        if ($validator->fails())
        {
            // Something went wrong.
            //
            return Redirect::to($this->package."/".$id)->withErrors($validator->messages());
        }

        return parent::update($id);
    }


	public function destroy($id)
	{
        $response = $this->api->delete($this->package."/".$id);
        return Redirect::to($this->package);
	}

}
