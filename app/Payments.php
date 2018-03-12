<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    //
    public function users()
    {
        return $this->belongsTo('App\User','userid','id');
    }
}
