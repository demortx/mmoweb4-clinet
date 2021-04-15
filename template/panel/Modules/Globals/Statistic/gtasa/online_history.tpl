<div id="online-graph"></div>
{$.site._SEO->addTegHTML('footer', 'highcharts', 'script', ['src'=> 'https://code.highcharts.com/highcharts.js'])}
{$.site._SEO->addTegHTML('footer', 'boost', 'script', ['src'=> 'https://code.highcharts.com/modules/boost.js'])}
<script>
    document.addEventListener("DOMContentLoaded", function (event) {

        Highcharts.chart('online-graph', {
            title: { text: '' },
            subtitle: { text: '' },
            chart: {
                zoomType: 'x',
                type: 'spline'
            },
            xAxis: {
                gapGridLineWidth: 0,
                type: 'datetime'
            },
            tooltip: {
                valueDecimals: 0
            },

            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },

            series: [
                {foreach $top_list as $type => $value index=$index}
                {
                    name: '{$lang_history[$type]}',
                    type: 'area',
                    data: {json_encode($value)}
                },
                {/foreach}
            ]
        });
    });
</script>