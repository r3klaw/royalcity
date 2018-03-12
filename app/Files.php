<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    //
    public function file_purchases()
    {
        return $this->hasMany('App\File_purchases','file_id','id');
    }

    public function file_downloads()
    {
        return $this->hasMany('App\FIle_downloads','file_id',id);
    }
}
