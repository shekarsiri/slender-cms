<?php namespace Dws\Slender\Api;

use \Exception as GenericException;
use Illuminate\Support\MessageBag;

class ApiException extends GenericException{

    protected $messages = array();

    public function __construct($message = null, $code = 0, Exception $previous = null){
        // if($message instanceof MessageBag){
        //     $message->setFormat(':message');
        //     $this->messages = $message->getMessages();
        // }
        parent::__construct("Validation Error", $code, $previous);
        // var_dump($message);
    }

    public function getMessages(){
        return $this->messages;
    }

}
