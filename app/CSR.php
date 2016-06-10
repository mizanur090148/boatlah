<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CSR extends Model
{
    protected $table = 'csr';
    protected $fillable = [ 'user_id'];

    /*
     * CSR User belongs to a user
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
