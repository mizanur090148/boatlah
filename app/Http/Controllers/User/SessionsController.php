<?php

namespace App\Http\Controllers\User;

use App\BoatCoardinatorProfile;
use App\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Validator;
use Sentinel;

class SessionsController extends Controller
{

    protected $redirectPath = '/';

    /**
     * Create a new sessions controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout']]);
    }

    /**
     * Show the login page.
     *
     * @return \Response
     */
    public function login()
    {
        return view('user.auth.login');
    }

    /**
     * Perform the login.
     *
     * @param  Request  $request
     * @return \Redirect
     */
    public function postLogin(Request $request)
    {
        $messages = [
            'login.required' => 'Enter your username',
            'password.required' => 'Enter your password',
        ];

        $rules = [
            'login' => 'required',
            'password' => 'required'
        ];

        $validator=Validator::make(Input::all(),$rules,$messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $input1 = ['username' => Input::get('login'), 'password' => Input::get('password'), 'status'=>'active'];
        $input2 = ['username' => Input::get('login'), 'password' => Input::get('password'), 'status'=>'pending'];
//return $input1;
        try {
            if (Sentinel::authenticate($input1, $request->has('remember'))) {

                Session::flash('flash_message', 'You have successfully signed in');
                //$this->redirectWhenLoggedIn();
                $user = Sentinel::getUser();
                
                //check roles
                $adminRole = Sentinel::findRoleBySlug('admin');
                $userRole = Sentinel::findRoleBySlug('user');
                $ownerRole = Sentinel::findRoleBySlug('owner');
                $companyRole = Sentinel::findRoleBySlug('company');
                $coordinatorRole = Sentinel::findRoleBySlug('coordinator');
                $captainRole = Sentinel::findRoleBySlug('captain');
                $csrRole = Sentinel::findRoleBySlug('csr');

                //If user is coordinator make his profile logged in
                if ($user->inRole($coordinatorRole)) {
                    BoatCoardinatorProfile::where('user_id','=',$user->id)->update(['loggedin'=>'yes']);
                }

                if ($user->inRole($adminRole)) {
                    return redirect('admin/dashboard');
                }  elseif ($user->inRole($ownerRole)) {
                    return redirect('owner/dashboard');
                } elseif ($user->inRole($companyRole)) {
                    return redirect('company/dashboard');
                } elseif ($user->inRole($coordinatorRole)) {
                    BoatCoardinatorProfile::where('user_id','=',$user->id)->update(['loggedin'=>'yes']);
                    return redirect('coordinator/dashboard');
                } elseif ($user->inRole($userRole)) {
                    return redirect('user/dashboard');
                }              
            } else {
                $users_check2 =  Sentinel::findByCredentials($input2);
                if($users_check2!=null)
                {
                    return redirect()->back()->withErrors([
                        'login_error' => 'User is not activated by Admin yet. Please contact Admin',
                    ]);
                }
                else
                {
                    return redirect()->back()->withErrors([
                        'login_error' => 'Sorry! Incorrect Username and/or Password.',
                    ]);
                }
            }
        } catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e) {
            return redirect()->back()->withErrors([
                'login_error' => 'Account is not activated, Please check your email to activate your account',
            ]);
        } catch (\Cartalyst\Sentinel\Checkpoints\ThrottlingException $e) {
            return redirect()->back()->withInput()->withErrorMessage($e->getMessage());
        }

    }

    /**
     * Destroy the user's current session.
     *
     * @return \Redirect
     */
    public function logout()
    {
        $user = Sentinel::getUser();

        if ($user){
            
            //if boat coordinator make his profile logged out
            $coordinatorRole = Sentinel::findRoleBySlug('coordinator');
            if ($user->inRole($coordinatorRole)) {
                $id = $user->getUserId();
                BoatCoardinatorProfile::where('user_id','=',$id)->update(['loggedin'=>'no']);
            }

            Sentinel::logout();
            
            Session::flash('flash_message', 'You have now been signed out. See ya.');
        }

        return redirect('login');
    }

}