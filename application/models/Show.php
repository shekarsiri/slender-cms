<?php

class Show extends BaseModel {

	public static $collection = 'show';

	protected static $parents = array('Channel');
	protected static $children = array('Episode', 'Video');
}