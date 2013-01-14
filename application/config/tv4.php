<?php

return array(
	'modules'	=> array(
		'user' => array(),		
		'site' => array(
				'name' 	=> '',
				'url'	=> '',
			),
		'page' => array(
				// title
				// meta.title
				// meta.keywords
				// body
				// slug (should default to sluggified title, but can be set manually) replacement function from fapi - https://github.com/startupdevs/fox-fapi/blob/master/app/src/fox/Fox/Fapi/Util/String.php
				// availability.sunrise
				// availability.sunset
				// created
				// updated
			),
		'video' => array(
				// title
				// description
				// tags
				// slug (should default to sluggified title, but can be set manually) replacement function from fapi - https://github.com/startupdevs/fox-fapi/blob/master/app/src/fox/Fox/Fapi/Util/String.php
				// premiere date
				// rating 			(?)  array('sdf','asd')
				// parent.id
				// parent.type (show, episode, whatever)	(with parent.id pop-up a window with drop-down and a list with ability to choose the parent)
				// genre 			(?) text fields with auto complete  from predefined array
				// episode_number	(?) num - !!! remove
				// season 			(?) num - !!! remove
				// urls.source 		(?) str
				// urls.streaming 	(?) str
				// urls.thumbnail   (?) str
				// availability.sunrise (?) date picker 
				// availability.sunset
				// created
				// updated
			),

		),
);