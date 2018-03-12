@extends('layout.dashboard')
@section('title')
    Royal City
@endsection
@section('logo')
    {!! url('/home') !!}
@endsection
@section('sidebar')
    <ul class="nav">
        <li>
            <a href="{{url('home')}}">
                <i class="ti-panel"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="hidden">
            <a href="{{url('tickets')}}">
                <i class="ti-ticket"></i>
                <p>Tickets</p>
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
            <a href="{{url('messages')}}">
                <i class="ti-comments"></i>
                <p>Messages</p>
            </a>
        </li>
        <li class="active-pro  active">
            <a href="{{url('settings')}}">
                <i class="ti-settings"></i>
                <p>Settings</p>
            </a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="card">
        <div class="header">
            <h3 class="title">Settings</h3>
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
            <div class="container-fluid">
                {!! Form::open(['url'=>'settings']) !!}
                <div class="form-group">
                    {!! Form::label('name','Name') !!}
                    {!! Form::text('name',$profile->name,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('phone','Phone') !!}
                    {!! Form::text('phone',$profile->phone,['placeholder'=>'Phone','class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('balance','Balance') !!}
                    {!! Form::number('balance',$profile->balance,['class'=>'form-control','disabled']) !!}
                </div>
                <div class="form-group form-inline">
                    <div class="col-md-4">
                        {!! Form::label('password_old','Current Password') !!}<br>
                        {!! Form::password('password_old',['class'=>'form-control']) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Form::label('password_new','New Password') !!}<br>
                        {!! Form::password('password_new',['class'=>'form-control']) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Form::label('password_confirm','Confirm Password') !!}<br>
                        {!! Form::password('password_confirm',['class'=>'form-control']) !!}
                    </div>
                </div>
                <button class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('notification')
    <div class="card">
        <div class="content">
            Notification
        </div>
    </div>
@endsection
@section('styles')
@endsection
@section('scripts')
@endsection