<?php

namespace App\Http\Controllers\Company;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Validator;
use Sentinel;

use App\BoatUserProfile;
use App\Approval;

use Event;
use App\Events\UserCompanyInteraction;

class EmployeeController extends DashboardController
 {

    public function index() 
    { 
        $data['current_page'] = 'My Employee';

        $data['my_employee'] = BoatUserProfile::where('company_id', $this->companyUserID)->get();

        return view('company.dashboard.employee.index', $data);
    }

    public function delete($id)
    {
        $company_input = [
            'company_id' => NULL
        ];
        BoatUserProfile::where('id','=',$id)->update($company_input);

        return redirect('/company/dashboard/my_employee')->with('success','Employee Data deleted successfully');
    }

    public function connect_employee()
    {
        $data['current_page'] = 'Connect Employee';

        $data['my_employee'] = BoatUserProfile::where('company_id', $this->companyUserID)->get();

        return view('company.dashboard.employee.connect_employee', $data);
    }

    public function post_connect_employee()
    {
        //return Input::all();
        $messages = array(
            'required' => 'The attribute field is required.',
        );
        $rules = [
          'name' => 'required'
        ];

        $validator=Validator::make(Input::all(),$rules,$messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->with('error','connect employee can not be completed, provide correct data');
        }

        $email = Input::get('name');
        $phone = Input::get('name');
        $user = \App\User::where('email','=',$email)->orWhere('phone','=',$phone)->first();

        $input = [
            'company_id' => $this->companyUserID
        ];
        if($user!=null) {
            $boatUser = BoatUserProfile::where('user_id', $user->id)->first();
            if($boatUser==null)
            {
                return redirect()->back()->withErrors($validator)->withInput()->with('error', 'User Found but not a boat user');

            }

            if ($boatUser->company_id != NULL) {
                return redirect()->back()->withErrors($validator)->withInput()->with('success', 'User is already connected to another company');
            }
            BoatUserProfile::where('user_id', $user->id)->update($input);
            $data['name'] = 'hello';
            $rules2 = [
                'name' => 'email'
            ];
            $validator2=Validator::make(Input::all(),$rules2);

            if($validator2->fails()){
                return redirect()->back()->withInput()->with('success', 'User connected successfully, Email request can not be sent, not valid email');
            }

            Mail::send('email.connect_employee', $data, function($message) {
                $message->to(Input::get('name'), 'test')
                    ->subject('Connection To Company Confirmation');
            });
            return redirect('/company/dashboard/connect_employee')->with('success','User connected successfully, email sent');
        }
        else
        {
            $data['confirmation_code'] = 'hello';
            $data['id'] = 'dsfgb';
            $rules2 = [
                'name' => 'email'
            ];
            $validator2=Validator::make(Input::all(),$rules2);

            if($validator2->fails()){
                return redirect('/company/dashboard/connect_employee')->with('error', 'Email request can not be sent, not valid email');
            }

            Mail::send('email.connect_employee_join', $data, function($message) {
                $message->to(Input::get('name'), 'test')
                    ->subject('Invitation to join Boatlah');
            });
            return redirect('/company/dashboard/connect_employee')->with('success','Email request has been sent');
        }
    }
    public function pendingApproval() 
    { 
        $data['current_page'] = 'Pending Approval';

        $data['approve_lists'] = Approval::where(['company_id' => $this->companyUserID, 'type' => 'approve'])->with('userProfile','userProfile.user')->get();

        return view('company.dashboard.employee.pending_approval', $data);
    }

    public function approve($id)
    {
        $approve = Approval::where('user_id', $id)->delete();
        $input = [
          'company_id' => $this->companyUserID
        ];
        BoatUserProfile::where('user_id', $id)->update($input);
        Event::fire(new UserCompanyInteraction($this->companyUserID, $id, 'company_approve_user'));
        return redirect('/company/dashboard/approve_list')->with('success','Employee connection approved');
    }
    public function approve_delete($id)
    {
        $approve = Approval::where('user_id', $id)->delete();
        return redirect('/company/dashboard/approve_list')->with('success','Employee connection deleted');
    }

    public function removeList()
    {
        $data['current_page'] = 'Pending Removal';
        $data['remove_lists'] = Approval::where(['company_id' => $this->companyUserID, 'type' => 'delete'])->get();
        return view('company.dashboard.employee.pending_removal', $data);
    }

    public function remove($id)
    {
        $approve = Approval::where('user_id', $id)->delete();
        $input = [
            'company_id' => NULL
        ];

        BoatUserProfile::where('user_id', $id)->update($input);
        Event::fire(new UserCompanyInteraction($this->companyUserID, $id, 'company_remove_user'));
        return redirect('/company/dashboard/remove_list')->with('success','Employee connection removed');
    }
}
