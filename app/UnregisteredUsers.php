<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnregisteredUsers extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'unregistered_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email','name','phone'
    ];
}
