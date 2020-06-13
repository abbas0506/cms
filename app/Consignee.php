<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consignee extends Model
{
    //
    protected $fillable=[
    	
    	'id',
    	'name',
    	'phone', 
    	'email', 
    	'address'
    
	];
	
    public function recentTransactions(){
        

    }
    public function topFiveRecoveries(){
        return $this->hasMany('App\Recovery','consigneeId')
        ->orderByDesc('created_at')
        ->limit(5);
    }
    public function recoveries(){
        return $this->hasMany('App\Recovery','consigneeId')
        ->orderByDesc('created_at');
    }
    
    public function consignments(){
        return $this->hasMany('App\Consignment','consigneeId')
        ->orderByDesc('created_at');
    }


    
    public function sumOfCr(){
        return $this->consignments->sum(function($consignment){
            return $consignment->vehicleCharges+$consignment->loadOneCharges+
                $consignment->biltyOneCharges+
                $consignment->insurance+
                $consignment->cartOneCharges+
                $consignment->otherCharges+
                $consignment->unloadCharges+
                $consignment->biltyTwoCharges+
                $consignment->cartTwoCharges+
                $consignment->loadTwoCharges
                ;
    
          });
    }
    
    public function sumOfDb(){
        return $this->recoveries->sum(function($recovery){
            return $recovery->amount;
    });
    }   

}
