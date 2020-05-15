<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealtimeChecking extends Model
{
    protected $guarded = [];

    public function realtime_setting()
    {
        return $this->hasOne('App\RealtimeSetting');
    }    
}
