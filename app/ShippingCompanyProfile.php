<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingCompanyProfile extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shipping_company_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id'
    ];

    /*
     * Shipping Company belongs to a user
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }     
}
