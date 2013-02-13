<?php
use Zend\Http\Request as Request;
use Zend\Http\Client as Client;

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
        error_reporting(E_ALL);
        $host = '10.0.2.2:4003/';
        $uri = '/users';
        $headers = array(
            'Authentication: ' . 'key',
            'Host: ' . 'localhost'
        );
        $method = Request::METHOD_GET;

        $request = new Request();
        $request->setUri($host . $uri);
        $request->setMethod($method);
        $request->getHeaders()->addHeaders($headers);
        $client = new Client();
        $client->setAdapter('\Zend\Http\Client\Adapter\Curl');
        $response = $client->dispatch($request);
        $response = $response->isSuccess() ? $response->getBody() : false;

		return View::make('hello');
	}

}