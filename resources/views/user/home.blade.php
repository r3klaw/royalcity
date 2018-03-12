@extends('layout.dashboard')
@section('title')
    Royal City
@endsection
@section('logo')
    {!! url('/home') !!}
@endsection
@section('sidebar')
    <ul class="nav">
        <li class="active">
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
    <div class="row">
        <div class="col-lg-4 col-sm-6">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="icon-big icon-warning text-center">
                                <i class="ti-comments"></i>
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <div class="numbers">
                                <p>Messages</p>
                                <br>
                                {!! $messages !!}
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="ti-reload"></i> Updated now
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="icon-big icon-success text-center">
                                <i class="ti-bell"></i>
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <div class="numbers">
                                <p>Notifications</p>
                                <br>
                                {!! $notifications !!}
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="ti-reload"></i> Updated now
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="icon-big icon-warning text-center">
                                <i class="ti-wallet"></i>
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <div class="numbers">
                                <p>Balance</p>
                                KSH
                                <br>
                                {!! number_format($balance,2) !!}
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="ti-reload"></i> Updated now
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-sm-6">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="icon-big icon-success text-center">
                                <i class="ti-files"></i>
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <div class="numbers">
                                <p>Files</p>
                                {{$files}}
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="ti-reload"></i> Updated now
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="icon-big icon-danger text-center">
                                <i class="ti-ticket"></i>
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <div class="numbers">
                                <p>Tickets</p>
                                Coming Soon
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="ti-reload"></i> Updated Recently
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <h4>Expenditure</h4>
        <div class="col-lg-4 col-sm-6">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="icon-big icon-success text-center">
                                <i class="ti-files"></i>
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <div class="numbers">
                                <p>Files</p>
                                KSH {{number_format($files_spent,2)}}
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="ti-reload"></i> Updated now
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-6">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="icon-big icon-danger text-center">
                                <i class="ti-ticket"></i>
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <div class="numbers">
                                <p>Tickets</p>
                                Coming Soon
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="ti-reload"></i> Updated Recently
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection