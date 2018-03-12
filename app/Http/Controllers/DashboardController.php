<?php

namespace App\Http\Controllers;

use App\File_purchases;
use App\Files;
use App\Messages;
use App\Notifications;
use App\Profile;
use App\Torrent_purchases;
use App\Torrents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function admin(Request $request)
    {
        $balance=Profile::all()->sum('balance');
        $files=Files::all()->count();
        $filesspent=File_purchases::all()->sum('amount');
        $messages=Messages::where('to_user','=',$request->user()->id)->where('read','=',0)->count();
        $notifications=Notifications::where('for_user','=',$request->user()->id)->where('read','=',0)->count();
        $this->role_authorize($request,'admin');
        return view('admin.home',[
            'balance'=>$balance,
            'files'=>$files,
            'files_spent'=>$filesspent,
            'messages'=>$messages,
            'notifications'=>$notifications
        ]);
    }

    public function user(Request $request)
    {
        try{
            $balance=Profile::where('user_id',$request->user()->id)->first()->balance;
        }catch (\Throwable $e){
            $balance=0;
        }
        $files=File_purchases::where('user_id','=',$request->user()->id)->count();
        $filesspent=File_purchases::where('user_id','=',$request->user()->id)->sum('amount');
        $messages=Messages::where('to_user','=',$request->user()->id)->where('read','=',0)->count();
        $notifications=Notifications::where('for_user','=',$request->user()->id)->where('read','=',0)->count();
        $this->role_authorize($request,'user');
        return view('user.home',[
            'balance'=>$balance,
            'files'=>$files,
            'files_spent'=>$filesspent,
            'messages'=>$messages,
            'notifications'=>$notifications
        ]);
    }

    public function shop(Request $request)
    {
        $balance=Profile::where('user_id',$request->user()->id)->sum('balance');
        $files=Files::where('byUser',$request->user()->id)->count();
        $messages=Messages::where('to_user','=',$request->user()->id)->where('read','=',0)->count();
        $notifications=Notifications::where('for_user','=',$request->user()->id)->where('read','=',0)->count();
        $files_spent=DB::table('file_purchases')
            ->join('files','files.id','file_purchases.file_id')
            ->where('byUser',$request->user()->id)
            ->sum('file_purchases.amount');
        $this->role_authorize($request,'shop');
        return view('shop.home',[
            'balance'=>$balance,
            'files'=>$files,
            'files_spent'=>$files_spent,
            'messages'=>$messages,
            'notifications'=>$notifications
        ]);
    }
}
