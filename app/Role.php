<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    public function users()
    {
        return $this
            ->belongsToOne('App\User')
            ->withTimestamps();
    }
}
