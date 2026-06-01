<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
<script>
// Gráfico taxa de engajamento
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById("taxa_engajamento").getContext("2d");

    const dataTaxaEngajamento = {
        labels: ["Pesquisa de Engajamento", "Pergunta de Engajamento", "Resposta de Engajamento"],
        datasets: [{
            data: [<?= $pesquisa_engajamento_total ?? 0 ?>, <?= $total_pergunta_engajamento ?? 0 ?>,
                <?= $total_resposta_engajamento ?? 0 ?>
            ],
            backgroundColor: ["#DAA520", "#336", "#ccc"],
            hoverOffset: 4
        }]
    };

    const configTaxaEngajamento = {
        type: 'doughnut',
        data: dataTaxaEngajamento,
        options: {
            responsive: true,
            maintainAspectRatio: false, // Permite ajustar a altura
            layout: {
                padding: 10 // Adiciona um pequeno espaço interno
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: "Distribuição - Taxa de Engajamento"
                }
            }
        }
    };

    new Chart(ctx, configTaxaEngajamento);
});

// Gráfico taxa de resposta
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById("taxa_resposta").getContext("2d");

    const dataTaxaResposta = {
        labels: ["Pessimo", "Mau", "Bom", "Muito Bom", "Excelênte"],
        datasets: [{
            data: [
                <?= $total_resposta_engajamento_pessimo ?? 0 ?>,
                <?= $total_resposta_engajamento_mau ?? 0 ?>,
                <?= $total_resposta_engajamento_bom ?? 0 ?>,
                <?= $total_resposta_engajamento_muito_bom ?? 0 ?>,
                <?= $total_resposta_engajamento_excelente ?? 0 ?>,
            ],
            backgroundColor: ["#DAA520", "#336", "#ff0000", "#ffff00", "#ccc"],
            hoverOffset: 4
        }]
    };

    const configTaxaResposta = {
        type: 'doughnut',
        data: dataTaxaResposta,
        options: {
            responsive: true,
            maintainAspectRatio: false, // Permite ajustar a altura
            layout: {
                padding: 10 // Adiciona um pequeno espaço interno
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: "Distribuição - Tipo de Funcionário 2"
                }
            }
        }
    };

    new Chart(ctx, configTaxaResposta);
});

// Gráfico Pontuação de Engajamento por Equipe
document.addEventListener("DOMContentLoaded", function() {
    var chartEquipe = echarts.init(document.getElementById('pontuacao_engajamento_equipe'));

    var option = {
        dataset: {
            source: [
                ['score', 'amount', 'product'],
                <?= $conflito_dashboard ?>
            ]
        },
        grid: {
            containLabel: true
        },
        xAxis: {
            name: 'Pontuação'
        },
        yAxis: {
            type: 'category'
        },
        series: [{
            type: 'bar',
            encode: {
                x: 'amount',
                y: 'product'
            },
            itemStyle: {
                color: '#336' // Cor fixa para as barras
            }
        }]
    };

    chartEquipe.setOption(option);

    window.addEventListener("resize", function() {
        chartEquipe.resize();
    });
});


// Gráfico Pontuação de Engajamento por Nível
document.addEventListener("DOMContentLoaded", function() {
    var chartEquipe = echarts.init(document.getElementById('pontuacao_engajamento_nivel'));

    var option = {
        dataset: {
            source: [
                ['score', 'amount', 'level'],
                [89.3, 58212, 'Júnior'],
                [57.1, 78254, 'Pleno'],
                [74.4, 41032, 'Sênior'],
                [50.1, 12755, 'Coordenador']
            ]
        },
        grid: {
            containLabel: true
        },
        xAxis: {
            name: 'Pontuação'
        },
        yAxis: {
            type: 'category'
        },
        series: [{
            type: 'bar',
            encode: {
                x: 'amount',
                y: 'level'
            },
            itemStyle: {
                color: '#DAA520' // Cor fixa para todas as barras
            }
        }]
    };

    chartEquipe.setOption(option);

    window.addEventListener("resize", function() {
        chartEquipe.resize();
    });
});


// Gráfico Pontuação Líquida do Promotor
document.addEventListener("DOMContentLoaded", function() {
    var chartPromotor = echarts.init(document.getElementById('pontuacao_liquida_promotor'), null, {
        width: "auto",
        height: "auto"
    });

    var option = {
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '10%', // Ajuste para evitar sobreposição de rótulos
            containLabel: true
        },
        xAxis: {
            type: 'value'
        },
        yAxis: {
            type: 'category',
            data: [' ']
        },
        series: [{
                name: 'Promotores',
                type: 'bar',
                stack: 'total',
                label: {
                    show: true,
                    position: 'inside'
                },
                emphasis: {
                    focus: 'series'
                },
                data: [400],
                itemStyle: {
                    color: '#336'
                }
            },
            {
                name: 'Passivos',
                type: 'bar',
                stack: 'total',
                label: {
                    show: true,
                    position: 'inside'
                },
                emphasis: {
                    focus: 'series'
                },
                data: [250],
                itemStyle: {
                    color: '#800000'
                }
            },
            {
                name: 'Detratores',
                type: 'bar',
                stack: 'total',
                label: {
                    show: true,
                    position: 'inside'
                },
                emphasis: {
                    focus: 'series'
                },
                data: [150],
                itemStyle: {
                    color: '#DAA520'
                }
            }
        ]
    };

    chartPromotor.setOption(option);

    window.addEventListener("resize", function() {
        chartPromotor.resize();
    });
});


// Gráfico Pontuação de Engajamento ao Tempo
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('pontuacao_engajamento_tempo').getContext('2d');

    // Dados do gráfico
    const labels = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
    const dataEngajamento = [30, 45, 50, 60, 55, 70, 80, 75, 65, 50, 40, 35];
    const dataInteracoes = [20, 35, 40, 50, 45, 60, 70, 65, 55, 40, 30, 25];

    const data = {
        labels: labels,
        datasets: [{
                label: 'Engajamento',
                data: dataEngajamento,
                backgroundColor: '#DAA520',
                borderColor: '#DAA520',
                borderWidth: 1
            },
            {
                label: 'Interações',
                data: dataInteracoes,
                backgroundColor: '#800000',
                borderColor: '#800000',
                borderWidth: 1
            }
        ]
    };

    // Configuração do gráfico
    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Pontuação de Engajamento e Interações ao Tempo'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    // Criando o gráfico
    new Chart(ctx, config);
});

// Gráficos Dimensões do Engajamento
document.addEventListener("DOMContentLoaded", function() {
    var chart1 = echarts.init(document.getElementById('dimensoes_engajamento_1'));

    var option1 = {
        dataset: {
            source: [
                ['score', 'amount', 'level'],
                [89.3, 58212, 'Júnior'],
                [57.1, 78254, 'Pleno'],
                [74.4, 41032, 'Sênior'],
                [50.1, 12755, 'Coordenador']
            ]
        },
        grid: {
            containLabel: true
        },
        xAxis: {
            name: 'Pontuação'
        },
        yAxis: {
            type: 'category'
        },
        series: [{
            type: 'bar',
            encode: {
                x: 'amount',
                y: 'level'
            },
            itemStyle: {
                color: '#336' // Cor fixa para todas as barras
            }
        }]
    };

    chart1.setOption(option1);
    window.addEventListener("resize", function() {
        chart1.resize();
    });
});

document.addEventListener("DOMContentLoaded", function() {
    var chart2 = echarts.init(document.getElementById('dimensoes_engajamento_2'));

    var option2 = {
        dataset: {
            source: [
                ['score', 'amount', 'level'],
                [89.3, 58212, 'Júnior'],
                [57.1, 78254, 'Pleno'],
                [74.4, 41032, 'Sênior'],
                [50.1, 12755, 'Coordenador']
            ]
        },
        grid: {
            containLabel: true
        },
        xAxis: {
            name: 'Pontuação'
        },
        yAxis: {
            type: 'category'
        },
        series: [{
            type: 'bar',
            encode: {
                x: 'amount',
                y: 'level'
            },
            itemStyle: {
                color: '#800000' // Cor fixa para todas as barras
            }
        }]
    };

    chart2.setOption(option2);
    window.addEventListener("resize", function() {
        chart2.resize();
    });
});
</script>