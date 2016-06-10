<?php

namespace App\Http\Controllers\CaptainAPI;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Validator;
use Sentinel;

use App\User;
use App\Boat;
use App\BoatCaptainProfile;
use App\RelBoatsCaptains;

class LoginController extends CaptainAPIController
{

    /**
     * Perform the login.
     */
    public function login(Request $request)
    { 
        //Validation
        $messages = [
            'login.required' => 'Enter your username',
            'password.required' => 'Enter your password',
        ];

        $rules = [
            'login' => 'required',
            'password' => 'required',
            'boat_unique_id' => 'required',
            'device_registration_id' => 'required'
        ];

        $validator=Validator::make(Input::all(),$rules,$messages);
        if($validator->fails()){
            $msg = [
                'data' =>  'Validation Error!',
                'validation_errors' => $validator->messages()
                ];
            return $this->apiResponse('error', '400', $msg);
        }
        //End
        
        $input = ['username' => Input::get('login'), 'password' => Input::get('password'), 'status'=>'active'];

        try {
            if (Sentinel::authenticate($input)) {

                $user = Sentinel::getUser();

                $boat = Boat::where('unique_id', Input::get('boat_unique_id'))->first();
                if(!$boat){
                    return $this->apiResponse('error', '401', 'Sorry! This boat unique id does not exist.');
                } 
                $boat_id = $boat->id;            
                
                $userRole = Sentinel::findRoleBySlug('captain');
                if ($user->inRole($userRole)) {
                    $is_captain = $this->isIamCaptainofThisBoat($user->id, $boat_id);
                    
                    if ($is_captain){
                        $api_token = $this->setApiToken($user->id, 'login');

                        $this->setBoatCaptain($boat_id, $user->id);

                        $this->setDeviceRegistrationId($user->id, Input::get('device_registration_id'));

                        $responseData = [
                                'user' => $user,
                                'api_token' => $api_token
                            ];

                        return $this->apiResponse('success', '200', $responseData);
                    } else {
                        return $this->apiResponse('error', '401', 'Sorry! You are not captain of this boat.');
                    }                    
                } else {
                    return $this->apiResponse('error', '401', 'Sorry! Invalid Captain Account!');
                }
            } else {
                $input2 = ['username' => Input::get('login'), 'password' => Input::get('password'), 'status'=>'pending'];
                $users_check2 =  Sentinel::findByCredentials($input2);
                if($users_check2!=null)
                {
                    return $this->apiResponse('error', '401', 'User is not activated by Admin yet. Please contact Admin');
                }
                else
                {
                    return $this->apiResponse('error', '401', 'Sorry! Incorrect Username and/or Password.');
                }
            }
        } catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e) {
            return $this->apiResponse('error', '401', 'Account is not activated, Please check your email to activate your account');
        } catch (\Cartalyst\Sentinel\Checkpoints\ThrottlingException $e) {
            return $this->apiResponse('error', '401', $e->getMessage());
        }

    }

    /**
     * Show Captain Profile
     */
    public function showProfile()
    {
        $user = Auth::guard('api')->user();

        if ($user){ 
            $user->profile = BoatCaptainProfile::where('user_id', $user->id)->first();

            $responseData = ['user' => $user];

            return $this->apiResponse('success', '200', $responseData);
        } else {
            return $this->apiResponse('error', '401', 'No Valid Token');
        }
    }

    /**
     * Logout the user
     */
    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();

        $boat = Boat::where('unique_id', Input::get('boat_unique_id'))->first();
        if (!$boat){
            return $this->apiResponse('error', '401', 'Sorry! This boat unique id does not exist.');
        } else {
            $this->setApiToken($user->id, 'logout');
            $this->setBoatCaptain($boat->id);
            $this->setDeviceRegistrationId($user->id, '');
            return $this->apiResponse('success', '200', 'Logged Out Successfully');
        }
    }

    /**
     * Set API Token
     */
    public function setApiToken($user_id, $type)
    {
        ($type=='login') ? $api_token = str_random(60) : $api_token = '';                  
        
        $user_data = [
            'api_token' =>  $api_token,
        ];

        User::find($user_id)->update($user_data);

        if($type=='login'){
            return $api_token;
        }
    }

    /**
     * Check If this captain is assigned to this boat
     */
    public function isIamCaptainofThisBoat($user_id, $boat_id)
    {
        $relation = RelBoatsCaptains::where([
                   'boat_id' => $boat_id, 
                   'captain_id' => $user_id
               ])->first();
        
        return $relation;
    }

    /**
     * Set Boat Captain
     */
    public function setBoatCaptain($boat_id, $user_id=NULL)
    {
        $boat_data = [
            'captain_id' =>  $user_id,
            'status' => 'available'
        ];

        Boat::find($boat_id)->update($boat_data);
    }

    /**
     * Set Device Registration Id for captain
     */
    public function setDeviceRegistrationId($user_id, $device_registration_id)
    {
        $captain = User::find($user_id);
        $captain->device_registration_id = $device_registration_id;
        $captain->save();
    }

    

}
