@extends('layout.dashboard')
@section('title')
    Royal City
@endsection
@section('logo')
    royalcity.jpg
@endsection
@section('sidebar')
    <ul class="nav">
        <li>
            <a href="{{url('home')}}">
                <i class="ti-panel"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li>
            <a target="_blank" href="http://192.168.88.254">
                <i class="ti-layout-media-right-alt"></i>
                <p>Router <i class="ti-new-window pull-right"></i> </p>
            </a>
        </li>
        <li>
            <a href="{{url('users')}}">
                <i class="fa fa-users"></i>
                <p>Users</p>
            </a>
        </li>
        <li>
            <a href="{{url('transactions')}}">
                <i class="fa fa-money"></i>
                <p>Payments</p>
            </a>
        </li>
        <li>
            <a href="{{url('withdrawals')}}">
                <i class="fa fa-bank"></i>
                <p>Withdrawals</p>
            </a>
        </li>
        <li class="dropdown">
            <a href="#demo3" class="list-group-item" data-toggle="collapse">
                <i class="ti-files"></i>
                <p>
                    Files
                    <i class="fa fa-caret-down pull-right"></i>
                </p>
            </a>
            <ul class="collapse nav" id="demo3">
                <li class="nav-divider"></li>
                <li>
                    <a href="{!! url('series') !!}">
                        <i class="ti-video-camera"></i>
                        <p>Series</p>
                    </a>
                </li>
                <li>
                    <a href="{!! url('videos') !!}">
                        <i class="ti-video-clapper"></i>
                        <p>Movies</p>
                    </a>
                </li>
                <li>
                    <a href="{!! url('documents') !!}">
                        <i class="ti-folder"></i>
                        <p>Documents</p>
                    </a>
                </li>
                <li class="nav-divider"></li>
            </ul>
        </li>
        <li class="active">
            <a href="{{url('message')}}">
                <i class="ti-comments"></i>
                <p>Messages</p>
            </a>
        </li>
        <li class="active-pro">
            <a href="{{url('settings')}}">
                <i class="ti-settings"></i>
                <p>Settings</p>
            </a>
        </li>
        <li>
            <a href="{!! url('/') !!}" class="">
                <i class="ti-home"></i>
                <p>Home page</p>
            </a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="card">
        <div class="header">
            <div class="pull-right"><button class="btn btn-primary" data-toggle="collapse" aria-expanded="false" data-target="#newmessage" type="button"><i class="fa fa-comment"></i> New Message</button></div>
            <h3 class="title">Messages</h3>
        </div>
        <div class="content">
            <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))
                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                    @endif
                @endforeach
            </div> <!-- end .flash-message -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="panel panel-primary collapse" id="newmessage">
                <div class="panel-heading">
                    <h4 class="text-center"><i class="fa fa-comment"></i> New message</h4>
                </div>
                <div class="panel-body">
                    {!! Form::open(['url'=>'message']) !!}
                    <div class="form-group">
                        {!! Form::label('recipient','Recipient (To)') !!}
                        <select name="recipient" id="recipient" class="form-control">
                            <option>Select Recipient</option>
                            @foreach($recipients as $recipient)
                                <option value="{!! $recipient->id !!}">{!! $recipient->name !!} ({!! $recipient->email !!})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        {!! Form::label('message','Message') !!}
                        {!! Form::textarea('message',null,['placeholder'=>'Message','class'=>'form-control']) !!}
                    </div>
                    <button class="btn btn-primary pull-right"><i class="fa fa-paper-plane"></i> Send</button>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="table-condensed table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                    <th>#</th>
                    <th>From</th>
                    <th>Message</th>
                    <th>Read</th>
                    <th>Delivered At</th>
                    <th></th>
                    </thead>
                    <tbody>
                    @foreach($messages as $message)
                        <tr>
                            <td>{!! $message->id !!}</td>
                            <td>
                                {!! App\User::find($message->from_user)->name !!}
                                ({!! App\User::find($message->from_user)->email !!})
                            </td>
                            <td>{!! $message->message !!}</td>
                            <td>
                                @if($message->status==0)
                                    <span class="label label-primary">New</span>
                                @elseif($message->status==1)
                                    <span class="label label-info">Read</span>
                                @endif
                            </td>
                            <td>{!! $message->created_at !!}</td>
                            <td>
                                <button onclick="reply('{!! url('/message/reply/'.$message->id) !!}','{!! App\User::find($message->from_user)->name !!}')" class="btn btn-primary"><i class="fa fa-mail-reply"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
<script>
    function reply(id,name){
        swal({
            title: 'Replying to '+name,
            confirmButtonText: 'Send',
            input:'textarea',
            showCancelButton:true,
            showLoaderOnConfirm: true,
            preConfirm: function (msg) {
                return new Promise(function (resolve, reject) {
                    $.ajax({
                        url: id,
                        data:{
                            'message':msg,
                            '_token':'{!! csrf_token() !!}'
                        },
                        type:'POST',
                        dataType:'JSON',
                        success:function(data){
                            if(data.status){
                                swal({
                                    title:'Message sent successfully',
                                    type:'success',
                                    timer:1500
                                })
                            }else{
                                swal({
                                    title:'Message failed',
                                    type:'error',
                                    timer:1500
                                })
                            }
                        }
                    });
                })
            },
            allowOutsideClick: false
        });
    }
</script>