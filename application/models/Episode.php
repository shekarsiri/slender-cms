<?php

class Episode extends BaseModel {

	public static $collection = 'episode';

	protected static $parents = array('Show');
	protected static $children = array('Video');
}