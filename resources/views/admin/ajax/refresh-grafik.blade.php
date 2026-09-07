<style>
    .highcharts-figure,
    .highcharts-data-table table {
        min-width: 360px;
        max-width: 800px;
        margin: 1em auto;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #EBEBEB;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }

    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }

    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }

    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
        padding: 0.5em;
    }

    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }

    text.highcharts-credits {
        display: none;
    }
</style>


<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;

setlocale(LC_TIME, 'id_ID');
\Carbon\Carbon::setLocale('id');


$dateObj   = \Carbon\Carbon::createFromFormat('!m', $bulan);
$monthName = $dateObj->isoFormat('MMMM'); // March


//$period = CarbonPeriod::create('2021-09-01', '2021-09-30');
$from = \Carbon\Carbon::createFromFormat('Y-m-d', $tahun . '-' . $bulan . '-01');

$tanggalsekarang = date("Y-m-t", strtotime($tahun . '-' . $bulan . '-01'));
$to = \Carbon\Carbon::createFromFormat('Y-m-d', $tanggalsekarang);
$period = new CarbonPeriod($from, '1 day', $to);


$tgl = [];
$datas1 = [];
$datas2 = [];
$datas3 = [];
$datas4 = [];
foreach ($period as $date) {
    $tgl[] = $date->format('d F');

    //IGD
    if (\App\Models\Laporanigd::whereDate('created_at', $date->format('Y-m-d'))->where('status', 1)->pluck('jumlah_pasien')->last()) {
        $datas1[] = \App\Models\Laporanigd::whereDate('created_at', $date->format('Y-m-d'))->where('status', 1)->pluck('jumlah_pasien')->last();
    } else {
        $datas1[] = 0;
    }

    //Ruangan Umum
    if (\App\Models\Laporanumum::whereDate('created_at', $date->format('Y-m-d'))->where('id_laporan', \App\Models\Laporan::whereDate('created_at', $date->format('Y-m-d'))->pluck('id')->last())->where('status', 1)->pluck('jumlah_total_pasien')->sum()) {
        $datas2[] = \App\Models\Laporanumum::whereDate('created_at', $date->format('Y-m-d'))->where('id_laporan', \App\Models\Laporan::whereDate('created_at', $date->format('Y-m-d'))->pluck('id')->last())->where('status', 1)->pluck('jumlah_total_pasien')->sum();
    } else {
        $datas2[] = 0;
    }

    //IRJ
    if (\App\Models\Laporanirjdetail::whereDate('created_at', $date->format('Y-m-d'))->where('id_laporan_irj', \App\Models\Laporanirj::whereDate('created_at', $date->format('Y-m-d'))->pluck('id')->last())->where('status', 1)->pluck('pasien_total')->sum()) {
        $datas3[] = \App\Models\Laporanirjdetail::whereDate('created_at', $date->format('Y-m-d'))->where('id_laporan_irj', \App\Models\Laporanirj::whereDate('created_at', $date->format('Y-m-d'))->pluck('id')->last())->where('status', 1)->pluck('pasien_total')->sum();
    } else {
        $datas3[] = 0;
    }

    //IBS
    if (\App\Models\Laporanibsdetail::whereDate('created_at', $date->format('Y-m-d'))->where('id_laporan_ibs', \App\Models\Laporanibs::whereDate('created_at', $date->format('Y-m-d'))->pluck('id')->last())->where('status', 1)->count()) {
        $datas4[] = \App\Models\Laporanibsdetail::whereDate('created_at', $date->format('Y-m-d'))->where('id_laporan_ibs', \App\Models\Laporanibs::whereDate('created_at', $date->format('Y-m-d'))->pluck('id')->last())->where('status', 1)->count();
    } else {
        $datas4[] = 0;
    }
}
?>




<div id="container" style="margin-top:30px"></div>



<script>
    // A point click event that uses the Renderer to draw a label next to the point
    // On subsequent clicks, move the existing label instead of creating a new one.
    // Highcharts.addEvent(Highcharts.Point, 'click', function () {
    //     if (this.series.options.className.indexOf('popup-on-click') !== -1) {
    //         const chart = this.series.chart;
    //         const date = Highcharts.dateFormat('%A, %b %e, %Y', this.x);
    //         const text = `<b>${this.series.name}</b> : ${this.y} pasien`;

    //         const anchorX = this.plotX + this.series.xAxis.pos;
    //         const anchorY = this.plotY + this.series.yAxis.pos;
    //         const align = anchorX < chart.chartWidth - 200 ? 'left' : 'right';
    //         const x = align === 'left' ? anchorX + 10 : anchorX - 10;
    //         const y = anchorY - 30;
    //         if (!chart.sticky) {
    //             chart.sticky = chart.renderer
    //                 .label(text, x, y, 'callout',  anchorX, anchorY)
    //                 .attr({
    //                     align,
    //                     fill: 'rgba(0, 0, 0, 0.75)',
    //                     padding: 10,
    //                     zIndex: 7 // Above series, below tooltip
    //                 })
    //                 .css({
    //                     color: 'white'
    //                 })
    //                 .on('click', function () {
    //                     chart.sticky = chart.sticky.destroy();
    //                 })
    //                 .add();
    //         } else {
    //             chart.sticky
    //                 .attr({ align, text })
    //                 .animate({ anchorX, anchorY, x, y }, { duration: 250 });
    //         }
    //     }
    // });


    Highcharts.chart('container', {

        chart: {
            scrollablePlotArea: {
                minWidth: 700
            }
        },

        title: {
            text: 'Laporan Total Pasien'
        },

        subtitle: {
            text: '{!! $monthName !!} {{ $tahun }}'
        },
        colors: ['#ED561B', '#50B432', '#058DC7', '#FFA500'],
        xAxis: {
            categories: {!! json_encode($tgl) !!},
            tickInterval: 7, // one week
            tickWidth: 0,
            gridLineWidth: 1,
            labels: {
                align: 'center',
                x: 0,
                y: 20
            }
        },

        yAxis: [{ // left y axis
            title: {
                text: null
            },
            labels: {
                align: 'left',
                x: 3,
                y: 16,
                format: '{value:.,0f}'
            },
            showFirstLabel: false
        }, { // right y axis
            linkedTo: 0,
            gridLineWidth: 0,
            opposite: true,
            title: {
                text: null
            },
            labels: {
                align: 'right',
                x: -3,
                y: 16,
                format: '{value:.,0f}'
            },
            showFirstLabel: false
        }],

        legend: {
            align: 'left',
            verticalAlign: 'top',
            borderWidth: 0
        },

        tooltip: {
            shared: true,
            crosshairs: true
        },

        plotOptions: {
            series: {
                cursor: 'pointer',
                className: 'popup-on-click',
                marker: {
                    lineWidth: 1
                }
            }
        },

        series: [{
            name: 'IGD',
            data: {!! json_encode($datas1) !!},
        }, {
            name: 'Ruangan Umum',
            data: {!! json_encode($datas2) !!},
        }, {
            name: 'IRJ',
            data: {!! json_encode($datas3) !!},
        }, {
            name: 'IBS',
            data: {!! json_encode($datas4) !!},
        }]
    });
</script>