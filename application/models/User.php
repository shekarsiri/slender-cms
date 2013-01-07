<?php

// use Enjoyit\Mongo\Model;

class User extends Mongor\Model {


    // public function Roles()
    // {
    //     return $this->has_and_belongs_to_many('Role','User', 'role_id', '_id');
    // }


	public static function find($id){

		if($id instanceof MongoId){
			$id = $id->__toString();
		}

		return User::first(array('_id'=> $id));
	}

	/**
	 * Get the user full name.
	 *
	 * @access   public
	 * @return   string
	 */
	public function fullName()
	{
		return $this->first_name . ' ' . $this->last_name;
	}
}