<?php

class Video extends Mongor\Model {

	public static $collection = 'video';

	public static function all(){
		return self::get();
	}

	public static function find($id){

		if(!$id instanceof MongoId){
			$id = new MongoId($id);
		}

		return self::where(array('_id'=> $id))->first();
	}

}