<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'trips';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'boat_id',
        'captain_id',
        'status',
        'started_at',
        'completed_at'
    ];
    /*
     * Booking belongs to a boat
     */
    public function boat()
    {
        return $this->belongsTo('App\Boat', 'boat_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo('App\User', 'owner_id', 'id');
    }
    public function ownerProfile()
    {
        return $this->belongsTo('App\BoatOwnerProfile', 'owner_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function userProfile()
    {
        return $this->belongsTo('App\BoatUserProfile', 'user_id', 'user_id');
    }

    public function captain()
    {
        return $this->belongsTo('App\User', 'captain_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo('App\User', 'contract_company', 'id');
    }
    public function companyProfile()
    {
        return $this->belongsTo('App\ShippingCompanyProfile', 'contract_company', 'user_id');
    }

    public function start()
    {
        return $this->belongsTo('App\BaseAnchorage', 'start_point', 'id');
    }
    
    public function destination()
    {
        return $this->belongsTo('App\BaseAnchorage', 'destination_point', 'id');
    }


    public function invoice()
    {
        return $this->hasOne('App\Invoice','trip_id','id');
    }

    public function un_register_user()
    {
        return $this->belongsTo('App\UnregisteredUsers','others','id');
    }
}
