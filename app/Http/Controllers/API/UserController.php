<?php

namespace App\Http\Controllers\API;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Validator;
use Auth;
use Sentinel;

use Event;
use App\Events\NewUserRegistered;
use App\Events\UserForgotPassword;

use App\User;
use App\BoatUserProfile;

class UserController extends Controller
{
    /**
     * Perform the login.
     */
    public function register(Request $request)
    {
        $rules = [
            'username' => 'required|unique:users',
            'name' => array('Regex:/^[\pL\s]+$/u'),
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone' => 'required|numeric|unique:users|digits_between:1,20',
            'agree' => 'required',
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return response()->json([
                'error' => [
                    'msg' => 'Validation Failed!',
                    'validation_errors' => $validator->errors()->all()
                ]
            ], 400);
        }

        // Insert into User table
        $api_token = str_random(60);
        $input = [
            'email' => Input::get('email'),
            'password' => Input::get('password'),
            'phone' => Input::get('phone'),            
            'name' => Input::get('name'),
            'username' => Input::get('username'),
            'api_token' => $api_token
        ];

        $user = Sentinel::registerAndActivate($input);
        
        Event::fire(new NewUserRegistered($user->id, 'user'));

        //set consumer device registration id
        $device_type = Input::get('device_type');
        $this->setConsumerDeviceToken($user->id, Input::get('consumer_device_registration_id'), $device_type);

        return response()->json([
            'data' => [
                'status' => 'success',
                'message' => 'Registration success',
                'api_token' => $api_token
            ]
        ], 200);
    }

    /**
     * Perform the login.
     */
    public function login(Request $request)
    {
        $messages = [
            'login.required' => 'Enter Username',
            'password.required' => 'Enter your password',
        ];

        $rules = [
            'login' => 'required',
            'password' => 'required'
        ];

        $validator=Validator::make(Input::all(),$rules,$messages);
        if($validator->fails()){
            return response()->json([
                'error' => [
                    'msg' => 'Validation Failed!'
                ]
            ], 400);
        }

        $input = ['username' => Input::get('login'), 'password' => Input::get('password'), 'status'=>'active'];

        try {
            
            if (Sentinel::authenticate($input)) {
                
                $user = Sentinel::getUser(); 

                $userRole = Sentinel::findRoleBySlug('user');
                if ($user->inRole($userRole)) {

                    $api_token = $this->updateApiToken($user->id);

                    $user->profile = BoatUserProfile::where('user_id', $user->id)->first();

                    //set consumer device registration id
                    $device_type = Input::get('device_type');
                    $this->setConsumerDeviceToken($user->id, Input::get('consumer_device_registration_id'), $device_type);

                    return response()->json([
                        'data' => [
                            'user' => $user,
                            'api_token' => $api_token
                        ]
                    ], 200);
                } else {
                    return response()->json([
                        'error' => [
                            'msg' => 'Sorry! Invalid Boat User.'
                        ]
                    ], 401);
                }
            } else {
                $input2 = ['username' => Input::get('login'), 'password' => Input::get('password'), 'status'=>'pending'];
                $users_check2 =  Sentinel::findByCredentials($input2);
                if($users_check2!=null)
                {
                    return response()->json([
                        'error' => [
                            'msg' => 'User is not activated by Admin yet. Please contact Admin'
                        ]
                    ], 401);
                }
                else
                {
                    return response()->json([
                        'error' => [
                            'msg' => 'Sorry! Incorrect Username and/or Password.'
                        ]
                    ], 401);
                }
            }

        } catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e) {
            return response()->json([
                'error' => [
                    'msg' => 'Account is not activated! Please check your email to activate your account'
                ]
            ], 401);
        } catch (\Cartalyst\Sentinel\Checkpoints\ThrottlingException $e) {
            return response()->json([
                'error' => [
                    'msg' => $e->getMessage()
                ]
            ], 401);
        }

    }

    /**
     * Perform the login.
     */
    public function showProfile()
    {
        $user = Auth::guard('api')->user();
        
        if ($user){ 

            $user->profile = BoatUserProfile::where('user_id', $user->id)->first();
            if($user->profile->photo==''){
                $user->profile->photo = '/images/preview.png';
            }
            
            return response()->json([
                'data' => [
                    'user' => $user,
                ]
            ], 200);
        } else {
            return response()->json([
                'error' => [
                    'msg' => 'Not valid token!'
                ]
            ], 401);
        }
    }

    /**
     * Update Profile
     */
    public function updateProfile()
    {
        $user = Auth::guard('api')->user();
        
        if ($user){ 

            $rules = [
                'username' => 'required|unique:users,username,'.$user->id,
                'email' => 'required|email|unique:users,email,'.$user->id,
                'phone' => 'required|numeric|unique:users,phone,'.$user->id,
                'name' => array('Regex:/^[\pL\s]+$/u'),
            ];

            $validator=Validator::make(Input::all(),$rules);
            if($validator->fails()){
                return response()->json([
                    'error' => [
                        'msg' => 'Validation Error!',
                        'data' => $validator->messages()
                    ]
                ], 401);
            }

            // Insert into User table
            $input = [
                'email' => Input::get('email'),
                'phone' => Input::get('phone'),
                'name' => Input::get('name'),
                'address' => Input::get('address'),
                'username' => Input::get('username'),
            ];
            $user = Sentinel::findById($user->id);
            
            Sentinel::update($user,$input);

            //Insert into Profile Table
            $boat_user = BoatUserProfile::where('user_id', $user->id)->first();

            $boat_user->about = Input::get('about');

            $boat_user->save();

            $user->profile = $boat_user;

            return response()->json([
                'data' => $user
            ], 200);

        } else {
            return response()->json([
                'error' => [
                    'msg' => 'Not valid token!'
                ]
            ], 401);
        }
    }

    /**
     * Update Profile
     */
    public function updatePhoto()
    {
        $user = Auth::guard('api')->user();
        
        if ($user){ 

            $rules = [
                'photo' => 'max:2048|mimes:jpg,jpeg,png,gif'
            ];

            $validator=Validator::make(Input::all(),$rules);
            if($validator->fails()){
                return response()->json([
                    'error' => [
                        'msg' => 'Validation Error!',
                        'data' => $validator->messages()
                    ]
                ], 401);
            }

            //Insert into Profile Table
            $boat_user = BoatUserProfile::where('user_id', $user->id)->first();

            $photo = Input::file('photo');

            $destinationPath = '/uploads/user_images/';
            if($photo!=null)
            {
                $filename = $photo->getClientOriginalName();
                $photo->move(public_path() . $destinationPath, $filename);
                $boat_user->photo = $destinationPath.$filename;
                resize( $destinationPath,$filename,300,'/thumbnail'.$destinationPath);
                $boat_user->thumb_photo = '/thumbnail'.$destinationPath.'thumb_'.$filename;
                $boat_user->save();
                
                return response()->json([
                    'data' => 'Photo Updated Successfully!',
                    'photo' => $boat_user->thumb_photo
                ], 200);

            } else {
                return response()->json([
                    'error' => [
                        'msg' => 'Sorry! Image was not uploaded'
                    ]
                ], 400);
            }

        } else {
            return response()->json([
                'error' => [
                    'msg' => 'Not valid token!'
                ]
            ], 401);
        }
    }

    /**
     * Change Password
     */
    public function changePassword()
    {
        $user = Auth::guard('api')->user();
        
        if ($user){ 

            $rules = [
                'old_password' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
            ];

            $validator=Validator::make(Input::all(),$rules);
            if($validator->fails()){
                return response()->json([
                    'error' => [
                        'msg' => 'Validation Error!',
                        'data' => $validator->messages()
                    ]
                ], 401);
            }

            $oldPassword = Input::get('old_password');
            $password = Input::get('password');
            $passwordConf = Input::get('password_confirm');


            $hasher = Sentinel::getHasher();

            $user = Sentinel::findById($user->id);

            if ($hasher->check($oldPassword, $user->password)){

                Sentinel::update($user, array('password' => $password));
                
                return response()->json([
                    'data' => [
                        'user' => $user,
                    ]
                ], 200);
            } else {
                return response()->json([
                    'error' => [
                        'msg' => 'Sorry! Wrong Passwords.'
                    ]
                ], 401);
            }

        } else {
            return response()->json([
                'error' => [
                    'msg' => 'Not valid token!'
                ]
            ], 401);
        }
    }

    /**
     * Forget Password
     */
    public function forgetPassword(Request $request)
    {
       // return Input::all();
        $rules = [
            'email' => 'required|email',
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return response()->json([
                'error' => [
                    'msg' => 'Validation Error!',
                    'validation_errors' => $validator->messages()
                ]
            ], 401);
        }

        $user = Sentinel::findByCredentials(['email' => Input::get('email')]);
        if($user==null)
        {
            return response()->json([
                'error' => [
                    'msg' => 'No User found with this email!',
                ]
            ], 400);
        }

        Event::fire(new UserForgotPassword($user->id));

        return response()->json([
            'data' => 'Please check your email'
        ], 200);
    }

    /**
     * Logout the user
     */
    public function logout()
    {
        $user = Auth::guard('api')->user();

        $user_data = [
            'api_token' =>  '',
            'consumer_device_registration_id' =>  '',
            'consumer_ios_device_token' =>  '',
        ];

        User::find($user->id)->update($user_data);

        Sentinel::logout();
    }

    /**
     * Update API Token
     */
    public function updateApiToken($user_id)
    {
        $api_token = str_random(60);
                    
        $user_data = [
            'api_token' =>  $api_token,
        ];

        User::find($user_id)->update($user_data);

        return $api_token;
    }

    /**
     * Set Device Registration Id for user
     */
    public function setConsumerDeviceToken($user_id, $device_token, $device_type)
    {
        $user = User::find($user_id);
        if ($device_type=='ios'){
            $user->consumer_ios_device_token = $device_token;
        } else {
            $user->consumer_device_registration_id = $device_token;
        }
        $user->save();
    }

}
