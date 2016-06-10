<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'catalogs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'zone', 'status','catalogs_parent_id'
    ];

    /*
     * Captain belongs to a user
     */
    public function catalogsParent()
    {
        return $this->belongsTo('App\CatalogsParent','catalogs_parent_id','id');
    }
}
