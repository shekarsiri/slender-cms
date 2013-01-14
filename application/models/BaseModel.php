<?php

class BaseModel extends Mongor\Model {


	public static function all(){
		return self::get();
	}

	public static function find($id){

		if(!$id instanceof MongoId){
			$id = new MongoId($id);
		}

		return self::where(array('_id'=> $id))->first();
	}

	public function dateify(){
		if(!($this->_id instanceof MongoId)){
			$this->created = new MongoDate(time());
		}
		$this->updated = new MongoDate(time());
		
		return $this;	
	}

} 