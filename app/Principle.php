<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Principle extends Model
{
    protected $table = 'principles';
    protected $fillable = [ 'title','details','company_user_id'];
}
