<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoatOwnerProfile extends Model
 {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'boat_owner_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'company_name', 'owner_name', 'mobile', 'email', 'gst_registration'
    ];

    /*
     * Boat Owner belongs to a user
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

     /*
    * Boat Owner has many boats
    */
    public function boats()
    {
        return $this->hasMany('App\Boat', 'user_id', 'user_id');
    }
 }
