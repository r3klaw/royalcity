<?php

namespace App\Http\Controllers;

use App\Notifications;
use App\Payments;
use App\Profile;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if($request->user()->hasRole('admin')){
            $payments=Payments::with('users')->get();
            return view('admin.payments',['payments'=>$payments]);
        }
        if($request->user()->hasRole('user')) {
            return view('user.payments', ['payments' => Payments::where('userid', $request->user()->id)->get()]);
        }
        abort(401);
    }

    public function make(Request $request)
    {
        $this->validate($request,[
            'transactionid'=>'required|unique:payments',
            'amount'=>'required',
            'contact'=>'required'
        ]);
        if($request->user()->hasRole('admin')){
            $payment=new Payments;
            $payment->transactionid=$request->transactionid;
            $payment->amount=$request->amount;
            $payment->contact=$request->contact;
            $payment->status=1;
            $payment->verified_by=$request->user()->id;
            try{
                $payment->save();
                return redirect()->back()->with('alert-success','Payment made successfully');
            }catch (\Throwable $e){
                return redirect()->back()->with('alert-danger','Failed to add Payment. Error:'.$e->getMessage());
            }
        }
        if($request->user()->hasRole('user')){
            $payment=new Payments;
            $payment->transactionid=$request->transactionid;
            $payment->amount=$request->amount;
            $payment->contact=$request->contact;
            $payment->status=0;
            $payment->userid=$request->user()->id;
            try{
                $payment->save();
                //to current user
                $notification=new Notifications;
                $notification->for_user=$request->user()->id;
                $notification->message='Payment added successfully. Waiting for Verification.';
                $notification->read=0;
                $notification->type=1;

                //to recipient
                $notification1=new Notifications;
                $notification1->for_user=0;
                $notification1->message='A payment has been made and is waiting for approval';
                $notification1->read=0;
                $notification1->type=2;
                try {
                    $notification->save();
                    $notification1->save();
                }catch (\Throwable $e){

                }
                return redirect()->back()->with('alert-success','Payment made successfully');
            }catch (\Throwable $e){
                return redirect()->back()->with('alert-danger','Failed to add Payment. Error:'.$e->getMessage());
            }
        }
    }

    public function verify(Request $request,$id)
    {
        if($request->user()->hasRole('admin')){
            $payment=Payments::findOrFail($id);
            $payment->verified_by=$request->user()->id;
            $payment->status=2;
            try{
                if(Profile::where('user_id','=',$payment->userid)->count()>0){
                    $profile=Profile::where('user_id','=',$payment->userid)->first();
                }else{
                    $profile=new Profile;
                }
                $profile->user_id=$payment->userid;
                $profile->balance=$profile->balance+$payment->amount;
                $profile->save();
                $payment->save();
                return redirect()->back()->with('alert-success','Payment has been successfully verified.');
            }catch (\Throwable $e){
                return redirect()->back()->with('alert-danger','Payment verification failed.Error: '.$e->getMessage());
            }
        }
        abort(401);
    }

    public function decline($id,Request $request)
    {
        if($request->user()->hasRole('admin')){
            $payment=Payments::findOrFail($id);
            $payment->verified_by=$request->user()->id;
            $payment->status=3;
            try{
                $payment->save();
                return redirect()->back()->with('alert-success','Payment declined successfully');
            }catch (\Throwable $e){
                return redirect()->back()->with('alert-danger','Payment failed to process');
            }
        }
    }
}
