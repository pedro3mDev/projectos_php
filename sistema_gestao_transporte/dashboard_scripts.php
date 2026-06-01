<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const transporte = <?php
        $q = mysqli_query($conexao, "SELECT SUM(ValorTransporte) AS total FROM meetchegadas");
        $r = mysqli_fetch_assoc($q);
        echo $r['total'] ?? 0;
    ?>;

    const embarques = <?php
        $q = mysqli_query($conexao, "SELECT SUM(ValorEmbarque) AS total FROM meetpartida");
        $r = mysqli_fetch_assoc($q);
        echo $r['total'] ?? 0;
    ?>;

    const desembarques = <?php
        $q = mysqli_query($conexao, "SELECT SUM(ValorDesembarque) AS total FROM meetchegadas");
        $r = mysqli_fetch_assoc($q);
        echo $r['total'] ?? 0;
    ?>;

    const capit = <?php
        $q = mysqli_query($conexao, "SELECT SUM(ValorCapitania) AS total FROM meetpartida");
        $r = mysqli_fetch_assoc($q);
        echo $r['total'] ?? 0;
    ?>;

    const ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Transporte', 'Embarques', 'Desembarques', 'Capitania'],
                datasets: [{
                    label: 'Faturação (KZ)',
                    data: [transporte, embarques, desembarques, capit],
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444'],
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#333', font: { size: 12 } },
                        grid: { color: '#eee' }
                    },
                    x: {
                        ticks: { color: '#333', font: { size: 12 } },
                        grid: { display: false }
                    }
                }
            }
    });

    const ctxPie = document.getElementById('pieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Transporte', 'Embarques', 'Desembarques', 'Capitania'],
            datasets: [{
                data: [transporte, embarques, desembarques, capit],
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { color: '#333', font: { size: 12 } }
                }
            }
        }
    });

</script>
