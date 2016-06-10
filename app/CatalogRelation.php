<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatalogRelation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'catalogs_relation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'principle_id', 'catalogs_parent_id'
    ];

    /*
     * Captain belongs to a user
     */

    public function principle()
    {
        return $this->belongsTo('App\Principle','principle_id','id');
    }
    public function catalogsParent()
    {
        return $this->belongsTo('App\CatalogsParent','catalogs_parent_id','id');
    }
}
