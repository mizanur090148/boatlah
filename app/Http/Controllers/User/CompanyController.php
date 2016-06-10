<?php

namespace App\Http\Controllers\User;

use Event;
use App\Events\UserCompanyInteraction;

use App\Http\Requests;
use Sentinel;

use App\BoatUserProfile;
use App\Approval;
use App\ShippingCompanyProfile;

class CompanyController extends DashboardController
 {

    public function index() 
    { 
        $data['current_page'] = 'My Company';
        
        $has_company = BoatUserProfile::where('user_id','=',$this->boatUserID)->first();
        if($has_company)
        {
            $data['my_company'] = ShippingCompanyProfile::where('user_id', $has_company->company_id)->first();
        }
        
        $data['all_companies'] = ShippingCompanyProfile::all();
        $data['check_remove'] = Approval::where('user_id','=',$this->boatUserID)->where('type','=','delete')->first();
        $data['check_approve'] = Approval::where('user_id','=',$this->boatUserID)->where('type','=','approve')->first();

        return view('user.dashboard.company.index', $data);
    }

    public function connect($company_id)
    {
        $approval = new Approval();
        $approval->user_id = $this->boatUserID;
        $approval->company_id = $company_id;
        $approval->type = 'approve';
        $check = Approval::where('user_id','=',$this->boatUserID)->where('company_id','=',$company_id)->first();
        if($check==null) {
            $approval->save();
            Event::fire(new UserCompanyInteraction($approval->company_id, $approval->user_id ,'user_request_connect'));
        }
        
        return redirect('/user/dashboard/company')->with('success','company connect request sent successfully');
    }


    public function remove()
    {
        $approval = new Approval();
        $approval->user_id = $this->boatUserID;
        $my_companies = BoatUserProfile::where('user_id','=',$this->boatUserID)->first();
        $approval->company_id = $my_companies->company_id;
        $approval->type = 'delete';
        $check = Approval::where('user_id','=',$this->boatUserID)->where('company_id','=',$my_companies->company_id)->first();
        if($check==null) {
            $approval->save();
            Event::fire(new UserCompanyInteraction($approval->company_id, $approval->user_id ,'user_request_remove'));
        }
        return redirect('/user/dashboard/company')->with('success','company connect request remove successfully');
    }

    public function delete($id)
    {
        $approve = Approval::find($id);
        $approve->delete();
        return redirect('/user/dashboard/company')->with('success','company connect request remove successfully');
    }


}
