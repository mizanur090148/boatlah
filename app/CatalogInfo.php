<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatalogInfo extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'catalog_info';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'catalogs_id','anchorage_code'
    ];

    /*
     * Captain belongs to a user
     */
    public function catalog()
    {
        return $this->belongsTo('App\Catalog');
    }

    public function anchorage()
    {
        return $this->belongsTo('App\BaseAnchorage','anchorage_code','id');
    }

}
