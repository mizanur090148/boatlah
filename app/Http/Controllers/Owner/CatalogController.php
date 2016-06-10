<?php

namespace App\Http\Controllers\Owner;

use App\CatalogsParent;
use App\Contracts;
use App\ShippingCompanyProfile;
use App\User;
use File;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Validator;
use Illuminate\Http\Request;
use Sentinel;

use App\Boat;
use App\Catalog;
use App\CatalogInfo;
use \App\BaseAnchorage;

class CatalogController extends DashboardController
{

    /**
     * All Catalogs
     */
    public function index()
    {
        $data['current_page'] = 'Tariff Tables';
        $catalogs_id = \App\lib\Catalog::create_catalog_parent('',$this->ownerUserID,null,'standard');
        $data['standard_western'] = \App\lib\Catalog::create_catalog($catalogs_id,'Western');
        $data['standard_eastern'] = \App\lib\Catalog::create_catalog($catalogs_id,'Eastern');
        $data['catalogs'] = CatalogsParent::where('company_id', '=', $this->ownerUserID)->groupBy('company_id')->get();
        return view('owner.dashboard.catalog.index', $data);
    }

    /**
     * Show A Catalog
     */
    public function show($catalog_id)
    {
        $data['current_page'] = 'Tariff Tables';
        return view('owner.dashboard.catalog.show', $data);
    }

    /**
     * Edit A Catalog
     */
    public function edit($catalog_id)
    {
        $data['current_page'] = 'Tariff Tables';
        $catalog = Catalog::where('id','=',$catalog_id)->first();
        $anchorages = BaseAnchorage::where('type','=',$catalog->zone)->get();
        return view('owner.dashboard.catalog.edit', $data)->with('catalog',$catalog)->with('anchorages',$anchorages);
    }

    /**
     * Updates the catalog
     */
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

            $catalogs = \App\Catalog::where('id','=',$id)->first();
            $catalogs->status = 'active';
            $catalogs->save();
        }
        
        return redirect('/owner/dashboard/catalogs')->with('success','Catalog Updated Successfully');
    }

    public function activate($catalog_id)
    {
        $catalogs = \App\Catalog::where('id','=',$catalog_id)->first();
        $catalogs->status = 'active';
        $catalogs->save();
        return redirect('/owner/dashboard/catalogs')->with('success','Catalog Activated Successfully');

    }
    /**
     * excel upload
     */
    public function excelUpload($catalog_id)
    {
      // parse excel file and insert in database
    }

    /**
     * Removes a catalog
     */
    public function destroy($catalog_id)
    {
        //code for destroy
    }

}
