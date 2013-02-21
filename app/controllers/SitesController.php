<?php

class SitesController extends BaseController {

    protected $package = 'sites'; 
    protected $displayFields = array(
                            'title' => 'Title',
                            'slug' => 'Slug',
                            'url'   => 'URL'
                        );

    public function switchsite($site)
    {
        if (in_array($site, array_keys(Session::get('sites'))) && is_array(Session::get('sites'))) {
            Session::put('site', $site);
        }
        return Redirect::to('/');
    }
}
