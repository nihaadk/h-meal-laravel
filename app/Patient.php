<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Patient extends Model
{
    protected $table = 'patients';

    protected $fillable = ['first_name','last_name', 'address', 'date','zzzs_number'];

    public function getVisits(){

        return $this->hasMany('App\Visit');
    }

    public function getDayvisits(){

        return $this->hasMany('App\Day_visit');
    }

    public function  getMeasuredsugars(){

        return $this->hasMany('App\Measured_sugar');
    }



    
}
