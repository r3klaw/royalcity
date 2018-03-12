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
        <li class="hidden">
            <a href="{{url('tickets')}}">
                <i class="ti-ticket"></i>
                <p>Tickets</p>
            </a>
        </li>
        <li class="dropdown active">
            <a href="#demo3" data-toggle="collapse">
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
    </ul>
@endsection
@section('content')
    <div class="card">
        <div class="header">
            <span class="label label-info pull-right"><i class="fa fa-download"></i> {!! $stats !!}</span>
            <h3 class="title">About File</h3>
        </div>
        <div class="content">
            <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))
                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                    @endif
                @endforeach
            </div> <!-- end .flash-message -->
        </div>
    </div>
    <div class="card">
        <div class="header">
            <a href="{!! url('/file/download/'.$file->id) !!}" target="_blank" class="btn btn-primary pull-right"><i class="fa fa-download"></i></a>
            <h4 class="title"> {!! $file->name !!}</h4>
        </div>
        <div class="content">
            <h4>Description</h4>
            <hr>
            <p>{!! $file->description !!}</p>
            <hr>
            <div class="footer">
                <a href="{!! URL::previous() !!}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Go to Files</a>
            </div>
        </div>
    </div>
@endsection