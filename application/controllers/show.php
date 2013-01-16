<?php
class Show_Controller extends Base_Controller
{
	public $restful = true;
	
	/**
	 * Main Show page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function get_index()
	{
		if(!Auth::user()->has_access("show.view")){
			return Response::error('401');
		}
		return View::make('show/index')->with('shows', Show::all());
	}


	/**
	 * New shows page.
	 *
	 * @access   public
	 * @return   View
	 */
	public function get_edit($id = null)
	{
		if(!Auth::user()->has_access("show.edit")){
			return Response::error('401');
		}
		$show = Show::find($id);
		$parent = $show->getParent();
		return View::make('show/edit')
						->with('show', $show)
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
		if(!Auth::user()->has_access("show.edit")){
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
			// Create the show
			//
			if(is_null($id)){
				$show = new Show;
			}else{
				$show =  Show::find($id);
			}
			$show->title = Input::get('title');

			$show->description = Input::get('description');
			$show->slug = Str::slug(Input::get('slug') ?:Input::get('title'));
			$show->tags = explode(',', Input::get('tags'));


			$show->genre = Input::get('genre');

			$start_date = DateTime::createFromFormat('m/d/Y H:i:s', Input::get('start_date'));
			$end_date = DateTime::createFromFormat('m/d/Y H:i:s', Input::get('end_date'));

			$show->parent = array(
					'id' => Input::get('parent_id'),
					'type' =>  Input::get('parent_type'),
				);

			$show->start_date = $start_date ? new MongoDate($start_date->getTimestamp()) : '';
			$show->end_date = $end_date ? new MongoDate($end_date->getTimestamp()) : '';

			$show->dateify() // set updated and created fields
					->save();


			// Redirect to the show page.
			//
			return Redirect::to('show')->with('success', 'Show updated with success!');
		}

		// Something went wrong.
		//
		return Redirect::to('show/edit/'.$id)->with_input()->with_errors($validator);
	}
}
