<?php

use Dws\Slender\Api\ApiException;

use Zend\Http\Request;
use Zend\Http\Client;


class LoginController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return View::make('login.login');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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
            'email'    => 'Required|Email',
            'password' => 'Required'
        );

        // Get all the inputs.
        //
        $email = Input::get('email');
        $password = Input::get('password');

        // Validate the inputs.
        //
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success.
        //
        if ($validator->passes())
        {
            // Try to log the user in.
            //
            if (Auth::attempt(array('email' => $email, 'password' => $password)))
            {
                $sites = $this->api->get('sites');
                $accessibleSites = array();
                if (count($sites->sites) && is_array($sites->sites)) {
                    $auth = Auth::user()->permissions;
                    foreach ($sites->sites as $site) {
                        if ($auth->global || $auth->$site) {
                            $accessibleSites[$site->slug] = $site->title;
                        }
                    }
                }
                if (count($accessibleSites)) {
                    Session::put('sites', $accessibleSites);
                    $currentSite = key($accessibleSites); // First key of assoc array
                    Session::put('site', $currentSite);
                }
                // Redirect to the users page.
                //
                return Redirect::to('/')->with('success', 'You have logged in successfully');
            }
            else
            {
                // Redirect to the login page.
                //
                return Redirect::to('login')->with('error', 'Email/password invalid.');
            }
        }

        // Something went wrong.
        //

        return Redirect::to('login')->withErrors($validator->messages());
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show($id)
	{
        if($id=='logout'){ // fuck! This should be fixed
            // Log the user out.
            //
            Auth::logout();

            // Redirect to the users page.
            //
            return Redirect::to('login')->with('success', 'Logged out with success!');
        }
		
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
