<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consigner extends Model
{
    //
    protected $fillable=[
    	
    	'id',
    	'name',
    	'phone', 
    	'email', 
    	'address'
    
    ];
}
