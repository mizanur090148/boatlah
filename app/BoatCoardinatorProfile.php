<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoatCoardinatorProfile extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'boat_coordinator_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'boat_id', 'name','mobile'
    ];

    /*
     * Coordinator belongs to a user
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /*
     * Coordinator belongs to a owner
     */
    public function boatOwner()
    {
        return $this->belongsTo('App\User', 'boat_owner', 'id');
    }
}
