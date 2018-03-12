<?php

namespace App\Http\Controllers;

use App\Notifications;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dismiss($id)
    {
        $notifications=Notifications::find($id);
        $notifications->read=1;
        if($notifications->save()){
            return 1;
        }else{
            return 0;
        }
    }
}
