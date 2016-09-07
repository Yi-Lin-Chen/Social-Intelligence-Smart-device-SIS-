@extends('layouts.app')

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
                    <a href="/request/redirect" class="btn btn-block btn-social btn-facebook">
                       <span class="fa fa-facebook"></span> Sign in with Facebook
                     </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
