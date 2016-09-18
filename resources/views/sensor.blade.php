@extends('layouts.app')

@section('title', 'Sensor Control')

@section('styles')
<style media="screen">

</style>
@endsection

@section('script')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
<script>
$(function () {

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
            data: [50],
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
            data: [70],
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
            data: [30],
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
            data: [1004],
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
            data: [30],
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
<div class="container">

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">溫度</div>
                <div class="panel-body">
                    <div id="chart-temp" style="width: 330px; height: 220px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">相對濕度</div>
                <div class="panel-body">
                    <div id="chart-humidity" style="width: 330px; height: 220px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Sensor 狀態</div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>狀態</td>
                                <td><button class="btn btn-success btn-sm">已連接</button></td>

                            </tr>
                            <tr>
                                <td>ID</td>
                                <td>1246</td>
                            </tr>
                            <tr>
                                <td>UUID</td>
                                <td>{{ uniqid() }}</td>
                            </tr>
                            <tr>
                                <td>型號</td>
                                <td>CC1345</td>
                            </tr>
                            <tr>
                                <td>藍芽位址</td>
                                <td>13:6f:c3:7a:u1:90</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">紅外線溫度</div>
                <div class="panel-body">
                    <div id="chart-irtemp" style="width: 330px; height: 220px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">大氣壓力</div>
                <div class="panel-body">
                    <div id="chart-bar" style="width: 330px; height: 220px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">裝置溫度</div>
                <div class="panel-body">
                    <div id="chart-devtemp" style="width: 330px; height: 220px;"></div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
