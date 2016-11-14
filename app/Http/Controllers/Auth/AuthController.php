<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use View;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Auth Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    public function login()
    {
        if (Auth::check())
            return Redirect::to('admin');


        return View::make('backend.login');
    }

    public function handleLogin(Request $request)
    {

        $rules = array(
            'username' => 'required',
            'password' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('login')
                ->withErrors($validator)// send back all errors to the login form
                ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {

            $userdata = $request->only('username', 'password');

            if (Auth::attempt($userdata)) {
                if (Auth::check()) { //check if the user is already logged in
                    $user_id = Auth::user()->user_id;

                    Session::put('current_user', $userdata['username']);
                    Session::put('current_user_id', $user_id);
                    return Redirect::intended('/admin');
                }
            } else {
                return Redirect::to('login')->withError(['password' => 'Username or Password is invalid']);
            }

        }
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to('login');
    }
}
