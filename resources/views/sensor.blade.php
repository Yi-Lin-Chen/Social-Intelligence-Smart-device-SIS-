@extends('layouts.app')

@section('title', 'Sensor Control')

@section('styles')
<style media="screen">
.chart-container{

}
.chart-div {
    height: 220px;
}
</style>
@endsection

@section('script')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
<script>
$(function () {

    var info = new WebSocket('ws://{{ env('WEBSOCKET_ADDR') }}/sensortag/info');
    info.onclose = function() {
        $('#dev-status').html('<span class="label label-danger">斷線</button>');
    }
    info.onerror = function() {
        $('#dev-status').html('<span class="label label-danger">斷線</button>');
    }
    info.onmessage = function (event) {
        var obj = JSON.parse(event.data);
        for( var key in obj ) {
            if(key == 'status') {
                if( obj[key] == 'connected')
                    $('#dev-' + key).html('<span class="label label-success">已連接</span>');
                else {
                    $('#dev-' + key).html('<span class="label label-danger">斷線</button>');
                }
            }
            else
                $('#dev-' + key).html(obj[key]);
        }
    };

    var ws_temp_humid = new WebSocket('ws://{{ env('WEBSOCKET_ADDR') }}/sensortag/humidity');
    ws_temp_humid.onopen = function() {
        update_label('label-temp', true);
        update_label('label-humidity', true);
    }
    ws_temp_humid.onclose = function() {
        update_label('label-temp', false);
        update_label('label-humidity', false);
    }
    ws_temp_humid.onerror = function() {
        update_label('label-temp', false);
        update_label('label-humidity', false);
    }
    ws_temp_humid.onmessage = function (event) {
        var data = JSON.parse(event.data);
        //console.log(data);
        update_chart('chart-temp', data.temperature);
        update_chart('chart-humidity', data.humidity);
    };

    var ws_bar = new WebSocket('ws://{{ env('WEBSOCKET_ADDR') }}/sensortag/barometricPressure');
    ws_bar.onopen = function() {
        update_label('label-bar', true);
    }
    ws_bar.onclose = function() {
        update_label('label-bar', false);
    }
    ws_bar.onerror = function() {
        update_label('label-bar', false);
    }
    ws_bar.onmessage = function (event) {
        var data = JSON.parse(event.data);
        //console.log(data);
        update_chart('chart-bar', data.pressure);
    };

    var ws_ir_temp = new WebSocket('ws://{{ env('WEBSOCKET_ADDR') }}/sensortag/irTemperature');
    ws_ir_temp.onopen = function() {
        update_label('label-irtemp', true);
        update_label('label-devtemp', true);
    }
    ws_ir_temp.onclose = function() {
        update_label('label-irtemp', false);
        update_label('label-devtemp', false);
    }
    ws_ir_temp.onerror = function() {
        update_label('label-irtemp', false);
        update_label('label-devtemp', false);
    }
    ws_ir_temp.onmessage = function (event) {
        var data = JSON.parse(event.data);
        //console.log(data);
        update_chart('chart-irtemp', data.objectTemperature);
        update_chart('chart-devtemp', data.ambientTemperature);
    }

    var update_label = function(label_id, connected) {
        if(connected) {
            $('#' + label_id).html('已連接');
            $('#' + label_id).removeClass('label-default');
            $('#' + label_id).removeClass('label-danger');
            $('#' + label_id).addClass('label-success');
        } else {
            $('#' + label_id).html('未連接');
            $('#' + label_id).removeClass('label-default');
            $('#' + label_id).removeClass('label-success');
            $('#' + label_id).addClass('label-danger');
        }
    }

    var update_chart = function(chart_id, data) {
        var chart = $('#' + chart_id).highcharts();
        if(chart) {
            var point = chart.series[0].points[0];
            point.update(roundDecimal(data, 2));
        }
    }

    var roundDecimal = function (val, precision) {
        return Math.round(Math.round(val * Math.pow(10, (precision || 0) + 1)) / 10) / Math.pow(10, (precision || 0));
    }

    var gaugeOptions = {

        chart: {
            type: 'solidgauge'
        },

        title: null,

        pane: {
            center: ['50%', '85%'],
            size: '140%',
            startAngle: -90,
            endAngle: 90,
            background: {
                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
                innerRadius: '60%',
                outerRadius: '100%',
                shape: 'arc'
            }
        },

        tooltip: {
            enabled: false
        },

        // the value axis
        yAxis: {
            stops: [
                [0.1, '#55BF3B'], // green
                [0.5, '#DDDF0D'], // yellow
                [0.9, '#DF5353'] // red
            ],
            lineWidth: 0,
            minorTickInterval: null,
            tickAmount: 2,
            title: {
                y: -70
            },
            labels: {
                y: 16
            }
        },

        plotOptions: {
            solidgauge: {
                size:'100%',
                dataLabels: {
                    y: 5,
                    borderWidth: 0,
                    useHTML: true
                }
            }
        }
    };

    $('#chart-temp').highcharts(Highcharts.merge(gaugeOptions, {

        yAxis: {
            min: 0,
            max: 80,
            title: {
                text: ''
            }
        },

        credits: {
            enabled: false
        },

        series: [{
            name: '',
            data: [0],
            dataLabels: {
                format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                       '<span style="font-size:12px;color:silver">°C</span></div>'
            }
        }]

    }));

    $('#chart-humidity').highcharts(Highcharts.merge(gaugeOptions, {

        yAxis: {
            min: 0,
            max: 100,
            title: {
                text: ''
            }
        },

        credits: {
            enabled: false
        },

        series: [{
            name: '',
            data: [0],
            dataLabels: {
                format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                       '<span style="font-size:12px;color:silver">%</span></div>'
            },
            tooltip: {
                valueSuffix: ' %'
            }
        }]

    }));

    $('#chart-irtemp').highcharts(Highcharts.merge(gaugeOptions, {

        yAxis: {
            min: 0,
            max: 80,
            title: {
                text: ''
            }
        },

        credits: {
            enabled: false
        },

        series: [{
            name: '',
            data: [0],
            dataLabels: {
                format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                       '<span style="font-size:12px;color:silver">°C</span></div>'
            }
        }]

    }));

    $('#chart-bar').highcharts(Highcharts.merge(gaugeOptions, {

        yAxis: {
            min: 960,
            max: 1060,
            title: {
                text: ''
            }
        },

        credits: {
            enabled: false
        },

        series: [{
            name: '',
            data: [0],
            dataLabels: {
                format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                       '<span style="font-size:12px;color:silver">hPa</span></div>'
            }
        }]

    }));

    $('#chart-devtemp').highcharts(Highcharts.merge(gaugeOptions, {

        yAxis: {
            min: 0,
            max: 80,
            title: {
                text: ''
            }
        },

        credits: {
            enabled: false
        },

        series: [{
            name: '',
            data: [0],
            dataLabels: {
                format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
                       '<span style="font-size:12px;color:silver">°C</span></div>'
            }
        }]

    }));


});
</script>
@endsection


@section('content')

@foreach( $data as $access)
    @if( !$access->isExpired() )
        <?php $all_expired = false; ?>
    @endif
@endforeach

@if ( $all_expired == true )
    <div class="col-md-6 col-md-offset-3 alert alert-danger">You have no active access, please <a href="/request">request</a> for a access first.</div>
@else
<div class="container">

    <div class="row">

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Sensor 狀態</div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>狀態</td>
                                <td id="dev-status">Loading...</td>
                            </tr>
                            <tr>
                                <td>ID</td>
                                <td id="dev-id"></td>
                            </tr>
                            <tr>
                                <td>UUID</td>
                                <td id="dev-uuid"></td>
                            </tr>
                            <tr>
                                <td>型號</td>
                                <td id="dev-type"></td>
                            </tr>
                            <tr>
                                <td>藍芽位址</td>
                                <td id="dev-address"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">溫度<span id="label-temp" class="label label-default pull-right">Loading</span></div>
                <div class="panel-body chart-container">
                    <div id="chart-temp" class="chart-div"></div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">相對濕度<span id="label-humidity" class="label label-default pull-right">Loading</span></div>
                <div class="panel-body chart-container">
                    <div id="chart-humidity" class="chart-div"></div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">紅外線溫度<span id="label-irtemp" class="label label-default pull-right">Loading</span></div>
                <div class="panel-body chart-container">
                    <div id="chart-irtemp" class="chart-div"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">大氣壓力<span id="label-bar" class="label label-default pull-right">Loading</span></div>
                <div class="panel-body chart-container">
                    <div id="chart-bar" class="chart-div"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">裝置溫度<span id="label-devtemp" class="label label-default pull-right">Loading</span></div>
                <div class="panel-body chart-container">
                    <div id="chart-devtemp" class="chart-div"></div>
                </div>
            </div>
        </div>
    </div>

</div>
@endif
@endsection
