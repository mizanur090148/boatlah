<?php

namespace App\Http\Controllers\Company;

use App\BaseAnchorage;
use App\BoatOwnerProfile;
use App\CatalogInfo;
use App\CatalogRelation;
use App\CatalogsParent;
use App\Contracts;
use App\Http\Requests;
use App\lib\Catalog;
use App\Principle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;
use Sentinel;


class CatalogController extends DashboardController
{

    public function index()
    {
        $data['current_page'] = 'My Tariff Tables';
        $data['catalogs'] = CatalogsParent::where('company_id', '=', $this->companyUserID)->groupBy('owner_id')->get();
        return view('company.dashboard.catalog.index', $data);
    }

    public function create()
    {
        $data['current_page'] = 'My Tariff Tables';
        $data['owners'] = Contracts::where('company_id','=',$this->companyUserID)->where('status','=','active')->get();
        return view('company.dashboard.catalog.create', $data);
    }


    public function store(Request $request)
    {
        //return Input::all();
        $rules = [
            'owner_name' => 'required',
            'catalog_name' => 'required'
        ];

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'connect owner can not be completed, provide correct data');
        }
        $owner_id = Input::get('owner_name');
        $catalog_name = Input::get('catalog_name');
        Catalog::manage_catalog_with_company($catalog_name, $this->companyUserID, $owner_id);
        return redirect('/company/dashboard/catalogs')->with('success', 'Catalogs creation successful');
    }

    public function change_principle($owner_id, $catalogs_parent_id)
    {
        $data['current_page'] = 'My Tariff Tables';
        $catalogs_parents = CatalogsParent::where('owner_id','=',$owner_id)->where('company_id', $this->companyUserID)->get();
        $principles = Principle::where('company_user_id','=',$this->companyUserID);
        foreach($catalogs_parents as $catalogs_parent) {
            $catalogs_relations = CatalogRelation::where('catalogs_parent_id', '=', $catalogs_parent->id)->get();
            foreach ($catalogs_relations as $catalogs_relation) {
                $principles = $principles->where('id', '!=', $catalogs_relation->principle_id);
            }
        }
        $data['principles'] = $principles->get();
        $catalogs_parent = CatalogsParent::where('id','=',$catalogs_parent_id)->first();
        return view('company.dashboard.catalog.change_principle', $data)->with('catalogs_parent',$catalogs_parent);
    }

    public function change_principle_post($catalogs_parent_id)
    {
        //return Input::all();
        $rules = [
            'principle_name' => 'required',
        ];

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'connect principle can not be completed, provide correct data');
        }
        $principles = Input::get('principle_name');
        Catalog::create_catalog_relation($catalogs_parent_id,$principles);
        Catalog::make_catalog_pending_by_parent_id($catalogs_parent_id);
        return redirect('/company/dashboard/catalogs')->with('success', 'Principle Assigned Successfully');
    }

    public function remove_principle($catalogs_parent_id,$principle_id)
    {
        CatalogRelation::where('catalogs_parent_id','=',$catalogs_parent_id)->where('principle_id','=',$principle_id)->delete();
        Catalog::make_catalog_pending_by_parent_id($catalogs_parent_id);
        return redirect('/company/dashboard/catalogs')->with('success', 'Principle Removed Successfully');
    }

    public function edit($catalog_id)
    {
        $data['current_page'] = 'My Tariff Tables';
        $catalog = \App\Catalog::where('id','=',$catalog_id)->first();
        $anchorages = BaseAnchorage::where('type','=',$catalog->zone)->get();
        return view('company.dashboard.catalog.edit', $data)->with('catalog',$catalog)->with('anchorages',$anchorages);
    }

    public function update(Request $request, $id)
    {
        //return Input::all();
        $anchorages = Input::get('anchorage_code');
        //return $anchorages;
        foreach($anchorages as $anchorage)
        {
            $info = CatalogInfo::firstOrCreate(['catalogs_id'=>$id,'anchorage_code'=>$anchorage]);
            $info->normal_rates = Input::get('normal_rates_'.$anchorage);
            $info->aoh_rates = Input::get('aoh_rates_'.$anchorage);
            $info->charges_withing_same_anchorages = Input::get('charges_withing_same_anchorages_'.$anchorage);
            $info->free_waiting_time = Input::get('free_waiting_time_'.$anchorage);
            $info->per_block_of_extra_time = Input::get('per_block_of_extra_time_'.$anchorage);
            $info->per_block_of_waiting_time_charges_normal = Input::get('per_block_of_waiting_time_charges_normal_'.$anchorage);
            $info->per_block_of_waiting_time_charges_aoh = Input::get('per_block_of_waiting_time_charges_aoh_'.$anchorage);
            $info->fuel_surcharge = Input::get('fuel_surcharge_'.$anchorage);
            $info->extra_boatman_charges = Input::get('extra_boatman_charges_'.$anchorage);
            $info->save();

            Catalog::make_catalog_pending_by_catalog_id($id);
        }

        return redirect('/company/dashboard/catalogs')->with('success', 'Catalog Updated Successfully');
    }


    public function excelUpload($catalog_id)
    {
        // parse excel file and insert in database
    }

    public function destroy($catalogs_parent_id)
    {
        CatalogsParent::where('id','=',$catalogs_parent_id)->delete();
        return redirect('/company/dashboard/catalogs')->with('success', 'Catalog Deleted Successfully');
    }

}
