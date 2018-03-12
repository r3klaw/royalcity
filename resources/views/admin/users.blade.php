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
        <li class="active">
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
        <li>
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
            <div class="pull-right"><button class="btn btn-primary" data-toggle="collapse" aria-expanded="false" data-target="#adduser" type="button"><i class="fa fa-user-plus"></i> Add User</button></div>
            <h3 class="title">Users</h3>
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
            <div class="panel panel-primary collapse" id="adduser">
                <div class="panel-heading">
                    <h4 class="text-center"><i class="fa fa-user-plus"></i>&nbsp; Add User</h4>
                </div>
                <div class="panel-body">
                    {!! Form::open(['url'=>'user']) !!}
                    <div class="form-group">
                        {!! Form::label('name','Name') !!}
                        {!! Form::text('name',null,['placeholder'=>'Name...','class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('type','User Type') !!}
                        <select name="type" id="type" class="form-control">
                            <option value="">Select Type</option>
                            <option value="1">User</option>
                            <option value="2">Shop</option>
                        </select>
                    </div>
                    <div class="form-group">
                        {!! Form::label('email','Email') !!}
                        {!! Form::email('email',null,['placeholder'=>'Email','class'=>'form-control']) !!}
                    </div>
                    {!! Form::submit('Submit',['class'=>'btn btn-primary pull-right']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="table-condensed table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Type</th>
                    <th></th>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{!! $user->id !!}</td>
                            <td>{!! $user->name !!}</td>
                            <td>{!! $user->email !!}</td>
                            <td>{!! $user->created_at !!}</td>
                            <td>
                                {!! \App\Http\Controllers\HomeController::getRole($user->id) !!}</td>
                            <td>
                                <a id="resetPassIconParent{!! $user->id !!}" href="#" onclick="reset('{!! $user->id !!}')" class="btn btn-info btn-fill"><i class="fa fa-lock"></i><i class="fa fa-refresh" id="resetpassIcon{!! $user->id !!}"></i> </a>
                                <button onclick="sendMessage('{!! url('/message/send/'.$user->id) !!}','{!! $user->id !!}','{!! App\User::find($user->id)->name !!}')" class="btn btn-primary"><i class="fa fa-comment-o"></i></button>
                                <a href="{!! url('/user/delete/'.$user->id) !!}" class="btn btn-warning"><i class="fa fa-trash"></i> </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
<script type="text/javascript">
    function reset(id){
        $.ajax({
            url: '{!! url("user/reset") !!}/'+id,
            type:'GET',
            dataType:'JSON',
            beforeSend:function(){
                $('#resetpassIcon'+id).addClass('fa-spin');
            },
            success:function(data){
                if(data.status) {
                    $('#resetpassIcon' + id).removeClass('fa-spin').removeClass('fa-refresh').addClass('fa-check');
                    $('#resetPassIconParent'+id).removeClass('btn-info').addClass('btn-success');
                    setTimeout(function(){
                        $('#resetpassIcon'+id).removeClass('fa-check').addClass('fa-refresh');
                        $('#resetPassIconParent'+id).removeClass('btn-success').addClass('btn-info');
                    },3000);
                }
                if(!data.status){
                    $('#resetpassIcon' + id).removeClass('fa-spin').removeClass('fa-refresh');
                    $('#resetPassIconParent'+id).addClass('btn-danger');
                    $('#resetPassIconParent'+id).removeClass('btn-info');
                    $('#resetpassIcon'+id).addClass('fa-close');
                    setTimeout(function(){
                        $('#resetpassIcon'+id).removeClass('fa-close').addClass('fa-refresh');
                        $('#resetPassIconParent'+id).removeClass('btn-danger').addClass('btn-info');
                    },3000);
                }
            }
        });
    }
    function sendMessage(id,to,name){
        swal({
            title: 'Message to '+name,
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
                            'to':to,
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