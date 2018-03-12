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
        <li class="dropdown active">
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
            <div class="pull-right"><button class="btn btn-primary" data-toggle="collapse" aria-expanded="false" data-target="#uploadfile" type="button"><i class="fa fa-upload"></i> Add File</button></div>
            <h3 class="title">Files</h3>
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
            <div class="panel panel-primary collapse" id="uploadfile">
                <div class="panel-heading">
                    <h4 class="text-center"><i class="fa fa-upload"></i> Add File</h4>
                </div>
                <div class="panel-body">
                    {!! Form::open(['url'=>'file','files'=>true]) !!}
                    <div class="form-group">
                        {!! Form::label('name','Name') !!}
                        {!! Form::text('name',null,['placeholder'=>'Name...','class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('type','Type') !!}
                        <select name="type" id="type" class="form-control">
                            <option value="">Select Type</option>
                            <option value="1">Document</option>
                            <option value="2">Video</option>
                            <option value="3">Music</option>
                        </select>
                    </div>
                    <div class="form-group">
                        {!! Form::label('amount','Amount') !!}
                        {!! Form::number('amount',null,['placeholder'=>'Amount','class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('description','Description') !!}
                        {!! Form::textarea('description',null,['class'=>'form-control','placeholder'=>'Enter file description']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('file','File') !!}
                        {!! Form::file('file') !!}
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
                    <th>Amount</th>
                    <th>Created At</th>
                    <th></th>
                    </thead>
                    <tbody>
                    @foreach($files as $file)
                        <tr>
                            <td>{!! $file->id !!}</td>
                            <td>{!! $file->name !!}</td>
                            <td>{!! $file->amount !!}</td>
                            <td>{!! $file->created_at !!}</td>
                            <td>
                                <a href="{!! url('/file/download/'.$file->id) !!}" target="_blank" class="btn btn-primary"><i class="fa fa-download"></i></a>
                                <a href="{!! url('/file/'.$file->id) !!}" class="btn btn-primary"><i class="fa fa-file-text"></i> </a>
                                <a href="{!! url('/file/delete/'.$file->id) !!}" class="btn btn-warning"><i class="fa fa-trash"></i> </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection