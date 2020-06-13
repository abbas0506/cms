<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    // 
    protected $fillable=[
    	
    	'forwarderId',
        'vehicleNo',
    	'carrierName',
    	'carrierPhone',
    	
    ];

    
    public function forwarder(){
        return $this->belongsTo('App\Forwarder','forwarderId');
    }
    
    public function payments(){
        return $this->hasMany('App\Payment','containerId');
    }

    public function consignments(){
        return $this->hasMany('App\Consignment','containerId');
    }
    public function pendingConsignments(){
        return $this->hasMany('App\Consignment','containerId')
        ->where('receiverName','');
    }
    public function getTotal(){
        return $this->consignments->sum(function($consignment){
            return $consignment->getTotal();
      
          });
    }
    public function getCarrierFraction(){
        return $this->consignments->sum(function($consignment){
            return $consignment->getSubTotalOne();
      
          });
    }
    public function getPaid(){
        return $this->payments->sum(function($payment){
            return $payment->amount;
      
          });
    }


}
