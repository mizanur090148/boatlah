<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvanceBooking extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'advance_bookings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    ];

    /*
     * Booking belongs to a user
     */
    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function start()
    {
        return $this->belongsTo('App\BaseAnchorage', 'start_point_id', 'id');
    }
    public function destination()
    {
        return $this->belongsTo('App\BaseAnchorage', 'destination_point_id', 'id');
    }

}
