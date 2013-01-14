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
								'keywords' => explode(',', Input::get('meta_keywords'))
							);
			$page->body = Input::get('body');
			$page->slug = Input::get('slug') ?:Input::get('title');


			$availability_sunrise = DateTime::createFromFormat('m/d/Y H:i:s', Input::get('availability_sunrise'));
			$availability_sunset = DateTime::createFromFormat('m/d/Y H:i:s', Input::get('availability_sunset'));


			$page->availability = array(
				'sunrise' => $availability_sunrise ? new MongoDate($availability_sunrise->getTimestamp()) : '',
				'sunset' =>  $availability_sunset ? new MongoDate($availability_sunset->getTimestamp()) : '',
			);

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
