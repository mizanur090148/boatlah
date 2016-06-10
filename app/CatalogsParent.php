<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatalogsParent extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'catalogs_parent';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'owner_id', 'company_id','catalog_type','catalogs_code'
    ];

    /*
     * Captain belongs to a user
     */
    public function owner()
    {
        return $this->belongsTo('App\User','owner_id','id');
    }

    public function company()
    {
        return $this->belongsTo('App\User','company_id','id');
    }
}
