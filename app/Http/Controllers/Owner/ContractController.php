<?php

namespace App\Http\Controllers\Owner;

use App\Contracts;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Sentinel;


class ContractController extends DashboardController
{


    public function contract()
    {
        $data['current_page'] = 'Contracts';

        $companies = Contracts::where('owner_id', '=', $this->ownerUserID)->groupBy('company_id')->get();
        return view('owner.dashboard.contract.contract', $data)->with('companies', $companies);
    }

    public function addContracts()
    {
        $data['current_page'] = 'Add Contracts for Company';
        $companies = \App\ShippingCompanyProfile::all();
        return view('owner.dashboard.contract.add_contracts', $data)->with('companies', $companies);
    }

    public function postAddContracts()
    {
        //return Input::all();
        $company_id = Input::get('company_id');
        $check = Contracts::where('owner_id','=',$this->ownerUserID)->where('company_id','=',$company_id)->first();
        if($check!=null)
        {
            return redirect('/owner/dashboard/contracts')->with('error', 'Company Already Added');
        }
        $contracts = new Contracts();
        $contracts->owner_id = $this->ownerUserID;
        $contracts->company_id = $company_id;
        $contracts->credit_limit = Input::get('credit_limit');
        $contracts->aging_limit = Input::get('aging_limit');
        $contracts->contract_code  = uniqid('boatlah',true);
        $contracts->invoice_prefix  = Input::get('invoice_prefix');
        $contracts->save();

        return redirect('/owner/dashboard/contracts')->with('success', 'Company Added to Contracts');
    }
}
