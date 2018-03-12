<?php

namespace App\Http\Controllers;

use App\File_purchases;
use App\Files;
use App\Profile;
use Illuminate\Http\Request;

class FilePurchasesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //
    public function purchase(Request $request,$id)
    {
        $file=Files::findOrFail($id);
        $purchase=new File_purchases;
        $purchase->file_id=$file->id;
        $purchase->user_id=$request->user()->id;
        $purchase->amount=$file->amount;
        $purchase->valid_for=3;
        if(Profile::where('user_id','=',$request->user()->id)->count()>0) {
            $profile = Profile::where('user_id', '=', $request->user()->id)->first();
            if($profile->balance>=$file->amount) {
                $profile->balance = $profile->balance-$purchase->amount;
                try{
                    if($msg=$this->creditShop($file->byUser,$file->amount)==='yes'){
                        $profile->save();
                    }else{
                        return $msg;
                    }
                }catch (\Throwable $e){
                    return json_encode(['status'=>false,'msg'=>'An error occurred.']);
                }
            }else{
                return json_encode(['status'=>false,'msg'=>'You have insufficient funds.']);
            }
        }else{
            return json_encode(['status'=>false,'msg'=>'You have insufficient funds.']);
        }
        try{
            $purchase->save();
            return json_encode(['status'=>true,'msg'=>'Purchase successful']);
        }catch (\Throwable $e){
            return json_encode(['status'=>false,'msg'=>'An error occurred.']);
        }
    }

    private function creditShop($id,$amount)
    {
        /**
         * check if the shop has a profile uploaded
         * if true, retrieve the profile balance,
         * if false, create a model for the user
         * add the amount to the balance
         * save the record
        */
        if(Profile::where('user_id','=',$id)->count()>0) {
            $profile = Profile::where('user_id', '=', $id)->first();
            $profile->balance = $profile->balance+$amount;
            try{
                $profile->save();
                return 'yes';
            }catch (\Throwable $e){
                dd($e->getMessage());
            }
        }else{
            $profile=new Profile;
            $profile->user_id=$id;
            $profile->balance = $profile->balance+$amount;
            try{
                $profile->save();
                return 'yes';
            }catch (\Throwable $e){
                dd($e->getMessage());
            }
        }
    }
}
