@extends('layouts.app')

@section('title', 'Request')

@section('styles')
<style media="screen">

</style>
@endsection

@section('scripts')


@endsection

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Request Permission from the room manager</div>
                <div class="panel-body">
                    <a href="/request/send" class="btn btn-danger btn-block">
                        Send your request to the manager
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
