<?php

namespace App\Http\Controllers\User;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Sentinel;

use Event;
use App\Events\UserVerifiedMail;


class ActivationController extends Controller
{

    public function activate()
    {
        $code = Input::get('code');
        $login = Input::get('login');

        if (!($user = Sentinel::findById($login)))
        {
            return redirect('/login')->with('error','User not found!');
        }

        if (!Activation::complete($user, $code))
        {
            if (Activation::completed($user))
            {
                return redirect('/login')->with('error','User is already activated. Try to log in.');
            }

            return redirect('/login')->with('error','Activation error!');
        }

        Event::fire(new UserVerifiedMail($user->id));
        
        //redirect to login page with this success message
        return redirect('/login')->with('success','Activation Successful. Try to log in.');
    }

}
