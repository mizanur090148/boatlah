<?php

namespace App\Http\Controllers\Owner;

use File;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Illuminate\Http\Request;
use Sentinel;

use App\Boat;

class BoatController extends DashboardController {

    public function index() { 
        $data['current_page'] = 'Boats';
        $data['boats'] = Boat::where('user_id', $this->ownerUserID)->orderBy('status')->get();
        return view('owner.dashboard.boat.index', $data);
    }

    public function add() { 
        $data['current_page'] = 'My Boats';
        $base_anchorages = \App\BaseAnchorage::all();
        $captains = \App\BoatCaptainProfile::where('boat_owner', $this->ownerUserID)->with('user')->get();
        return view('owner.dashboard.boat.create', $data)->with('base_anchorages',$base_anchorages)->with('captains',$captains);
    }

    public function store()
    {
        //return Input::all();
        $rules = [
            'name' => array('required','Regex:/^[\pL\s]+$/u'),
//            'company_name' => array('required','Regex:/^[\pL\s]+$/u'),
//            'registration_no'=>  array('required','Regex:/^(SC|SP)\d{4}[A-Z]$/'),
//            'date_of_registration'=> 'required',
            'habourcraft_number'=> 'required|unique:boats',
            'license_date'=> 'required',
            'manning_type'=> 'required',
            'operating_zone'=> 'required',
            'photo' => 'max:2048|mimes:jpg,jpeg,png,gif',
            'average_speed'=> 'numeric',
            'capacity'=> 'numeric',
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->with('error','boat can not be created, provide correct data');
        }

        $boat = new Boat();

        $boat->name = Input::get('name');
        $boat->user_id = $this->ownerUserID;

//        $boat->company_name = Input::get('company_name');
//        $boat->registration_no = Input::get('registration_no');
//        $boat->date_of_registration = Input::get('date_of_registration');
        $boat->about = Input::get('about');
        $boat->habourcraft_number = Input::get('habourcraft_number');
//        $boat->license = Input::get('license');
        $boat->license_date = Input::get('license_date');
        $boat->manning_type = Input::get('manning_type');
        $boat->unique_id = uniqid();
        $boat->average_speed = Input::get('average_speed');
        $boat->capacity = Input::get('capacity');
//        $boat->anchorage_id = Input::get('anchorage_id');
        $boat->status = Input::get('status');
        $boat->operating_zone = Input::get('operating_zone');

        #photo
        $photo = Input::file('photo');
        $destinationPath = '/uploads/boat_images/';
        if($photo!=null)
        {
            $filename = $photo->getClientOriginalName();
            $photo->move(public_path() . $destinationPath, $filename);
            $boat->photo = $destinationPath.$filename;
            resize( $destinationPath,$filename,300,'/thumbnail'.$destinationPath);
            $boat->thumb_photo = '/thumbnail'.$destinationPath.'thumb_'.$filename;
        }
        else
        {
            $boat->photo = $destinationPath.'no-image.jpg';
            $boat->thumb_photo = '/images/preview.png';
        }
        #photo end
        $boat->save();
        if(Input::get('boat_captain_id')) {

            $boat_id = \App\Boat::orderBy('id','DESC')->first();
            $captain_ids =Input::get('boat_captain_id');
            foreach($captain_ids as $captain_id)
            {
                \App\RelBoatsCaptains::firstOrCreate([
                    'boat_id' => $boat_id->id,
                    'captain_id' => $captain_id,
                ]);
            }
        }


        return Redirect::to('/owner/dashboard/boats')->with('success',"Boat Data saved successfully");
    }

    public function edit($id)
    {
        $boat = Boat::findOrFail($id);
        $data['current_page'] = 'My Boats';
        $captains = \App\BoatCaptainProfile::where('boat_owner', $this->ownerUserID)->with('user')->get();
        $base_anchorages = \App\BaseAnchorage::all();
        $rel_boat_captains = \App\RelBoatsCaptains::where('boat_id','=',$id)->get();
        return view('owner.dashboard.boat.edit',$data)->with('boat',$boat)
            ->with('rel_boat_captains',$rel_boat_captains)
            ->with('captains',$captains)
            ->with('base_anchorages',$base_anchorages);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => array('required','Regex:/^[\pL\s]+$/u'),
//            'company_name' => array('required','Regex:/^[\pL\s]+$/u'),
//            'registration_no'=>  array('required','Regex:/^(SC|SP)\d{4}[A-Z]$/'),
//            'date_of_registration'=> 'required',
            'habourcraft_number'=> 'required|unique:boats,habourcraft_number,'.$id,
            'license_date'=> 'required',
            'manning_type'=> 'required',
            'operating_zone'=> 'required',
            'photo' => 'max:2048|mimes:jpg,jpeg,png,gif',
            'average_speed'=> 'numeric',
            'capacity'=> 'numeric',
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput()->withInput()->with('error','boat can not be updated, provide correct data');
        }

        $boat = Boat::findOrFail($id);

        $boat->name = Input::get('name');
        $boat->user_id = $this->ownerUserID;

//        $boat->company_name = Input::get('company_name');
//        $boat->registration_no = Input::get('registration_no');
//        $boat->date_of_registration = Input::get('date_of_registration');
        $boat->about = Input::get('about');
        $boat->habourcraft_number = Input::get('habourcraft_number');
//        $boat->license = Input::get('license');
        $boat->license_date = Input::get('license_date');
        $boat->manning_type = Input::get('manning_type');
        $boat->unique_id = uniqid();
        $boat->average_speed = Input::get('average_speed');
        $boat->capacity = Input::get('capacity');
//        $boat->anchorage_id = Input::get('anchorage_id');
        $boat->status = Input::get('status');
        $boat->operating_zone = Input::get('operating_zone');


        #photo
        $photo = Input::file('photo');
        $destinationPath = '/uploads/boat_images/';
        if($photo!=null)
        {
            $filename = $photo->getClientOriginalName();
            $photo->move(public_path() . $destinationPath, $filename);
            $boat->photo = $destinationPath.$filename;
            resize( $destinationPath,$filename,300,'/thumbnail'.$destinationPath);
            $boat->thumb_photo = '/thumbnail'.$destinationPath.'thumb_'.$filename;
        }
        #photo end

        $boat->save();

        if(Input::get('boat_captain_id')) {
            \App\RelBoatsCaptains::where('boat_id','=',$id)->delete();
            $captain_ids =Input::get('boat_captain_id');
            foreach($captain_ids as $captain_id)
            {
                \App\RelBoatsCaptains::firstOrCreate([
                    'boat_id' => $id,
                    'captain_id' => $captain_id,
                ]);
            }
        }

        return Redirect::to('/owner/dashboard/boats')->with('success',"Boat Data Updated successfully");
    }

    public function delete($id)
    {
        Boat::where('id','=',$id)->delete();

        return Redirect::to('/owner/dashboard/boats')->with('success',"Boat removed successfully");
    }
}
