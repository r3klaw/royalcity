<?php

namespace App\Http\Controllers;

use App\Messages;
use App\Notifications;
use App\User;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->user()->hasRole('admin')) {
            return view(
                'admin.messages',
                ['messages' => Messages::where('to_user', $request->user()->id)->get(), 'recipients' => User::all(['id', 'name', 'email']
                )
                    ->except($request->user()->id)]);
        } elseif ($request->user()->hasRole('user')) {
            return view(
                'user.messages',
                ['messages' => Messages::where('to_user', $request->user()->id)->get(), 'recipients' => User::all(['id', 'name', 'email']
                )
                    ->except($request->user()->id)]);
        } elseif ($request->user()->hasRole('shop')) {
            return view(
                'shop.messages',
                ['messages' => Messages::where('to_user', $request->user()->id)->get(), 'recipients' => User::all(['id', 'name', 'email']
                )
                    ->except($request->user()->id)]);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'recipient' => 'required',
            'message' => 'required'
        ]);
        if ($request->recipient == 'all') {
            foreach (User::all()->except($request->user()->id) as $recipient) {
                $message = new Messages;
                $message->from_user = $request->user()->id;
                $message->to_user = $recipient->id;
                $message->message = $request->message;
                $message->read = 0;
                $message->deleted = 0;
                try {
                    $message->save();

                    //to recipient
                    $notification1 = new Notifications;
                    $notification1->for_user = $recipient->id;
                    $notification1->message = 'New Message from ' . User::find($request->user()->id)->name . ' (' . User::find($request->user()->id)->email . ')';
                    $notification1->read = 0;
                    $notification1->type = 2;
                    try {
                        $notification1->save();
                    } catch (\Throwable $e) {

                    }
                } catch (\Throwable $e) {
                    return redirect()->back()->with('alert-danger', 'Message failed to send. Error:' . $e->getMessage());
                }
            }
            //to current user
            $notification = new Notifications;
            $notification->for_user = $request->user()->id;
            $notification->message = 'Message sent successfully';
            $notification->read = 0;
            $notification->type = 1;
            try{
                $notification->save();
            }catch (\Throwable $e){

            }
            return redirect()->back()->with('alert-success', 'Message sent successfully');
        }
        $message = new Messages;
        $message->from_user = $request->user()->id;
        $message->to_user = $request->recipient;
        $message->message = $request->message;
        $message->read = 0;
        $message->deleted = 0;
        try {
            $message->save();
            //to current user
            $notification = new Notifications;
            $notification->for_user = $request->user()->id;
            $notification->message = 'Message sent successfully';
            $notification->read = 0;
            $notification->type = 1;

            //to recipient
            $notification1 = new Notifications;
            $notification1->for_user = $request->recipient;
            $notification1->message = 'New Message from ' . User::find($request->user()->id)->name . ' (' . User::find($request->user()->id)->email . ')';
            $notification1->read = 0;
            $notification1->type = 2;
            try {
                $notification->save();
                $notification1->save();
            } catch (\Throwable $e) {

            }
            return redirect()->back()->with('alert-success', 'Message sent successfully');
        } catch (\Throwable $e) {
            return redirect()->back()->with('alert-danger', 'Message failed to send. Error:' . $e->getMessage());
        }
    }

    public function reply($id,Request $request)
    {
        $message=Messages::findOrFail($id);
        $from=$message->to_user;
        $to=$message->from_user;
        $newmessage=new Messages;
        $newmessage->from_user=$from;
        $newmessage->to_user=$to;
        $newmessage->message=$request->message;
        $newmessage->read=0;
        $newmessage->deleted=0;
        try{
            $newmessage->save();
            return json_encode(['status'=>true]);
        }catch (\Throwable $e){
            return json_encode(['status'=>true,'msg'=>'An Error Occurred']);
        }
    }

    public function send($id,Request $request)
    {
        $message = new Messages;
        $message->from_user = $request->user()->id;
        $message->to_user = $request->to;
        $message->message = $request->message;
        $message->read = 0;
        $message->deleted = 0;
        try {
            $message->save();
            //to current user
            $notification = new Notifications;
            $notification->for_user = $request->user()->id;
            $notification->message = 'Message sent successfully';
            $notification->read = 0;
            $notification->type = 1;

            //to recipient
            $notification1 = new Notifications;
            $notification1->for_user = $request->to;
            $notification1->message = 'New Message from ' . User::find($request->user()->id)->name . ' (' . User::find($request->user()->id)->email . ')';
            $notification1->read = 0;
            $notification1->type = 2;
            try {
                $notification->save();
                $notification1->save();
            } catch (\Throwable $e) {

            }
            return json_encode(['status'=>true]);
        } catch (\Throwable $e) {
            return json_encode(['status'=>false,'msg'=>'Failed. An error occurred.']);
        }
    }
    //
}
