<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recovery extends Model
{
    //
    protected $fillable=[
    	
    	'id',
    	'consigneeId',
    	'amount', 
    	'description', 
    	
	];
	
    public function consignee(){
        return $this->belongsTo('App\Consignee','consigneeId');
    }

    
}
