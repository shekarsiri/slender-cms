<?php

class Episode extends BaseModel {

	public static $collection = 'episode';

	protected static $parents = array('Show');
	protected static $children = array('Video');

    /**
     * getting seasons depends on show id
     *
     * @param int $showId
     * @return mixed list of seasons where parent show id = $showId
     */
    public function getSeasons($showId = null) {
        if ($showId) {
            return $this->where(array('parent.id'=> $showId))->get();
        }
        else {
            return $this->all();
        }
    }
}