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

        //Session::put('site', 'ai');
        $this->api->setSite(Session::get('site'));
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
                ->with('data', $response)
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
        // Declare the rules for the form validation.
        //
        $rules = array(
            'title'                 => 'Required',
            'description'           => 'Required',
            'slug'                  => 'Required',
            'premiere_date'         => 'Date',
            'rating' 	            => 'Integer',
            'genre' 	            => 'Required',
            'episode_number'        => 'Integer',
            'season' 	            => 'Required',
            'urls[source]'          => 'URL',
            'urls[streaming]'       => 'URL',
            'urls[thumbnail]'       => 'URL',
            'availability[sunrise]' => 'Date',
            'availability[sunset]'  => 'Date',
            'created' 	            => 'Date',
            'updated' 	            => 'Date',
        );

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
            return Redirect::to($this->package."/create")->withErrors($validator->messages());
        }

        parent::store();
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
        $rules = array(
            'title'                 => 'Required',
            'description'           => 'Required',
            'slug'                  => 'Required',
            'premiere_date'         => 'Date',
            'rating' 	            => 'Integer',
            'genre' 	            => 'Required',
            'episode_number'        => 'Integer',
            'season' 	            => 'Required',
            'urls[source]'          => 'URL',
            'urls[streaming]'       => 'URL',
            'urls[thumbnail]'       => 'URL',
            'availability[sunrise]' => 'Date',
            'availability[sunset]'  => 'Date',
            'created' 	            => 'Date',
            'updated' 	            => 'Date',
        );

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

}
