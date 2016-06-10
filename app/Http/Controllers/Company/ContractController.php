<?php

namespace App\Http\Controllers\Company;

use App\Contracts;
use App\Http\Requests;
use Sentinel;


class ContractController extends DashboardController
{


    public function contract()
    {
        $data['current_page'] = 'Contracts';

        $companies = Contracts::where('company_id','=',$this->companyUserID)->groupBy('owner_id')->get();
        return view('company.dashboard.contract.contract', $data)->with('companies',$companies);
    }

    public function activate($id)
    {
        Contracts::where('id','=',$id)->update(['status'=>'active']);
        return redirect('company/dashboard/contracts')->with('success','Contract activated successfully');
    }}
