<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    protected $guarded = [];

    public function market()
    {
        return $this->belongsTo('App\Market');
    }

    public function industry()
    {
        return $this->belongsTo('App\Industry');
    }    
}
