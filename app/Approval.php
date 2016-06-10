<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $table = 'pending_and_approve_list';
    protected $fillable = [ 'user_id', 'company_id' ];

    /*
     * User belongs to a boat user
     */
    public function userProfile()
    {
        return $this->belongsTo('App\BoatUserProfile', 'user_id', 'user_id');
    }

    /*
     * Company belongs to a user
     */
    public function companyProfile()
    {
        return $this->belongsTo('App\ShippingCompanyProfile', 'company_id', 'user_id');
    }
}
