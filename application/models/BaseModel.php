<?php

class BaseModel extends Mongor\Model {


	protected static $parents = array();
	protected static $children = array();

	public function getParents(){
		return $this::$parents;
	}

	public function getParent(){
		$id = $this->parent['id'];
		$type = $this->parent['type'];
		return ($type && $id) ? $type::find($id) : null;
	}

	public static function getChildren(){
		return $this::$children;
	}

	public static function all(){
		return self::get();
	}
	
	// public function toArray(){

	// }

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