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
        <li class="active">
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
            <h3 class="title">Withdrawals</h3>
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
            <div class="table-condensed table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                    <th>#</th>
                    <th>Transaction Id</th>
                    <th>Amount</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Verified By</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th></th>
                    </thead>
                    <tbody>
                    @if(isset($withdrawals) && count($withdrawals)>0)
                        @foreach($withdrawals as $withdrawal)
                            <tr>
                                <td>{!! $withdrawal->id !!}</td>
                                <td>{!! $withdrawal->txno !!}</td>
                                <td>{!! $withdrawal->amount !!}</td>
                                <td>
                                    {!! \App\User::find($withdrawal->user_id)->name !!}
                                </td>
                                <td>
                                    @if($withdrawal->status==0)
                                        <span class="label label-default">Waiting</span>
                                    @elseif($withdrawal->status==1)
                                        <span class="label label-info">Completed</span>
                                    @elseif($withdrawal->status==9)
                                        <span class="label label-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    @if(isset(\App\User::find($withdrawal->byUser)->name))
                                        {!! \App\User::find($withdrawal->byUser)->name !!}
                                    @endif
                                </td>
                                <td>{!! $withdrawal->created_at !!}</td>
                                <td>{!! $withdrawal->updated_at !!}</td>
                                <td>
                                    @if($withdrawal->status==0)
                                        <button onclick="approve('{!! url('withdraw/approve/'.$withdrawal->id) !!}')" class="btn btn-primary"><i class="fa fa-check"></i></button>
                                        <button onclick="deny('{!! url('withdraw/deny/'.$withdrawal->id) !!}')" class="btn btn-danger"><i class="fa fa-close"></i></button>
                                    @elseif($withdrawal->status==1)
                                        <div class="label label-success">Completed</div>
                                    @elseif($withdrawal->status==9)
                                        <div class="label label-danger">Rejected</div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
<script>
    function approve(uri){
        swal({
            title: 'Approve',
            text:'Enter transaction number',
            confirmButtonText: 'Withdraw',
            input:'text',
            showCancelButton:true,
            showLoaderOnConfirm: true,
            preConfirm: function (txid) {
                return new Promise(function (resolve, reject) {
                    $.ajax({
                        url: uri,
                        data:{
                            'txid':txid,
                            '_token':'{!! csrf_token() !!}'
                        },
                        type:'POST',
                        dataType:'JSON',
                        success:function(data){
                            if(data.status){
                                swal({
                                    title:data.msg,
                                    type:'success',
                                    timer:1500
                                })
                            }else{
                                swal({
                                    title:'Error: '+data.msg,
                                    type:'error',
                                    timer:3000
                                })
                            }
                        }
                    });
                })
            },
            allowOutsideClick: false
        });
    }

    function deny(uri){
        swal({
            title: 'Reject',
            text:'Are you sure?',
            confirmButtonText: 'Deny',
            showCancelButton:true,
            showLoaderOnConfirm: true,
            preConfirm: function () {
                return new Promise(function (resolve, reject) {
                    $.ajax({
                        url: uri,
                        type:'GET',
                        dataType:'JSON',
                        success:function(data){
                            if(data.status){
                                swal({
                                    title:data.msg,
                                    type:'success',
                                    timer:1500
                                })
                            }else{
                                swal({
                                    title:'Error: '+data.msg,
                                    type:'error',
                                    timer:3000
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