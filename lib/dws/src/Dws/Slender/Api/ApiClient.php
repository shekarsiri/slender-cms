<?php namespace Dws\Slender\Api;

use Zend\Http\Request as Request;
use Zend\Http\Client as Client;
use Zend\Http\Server\Client as ServerClient;
// use Dws\Slender\Api\ApiException;

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
        $this->request->getPost()->fromArray($params);
        $this->client->setEncType("multipart/form-data");   
        return $this->run();
    }

    public function put($path, array $params = array()){
        $this->request->setMethod(Request::METHOD_PUT);
        $this->request->setUri($this->getUri($path));
        $this->request->setContent(json_encode($params));
        return $this->run();
    }
    
    private function run(){
        $response = $this->client->dispatch($this->request);
        if($response->isSuccess()){
            return json_decode($response->getBody());
        }else{
            $error = json_decode($response->getBody());
            throw new ApiException($error);
        }

        return $response->isSuccess() ? $response->getBody() : false;
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


