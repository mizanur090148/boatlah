<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Boat extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'boats';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'captain_id', 'coordinator_id', 'name', 'habourcraft_number', 'license', 'license_date', 'manning_type', 'unique_id', 'average_speed', 'capacity', 'photo', 'status', 'isactive',
    ];

    /*
     * Boat belongs to a user
     */
    public function owner()
    {
        return $this->belongsTo('App\BoatOwnerProfile', 'user_id', 'user_id');
    }

    /*
     * Boat belongs to a Captain
     */
    public function captain()
    {
        return $this->hasOne('App\BoatCaptainProfile', 'user_id', 'captain_id');
    }

    /*
     * Boat belongs to a Coordinator
     */
    public function coordinator()
    {
        return $this->belongsTo('App\BoatCoardinatorProfile', 'coordinator_id', 'user_id');
    }


    /*
     * Get Boat By Distance
     */
    public static function getByDistance($lat, $lng, $distance)
    {
        $results = DB::select(DB::raw('SELECT id,name,captain_id, operating_zone,registration_no,thumb_photo,average_speed,capacity,manning_type,latitude,longitude, ( 3959 * acos( cos( radians(' . $lat . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $lng . ') ) + sin( radians(' . $lat .') ) * sin( radians(latitude) ) ) ) AS distance FROM boats WHERE status="available" AND captain_id!="null" HAVING distance < ' . $distance . ' ORDER BY distance') );

        return $results;
    }
}
