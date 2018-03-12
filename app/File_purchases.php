<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File_purchases extends Model
{
    //
    public function files()
    {
        return $this->belongsTo('App\Files','file_id','id');
    }
}
