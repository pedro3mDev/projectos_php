<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
window.onload = function() {
    // Primeiro gráfico (barras horizontais)
    const ctx = document.getElementById('graficoRespostasColaborador').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= $dashboard_resposta_engajamento['labels'] ?? '[]' ?>,
            datasets: [{
                label: 'Número de Respostas',
                data: <?= $dashboard_resposta_engajamento['total'] ?? '[]' ?>,
                backgroundColor: '#8B0000',
                borderColor: '#8B0000',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });

    // Segundo gráfico (radar)
    const ctxRadar = document.getElementById('graficoMediaRespostas').getContext('2d');
    new Chart(ctxRadar, {
        type: 'radar',
        data: {
            labels: ['Pessimo', 'Mau', 'Bom', 'Muito Bom', 'Excelênte'],
            datasets: [{
                label: 'Média de Respostas',
                data: [
                    <?= $somar_resposta_engajamento_pessimo ?? 0 ?>,
                    <?= $somar_resposta_engajamento_mau ?? 0 ?>,
                    <?= $somar_resposta_engajamento_bom ?? 0 ?>,
                    <?= $somar_resposta_engajamento_muito_bom ?? 0 ?>,
                    <?= $somar_resposta_engajamento_excelente ?? 0 ?>
                ],
                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                r: {
                    beginAtZero: true
                }
            }
        }
    });
};
</script>