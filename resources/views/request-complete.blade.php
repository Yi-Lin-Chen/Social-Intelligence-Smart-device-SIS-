@extends('layouts.app')

@section('title', 'Request Complete')

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
                <div class="panel-heading">Request Permission Completed</div>
                <div class="panel-body">
                    Hello {{ $name }}, <br/><br/>
                    Your request has been sent to the manager, please wait for response or call the manager, thank you.
                    <br>
                    <br>

                    <a href="/" class="btn btn-primary">Back to home</a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
