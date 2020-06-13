<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    protected $fillable=[
        
        'id',
        'password',
        'role', 
    ];

    public $incrementing = false;           //customize find method of User class
    
    protected $casts = [
        'id' => 'string',
    ];
    
    protected $keyType = 'string';

    
}