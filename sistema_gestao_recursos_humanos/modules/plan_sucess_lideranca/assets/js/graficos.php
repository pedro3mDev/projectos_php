<!-- Script do ECharts -->
<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js">
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Gráfico de Barras Empilhadas
                var chartDom = document.getElementById('chart');
                var myChart = echarts.init(chartDom);
                var barOption = {
                    xAxis: {
                        data: ['A', 'B', 'C', 'D', 'E']
                    },
                    yAxis: {},
                    series: [{
                            data: [10, 22, 28, 43, 49],
                            type: 'bar',
                            stack: 'x'
                        },
                        {
                            data: [5, 4, 3, 5, 10],
                            type: 'bar',
                            stack: 'x'
                        }
                    ]
                };
                myChart.setOption(barOption);

                // Gráfico de Gauge 
                var gaugeChartDom = document.getElementById(
                    'gaugeChart');
                var gaugeChart = echarts.init(gaugeChartDom);
                var gaugeOption = {
                    series: [{
                        type: 'gauge',
                        progress: {
                            show: true,
                            width: 18,
                            itemStyle: {
                                color: '#336'
                            }
                        },
                        axisLine: {
                            lineStyle: {
                                width: 18,
                                color: [
                                    [0.11, '#336'],
                                    [1, '#800000']
                                ]
                            }
                        },
                        axisTick: {
                            show: false
                        },
                        splitLine: {
                            length: 15,
                            lineStyle: {
                                width: 2,
                                color: '#999'
                            }
                        },
                        axisLabel: {
                            distance: 25,
                            color: '#999',
                            fontSize: 12
                        },
                        anchor: {
                            show: true,
                            showAbove: true,
                            size: 25,
                            itemStyle: {
                                borderWidth: 10,
                                borderColor: '#f0f0f0',
                            }
                        },
                        title: {
                            show: false
                        },
                        detail: {
                            valueAnimation: true,
                            fontSize: 30,
                            offsetCenter: [0, '70%'],
                            formatter: '{value}%'
                        },
                        data: [{
                            value: 10
                        }]
                    }]
                };
                gaugeChart.setOption(gaugeOption);

                // Gráfico de Pizza
                var pieChartDom = document.getElementById('pieChart');
                var pieChart = echarts.init(pieChartDom);
                var pieOption = {
                    tooltip: {
                        trigger: 'item'
                    },
                    legend: {
                        top: '5%',
                        left: 'center'
                    },
                    series: [{
                        name: 'Access From',
                        type: 'pie',
                        radius: ['30%', '60%'],
                        avoidLabelOverlap: false,
                        label: {
                            show: false,
                            position: 'center'
                        },
                        emphasis: {
                            label: {
                                show: true,
                                fontSize: 40,
                                fontWeight: 'bold'
                            }
                        },
                        labelLine: {
                            show: false
                        },
                        data: [{
                                value: 1048,
                                name: 'Search Engine'
                            },
                            {
                                value: 735,
                                name: 'Direct'
                            },
                            {
                                value: 580,
                                name: 'Email'
                            },
                            {
                                value: 484,
                                name: 'Union Ads'
                            },
                            {
                                value: 300,
                                name: 'Video Ads'
                            }
                        ]
                    }]
                };
                pieChart.setOption(pieOption);
            });
        </script>