<?php

class UsersController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $response = json_decode($this->api->get("users"));
		return View::make('users/index')->with('users', $response->users);
	}

	public function show($id)
	{
        $response = json_decode($this->api->get("users/" . $id));
        if (count ($response->users) && is_array($response->users)) {
            $user = $response->users[0];
            return View::make('users/edit')->with('user', $user);
        }
        else {
            return Redirect::to('users')->withErrors(array('User not found'));
        }
	}

	public function update($id)
	{
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
            //$response = json_decode($this->api->put("users/" . $id));
            /*
            Input::get('first_name');
            Input::get('last_name');
            Input::get('email');
            Input::get('password')
            */

            // Redirect to the register page.
            //
            return Redirect::to('users')->with('success', 'Account updated with success!');
        }

        // Something went wrong.
        return Redirect::to('users/'.$id)->withInput()->withErrors($validator);
	}

	public function destroy($id)
	{
        $response = json_decode($this->api->delete("users/" . $id));
        return Redirect::to('users');
	}

}
