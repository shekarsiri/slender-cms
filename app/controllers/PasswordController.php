<?php

class PasswordController extends BaseController {

    protected $messageBag;

    public function __construct(MessageBag $messageBag)
    {
        $this->messageBag = $messageBag;
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

            $data = array('link' => 'sha1');

            if (false) {
                $this->messageBag->add('email', "the provided email doesn't exists");    
                return Redirect::route('forgotpassword')->withErrors($this->messageBag);
            }

            Mail::send('emails.auth.reminder', $data, function($m)
            {
                $m->to('jsamos@gmail.com', 'Juni Samos')->subject('Welcome!');
            });

           return Redirect::route('forgotpassword')->with('success', 'Please check your email for instructions on how to reset your password.'); 

        }
                
    }

}