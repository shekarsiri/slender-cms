<?php

class Channel extends BaseModel {

	public static $collection = 'channel';

	protected static $parents = array();
	protected static $children = array('episodes', 'videos', 'shows');
}