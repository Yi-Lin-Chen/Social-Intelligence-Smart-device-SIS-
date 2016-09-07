@extends('layouts.app')

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
.btn {
    width: 90%;
}
.btn-col {
    margin: 0 auto;
    text-align: center;
}
</style>
@endsection

@section('scripts')

@endsection

@section('content')
<div class="container">

    <div class="row">
        @if( $type == 'list' )
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Pending User Request</div>
                <div class="panel-body">
                    <table class="table table-bordered">
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
                                <td><button class="btn btn-danger btn-xs">Delete</button></td>
                                <td><a href="/approval/{{ $item->id }}" class="btn btn-primary btn-xs">Enter</button></td>
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
                    <div class="col-md-6 col-md-offset-3">
                        <a href="https://www.facebook.com/{{ $user->fb_id }}" target="_blank" class="btn btn-block btn-social btn-facebook">
                           <span class="fa fa-facebook"></span> View Profile
                        </a>
                    </div>
                </div>

                <div class="row custom-row">
                    <div class="col-md-6 btn-col">
                        <a href="/approval/grant/{{ $request->id }}" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Approve</a>
                    </div>
                    <div class="col-md-6 btn-col">
                        <a href="/approval/deny/{{ $request->id }}" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Deny</a>
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
