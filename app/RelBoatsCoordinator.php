<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelBoatsCoordinator extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rel_boat_coordinator';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'boat_id','coordinator_id'
    ];

    /*
     * Relation belongs to a cooridnator user
     */
    public function user()
    {
        return $this->belongsTo('App\User','coordinator_id','id');
    }

     /*
     * Relation belongs to a user
     */
    public function boat()
    {
        return $this->belongsTo('App\Boats','boat_id','id');
    }
}
