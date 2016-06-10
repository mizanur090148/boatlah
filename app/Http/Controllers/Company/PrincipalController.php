<?php

namespace App\Http\Controllers\Company;

use App\Contracts;
use App\Http\Requests;
use App\Principle;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Sentinel;

class PrincipalController extends DashboardController
{

    public function index()
    {
        $data['current_page'] = 'My Principals';
        $principles = Principle::where('company_user_id','=',$this->companyUserID)->get();
        return view('company.dashboard.principal.index', $data)->with('principles',$principles);
    }

    public function create()
    {
        $data['current_page'] = 'My Principals';

        return view('company.dashboard.principal.create', $data);
    }

    public function store()
    {
        //return Input::all();
        $rules = [
            'principle_name' => 'required'
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->withInput()->with('error','Principle can not be created, provide correct data');
        }
        $principles = Principle::firstOrCreate([
                'company_user_id' => $this->companyUserID,
                'title' => Input::get('principle_name')
        ]);

        return redirect('/company/dashboard/my_principals')->with('success',"Principal created successfully");
    }
    
    public function edit($id)
    {
        $data['current_page'] = 'My Principals';
        $principle = Principle::find($id);
        return view('company.dashboard.principal.edit', $data)->with('principle',$principle);
    }

    public function update($id)
    {
        //return Input::all();
        $principle = Principle::find($id);
        $principle->title = Input::get('principle_name');
        $principle->save();

        return redirect('/company/dashboard/my_principals')->with('success',"Principal edited successfully");
    }

    public function destroy($id)
    {
        //return $id;
        Principle::where('id','=',$id)->delete();
        return redirect('/company/dashboard/my_principals')->with('success',"Principal deleted successfully");
    }

}
