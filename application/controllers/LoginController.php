<?php

class LoginController extends BaseController {


	public function get_signup()
	{
		return View::make('login.signup');
	}

	public function get_info()
	{

	}

	public function get_logout()
	{
		Auth::logout();
		return Redirect::to('/');
	}
	
	public function show_login()
	{
		if(Auth::check()){
			return View::make('home.index');
		}else{
			return View::make('login.login');
		}
	}

	public function post_signup()
	{


		$rules = array(
			'name' => 'required',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:8|max:100'
		);

    	$validation = Validator::make(Input::all(), $rules);

		if ($validation->fails())
    	{
        	return Redirect::to('signup')->with_errors($validation)->with_input();
    	}


		User::create(array(
				'email' => Input::get('email'),
				'name'	=> Input::get('name'),
				'password' => Hash::make(Input::get('password'))
			));

		return Redirect::to('/');
	}

	public function post_login(){

		$rules = array(
			'email' => 'required|email',
			'password' => 'required|login'
		);

		$messages = array(
		    'login' => 'Wrong email or password!',
		);
		Validator::register('login', function($attribute, $value, $parameters)
		{
			$credentials = array(
				'username' => Input::get('email'),
				'password' => Input::get('password')
			);
			return Auth::attempt($credentials);
		});

		$validation = Validator::make(Input::get(), $rules, $messages);


    	if ($validation->fails())
    	{
        	return Redirect::to('/')->with_input()->with_errors($validation);
    	}

    	return Redirect::to('/');
		
	}	

}