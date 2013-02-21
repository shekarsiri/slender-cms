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

    public function store()
    {
        $data = Input::all();

        try {
            $response = $this->api->post($this->package, $data);
            $sites = Session::get('sites');
            $sites[$data['slug']] = $data['title'];
            Session::put('sites', $sites);
        } catch (ApiException $e) {
            $errors = new MessageBag;
            $messages = $e->getMessages();
            foreach ($messages[0] as $key => $value) {
                foreach ($value as $msg) {
                    $errors->add($key, $msg);
                }
            }
            return Redirect::to($this->package."/create")->withErrors($errors);
        }
        return Redirect::to($this->package)->with('success', 'The data successfully saved!');
    }
}
