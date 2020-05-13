<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    protected $guarded = [];

    public function codes()
    {
        return $this->hasMany('App\Code');
    }    
}
