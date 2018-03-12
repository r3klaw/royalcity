@extends('layout.dashboard')
@section('title')
    Royal City
@endsection
@section('logo')
    royalcity.jpg
@endsection
@section('sidebar')
    <ul class="nav">
        <li class="active">
            <a href="{{url('home')}}">
                <i class="ti-panel"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li>
            <a href="{{url('users')}}">
                <i class="fa fa-users"></i>
                <p>Users</p>
            </a>
        </li>
        <li>
            <a href="{{url('tickets')}}">
                <i class="ti-ticket"></i>
                <p>Tickets</p>
            </a>
        </li>
        <li>
            <a href="{{url('torrents')}}">
                <i class="fa fa-magnet"></i>
                <p>Torrents</p>
            </a>
        </li>
        <li>
            <a href="{{url('transactions')}}">
                <i class="fa fa-money"></i>
                <p>Payments</p>
            </a>
        </li>
        <li>
            <a href="{{url('files')}}">
                <i class="ti-files"></i>
                <p>Files</p>
            </a>
        </li>
        <li>
            <a href="{{url('')}}">
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
    <div class="row"><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus aliquam amet aperiam commodi delectus esse laborum, minima nam odio, omnis quas quidem temporibus velit. Consequatur deleniti impedit officiis temporibus ullam.</p></div>
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