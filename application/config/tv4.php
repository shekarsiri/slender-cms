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
				// slug (should default to sluggified title, but can be set manually) replacement function from fapi - https://github.com/startupdevs/fox-fapi/blob/master/app/src/fox/Fox/Fapi/Util/String.php
				// premiere date

				// @TODO: implement this! why array()??
				// rating 			(?)  array('sdf','asd')
				
				// parent.id
				// parent.type (show, episode, whatever)	(with parent.id pop-up a window with drop-down and a list with ability to choose the parent)
				// genre 			(?) text fields with auto complete  from predefined array
				// urls.source 		(?) str
				// urls.streaming 	(?) str
				// urls.thumbnail   (?) str
			
				// availability.sunrise (?) date picker 
				// availability.sunset
				// created
				// updated
				
				// episode_number	(?) num - !!! remove
				// season 			(?) num - !!! remove

		),
		'channel' => array(
			// + id
			// + title
			// + slug
			// + description
			// + tags
			// + genre
			// + start_date
			// + end_date
			// + updated
			// + created


			// Relations:
			// parents: none
			// children: episodes, videos, shows

			// front end:
			// - slug autogenerate from from title but allow override
			// - taggable
			// - parentable
			// - genre auto complete

		),
		'show' => array(
			// + id
			// + title
			// + slug
			// + description
			// + tags
			// + genre
			// parent.id
			// parent.type (show, episode, whatever)	(with parent.id pop-up a window with drop-down and a list with ability to choose the parent)
			// + start_date
			// + end_date
			// + updated
			// + created


			// Relations:
			// parents: none
			// children: episodes, videos, shows

			// front end:
			// - slug autogenerate from from title but allow override
			// - taggable
			// - parentable
			// - genre auto complete

		),
        'episode' => array(
            //- id
            //- title
            //- slug
            //- description
            //- season
            //- tags (array)
            //- parent.id
            //- parent.type
            //- updated
            //- created

            //Relations:
            //parents: show
            //children: video


            //Front end:
            //- Autocomplete on season based on what is in existing episode records
            //- taggable
            //- slug auto generates from title, but can be overriden. slugs must be unique.
        ),
	),
	'genre_list' => array(
		"Action",
		"Action/Adventure",
		"Adult",
		"Adventure",
		"Catastrophe",
		"Child's",
		"Claymation",
		"Comedy",
		"Concert",
		"Documentary",
		"Drama",
		"Eastern",
		"Entertaining",
		"Erotic",
		"Extremal Sport",
		"Fantasy",
		"Fashion",
		"Historical",
		"Horror",
		"Horror/Mystic",
		"Humor",
		"Indian",
		"Informercial",
		"Melodrama",
		"Military & War",
		"Music Video",
		"Musical",
		"Mystery",
		"Nature",
		"Political Satire",
		"Popular Science",
		"Psychological Thriller",
		"Religion",
		"Science Fiction",
		"Scifi Action",
		"Slapstick",
		"Splatter",
		"Sports",
		"Thriller",
		"Western"
	),
);