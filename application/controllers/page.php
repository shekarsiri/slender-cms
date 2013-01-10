<?php

class Page_Controller extends Base_Controller
{
	public $restful = true;
	
	/**
	 * Main pages page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function get_index()
	{
		if(!Auth::user()->has_access("page.view")){
			return Response::error('401');
		}
		return View::make('page/index')->with('pages', Page::all());
	}


	/**
	 * New pages page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function get_edit($id = null)
	{
		if(!Auth::user()->has_access("page.edit")){
			return Response::error('401');
		}
		return View::make('page/edit')->with('page', Page::find($id));
	}


	/**
	 *
	 *
	 * @access   public
	 * @return   Redirect
	 */
	public function post_edit($id = null)
	{
		if(!Auth::user()->has_access("page.edit")){
			return Response::error('401');
		}
		// Declare the rules for the form validation.
		//
		$rules = array(
			'title' => 'required',
			// 'meta_title'  => 'required|between:5,1000',
			'body' => 'required|between:5,2000',
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
				$page = new Page;
			}else{
				$page =  Page::find($id);
			}
			$page->title = Input::get('title');
			$page->meta  = array( 
								'title' => Input::get('meta_title'),
								'keywords' => Input::get('meta_keywords')
							);
			$page->body = Input::get('body');
			$page->slug = Input::get('slug') ?:Input::get('title');
			$page->save();


			// Redirect to the register page.
			//
			return Redirect::to('page')->with('success', 'Page updated with success!');
		}

		// Something went wrong.
		//
		return Redirect::to('page/edit/'.$id)->with_input()->with_errors($validator);
	}
}
