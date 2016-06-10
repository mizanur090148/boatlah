<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contracts extends Model
{
    protected $table = 'contracts';
    protected $fillable = [ 'owner_id','company_id','invoice_prefix'];

    public function owner()
    {
        return $this->belongsTo('App\BoatOwnerProfile','owner_id','user_id');
    }
    public function company()
    {
        return $this->belongsTo('App\ShippingCompanyProfile','company_id','user_id');
    }
}
