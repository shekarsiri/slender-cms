<?php
// TODO: change to channel
class Channel_Controller extends Base_Controller
{
	public $restful = true;
	
	/**
	 * Main Channel page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function get_index()
	{
		if(!Auth::user()->has_access("channel.view")){
			return Response::error('401');
		}
		return View::make('channel/index')->with('videos', Channel::all());
	}


	/**
	 * New videos page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function get_edit($id = null)
	{
		if(!Auth::user()->has_access("channel.edit")){
			return Response::error('401');
		}
		$video = Channel::find($id);
		$parent = $video->getParent();
		return View::make('channel/edit')
						->with('video', $video)
						->with('parent', $parent);
	}


	/**
	 *
	 *
	 * @access   public
	 * @return   Redirect
	 */
	public function post_edit($id = null)
	{
		if(!Auth::user()->has_access("channel.edit")){
			return Response::error('401');
		}
		// Declare the rules for the form validation.
		//
		$rules = array(
			'title' => 'required',
			'description'  => 'required|between:5,1000',
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
				$video = new Channel;
			}else{
				$video =  Channel::find($id);
			}
			$video->title = Input::get('title');

			$video->description = Input::get('description');
			$video->slug = Str::slug(Input::get('slug') ?:Input::get('title'));
			$video->tags = explode(',', Input::get('tags'));

			if($premiere_date = DateTime::createFromFormat('m/d/Y H:i:s', Input::get('premiere_date'))){
				$video->premiere_date = new MongoDate($premiere_date->getTimestamp());
			}else{
				$video->premiere_date = '';
			}

			$video->genre = Input::get('genre');

			$video->urls = array( 
				'source' => Input::get('urls_source'),
				'streaming' => Input::get('urls_streaming'),
				'thumbnail' => Input::get('urls_thumbnail')
			);

			$availability_sunrise = DateTime::createFromFormat('m/d/Y H:i:s', Input::get('availability_sunrise'));
			$availability_sunset = DateTime::createFromFormat('m/d/Y H:i:s', Input::get('availability_sunset'));

			$video->availability = array(
				'sunrise' => $availability_sunrise ? new MongoDate($availability_sunrise->getTimestamp()) : '',
				'sunset' =>  $availability_sunset ? new MongoDate($availability_sunset->getTimestamp()) : '',
			);

			$video->parent = array(
				'id' => Input::get('parent_id'),
				'type' =>  Input::get('parent_type'),
			);

			$video->dateify() // set updated and created fields
					->save();


			// Redirect to the video page.
			//
			return Redirect::to('channel')->with('success', 'Video updated with success!');
		}

		// Something went wrong.
		//
		return Redirect::to('channel/edit/'.$id)->with_input()->with_errors($validator);
	}
}
