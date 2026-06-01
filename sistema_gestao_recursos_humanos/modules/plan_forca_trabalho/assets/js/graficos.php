<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Função para configurar o gráfico
    function setupChart(id, option) {
        var chart = echarts.init(document.getElementById(id));
        chart.setOption(option);
        window.onresize = function() {
            chart.resize();
        };
    }

    // Configurações dos gráficos
    var optionSimulacao = {
        color: ['#336', '#800000'],
        tooltip: { trigger: 'item' },
        legend: { top: '5%', left: 'center' },
        series: [{
            name: 'Origem de Acesso',
            type: 'pie',
            radius: ['40%', '70%'],
            center: ['50%', '55%'],
            avoidLabelOverlap: false,
            label: { show: false, position: 'center' },
            emphasis: { label: { show: true, fontSize: 20, fontWeight: 'bold' } },
            labelLine: { show: false },
            data: [{ value: 1048, name: 'Search Engine' }, { value: 735, name: 'Direct' }]
        }]
    };

    // Ajuste
    var optionAjustes = {
        color: ['#336', '#800000'],
        tooltip: { trigger: 'item' },
        legend: { top: '5%', left: 'center' },
        series: [{
            name: 'Origem de Acesso',
            type: 'pie',
            radius: ['40%', '70%'],
            center: ['50%', '55%'],
            avoidLabelOverlap: false,
            label: { show: false, position: 'center' },
            emphasis: { label: { show: true, fontSize: 20, fontWeight: 'bold' } },
            labelLine: { show: false },
            data: [{ value: 1048, name: 'Search Engine' }, { value: 735, name: 'Direct' }]
        }]
    };

    // Monitoramento
    var optionMonitoramento = {
        dataset: {
            source: [
                ['score', 'amount', 'product'],
                [89.3, 58212, 'Outra'],
                [57.1, 78254, 'RH'],
                [74.4, 41032, 'Finanças'],
                [50.1, 12755, 'Vendas']
            ]
        },
        grid: { containLabel: true },
        xAxis: { name: 'amount' },
        yAxis: { type: 'category' },
        series: [{
            type: 'bar',
            encode: { x: 'amount', y: 'product' },
            itemStyle: { color: '#336' }
        }]
    };

    // Previsão
    var optionPrevisao = {
        xAxis: {
            type: 'category',
            data: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']
        },
        yAxis: { type: 'value' },
        series: [{
            data: [120, 180, 150, 90, 70, 110, 130, 160, 140, 170, 190, 200],
            type: 'bar',
            itemStyle: { color: '#336' }
        }]
    };

    // Análise
    var optionAnalise = {
        xAxis: {
            type: 'category',
            data: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']
        },
        yAxis: { type: 'value' },
        series: [{
            data: [120, 180, 150, 90, 70, 110, 130, 160, 140, 170, 190, 200],
            type: 'bar',
            itemStyle: { color: '#800000' }
        }]
    };

    // Integração
    var optionIntegracao = {
        color: ['#336', '#800000'],
        tooltip: { trigger: 'item' },
        legend: { top: '5%', left: 'center' },
        series: [{
            name: 'Origem de Acesso',
            type: 'pie',
            radius: ['40%', '70%'],
            center: ['50%', '55%'],
            avoidLabelOverlap: false,
            label: { show: false, position: 'center' },
            emphasis: { label: { show: true, fontSize: 20, fontWeight: 'bold' } },
            labelLine: { show: false },
            data: [{ value: 1048, name: 'Search Engine' }, { value: 735, name: 'Direct' }]
        }]
    };

    // Inicializando os gráficos
    setupChart('simulacao', optionSimulacao);
    setupChart('ajustes', optionAjustes);
    setupChart('monitoramento', optionMonitoramento);
    setupChart('previsao', optionPrevisao);
    setupChart('analise', optionAnalise);
    setupChart('integracao', optionIntegracao); // Adicionando o gráfico de Integração
});
</script>