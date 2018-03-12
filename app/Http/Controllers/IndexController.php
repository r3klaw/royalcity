<?php

namespace App\Http\Controllers;

use App\Files;
use App\User;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //
    public function index()
    {
        $shops=DB::table('files')
            ->select(DB::raw('Distinct (byUser)'))
            ->join('users','files.byUser','users.id')
            ->get();
        return view('index',['shops'=>$shops]);
    }

    public function shop($id)
    {
        $shop=User::find($id);
        if(Files::where('byUser',$id)->count()<1){
            abort(401);
        }
        if($shop->hasRole('shop') || $shop->hasRole('admin')){
            $documents=Files::where('byUser',$id)
                ->where('type',1)->paginate(9);
            $music=Files::where('byUser',$id)
                ->where('type',3)->paginate(9);
            $videos=Files::where('byUser',$id)
                ->where('type',2)->paginate(9);
            return view('shop',['documents'=>$documents,'musics'=>$music,'videos'=>$videos]);
        }else{
            abort(401);
        }
    }
}
