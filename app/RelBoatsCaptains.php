<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelBoatsCaptains extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rel_boat_captain';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'boat_id','captain_id'
    ];

    /*
     * Relation belongs to a captain user
     */
    public function user()
    {
        return $this->belongsTo('App\User','captain_id','id');
    }

    /*
     * Relation belongs to a user
     */
    public function boat()
    {
        return $this->belongsTo('App\Boats','boat_id','id');
    }
}
