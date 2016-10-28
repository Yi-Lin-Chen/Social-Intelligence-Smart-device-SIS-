@extends('layouts.app')

@section('title', 'BB8 Control')

@section('styles')
<style media="screen">
.bb8-btn {
    width: 100%;
    height: 13.5vh;
    font-size: 2.5em;
}
td {
    border-top: none !important;
}
.bb8-addi-btn {
    width: 100%;
}
</style>
@endsection

@section('script')
<script>
$(function() {

    var connected = new WebSocket('ws://{{ env('WEBSOCKET_ADDR') }}/bb8/status');
    connected.onclose = function() {
        $('#status').html('<span class="label label-danger">斷線</span>');
    }
    connected.onerror = function() {
        $('#status').html('<span class="label label-danger">斷線</span>');
    }
    connected.onmessage = function (event) {
        var data = JSON.parse(event.data);
        console.log(data);
        if( data.status )
            $('#status').html('<span class="label label-success">已連線</span>');
        else {
            $('#status').html('<span class="label label-warning">BB8 未連接</span>');
        }
    }

    var bb8_control = new WebSocket('ws://{{ env('WEBSOCKET_ADDR') }}/bb8/control');

    $('#up').click(function() {
        bb8_control.send('up');
    });

    $('#down').click(function() {
        bb8_control.send('down');
    });

    $('#left').click(function() {
        bb8_control.send('left');
    });

    $('#right').click(function() {
        bb8_control.send('right');
    });

    $('#stop').click(function() {
        bb8_control.send('stop');
    });

    $('#calibrate').click(function() {
        bb8_control.send('calibrate');
    });

    $('#calibrate_finish').click(function() {
        bb8_control.send('calibrate_finish');
    });

    $('#reconnect').click(function() {
        bb8_control.send('reconnect');
    });

    // Disable overscroll / viewport moving on everything but scrollable divs
    $('body').on('touchmove', function (e) {
            if (!$('.scrollable').has($(e.target)).length) e.preventDefault();
    });
});
</script>
@endsection

@section('content')
<div class="container">
    @if( !Auth::user()->isManager() && Auth::user()->fb_group_level() < 2 )
        <div class="alert alert-danger">Oops, you have no access to this page.</div>
    @else
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">BB8 Control
                        <span id="status" class="pull-right"><span class="label label-warning">連接中</span></span>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td><button class="btn btn-default bb8-btn" id="up"><span class="glyphicon glyphicon-arrow-up"></span></button></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><button class="btn btn-default bb8-btn" id="left"><span class="glyphicon glyphicon-arrow-left"></span></button></td>
                                    <td><button class="btn btn-default bb8-btn" id="stop"><span class="glyphicon glyphicon-stop"></span></button></td>
                                    <td><button class="btn btn-default bb8-btn" id="right"><span class="glyphicon glyphicon-arrow-right"></span></button></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><button class="btn btn-default bb8-btn" id="down"><span class="glyphicon glyphicon-arrow-down"></span></button></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td><button class="btn btn-primary bb8-addi-btn" id="calibrate">方向校準</button></td>
                                    <td><button class="btn btn-default bb8-addi-btn" id="reconnect">重新連接</button></td>
                                    <td><button class="btn btn-primary bb8-addi-btn" id="calibrate_finish">完成校準</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
