import "https://cdn.jsdelivr.net/npm/chart.js";
    
export function grafico1() {
    var ctx = document.getElementById('pedidorecebido').getContext('2d');
    var pedidorecebido = new Chart(ctx, {
        type: 'bar', // Usando o tipo 'bar' para gráficos de barras horizontais
        data: {
            labels: ['Item 1', 'Item 2', 'Item 3', 'Item 4'], // Labels (nome dos itens)
            datasets: [{
                label: 'Percentual',
                data: [70, 50, 90, 60], // Dados das porcentagens
                backgroundColor: 'rgba(128,0,0)', // Cor de fundo das barras
                borderColor: 'rgba(255,255,255)', // Cor da borda das barras
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            indexAxis: 'y', // Faz as barras ficarem horizontais
            scales: {
                x: {
                    ticks: {
                        beginAtZero: true,
                        callback: function(value) { return value + '%' } // Adiciona o símbolo de porcentagem
                    }
                },
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.raw + '%'; // Exibe a porcentagem no tooltip
                        }
                    }
                }
            }
        }
    });

}