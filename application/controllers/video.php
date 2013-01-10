<?php

class Video_Controller extends Base_Controller
{
	public $restful = true;
	
	/**
	 * Main videos page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function get_index()
	{
		if(!Auth::user()->has_access("video.view")){
			return Response::error('401');
		}
		return View::make('video/index')->with('videos', Video::all());
	}


	/**
	 * New videos page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function get_edit($id = null)
	{
		if(!Auth::user()->has_access("video.edit")){
			return Response::error('401');
		}
		return View::make('video/edit')->with('video', Video::find($id));
	}


	/**
	 *
	 *
	 * @access   public
	 * @return   Redirect
	 */
	public function post_edit($id = null)
	{
		if(!Auth::user()->has_access("video.edit")){
			return Response::error('401');
		}
		// Declare the rules for the form validation.
		//
		$rules = array(
			'title' => 'required',
			// 'meta_title'  => 'required|between:5,1000',
			// 'body' => 'required|between:5,2000',
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
				$video = new Video;
			}else{
				$video =  Video::find($id);
			}
			$video->title = Input::get('title');
			// $video->meta  = array( 
			// 					'title' => Input::get('meta_title'),
			// 					'keywords' => Input::get('meta_keywords')
			// 				);
			// $video->body = Input::get('body');
			// $video->slug = Input::get('slug') ?:Input::get('title');
			$video->save();


			// Redirect to the video page.
			//
			return Redirect::to('video')->with('success', 'Video updated with success!');
		}

		// Something went wrong.
		//
		return Redirect::to('video/edit/'.$id)->with_input()->with_errors($validator);
	}
}
