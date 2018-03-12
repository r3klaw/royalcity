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
        <li class="active">
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
    <div class="card">
        <div class="header">
            <div class="pull-right"><button class="btn btn-primary" data-toggle="collapse" aria-expanded="false" data-target="#makepayment" type="button"><i class="fa fa-money"></i> Add Payment</button></div>
            <h3 class="title">Payments</h3>
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
            <div class="panel panel-primary collapse" id="makepayment">
                <div class="panel-heading">
                    <h4 class="text-center"><i class="fa fa-money"></i> Add Payment</h4>
                </div>
                <div class="panel-body">
                    {!! Form::open(['url'=>'payment']) !!}
                    <div class="form-group">
                        {!! Form::label('transactionid','Transaction ID') !!}
                        {!! Form::text('transactionid',null,['placeholder'=>'Transaction ID','class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('amount','Amount') !!}
                        {!! Form::number('amount',null,['placeholder'=>'Amount','class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('contact','Contact') !!}
                        {!! Form::text('contact',null,['class'=>'form-control','placeholder'=>'Enter payer\'s Contact']) !!}
                    </div>
                    {!! Form::submit('Submit',['class'=>'btn btn-primary pull-right']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="table-condensed table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                    <th>#</th>
                    <th>Transaction Id</th>
                    <th>Amount</th>
                    <th>Contact</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th></th>
                    </thead>
                    <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td>{!! $payment->id !!}</td>
                            <td>{!! $payment->transactionid !!}</td>
                            <td>{!! $payment->amount !!}</td>
                            <td>{!! $payment->contact !!}</td>
                            <td>
                                @if($payment->status==0)
                                    <span class="label label-default">Waiting</span>
                                @elseif($payment->status==1)
                                    <span class="label label-info">Processing</span>
                                @elseif($payment->status==2)
                                    <span class="label label-success">Completed</span>
                                @elseif($payment->status==3)
                                    <span class="label label-danger">Declined</span>
                                @endif
                            </td>
                            <td>{!! $payment->created_at !!}</td>
                            <td>{!! $payment->updated_at !!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection