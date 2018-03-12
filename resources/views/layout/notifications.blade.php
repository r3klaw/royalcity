<?php
    if(Auth::user()->hasRole('admin')){
        $notifications=\App\Notifications::where('for_user','=',\Illuminate\Support\Facades\Auth::user()->id)->where('read',0)->orWhere(
            'for_user','=',0
        )->where('read',0)->get();
        $count=\App\Notifications::where('for_user','=',\Illuminate\Support\Facades\Auth::user()->id)->where('read',0)->orWhere(
            'for_user','=',0
        )->where('read',0)->count();
    }else{
        $notifications=\App\Notifications::where('for_user',\Illuminate\Support\Facades\Auth::user()->id)->where('read',0)->get();
        $count=\App\Notifications::where('for_user',\Illuminate\Support\Facades\Auth::user()->id)->where('read',0)->count();
    }
?>
<div class="col-md-3">
    <div class="card">
        <div class="content">
            <div class="header">
                <h3 class="title pull-left">
                    Notifications &nbsp;
                </h3>
                <div class="label label-primary">Unread: {{$count}}</div>
            </div>
            <hr>
            <div class="body">
                @foreach($notifications as $notification)
                    <div class="alert
                        @if($notification->type==0)
                                alert-danger
                        @elseif($notification->type==1)
                                alert-success
                        @elseif($notification->type==2)
                                alert-info
                        @endif">
                        {!! $notification->message !!}
                        <a href="#" onclick="dismiss({{$notification->id}})" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script type="text/javascript">
        function dismiss(id){
            $.ajax({
                url         :   'notifications/dismiss/'+id,
                type        :   'get',
                success     :   function(data){
                    shownotification('top','center');
                }
            });
        }
        function shownotification(from, align){
            $.notify({
                message: "Notification Dismissed"
            },{
                timer: 3000,
                placement: {
                    from: from,
                    align: align
                }
            });
        }
    </script>
@endsection