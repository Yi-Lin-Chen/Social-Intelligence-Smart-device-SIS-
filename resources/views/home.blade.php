@extends('layouts.app')

@section('title', 'Home')

@section('styles')
<style media="screen">
    .door-photo {
        width: 100%;
    }
    #last_update {
        padding-top: 10px;
    }
</style>
@endsection

@section('script')
<script>
$(function() {

    $('#door-status').click(function() {
        getStatus();
    });

    $('.btn-record').click(function() {
        bootbox.alert('<img src="/home/door/record?ts=' + $(this).data('ts') + '">');
    });

    $('#door-photo').click(function() {
        var now = new Date();
        $('.col-big').append(
            '<div class="panel panel-default"><div class="panel-heading">Photo: ' + now + '</div><div class="panel-body"><img class="door-photo" src="/home/door/photo?ts=' + now.getTime() + '"/></div></div>'
        );
        //$('.door-photo').css('width', '100%');
    });

    $('#door-lock').click(function() {
        $.getJSON('/home/door/lock', {} , function(resp) {
            console.log(resp);
            getStatus();
        }).fail(function(resp) {
            updateStatusBtn('Network error, click to retry', 'danger');
            console.error(resp);
        });
    });

    $('#door-unlock').click(function() {
        $.getJSON('/home/door/unlock', {} , function(resp) {
            console.log(resp);
            getStatus();
        }).fail(function(resp) {
            updateStatusBtn('Network error, click to retry', 'danger');
            console.error(resp);
        });
    });

    // First Time
    getStatus();

    var interval = setInterval(function(){
        getStatus(false);
    }, 5000);
});

var getStatus = function(show_status) {

    if(show_status == undefined)
        show_status = true;

    if(show_status)
        updateStatusBtn('Updating...', 'default');

    $.getJSON('/home/door/status', {} , function(resp) {

        console.log(resp);
        if( resp.lock == 0 ) {
            updateStatusBtn('Unlocked', 'warning');
        } else if( resp.lock == 1) {
            updateStatusBtn('Locked', 'success');
        }

    }).fail(function(resp) {
        updateStatusBtn('Network error, click to retry', 'danger');
        console.error(resp);
    });

    $('#last_update').html('Last update at ' + (new Date()));
}

var updateStatusBtn = function(text, btn_class) {
    $('#door-status').html(text);
    $('#door-status').removeClass('btn-default');
    $('#door-status').removeClass('btn-success');
    $('#door-status').removeClass('btn-info');
    $('#door-status').removeClass('btn-warning');
    $('#door-status').removeClass('btn-danger');
    $('#door-status').addClass('btn-' + btn_class);
}
</script>
@endsection

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-8 col-big">
            <div class="panel panel-default">
                <div class="panel-heading">Recent QRCode Query Log</div>
                <div class="panel-body">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Time</th>
                                <th>IP</th>
                                <th>Code</th>
                                <th>Access Data</th>
                                <th>Photo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $records as $record )
                                <td>{{ $record->id }}</td>
                                <td>{{ $record->created_at }}</td>
                                <td>{{ $record->ip }}</td>
                                <td>{{ $record->error_code }}</td>
                                <td>
                                    @if( $record->access_id == null )
                                        -
                                    @else
                                        Access #{{ $record->access_id }}<br/>
                                        User #{{ $record->access()->first()->user()->first()->id }} {{ $record->access()->first()->user()->first()->name }}
                                    @endif
                                </td>
                                <td>
                                    @if( $record->photo_ts != null )
                                        <button class="btn btn-default btn-record" data-ts="{{ $record->photo_ts }}"><span class="glyphicon glyphicon-picture"></span></button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Door Control</div>
                <div class="panel-body" style="text-align: center;">
                    <p>
                        Server at {{ env('DOOR_SERVER_URL') }}
                    </p>
                    <hr>
                    <p>
                        Door status
                    </p>
                    <button class="btn btn-default" id="door-status">Loading...</button>
                    <p id="last_update">

                    </p>
                    <hr>
                    <button class="btn btn-success" id="door-lock">Lock</button>
                    <button class="btn btn-warning" id="door-unlock">Unlock</button>
                    <hr>
                    <button class="btn btn-default" id="door-photo">Take Photo</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
