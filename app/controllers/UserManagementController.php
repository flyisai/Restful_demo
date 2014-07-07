<?php

class UserManagementController extends \BaseController {

	public function registerUser() {
        if (Request::getMethod() === "GET") {        
            return View::make('usermanagement.registeruser');  
        } elseif (Request::getMethod() === "POST") {
            
            $rules = array(
                'email' => 'email|unique:users|required',
                'password' => 'required',
                'password_again' => 'required|same:password'
            );
            $messages = array();
            $validator = Validator::make(Input::all(), $rules, $messages);                    
            if ($validator->fails()) {
                return Redirect::route('registerUser')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $user = Sentry::createUser(array(
                    'email'     => Input::get('email'),
                    'password'  => Input::get('password'),
                    'activated' => true,
                ));
                return View::make('usermanagement.registeruserthanks');  
            }
        }

	}

    /**
    * Page where user can enter their email to reset their password
    */
    public function resetPassword() {
        if (Request::getMethod() === "GET") {
            return View::make('usermanagement.resetpassword');  
        } elseif (Request::getMethod() === "POST") {
            $rules = array(
                'email' => 'email|exists:users|required',
            );
            $messages = array();
            $validator = Validator::make(Input::all(), $rules, $messages);                    
            if ($validator->fails()) {
                return Redirect::route('resetPassword')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $user = Sentry::findUserByLogin(Input::get('email'));
                $resetCode = $user->getResetPasswordCode();
                $data = array(
                    'resetCode' => $resetCode
                );
                Mail::send('emails.auth.resetpasswordemail', $data, function($message) {
                    $message->from('DONOTREPLY@example.com', 'Dr. Jujur');
                    $message->to(Input::get('email'))->subject('Reset your Dr. Jujur password');
                });             
                return View::make('usermanagement.resetpasswordemailsent');  
            }
        }
    }

    /**
    * Page user is directed to from password reset email where they can enter a new password
    */
    public function resetPasswordConfirm($resetCode) {
        if (Request::getMethod() === "GET") {
            return View::make('usermanagement.resetpasswordconfirm');
        } elseif (Request::getMethod() === "POST") {
            $rules = array(
                'password' => 'required',
                'password_again' => 'required|same:password'            );
            $messages = array();
            $validator = Validator::make(Input::all(), $rules, $messages);                    
            if ($validator->fails()) {
                return Redirect::route('resetPasswordConfirm')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                try {
                    $user = Sentry::findUserByResetPasswordCode($resetCode);
                } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                    App::abort('401');
                }
                $user->attemptResetPassword($resetCode, Input::get('password'));                
                return Redirect::route('resetPasswordThanks');
            }
        }
    }

    /**
    * Simple page where we thank user for resetting password
    */
    public function resetPasswordThanks() {
        return View::make('usermanagement.resetpasswordthanks');  
    }

    public function login() {
        
        if (Request::getMethod() === "GET") {
            return View::make('usermanagement.login');
        } elseif (Request::getMethod() === "POST") {
            
            $rules = array(
                'username' => 'required',
                'password' => 'required'
            );
            $messages = array();
            $validator = Validator::make(Input::all(), $rules, $messages);                    
            if ($validator->fails()) {
                return Redirect::route('login')
                    ->withErrors($validator)
                    ->withInput();
            } else {       
                try {
                    // Login credentials
                    $credentials = array(
                        'email'    => Input::get('username'),
                        'password' => Input::get('password'),
                    );
                    
                 
                    // Authenticate the user
                    $user = Sentry::authenticate($credentials, false);
                } 
                catch (Exception $e) 
                {
                    $messages = \App::make('Illuminate\Support\MessageBag');
                    $messages->add('validationError', 'Incorrect username or password.');
                    return Redirect::route('login')
                        ->withErrors($messages)->withInput();
                }       

                return Redirect::route('manageUserProfile');
            }
        } 
    }

    /**
    * Allows user to update their information
    */
    public function manageUserProfile() {
        //
        $user = Sentry::getUser();
        print_r($user->email);
        return View::make('usermanagement.login');
    }
}
