<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * check if user has the authorised role
     */

    public function role_authorize($request,$role)
    {
        if($request->user()->hasAnyRole(['admin','user','shop'])){
            if($request->user()->roles()->first()->name==$role){

            }else{
                abort(401, 'This action is unauthorized.');
            }
        }else{
            abort(401, 'This action is unauthorized.');
        }
    }
}
