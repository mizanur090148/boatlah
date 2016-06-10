<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoatCaptainProfile extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'boat_captain_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'boat_id', 'name'
    ];

    /*
     * Captain belongs to a user
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
