<?php namespace Dws\Slender\Api;

use Zend\Http\Request as Request;
use Zend\Http\Client as Client;

class ApiClient {

    protected $host;
    protected $auth;
    protected $site;

    protected $request;
    protected $client;

    public function __construct($host, $auth=null, $site=null)
    {
        $this->host = $host;
        $this->auth = $auth;
        $this->site = $site;

        $this->request = new Request();
        $this->request->setMethod('GET');
        $this->request->getHeaders()->addHeaders(array('Authentication: ' . $this->auth));
        $this->client = new Client();
        $this->client->setAdapter('\Zend\Http\Client\Adapter\Curl');
    }

    public function setAuth($auth){
        $this->auth = $auth;
    }

    public function get($path){
        $this->request->setMethod('GET');
        $this->request->setUri($this->getUri($path));
        return $this->run();
    }

    public function post($path, array $params = array()){
        $this->request->setMethod(Request::METHOD_POST);
        $this->request->setUri($this->getUri($path));
        $this->client->setParameterPost($params);
        return $this->run();
    }

    private function run(){
        $response = $this->client->dispatch($this->request);

        if($response->isSuccess()){

        }else{
            $error = json_decode($response->getBody());
            // throw new \Exception("Error Processing Request", 1);
            
            throw new ApiException($error);
        }
        var_dump($response, $response->getBody());

        return $response->isSuccess() ? $response->getBody() : false;
        // if ($response) {
        //     return Json::decode($response, true);
        // } else {
        //     return false;
        // }
    }

    private function getUri($path, $site=null){
        $uri = array($this->host);
        if($this->site){
            $uri[] = $this->site;
        }
        $uri[] = $path;
        return implode("/", $uri);
    }
}


