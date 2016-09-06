@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">Recent Activity</div>
                <div class="panel-body">

                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="panel panel-danger">
                <div class="panel-heading">Direct Control</div>
                <div class="panel-body" style="text-align: center;">
                    <button class="btn btn-danger">Open Door</button>
                    <hr>
                    <button class="btn btn-default">Take Photo</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
