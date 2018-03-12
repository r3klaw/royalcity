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
        <li>
            <a href="{{url('transactions')}}">
                <i class="fa fa-money"></i>
                <p>Payments</p>
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
                        <i class="ti-music-alt"></i>
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
            <a href="{!! url('file/list') !!}" class="btn btn-primary pull-right"><i class="fa fa-money"></i> Purchase File</a>
            <h3 class="title">Files</h3>
        </div>
        <div class="content">
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
                            <td>
                                @if(isset($file->files))
                                    {!! $file->files->name !!}
                                @endif
                            </td>
                            <td>{!! $file->amount !!}</td>
                            <td>{!! $file->created_at !!}</td>
                            <td>
                                @if(isset($file->files))
                                    <a href="{!! url('/file/download/'.$file->files->id) !!}" class="btn btn-primary"><i class="fa fa-download"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection