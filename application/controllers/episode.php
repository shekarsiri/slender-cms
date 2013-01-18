<?php
class Episode_Controller extends Base_Controller
{
	public $restful = true;
	
	/**
	 * Main Episode page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function get_index()
	{
		if(!Auth::user()->has_access("episode.view")){
			return Response::error('401');
		}
		return View::make('episode/index')->with('episodes', Episode::all());
	}


	/**
	 * New episode page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function get_edit($id = null)
	{
		if(!Auth::user()->has_access("episode.edit")){
			return Response::error('401');
		}
		$episode = Episode::find($id);
		$parent = $episode->getParent();
		return View::make('episode/edit')
						->with('episode', $episode)
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
		if(!Auth::user()->has_access("episode.edit")){
			return Response::error('401');
		}
		// Declare the rules for the form validation.
		//
		$rules = array(
			'title' => 'required',
			'description'  => 'required|between:5,1000',
			'season' => 'required',
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
			// Create the episode
			//
			if(is_null($id)){
				$episode = new Episode;
			}else{
                $episode =  Episode::find($id);
			}
            $episode->title = Input::get('title');

            $episode->description = Input::get('description');
            $episode->slug = Str::slug(Input::get('slug') ?:Input::get('title'));
            $episode->tags = explode(',', Input::get('tags'));

            $episode->season = Input::get('season');

            $episode->parent = array(
               'id' => Input::get('parent_id'),
               'type' =>  Input::get('parent_type'),
            );

            $episode->dateify() // set updated and created fields
                   ->save();


			// Redirect to the episode page.
			//
			return Redirect::to('episode')->with('success', 'Episode updated with success!');
		}

		// Something went wrong.
		//
		return Redirect::to('episode/edit/'.$id)->with_input()->with_errors($validator);
	}
}
