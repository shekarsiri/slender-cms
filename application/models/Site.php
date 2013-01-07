<?php

class Site extends Mongor\Model {

	public static function all(){
		return self::get();
	}

}