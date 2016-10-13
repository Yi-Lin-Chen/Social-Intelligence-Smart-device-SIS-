@extends('layouts.app')

@section('title', 'Device')

@section('styles')
<style media="screen">

</style>
@endsection

@section('script')
<script src="/js/sprintf.min.js"></script>
<script>

var device_panel = '<div class="panel panel-info">' +
    '<div class="panel-heading"><span class="glyphicon glyphicon-record"></span> Sensortag</div>' +
    '<div class="panel-body">' +
    '<span class="label label-info">%s</span>&nbsp;' +
    '<span class="label label-info">%s</span>' +
    '<button class="btn btn-default btn-sm btn-view pull-right" data-uuid="%s">View</button>'+
    '</div>' +
'</div>';

$(function(){

    var info = new WebSocket('ws://{{ env('WEBSOCKET_ADDR') }}/sensortag/connected');

    info.onclose = function() {
        $('#dev-status').html('<span class="label label-danger">斷線</button>');
    }
    info.onerror = function() {
        $('#dev-status').html('<span class="label label-danger">斷線</button>');
    }
    info.onmessage = function (event) {
        var device = JSON.parse(event.data);
        $('#device-panel').html('');
        for( var uuid in device ) {
            $('#device-panel').append(sprintf(device_panel, device[uuid].type, device[uuid].address, uuid));
        }
    }

    $(document).on('click', '.btn-view', function(event) {

        var uuid = $(this).data('uuid');
        console.log('View %s', uuid);

        location.href = '/sensor/' + uuid;
    });

});
</script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <!-- 拖拉介面塞在這裡 -->
            <div class="panel panel-default">
                <div class="panel-heading">Device Map</div>
                <div class="panel-body">

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Connected Device <span id="dev-status"></span></div>
                <div class="panel-body" id="device-panel">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
