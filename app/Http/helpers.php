<?php

function createDbFormattedDateFromDatePicker($date)
{
    if ($date == '' || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
        return '';
    }
    if (\Carbon\Carbon::createFromFormat('d/m/Y', $date) !== false) {
        return \Carbon\Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
    } else {
        return '';
    }
}

function createDatePickerFormattedFromDb($date)
{
    if ($date == '' || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
        return '';
    }
    if (\Carbon\Carbon::createFromFormat('Y-m-d', $date) !== false) {
        return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');
    } else {
        return \Carbon\Carbon::now()->format('d/m/Y');
    }
}

function customDateFormat($date)
{
    if ($date == '' || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
        return '';
    }
    if (\Carbon\Carbon::createFromFormat('Y-m-d', $date) !== false) {
        return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d M, Y');
    } else {
        return \Carbon\Carbon::now()->format('d/m/Y');
    }
}

function customDateFormatWithTime($date)
{
    if ($date == '' || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
        return '';
    }
    if (\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date) !== false) {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d M, Y @ h:i A');
    } else {
        return \Carbon\Carbon::now()->format('d/m/Y');
    }
}

function limit_words($string, $word_limit)
{
    $words = explode(" ", $string);
    $dot = '';
    if (count($words) > $word_limit) {
        $dot = '(.....)';
    }
    return implode(" ", array_splice($words, 0, $word_limit)) . $dot;
}

function pr($param1, $die = true)
{
    echo "<pre>";
    print_r($param1);
    echo "</pre>";
    if ($die == TRUE) {
        die();
    }
}

function getRandomCode()
{
    return uniqid();
}

function getRandomPhoneCode()
{
    $digits = 4;
    return rand(pow(10, $digits - 1), pow(10, $digits) - 1);
}

function themeAsset($asset)
{
    return asset('material/base/assets/' . ltrim($asset, '/'));
}

function themeGlobalAsset($asset)
{
    return asset('material/global/' . ltrim($asset, '/'));
}

function getFullAddress($data)
{
    if (isset($data['address1'])) {
        $data['address_one'] = $data['address1'];
    }
    if (isset($data['address2'])) {
        $data['address_two'] = $data['address2'];
    }
    $retData = $data['address_one'] . (($data['address_two'] != '') ? ' ' . $data['address_two'] : '') . (($data['city'] != '') ? ' ' . $data['city'] : '') . (($data['state'] != '') ? ', ' . $data['state'] : '') . (($data['zip'] != '') ? '-' . $data['zip'] : '') . (($data['country'] != '') ? ', ' . getCountryNameById($data['country']) . '.' : '');
    return $retData;
}

function resize($input_dir, $cur_file, $newwidth, $output_dir)
{
    $filename = public_path() . $input_dir . $cur_file;
    $format = '';
    if (preg_match("/.jpg/i", $filename)) {
        $format = 'image/jpeg';
    }
    if (preg_match("/.gif/i", $filename)) {
        $format = 'image/gif';
    }
    if (preg_match("/.png/i", $filename)) {
        $format = 'image/png';
    }
    if ($format != '') {
        list($width, $height) = getimagesize($filename);
        $newheight = $height * $newwidth / $width;
        switch ($format) {
            case 'image/jpeg':
                $source = imagecreatefromjpeg($filename);
                break;
            case 'image/gif';
                $source = imagecreatefromgif($filename);
                break;
            case 'image/png':
                $source = imagecreatefrompng($filename);
                break;
        }
        $thumb = imagecreatetruecolor($newwidth, $newheight);
        imagealphablending($thumb, false);
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        header("Content-type: image/jpeg");
        //imagejpeg($img, realpath($this->gallery_path .'/thumb/rollover/filename.jpg'));
        imagejpeg($thumb, public_path() . $output_dir . 'thumb_' . $cur_file);
    }
}

function getCatalog($owner_id, $company_id = null, $trip_type, $manning_type, $operating_zone)
{
    $check = \App\Contracts::where('owner_id', '=', $owner_id)->where('company_id', '=', $company_id)->first();
    if ($check!=null) {
        $catalog = \App\Catalog::where([
            'contract_id' => $check->id,
            'trip_type' => $trip_type,
            'boat_type' => $manning_type,
            'zone' => $operating_zone,
            'status' => 'active'
        ])->first();

        if($catalog!=null)
            return $catalog;
    }

    if ($check==null || $catalog == null){
        $catalog = \App\Catalog::where([
            'contract_id' => null,
            'owner_id' =>$owner_id,
            'trip_type' => $trip_type,
            'boat_type' => $manning_type,
            'zone' => $operating_zone,
            'status' => 'active'
        ])->first();

        return $catalog;
    }
}


function getJourneyCost($owner_id, $company_id, $trip_type, $manning_type, $operating_zone, $start_point, $destination_point)
{
    $catalog = getCatalog($owner_id, $company_id, $trip_type, $manning_type, $operating_zone);

    if ($catalog==null)
        return null;

    $catalog_info = \App\CatalogInfo::where(['catalogs_id' => $catalog->id, 'start_point' => $start_point, 'destination_point' => $destination_point])->with('start', 'destination')->first();

    if ($catalog_info==null){
        return null;
    } else {
        $cost['catalog_info'] = $catalog_info;
        $cost['cost'] = $catalog_info->cost;
        $cost['contract_id'] = $catalog->contract_id;

        return $cost;
    }
}

function insertNewTrip($trip_data)
{
    $boat = \App\Boat::find($trip_data['boat_id']);

    $passenger = getThePassenger($trip_data['user_id']);

    $journey_cost = getJourneyCost($boat->user_id, $passenger['company_id'], $trip_data['trip_type'], $boat->manning_type, $boat->operating_zone, $trip_data['start_point'], $trip_data['destination_point']);

    $logical_validation = logicalValidationforBooking($boat, $passenger, $journey_cost);

    if ($logical_validation['status'] == 'success'){

        //Payment Algorithm
        if ($journey_cost['contract_id']!=null){
            $contract_company_id = \App\Contracts::where('id',  $journey_cost['contract_id'])->first()->company_id;
            $payment_method = 'invoice';
            $collected_user_type = null;
        }
        else {
            $contract_company_id = null;
            $payment_method = 'cash';
            //TODO  SET COLLECTED USER TYPE
            if ($trip_data['start_point']==1 || $trip_data['start_point']==17){
                $collected_user_type = 'coordinator';
            } else {
                $collected_user_type = 'captain';
            }
        }

        $trip = new \App\Trip();
        //common
        $trip->trip_id = uniqid();
        $trip->trip_date = date('Y-m-d');
        $trip->status = 'upcoming';
        //user inputs
        $trip->boat_id = $trip_data['boat_id'];
        $trip->start_point = $trip_data['start_point'];
        $trip->destination_point = $trip_data['destination_point'];
        $trip->user_id = $trip_data['user_id'];
        $trip->zone = $trip_data['zone'];
        $trip->vessel_name = $trip_data['vessel_name'];
        $trip->accompanying_passenger = $trip_data['accompanying_passenger'];
        $trip->remarks = $trip_data['remarks'];

        $trip->booked_by = $trip_data['booked_by'];
        //calculated values
        $trip->owner_id = $boat->user_id;
        $trip->captain_id = $boat->captain_id;
        //payment
        $trip->cost = $journey_cost['cost'];
        $trip->contract_id = $journey_cost['contract_id'];
        $trip->contract_company = $contract_company_id;
        $trip->payment_method = $payment_method;
        $trip->payment_status = 'unpaid';
        $trip->collected_user_type = $collected_user_type;
        //todo
        if($trip_data['others']==null){
            $trip->passenger_name = $passenger['passenger_name'];
        } else {
            $trip->others = $trip_data['others'];
            $trip->passenger_name = $trip_data['passenger_name'];
        }

        $trip->save();

        $trip_data['status'] = 'success';
        $trip_data['trip'] = $trip;

        return $trip_data;

    } else {
        return $logical_validation;
    }
}

function logicalValidationforBooking($boat, $passenger, $journey_cost)
{
    $data['status'] = 'error';

    if ($boat->status!='available' || $boat->captain==null){
        $data['message'] = 'Sorry! The Boat is not available.';
    } else if ($passenger==null){
        $data['message'] = 'Sorry! Invalid Passenger.';
    } else if ($journey_cost==null){
        $data['message'] = 'Sorry! Costing was not found from Catalog.';
    } else {
        $data['status'] = 'success';
        $data['message'] = '';
    }

    return $data;
}

function payForTrip($trip_unique_id, $payment_method, $collected_user_type, $collected_by_user)
{
    $trip = \App\Trip::where('trip_id', $trip_unique_id)->with(['boat.owner.user', 'start', 'destination','captain'])->first();

    if ($trip){
        $trip->payment_method = $payment_method;
        $trip->collected_user_type = $collected_user_type;
        $trip->collected_by_user = $collected_by_user;
        $trip->payment_status = 'paid';
        $trip->save();
    } else {
        return null;
    }

    return $trip;
}

/* 
    Check if the passenger is a company or employee of a company
*/
function getThePassenger($passenger_user_id)
{
    $passenger_info = \App\BoatUserProfile::where('user_id', $passenger_user_id)->first();

    $passenger['user_id'] = $passenger_info->user_id;

    $passenger['passenger_name'] = $passenger_info->user->name;

    if ($passenger_info->company_id!=null){
        $passenger['company_id'] = $passenger_info->company_id;
    } else {
        $check = \App\ShippingCompanyProfile::where('user_id',$passenger_user_id)->first();
        if($check!=null)
        {
            $passenger['company_id'] = $passenger_user_id;
        } else {
            $passenger['company_id'] = null;
        }
    }

    return $passenger;
}

function getCoordinatorForThisTrip($tripID)
{
    $trip = \App\Trip::find($tripID);
    $coordinator = \App\BoatCoardinatorProfile::where('boat_owner','=',$trip->owner_id)
        ->where('location','=',$trip->zone)
        ->where('loggedin','=','yes')->first();

    return $coordinator;
}

