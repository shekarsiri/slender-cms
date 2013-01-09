<?php

class Account_Controller extends Base_Controller
{
	public $restful = true;

	/**
	 * Let's whitelist all the methods we want to allow guests to visit!
	 *
	 * @access   protected
	 * @var      array
	 */
	protected $whitelist = array(
		'login',
		'register',
	);

	/**
	 * Main account page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function get_index()
	{
		// Show the page.
		//
		return View::make('account/index')->with('user', Auth::user());
	}

	/**
	 *
	 *
	 * @access   public
	 * @return   Redirect
	 */
	public function post_index()
	{
		// Declare the rules for the form validation.
		//
		$rules = array(
			'first_name' => 'Required',
			'last_name'  => 'Required',
			'email'      => 'Required|Email',
		);

		// If we are updating the password.
		//
		if (Input::get('password'))
		{
			// Update the validation rules.
			//
			$rules['password']              = 'Required|Confirmed';
			$rules['password_confirmation'] = 'Required';
		}

		// Get all the inputs.
		//
		$inputs = Input::all();

		// Validate the inputs.
		//
		$validator = Validator::make($inputs, $rules);

		// Check if the form validates with success.
		//
		if ($validator->passes())
		{
			// Create the user.
			//
			$user =  User::find(Auth::user()->_id);
			$user->first_name = Input::get('first_name');
			$user->last_name  = Input::get('last_name');
			$user->email      = Input::get('email');
			$user->access 	  = Input::get('access');

			if (Input::get('password') !== '')
			{
				$user->password = Hash::make(Input::get('password'));
			}

			$user->save();

			// Redirect to the register page.
			//
			return Redirect::to('account')->with('success', 'Account updated with success!');
		}

		// Something went wrong.
		//
		return Redirect::to('account')->with_input()->with_errors($validator);
	}

	/**
	 * Login form page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function get_login()
	{
		// Are we logged in?
		//
		if (Auth::check())
		{
			return Redirect::to('account');
		}

		// Show the page.
		//
		return View::make('account/login');
	}

	/**
	 * Login form processing.
	 *
	 * @access   public
	 * @return   Redirect
	 */
	public function post_login()
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
				// Redirect to the users page.
				//
				return Redirect::to('/')->with('success', 'You have logged in successfully');
			}
			else
			{
				// Redirect to the login page.
				//
				return Redirect::to('account/login')->with('error', 'Email/password invalid.');
			}
		}

		// Something went wrong.
		//

		return Redirect::to('account/login')->with_errors($validator);
	}

	/**
	 * User account creation form page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function get_register()
	{
		// Are we logged in?
		//
		if (Auth::check())
		{
			return Redirect::to('account');
		}

		// Show the page.
		//
		return View::make('account/register');
	}

	/**
	 * User account creation form processing.
	 *
	 * @access   public
	 * @return   Redirect
	 */
	public function post_register()
	{
		// Declare the rules for the form validation.
		//
		$rules = array(
			'first_name'            => 'Required',
			'last_name'             => 'Required',
			'email'                 => 'Required|Email',
			'password'              => 'Required|Confirmed',
			'password_confirmation' => 'Required'
		);

		// Get all the inputs.
		//
		$inputs = Input::all();

		// Validate the inputs.
		//
		$validator = Validator::make($inputs, $rules);

		// Check if the form validates with success.
		//
		if(User::where(array('email' => Input::get('email')))->first()->_id){
			return Redirect::to('account/register')->with_input()->with('error', "Account with email '".Input::get('email')."' already exist!");
		}	
			
		if ($validator->passes())
		{
			// Create the user.
			//
			$user = new User;
			$user->first_name = Input::get('first_name');
			$user->last_name  = Input::get('last_name');
			$user->email      = Input::get('email');
			$user->password   = Hash::make(Input::get('password'));
			if(!User::first()->_id){
				$user->access = array(
					'user' => array(
						'view' 	=> 1,
						'edit' 	=> 1,
						'delete'=> 1,
					),
				);
			}	
			$user->save();

			// Redirect to the register page.
			//
			return Redirect::to('account/register')->with('success', 'Account created with success!');
		}

		// Something went wrong.
		//
		return Redirect::to('account/register')->with_input()->with_errors($validator);
	}

	/**
	 * Logout page.
	 *
	 * @access   public
	 * @return   Redirect
	 */
	public function get_logout()
	{
		// Log the user out.
		//
		Auth::logout();

		// Redirect to the users page.
		//
		return Redirect::to('account/login')->with('success', 'Logged out with success!');
	}
}
