<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoatUserProfile extends Model
 {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'boat_user_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id'
    ];

    /*
     * Boat User belongs to a user
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }                       
 }
