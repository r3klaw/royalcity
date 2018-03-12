<?php

namespace App\Http\Controllers;

use App\Notifications;
use App\Profile;
use App\Withdraws;
use Illuminate\Http\Request;

class WithdrawsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function approve($id, Request $request)
    {
        $this->validate($request,[
            'txid'=>'required'
        ]);
        if($request->user()->hasRole('admin')){
            $withdraw=Withdraws::findOrFail($id);
            $withdraw->byUser=$request->user()->id;
            $withdraw->txno=$request->txid;
            $withdraw->status=1;
            if(Profile::where('user_id',$withdraw->user_id)->count()>0) {
                $profile=Profile::where('user_id',$withdraw->user_id)->first();
                if($profile->balance>=$withdraw->amount){
                    $profile->balance=$profile->balance-$withdraw->amount;
                    try{
                        $profile->save();
                    }catch (\Throwable $e){
                        return json_encode(['status'=>false,'msg'=>'An error occurred']);
                    }
                }else{
                    return json_encode(['status'=>false,'msg'=>'Not enough funds']);
                }
            }else{
                return json_encode(['status'=>false,'msg'=>'Request may be invalid.']);
            }
            try{
                $withdraw->save();
                $notification=new Notifications;
                $notification->for_user=$withdraw->user_id;
                $notification->message='Withdrawal request has been approved.';
                $notification->read=0;
                $notification->type=1;
                try{
                    $notification->save();
                }catch (\Throwable $g){

                }
                return json_encode(['status'=>true,'msg'=>'Withdrawal request has been successfully accepted.']);
            }catch (\Throwable $e){
                return json_encode(['status'=>false,'msg'=>'An error occurred. Please try again']);
            }
        }
    }

    public function deny($id,Request $request)
    {
        if($request->user()->hasRole('admin')){
            $withdraw=Withdraws::findOrFail($id);
            $withdraw->status=9;
            $withdraw->byUser=$request->user()->id;
            try{
                $withdraw->save();
                $notification=new Notifications;
                $notification->for_user=$withdraw->user_id;
                $notification->message='Withdrawal request has been denied.';
                $notification->read=0;
                $notification->type=1;
                try{
                    $notification->save();
                }catch (\Throwable $g){

                }
                return json_encode(['status'=>true,'msg'=>'Withdrawal request has been successfully rejected.']);
            }catch (\Throwable $e){
                return json_encode(['status'=>false,'msg'=>'An error occurred. Please try again']);
            }
        }
        abort(401);
    }

    public function index(Request $request)
    {
        if($request->user()->hasRole('admin')){
            $data=Withdraws::all();
            return view('admin.withdrawals',['withdrawals'=>$data]);
        }
        abort(401);
    }

    public function request(Request $request)
    {
        $this->validate($request,[
            'amount'=>'required'
        ]);
        $amount=$request->amount;
        if($request->user()->hasRole('shop')){
            $profile=Profile::where('user_id',$request->user()->id);
            if($profile->count()>0){
                if($profile->first()->balance>=$amount){
                    $withdraw=new Withdraws;
                    $withdraw->amount=$amount;
                    $withdraw->user_id=$request->user()->id;
                    try{
                        $withdraw->save();
                        $notification=new Notifications;
                        $notification->for_user=0;
                        $notification->message='A withdrawal request is waiting.';
                        $notification->read=0;
                        $notification->type=1;
                        try{
                            $notification->save();
                        }catch (\Throwable $g){

                        }
                        return json_encode(['status'=>true,'msg'=>'Working on it.']);
                    }catch (\Throwable $e){
                        return json_encode(['status'=>false,'msg'=>'An error occurred. Please try again:'.$e->getMessage()]);
                    }
                }else{
                    return json_encode(['status'=>false,'msg'=>'Insufficient funds.']);
                }
            }else{
                return json_encode(['status'=>false,'msg'=>'Insufficient funds.']);
            }
        }
        abort(401);
    }
}
