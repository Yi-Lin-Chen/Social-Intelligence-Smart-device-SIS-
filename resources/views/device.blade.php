@extends('layouts.app')

@section('title', 'Device')

@section('styles')
<style media="screen">
.roommap{
    background-image: url("/img/room_layout.jpg");
    background-size: 600px 600px;
    margin:auto;
    width: 600px;
    height: 600px;
}
.device{
  width: 30px;
}
.device-img{
  width: 3em;
  height: 3em;
}
</style>
@endsection

@section('script')
<script src="/js/sprintf.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>

var device_panel = '<div class="panel panel-info">' +
    '<div class="panel-heading"><span class="glyphicon glyphicon-record"></span> Sensortag</div>' +
    '<div class="panel-body">' +
    '<span class="label label-info">%s</span>&nbsp;' +
    '<span class="label label-info">%s</span>' +
    '<div class="btn-group pull-right" role="group" data-uuid="%s">'+
      '<button type="button" class="btn btn-sm btn-add btn-default"><span class="glyphicon glyphicon-plus"></span></button>'+
      '<button type="button" class="btn btn-sm btn-delete btn-default"><span class="glyphicon glyphicon-minus"></span></button>'+
      '<button type="button" class="btn btn-sm btn-view btn-default"><span class="glyphicon glyphicon-arrow-right"></span></button>'+
    '</div>'+
'</div>';

var device_div = '<div id="device" data-uuid="%s" class="device draggable">' +
    '<img class="device-img" src="/img/device1.png">' +
'</div>';

var device = {
  "1111": {
     "type": 'fjaweio',
     "address": '1111'
   }
};

var current_device = {};

$(document).ready(function(){

    var info = new WebSocket('ws://{{ env('WEBSOCKET_ADDR') }}/sensortag/connected');

    info.onclose = function() {
        $('#dev-status').html('<span class="label label-danger">斷線</span>');
    }
    info.onerror = function() {
        $('#dev-status').html('<span class="label label-danger">斷線</span>');
    }
    info.onmessage = function (event) {
        var device = JSON.parse(event.data);
        $('#device-panel').html('');
        for( var uuid in device ) {
          $('#device-panel').append(sprintf(device_panel, device[uuid].type, device[uuid].address, uuid));
        }
    }

    $('#device-panel').append(sprintf(device_panel, device["1111"].type, device["1111"].address, "1111" ));

    $(document).on('click', '.btn-view', function(event) {

        var uuid = $(this).parent().data('uuid');
        console.log('View %s', uuid);

        location.href = '/sensor/' + uuid;
    });

    $(document).on('click', '.btn-add', function(event) {
        var uuid = $(this).parent().data('uuid');
        console.log('Add %s', uuid);

        if( current_device[uuid] != undefined )
          return;
        else {
          current_device[uuid] = true;
        }

        $('#containment-wrapper').append(sprintf(device_div, uuid));

        $('.draggable').draggable({
          containment: "#containment-wrapper",
          drag: function(){
            var offset = $(this).offset();
            var xPos = offset.left;
            var yPos = offset.top;
            $('#posX').text('x: ' + xPos);
            $('#posY').text('y: ' + yPos);
          },
          stop: function(){
            var finalOffset = $(this).offset();
            var finalxPos = finalOffset.left;
            var finalyPos = finalOffset.top;
            $('#finalX').text('Final X:' + finalxPos);
            $('#finalY').text('Final Y:' + finalyPos);
          },
          scroll:true
        });
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
                <div id="containment-wrapper" class="panel-body roommap">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Connected Device<span id="dev-status pull-right"></span></div>
                <div class="panel-body" id="device-panel">

                </div>
            </div>
        </div>
    </div>
</div>
<div>
    <ul>
        <li id="posX">x: <span></span></li>
        <li id="posY">y: <span></span></li>
        <li id="finalX">Final X: <span></span></li>
        <li id="finalY">Final Y: <span></span></li>
    </ul>
</div>
@endsection
