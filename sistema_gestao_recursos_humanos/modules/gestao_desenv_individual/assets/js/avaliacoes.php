<!-- <script>
    const ctx = document.getElementById('graficoAvaliacao').getContext('2d');
    const dadosAvaliacao = {
        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        datasets: [{
            label: 'Avaliação do Funcionário',
            data: [7, 8, 6, 9, 7, 8, 9, 7, 8, 7, 9, 10], // Notas de exemplo
            backgroundColor: 'rgba(0, 0, 255, 0.5)',
            borderColor: 'blue',
            borderWidth: 1
        }]
    };

    new Chart(ctx, {
        type: 'bar',
        data: dadosAvaliacao,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 10
                }
            }
        }
    });
</script> -->
