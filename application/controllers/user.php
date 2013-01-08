<?php

class User_Controller extends Base_Controller
{
	public $restful = true;

	/**
	 * Main account page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function get_index()
	{
		if(!Auth::user()->has_access("user.view")){
			return Response::error('401');
		}
		return View::make('user/index')->with('users', User::get());
	}

	/**
	 * Main users page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function get_edit($id = null)
	{
		if(!Auth::user()->has_access("user.view")){
			return Response::error('401');
		}
		return View::make('user/edit')->with('user', User::find($id));
	}

	/**
	 *
	 *
	 * @access   public
	 * @return   Redirect
	 */
	public function post_edit($id = null)
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
			$user =  User::find($id);
			$user->first_name = Input::get('first_name');
			$user->last_name  = Input::get('last_name');
			$user->email      = Input::get('email');
			if(Input::get('access')){
				$user->access 	  = Input::get('access');
			}

			if (Input::get('password') !== '')
			{
				$user->password = Hash::make(Input::get('password'));
			}

			$user->save();

			// Redirect to the register page.
			//
			return Redirect::to('user')->with('success', 'Account updated with success!');
		}

		// Something went wrong.
		//
		return Redirect::to('user/edit/'.$id)->with_input()->with_errors($validator);
	}

}
