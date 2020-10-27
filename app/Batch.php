<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    //

    public function recoveries(){
        return $this->hasMany('App\Recovery','batchId');
    }
    
    public function getTotal(){
        return $this->recoveries->sum(function($recovery){
            return $recovery->amount;
        });
    }
    
}
