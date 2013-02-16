<?php

class PasswordController extends BaseController {

    protected $messageBag;

    public function __construct(MessageBag $messageBag)
    {
        $this->messageBag = $messageBag;
        parent::__construct();
    }

    public function forgot()
    {
        return View::make('password.forgot');
    }

    public function send()
    {

        $rules = array(
            'email'    => 'Required|Email',
        );

        $validator = Validator::make(Input::all(), $rules);

        if (!$validator->passes()) {

            return Redirect::route('forgotpassword')->withErrors($validator->messages());
            
        } else {

            $email = Input::get('email');

            $response = $this->api->get("users?where[]=email:{$email}");
            
            if ($response->meta->count === 0) {
                $this->messageBag->add('email', "the provided email does not exist");    
                return Redirect::route('forgotpassword')->withErrors($this->messageBag);
            }

            $data = array('link' => Crypt::encrypt($email));

            /*
            Mail::send('emails.auth.reminder', $data, function($m)
            {
                $m->to('jsamos@gmail.com', 'Juni Samos')->subject('Welcome!');
            });
            */

           return Redirect::route('forgotpassword')->with('success', "Please check your email for instructions on how to reset your password. {$data['link']}"); 

        }
                
    }

    public function reset($data)
    {

    }

}