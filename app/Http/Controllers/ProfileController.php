<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //

    public function users(Request $request)
    {
        if($request->user()->hasRole('admin')) {
            return view('admin.users',['users'=>User::with('roles')->get()->except($request->user()->id)]);
        }
        abort(401);
    }

    public function create(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|unique:users',
            'type'=>'required'
        ]);
        if($request->user()->hasRole('admin'))
        {
            $password=str_random();
            try {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($password)
                ]);
                if($request->type==2) {
                    $user->roles()
                        ->attach(Role::where('name', 'shop')->first());
                }else{
                    $user->roles()
                        ->attach(Role::where('name', 'user')->first());
                }
                $data=[
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>$password,
                    'subject'=>'Account Details'
                ];
                Mail::send('mail.newAccount',$data,function($message) use ($data){
                    $message->from('admin@example.com');
                    $message->to($data['email']);
                    $message->subject('Account Creation');
                });
                return redirect()->back()->with('alert-success','Account successfully created');
            }catch (\Throwable $e){
                return redirect()->back()->with('alert-danger','An Error Occurred. Try again later.');
            }
        }
    }

    public function reset(Request $request,$id)
    {
        if($request->user()->hasRole('admin')){
            $user=User::findOrFail($id);
            $password=str_random();
            $user->password=bcrypt($password);
            try{
                $user->save();
            }catch (\Throwable $e){
                return json_encode(['status'=>false,'msg'=>'An Error Occurred']);
            }

            try{
                $data=[
                    'name'=>$user->name,
                    'email'=>$user->email,
                    'password'=>$password,
                    'subject'=>'Account Details'
                ];
                Mail::send('mail.resetAdmin',$data,function($message) use ($data){
                    $message->from('admin@example.com');
                    $message->to($data['email']);
                    $message->subject('Account Password Reset');
                });
                return json_encode(['status'=>true]);
            }catch (\Throwable $e){
                return json_encode(['status'=>true,'msg'=>'Email failed to send.']);
            }
        }
        return $id;
    }

    public function settings(Request $request)
    {
        if($request->user()->hasRole('admin')){
            $profile=Profile::where('user_id',$request->user()->id);
            if($profile->count()>0){
                return view('admin.settings',['profile'=>$profile->first()]);
            }else{
                return view('admin.settings',['profile'=>(object)(['name'=>'','phone'=>'','balance'=>0])]);
            }
        }elseif($request->user()->hasRole('user')){
            $profile=Profile::where('user_id',$request->user()->id);
            if($profile->count()>0){
                return view('user.settings',['profile'=>$profile->first()]);
            }else{
                return view('user.settings',['profile'=>(object)(['name'=>'','phone'=>'','balance'=>0])]);
            }
        }elseif($request->user()->hasRole('shop')){
            $profile=Profile::where('user_id',$request->user()->id);
            if($profile->count()>0){
                return view('shop.settings',['profile'=>$profile->first()]);
            }else{
                return view('shop.settings',['profile'=>(object)(['name'=>'','phone'=>'','balance'=>0])]);
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function savesettings(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'phone'=>'required',
            'password_old'=>'required'
        ]);
        if(!empty($request->password_new) && !empty($request->password_confirm)){
            if($request->password_new!=$request->password_confirm){
                return redirect()->back('alert-danger', 'Passwords does not match.');
            }else{
                $password=User::find($request->user()->id)->password;
                if(!password_verify($request->password_old,$password)){
                    return redirect()->back()->with('alert-danger','You\'ve entered an incorrect password. Please enter your current password again.');
                }
                $user=User::find($request->user()->id);
                $user->password=bcrypt($request->password_new);
                try{
                    $user->save();
                }catch (\Throwable $e){
                    return redirect()->back()->with('alert-danger','An error occurred updating the password.'.$e->getMessage());
                }
                if(Profile::where('user_id',$request->user()->id)->count()>0){
                    $profile=Profile::where('user_id',$request->user()->id)->first();
                    $profile->name=$request->name;
                    $profile->phone=$request->phone;
                    try{
                        $profile->save();
                        return redirect()->back()->with('alert-success','Successfully Updated');
                    }catch (\Throwable $e){
                        return redirect()->back()->with('alert-danger','Update Failed');
                    }
                }
                $profile=new Profile;
                $profile->user_id=$request->user()->id;
                $profile->name=$request->name;
                $profile->phone=$request->phone;
                try{
                    $profile->save();
                    return redirect()->back()->with('alert-success','Saved.');
                }catch (\Throwable $e){
                    return redirect()->back()->with('alert-danger','An Error Occurred');
                }
            }
        }else{
            $password=User::find($request->user()->id)->password;
            if(!password_verify($request->password_old,$password)){
                return redirect()->back()->with('alert-danger','You\'ve entered an incorrect password. Please enter your current password again.');
            }
            if(Profile::where('user_id',$request->user()->id)->count()>0){
                $profile=Profile::where('user_id',$request->user()->id)->first();
                $profile->name=$request->name;
                $profile->phone=$request->phone;
                try{
                    $profile->save();
                    return redirect()->back()->with('alert-success','Successfully Updated');
                }catch (\Throwable $e){
                    return redirect()->back()->with('alert-danger','Update Failed');
                }
            }
            $profile=new Profile;
            $profile->user_id=$request->user()->id;
            $profile->name=$request->name;
            $profile->phone=$request->phone;
            try{
                $profile->save();
                return redirect()->back()->with('alert-success','Saved.');
            }catch (\Throwable $e){
                return redirect()->back()->with('alert-danger','An Error Occurred');
            }
        }
    }

    public function delete($id,Request $request)
    {
        if($request->user()->hasRole('admin')){
            $user=User::find($id);
            try{
                $user->delete();
                return redirect()->back()->with('alert-info','User deleted successfully.');
            }catch (\Throwable $e){
                return redirect()->back()->with('alert-danger','An error occured. User has not been deleted.');
            }
        }
    }
}
