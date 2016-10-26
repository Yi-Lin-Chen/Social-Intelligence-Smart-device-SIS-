@extends('layouts.app')

@section('title', 'IFTTT')

@section('styles')
<style media="screen">
.btn{
    width: 100px;
}
</style>
@endsection


@section('script')
<script type="text/javascript">
$(function() {

    $(document).on('click' , '.btn-delete' , function(){
        var id = $(this).data('id');
        console.log('btn-delete click, id = ' + id);

        bootbox.confirm('Do you really want to delete ifttt #' + id + '?', function(ret) {
            if (ret) {
                $.ajax({
                    url: '/ifttt/' + id,
                    method: 'DELETE',
                    data: {
                        _token: window.Laravel.csrfToken
                    }
                }).done(function (resp) {
                    console.log(resp);
                    location.href = '/ifttt';
                }).fail(function (resp) {
                    bootbox.alert('Delete ifttt fail!');
                    console.error(resp);
                });
            }
        });
    } );

});
</script>
@endsection


@section('content')
<div class="container">

    @if( isset($errors) && count($errors) > 0 )
        <div class="alert alert-danger" role="alert">
            {{ $errors->first() }}
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">IFTTT List</div>
                <div class="panel-body">
                    <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>UUID</th>
                                <th>IF</th>
                                <th>Operator</th>
                                <th>Value</th>
                                <th>Then</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $ifttts as $ifttt )
                                <tr>
                                    <td>
                                        {{ $ifttt->uuid }}
                                    </td>
                                    <td>
                                        @if ( $ifttt->if == "humidity.temperature" )
                                            溫度
                                        @elseif ( $ifttt->if == "humidity.humidity" )
                                            相對濕度
                                        @elseif ( $ifttt->if == "irTemperature.objectTemperature" )
                                            紅外線溫度
                                        @elseif ( $ifttt->if == "barometricPressure.pressure" )
                                            大氣壓力
                                        @elseif ( $ifttt->if == "irTemperature.ambientTemperature" )
                                            裝置溫度
                                        @endif
                                    </td>
                                    <td>
                                        {{ $ifttt->opr }}
                                    </td>
                                    <td>
                                        {{ $ifttt->value }}
                                    </td>
                                    <td>
                                      @if ( $ifttt->then == "speaker" )
                                          Speaker
                                      @elseif ( $ifttt->then == "open_door" )
                                          Open door
                                      @elseif ( $ifttt->then == "email" )
                                          Send Email
                                      @elseif ( $ifttt->then == "email_photo" )
                                          Send photo by email
                                      @endif
                                    </td>
                                    <td>
                                        <button data-id="{{ $ifttt->id }}"  class="btn btn-danger btn-xs btn-delete"><span class="glyphicon glyphicon-remove"></span></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">IFTTT Create</div>
                <div class="panel-body">
                    <form method="post" action="/ifttt">
                        {{ csrf_field() }}
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>UUID</th>
                                    <th>IF</th>
                                    <th>Operator</th>
                                    <th>Value</th>
                                    <th>Then</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="uuid" id="uuid" class="form-control">
                                            <option value="0">Please select device.</option>
                                            @foreach ( $devices as $device )
                                                <option value="{{ $device->uuid }}"> Device: {{ $device->uuid }} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="if" id="if" class="form-control">
                                            <option value="0">Please select service.</option>
                                            <option value="humidity.temperature">溫度</option>
                                            <option value="humidity.humidity">相對濕度</option>
                                            <option value="irTemperature.objectTemperature">紅外線溫度</option>
                                            <option value="barometricPressure.pressure">大氣壓力</option>
                                            <option value="irTemperature.ambientTemperature">裝置溫度</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="opr" id="opr" class="form-control">
                                            <option value="0">Please select operation.</option>
                                            <option value=">">&gt;</option>
                                            <option value="=">=</option>
                                            <option value="<">&lt;</option>
                                            <option value=">=">&gt;=</option>
                                            <option value="<=">&lt;=</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="value" id="value" placeholder="Please input number." value="{{ Request::old('value') }}">
                                    </td>
                                    <td>
                                        <select name="then" id="then" class="form-control">
                                            <option value="0">Please select value.</option>
                                            <option value="speaker">Speaker</option>
                                            <option value="open_door">Open door</option>
                                            <option value="email">Send email</option>
                                            <option value="email_photo">Send photo by email</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-add btn-primary pull-right">Create</button>
                    </from>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
