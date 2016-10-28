@extends('layouts.app')

@section('title', 'Device')

@section('styles')
<style media="screen">
.roommap{
    background-image: url("/storage/room_layout.jpg");
    background-size: 600px 600px;
    margin:auto;
    width: 600px;
    height: 600px;
}
.device{
  width: 30px;
}
.device-img{
  color: rgba(255,0,87,0.22);
}
label{
   display: inline-block;
   /*width: 5em;*/
 }
</style>
<link rel="stylesheet" href="/css/jquery-ui.css">
@endsection

@section('script')
<script src="/js/sprintf.min.js"></script>
<script src="/js/jquery-ui.js"></script>
<script>

//device list
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

//device img
var device_div = '<div id="%s" data-uuid="%s" class="device draggable">' +
    '<span class="fa fa-asterisk fa-3x device-img" title="UUID: %s"></span>' +
'</div>';

var connect_device  = {}; //connecting device
var current_device = {};  //device on map

//Load device setted address
function load_device(){
    $( '#containment-wrapper' ).html('');
    $.get('/device/all',{} , function(res){
      var device = res.device;
      var manager = res.manager;
      console.log(res);
      if ( device.length != 0 ){
          for ( var index in device ){
              $('#containment-wrapper').append(sprintf(device_div, device[index].uuid, device[index].uuid, device[index].uuid));
              $('#' + device[index].uuid).offset({ top: device[index].y, left: device[index].x });
              current_device[device[index].uuid] = true;
	      update_device_status( device[index].uuid );
              if ( manager == 1 ){
                  register_draggable( device[index].uuid );
              }
              else{
                  $( '.btn-add' ).attr( 'disabled', 'disabled' );
                  $( '.btn-delete' ).attr( 'disabled', 'disabled' );
              }
          }
      }
    });
}

//Device img register draggable
function register_draggable( uuid ){
    $( '#' + uuid + ' span').tooltip();
    $( '#' + uuid ).draggable({
      containment: "#containment-wrapper",
      stop: function(){
        var finalOffset = $(this).offset();
        var finalxPos = finalOffset.left;
        var finalyPos = finalOffset.top;

        $.post('/device', {uuid: uuid, x:finalxPos, y:finalyPos, _token:window.Laravel.csrfToken}, function(resp) {
          console.log(resp);
        });
      },
      scroll:true
    });
}

//Update device img color with connect ststus
function update_device_status( uuid ){
    console.log(uuid);
    if ( current_device[uuid] == true && connect_device[uuid] != undefined ){
        console.log('flag');
	$( '#' + uuid + ' span' ).css( 'color', 'rgba(255,0,87,0.87)' );
    }
    else {
        $( '#' + uuid + ' span' ).css( 'color', 'rgba(255,0,87,0.22)' );
        $( '#' + uuid + ' span' ).attr( 'title' , "UUID: " + uuid + " disconnected" );
    }
}

$(document).ready(function(){
    //To get connecting device
    var info = new WebSocket('ws://{{ env('WEBSOCKET_ADDR') }}/sensortag/connected');
    info.onclose = function() {
        $('#dev-status').html('<span class="label label-danger">斷線</span>');
    }
    info.onerror = function() {
        $('#dev-status').html('<span class="label label-danger">斷線</span>');
    }
    info.onmessage = function (event) {
        connect_device = JSON.parse(event.data);
        load_device();
        $('#device-panel').html('');
        for( var uuid in connect_device ) {
          $('#device-panel').append(sprintf(device_panel, connect_device[uuid].type, connect_device[uuid].address, uuid));
        }
    }

    //load_device();  //Load device address on device map

    //button view device
    $(document).on('click', '.btn-view', function(event) {

        var uuid = $(this).parent().data('uuid');
        console.log('View %s', uuid);

        location.href = '/sensor/' + uuid;
    });

    //button add device img on device map
    $(document).on('click', '.btn-add', function(event) {
        var uuid = $(this).parent().data('uuid');
        console.log('Add %s', uuid);

        if( current_device[uuid] != undefined ){
          return;
        }
        else {
          current_device[uuid] = true;
        }

        $('#containment-wrapper').append(sprintf(device_div, uuid, uuid, uuid));

        register_draggable( uuid );
        update_device_status( uuid );
    });

    //button delete device img on map
    $(document).on('click', '.btn-delete', function(event){
        var uuid = $(this).parent().data('uuid');
        console.log('Delete %s', uuid);
        if ( current_device[uuid] != true ){
            return;
        }
        else{
            current_device[uuid] = undefined;
            $('#' + uuid).remove();
            $.ajax({
                url: '/device/' + uuid,
                method: 'DELETE',
                data:{
                    _token: window.Laravel.csrfToken
                }
            });
        }
    })
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
                <div class="table-responsive">
                  <div id="containment-wrapper" class="panel-body roommap">
                  </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Connected Device<span id="dev-status pull-right"></span></div>
                <div class="panel-body" id="device-panel">

                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Change map background<span id="pull-right"></span></div>
                <div class="panel-body" id="device-panel">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="/device/upload" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <input type="file" id="file" name="photo">
                            <p class="help-block">Please select image.</p>
                        </div>
                        <button type="submit" class="btn btn-sm btn-default pull-right">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
