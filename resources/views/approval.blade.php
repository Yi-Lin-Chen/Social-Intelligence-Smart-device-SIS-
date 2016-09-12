@extends('layouts.app')

@section('title', 'Approval')

@section('styles')
<style media="screen">
.wrapper {
    text-align: center;
    margin: 0 auto;
}
.custom-row {
    margin-top: 20px;
    margin-bottom: 30px;
}
.btn-enter,
.btn-delete{
    width: 100%;
}
.btn-col {
    margin: 0 auto;
    text-align: center;
    margin-top: 10px;
}
.table-list td{
    vertical-align:middle !important;
}
</style>
@endsection

@section('script')
<script>
    $(function(){
        $('#deny-btn').click(function() {
            bootbox.dialog({
                title: "Pick a denail reason",
                message: ''
            });
        });

        $(document).on('click' , '.btn-delete' , function(){
            var id = $(this).data('id');
            console.log('btn-delete click, id = ' + id);

        bootbox.confirm('Do you really want to delete user #' + id + '?', function(ret) {
            if(ret) {
                $.ajax({
                    url: '/approval/' + id,
                    method: 'DELETE',
                    data: {
                        _token: window.Laravel.csrfToken
                    }
                }).done(function(resp) {
                    console.log(resp);
                    location.href = '/approval';
                }).fail(function(resp) {
                    bootbox.alert('Delete approval fail!');
                    console.error(resp);
                });
            }
        });
        });
    });
</script>
@endsection

@section('content')
<div class="container">

    <div class="row">
        @if( $type == 'list' )

        <div class="col-md-12">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="panel panel-default">
                <div class="panel-heading">Pending User Request</div>
                <div class="panel-body">
                    <table class="table table-bordered table-list">
                        <thead>
                            <tr>
                                <th>Avatar</th>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>Request Time</th>
                                <th>State</th>
                                <th>Delete</th>
                                <th>Enter</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $request as $item )
                            <tr>
                                <td><img src="{{ $item->user()->first()->fb_avatar(1) }}" alt="FB Avatar"></td>
                                <td>{{ $item->user_id }}</td>
                                <td>{{ $item->user()->first()->name }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->state }}</td>
                                <td><button data-id="{{ $item->id }}" class="btn btn-danger btn-xs btn-delete">Delete</button></td>
                                <td><a href="/approval/{{ $item->id }}" class="btn btn-primary btn-xs btn-enter">Enter</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @else
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">Approve User Request</div>
                <div class="panel-body">

                <p>
                    {{ $user->name }} Requested for access to enter your room
                </p>

                <div class="wrapper">
                    <img src="{{ $user->fb_avatar(3) }}" class="avatar" alt="">
                </div>

                <div class="row custom-row">

                    <div class="col-md-12">
                        <a href="https://www.facebook.com/{{ $user->fb_id }}" target="_blank" class="btn btn-block btn-social btn-facebook">
                           <span class="fa fa-facebook"></span> View Profile
                        </a>
                    </div>

                </div>

                <div class="row custom-row">
                    <div class="col-md-6 btn-col">
                        <a href="/approval/grant/{{ $request->id }}" class="btn btn-primary btn-enter"><span class="glyphicon glyphicon-ok"></span> Approve</a>
                    </div>
                    <div class="col-md-6 btn-col">
                        <a href="/approval/deny/{{ $request->id }}" id="deny-btn" class="btn btn-danger btn-enter"><span class="glyphicon glyphicon-remove"></span> Deny</a>
                    </div>
                </div>

                <p>This user will only be granted access for 24 hour, you can extend it in the access control page.</p>

                </div>
            </div>
        </div>
        @endif
        </div>
    </div>

</div>
@endsection
