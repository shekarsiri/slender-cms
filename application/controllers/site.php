<?php

class Site_Controller extends Base_Controller
{
	public $restful = true;

	
	/**
	 * Main sites page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function get_index()
	{
		if(!Auth::user()->has_access("site.view")){
			return Response::error('401');
		}
		return View::make('site/index')->with('sites', Site::all());
	}


	/**
	 * New site page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function get_edit($id = null)
	{
		if(!Auth::user()->has_access("site.edit")){
			return Response::error('401');
		}
		return View::make('site/edit')->with('site', Site::find($id));
	}


	/**
	 *
	 *
	 * @access   public
	 * @return   Redirect
	 */
	public function post_edit($id = null)
	{
		if(!Auth::user()->has_access("site.edit")){
			return Response::error('401');
		}
		// Declare the rules for the form validation.
		//
		$rules = array(
			'name' => 'required',
			'description'  => 'required|between:5,1000',
			'url'      => 'required',
		);

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
			// Create the site
			//
			if(is_null($id)){
				$site = new Site;
			}else{
				$site =  Site::find($id);
			}
			$site->name = Input::get('name');
			$site->description  = Input::get('description');
			$site->url      = Input::get('url');
			$site->save();


			// Redirect to the register page.
			//
			return Redirect::to('site')->with('success', 'Site updated with success!');
		}

		// Something went wrong.
		//
		return Redirect::to('site/edit/'.$id)->with_input()->with_errors($validator);
	}
}
