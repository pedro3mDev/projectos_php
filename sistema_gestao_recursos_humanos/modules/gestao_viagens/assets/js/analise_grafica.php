<canvas id="graficoOrcamento"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('graficoOrcamento').getContext('2d');

const dadosOrcamento = {
    labels: <?= $orcamentos_grafico['label'] ?>,
    datasets: [
        
        {
            label: 'Estimativa',
            data: <?= $orcamentos_grafico['estimativa'] ?>,
            backgroundColor: '#ccc',
            borderColor: '#ccc',
            borderWidth: 1
        },
        {
            label: 'Orçamento Real',
            data: <?= $orcamentos_grafico['orcamento'] ?>,
            backgroundColor: '#333366',
            borderColor: '#333366',
            borderWidth: 1
        }
    ]
};

new Chart(ctx, {
    type: 'bar',
    data: dadosOrcamento,
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
