<?php
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
		return View::make('channel/index')->with('channels', Channel::all());
	}


	/**
	 * New channels page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function get_edit($id = null)
	{
		if(!Auth::user()->has_access("channel.edit")){
			return Response::error('401');
		}
		$channel = Channel::find($id);
		$parent = $channel->getParent();
		return View::make('channel/edit')
						->with('channel', $channel)
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
				$channel = new Channel;
			}else{
				$channel =  Channel::find($id);
			}
			$channel->title = Input::get('title');

			$channel->description = Input::get('description');
			$channel->slug = Str::slug(Input::get('slug') ?:Input::get('title'));
			$channel->tags = explode(',', Input::get('tags'));


			$channel->genre = Input::get('genre');

			$start_date = DateTime::createFromFormat('m/d/Y H:i:s', Input::get('start_date'));
			$end_date = DateTime::createFromFormat('m/d/Y H:i:s', Input::get('end_date'));

			$channel->start_date = $start_date ? new MongoDate($start_date->getTimestamp()) : '';
			$channel->end_date = $end_date ? new MongoDate($end_date->getTimestamp()) : '';

			$channel->dateify() // set updated and created fields
					->save();


			// Redirect to the channel page.
			//
			return Redirect::to('channel')->with('success', 'Channel updated with success!');
		}

		// Something went wrong.
		//
		return Redirect::to('channel/edit/'.$id)->with_input()->with_errors($validator);
	}
}
