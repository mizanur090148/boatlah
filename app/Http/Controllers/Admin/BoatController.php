<?php

namespace App\Http\Controllers\Admin;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use App\Catalog;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App;

class BoatController extends Controller
 {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boats = App\Boat::all();
        return view('admin.boats.index')->with('boats',$boats);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $captains = App\BoatCaptainProfile::with('user')->get();
        $boat_owner_profiles = \App\BoatOwnerProfile::with('user')->get();
        $base_anchorages = \App\BaseAnchorage::all();

        return view('admin.boats.create')
            ->with('boat_owner_profiles',$boat_owner_profiles)
            ->with('captains',$captains)
            ->with('base_anchorages',$base_anchorages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return Input::all();
        $rules = [
            'name' => array('required','Regex:/^[\pL\s]+$/u'),
            'company_name' => array('required','Regex:/^[\pL\s]+$/u'),
            'boat_owner_id'=>'required',
            'registration_no'=> array('required','Regex:/^(SC|SP)\d{4}[A-Z]$/'),
            'date_of_registration'=> 'required',
            'manning_type'=> 'required',
            'operating_zone'=> 'required',
            'anchorage_id' =>'required',
            'photo' => 'max:2048|mimes:jpg,jpeg,png,gif',
            'average_speed'=> 'numeric',
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $boat = new App\Boat();

        $boat->name = Input::get('name');
        $boat->user_id =Input::get('boat_owner_id');
        $boat->company_name = Input::get('company_name');
        $boat->registration_no = Input::get('registration_no');
        $boat->date_of_registration = Input::get('date_of_registration');
        $boat->about = Input::get('about');
        $boat->habourcraft_number = Input::get('habourcraft_number');
        $boat->license = Input::get('license');
        $boat->license_date = Input::get('license_date');
        $boat->manning_type = Input::get('manning_type');
        $boat->average_speed = Input::get('average_speed');
        $boat->unique_id = uniqid();
        $boat->capacity = Input::get('capacity');
        $boat->anchorage_id = Input::get('anchorage_id');
        $boat->status = Input::get('status');
        $boat->operating_zone = Input::get('operating_zone');

        $photo = Input::file('photo');
        $destinationPath = '/uploads/boat_images/';
        if($photo!=null)
        {
            $filename = $photo->getClientOriginalName();
            $photo->move(public_path() . $destinationPath, $filename);
            $boat->photo = $destinationPath.$filename;
            resize( $destinationPath,$filename,300,'/thumbnail'.$destinationPath);
            $boat->thumb_photo = '/thumbnail'.$destinationPath.'thumb_'.$filename;
        } else {
            $boat->photo = '/images/preview.png';
            $boat->thumb_photo = '/images/preview.png';
        }
        $boat->save();

        if(Input::get('boat_captain_id')) {

            $boat_id = App\Boat::orderBy('id','DESC')->first();
            $captain_ids =Input::get('boat_captain_id');
            foreach($captain_ids as $captain_id)
            {
                App\RelBoatsCaptains::firstOrCreate([
                    'boat_id' => $boat_id->id,
                    'captain_id' => $captain_id,
                ]);
            }
        }
        return Redirect::to('/admin/boats')->with('success',"Boat Data saved successfully");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $boat = App\Boat::find($id);
        return view('admin.boats.show')->with('boat',$boat);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $captains = App\BoatCaptainProfile::with('user')->get();
        $boat_owner_profiles = \App\BoatOwnerProfile::with('user')->get();
        $base_anchorages = \App\BaseAnchorage::all();
        $rel_boat_captains = \App\RelBoatsCaptains::where('boat_id','=',$id)->get();
        $boat = App\Boat::find($id);
        
        return view('admin.boats.edit')
            ->with('boat',$boat)
            ->with('boat_owner_profiles',$boat_owner_profiles)
            ->with('captains',$captains)
            ->with('rel_boat_captains',$rel_boat_captains)
            ->with('base_anchorages',$base_anchorages);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //return Input::all();
        $rules = [
            'name' => array('required','Regex:/^[\pL\s]+$/u'),
            'company_name' => array('required','Regex:/^[\pL\s]+$/u'),
            'boat_owner_id'=>'required',
            'registration_no'=> 'required',
            'date_of_registration'=> 'required',
            'manning_type'=> 'required',
            'operating_zone'=> 'required',
            'anchorage_id' =>'required',
            'photo' => 'max:2048|mimes:jpg,jpeg,png,gif',
            'average_speed'=> 'numeric',
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $boat = App\Boat::find($id);
        $boat->name = Input::get('name');
        $boat->company_name = Input::get('company_name');
        $boat->registration_no = Input::get('registration_no');
        $boat->date_of_registration = Input::get('date_of_registration');
        $boat->about = Input::get('about');
        $boat->user_id =Input::get('boat_owner_id');
        $boat->habourcraft_number = Input::get('habourcraft_number');
        $boat->license = Input::get('license');
        $boat->license_date = Input::get('license_date');
        $boat->manning_type = Input::get('manning_type');
        $boat->average_speed = Input::get('average_speed');
        $boat->capacity = Input::get('capacity');
        $boat->anchorage_id = Input::get('anchorage_id');
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

        }
        #end photo
        $boat->save();

        if(Input::get('boat_captain_id')) {
            \App\RelBoatsCaptains::where('boat_id','=',$id)->delete();
            $captain_ids =Input::get('boat_captain_id');
            foreach($captain_ids as $captain_id)
            {
                App\RelBoatsCaptains::firstOrCreate([
                    'boat_id' => $id,
                    'captain_id' => $captain_id,
                ]);
            }
        }

        return Redirect::to('/admin/boats')->with('success',"Boat Data updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        App\Boat::where('id','=',$id)->delete();

        return Redirect::to('/admin/boats')->with('success',"Boat Data deleted successfully");
    }
}
