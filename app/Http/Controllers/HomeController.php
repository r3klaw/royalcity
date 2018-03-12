<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Role;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->role($request);
    }

    function role(Request $request){
        $request->user()->authorizeRoles(['admin','user','shop']);
        return $this->role_redirect($request);
    }

    public static function getRole($id)
    {
        $roleid=DB::table('role_user')->where('user_id',$id)->first()->role_id;
        $role=Role::find($roleid)->name;
        return $role;
    }

    function role_redirect(Request $request)
    {
        if($request->user()->hasRole('admin'))
        {
            return redirect('admin');
        }

        if($request->user()->hasRole('user'))
        {
            return redirect('user');
        }

        if($request->user()->hasRole('shop'))
        {
            return redirect('shop');
        }

        return abort(401,'Not Authorised');
    }
}
