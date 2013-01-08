<?php

// use Enjoyit\Mongo\Model;

class User extends Mongor\Model {

	public static $collection = 'user';

    // public function Roles()
    // {
    //     return $this->has_and_belongs_to_many('Role','User', 'role_id', '_id');
    // }

    public function has_access($to){
    	list($module, $access) = explode('.', $to, 2);
    	
    	return (isset($this->access[$module][$access]) && $this->access[$module][$access]) ? true : false;
    }


	public static function find($id){

		if(!$id instanceof MongoId){
			$id = new MongoId($id);
		}

		return self::where(array('_id'=> $id))->first();
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