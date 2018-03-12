<?php

namespace App\Http\Controllers;

use App\Tickets;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if($request->user()->hasRole('admin')){

        }elseif ($request->user()->hasRole('user')){
            $tickets=Tickets::where([
                ['user_id','=',$request->user()->id]
            ])->get();
            return view('user.tickets',['tickets'=>$tickets]);
        }
    }
    //
}
