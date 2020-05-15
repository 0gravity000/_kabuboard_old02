<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealtimeSetting extends Model
{
    protected $guarded = [];

    public function code()
    {
        return $this->belongsTo('App\Code');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }    

    public function realtime_checking()
    {
        return $this->belongsTo('App\RealtimeChecking');
    }    
   
}
