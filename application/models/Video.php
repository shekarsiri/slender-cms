<?php

class Video extends BaseModel {

	public static $collection = 'video';

	protected static $parents = array('Site', 'Page');
	protected static $children = array();
}