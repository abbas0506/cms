<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consignment extends Model
{
    //
    protected $fillable=[

    	'biltyNo',
        'containerId',
    	'consignerId',
    	'consigneeId',
        'nItems',
        'description',
    	
    	'vehicleCharges',
        'loadOneCharges',
        'biltyOneCharges',				
    	'insurance',
    	'cartOneCharges',
    	'otherCharges',  
        
    	'unloadCharges',
    	'biltyTwoCharges',
        'cartTwoCharges',
    	'loadTwoCharges',
        'receiverName',
        'receiverPic',
        'receiveDate',
        'receiveTime'
	];

    public function container(){
      return $this->belongsTo('App\Container','containerId');
    }
    public function consigner(){
        return $this->belongsTo('App\Consigner','consignerId');
      }
    public function consignee(){
      return $this->belongsTo('App\Consignee','consigneeId');
    }

    public function getStatus(){
        if(is_null($this->receiverName) || $this->receiverName=='') return 'Pending';
        else return 'Delivered';
    }
    public function getTotal(){
        return $this->vehicleCharges+
                $this->loadOneCharges+
                $this->biltyOneCharges+
                $this->insurance+
                $this->cartOneCharges+
                $this->otherCharges+
                $this->unloadCharges+
                $this->biltyTwoCharges+
                $this->cartTwoCharges+
                $this->loadTwoCharges
                ;
    }

    public function getSubTotalOne(){
        return $this->vehicleCharges+
                $this->loadOneCharges+
                $this->biltyOneCharges+
                $this->insurance+
                $this->cartOneCharges+
                $this->otherCharges;
    }
    public function getSubTotalTwo(){
        return  $this->unloadCharges+
                $this->biltyTwoCharges+
                $this->cartTwoCharges+
                $this->loadTwoCharges;
    }
        
}
