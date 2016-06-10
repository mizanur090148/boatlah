<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseAnchorage extends Model
 {
    protected $table = 'base_anchorages'; 
    protected $fillable = [ 'title',  'fullname', 'type', 'latitude', 'longitude' ];
 }
