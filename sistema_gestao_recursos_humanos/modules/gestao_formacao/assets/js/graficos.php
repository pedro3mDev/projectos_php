<!-- Inclusão das bibliotecas -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/echarts"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  // ========== FUNÇÕES UTILITÁRIAS ==========
  const Utils = {
    months: ({ count }) => ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'].slice(0, count),
    numbers: ({ count, min, max }) => Array.from({ length: count }, () => Math.floor(Math.random() * (max - min + 1)) + min),
    CHART_COLORS: {
      primeiro: '#3366cc',
      segundo: '#DAA520',
      terceiro: '#800000',
      primeiro_alt: '#6874c9',
      segundo_alt: '#eacd5a',
      terceiro_alt:'#ff1111',
      green: '#008000',
      red: '#FF0000',
      gray: '#808080'
    },
    transparentize: (color, opacity) => {
      const rgba = color.replace('#', '').match(/.{1,2}/g).map(x => parseInt(x, 16));
      return `rgba(${rgba[0]}, ${rgba[1]}, ${rgba[2]}, ${opacity})`;
    }
  };

  // ========== GRÁFICO 1: TIPO DE FUNCIONÁRIO (Pizza - Chart.js) ==========
  new Chart(document.getElementById('grafico_tipo_funcionario'), {
    type: 'pie',
    data: { 
      labels: ['Efetivos', 'Terceirizados'], 
      datasets: [{
        data: [200, 100], 
        backgroundColor: [Utils.CHART_COLORS.primeiro, Utils.CHART_COLORS.segundo_alt], 
        hoverOffset: 6 
      }] 
    },
    options: { 
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { position: 'bottom' } } 
    }
  });

  // ========== GRÁFICO 2: VISÃO GERAL (Drilldown - ECharts) ==========
  const visaoGeralChart = echarts.init(document.getElementById('grafico_visao_geral'));
  const optionVisaoGeral = {
    grid: { left: '10%', right: '10%', bottom: '15%', top: '15%', containLabel: true },
    xAxis: { data: ['Sede', 'Remoto'], axisLabel: { fontSize: 14 } },
    yAxis: {},
    series: [{
      type: 'bar',
      id: 'sales',
      barWidth: '60%',
      itemStyle: {
        color: (params) => params.dataIndex === 0 ? Utils.CHART_COLORS.primeiro_alt : Utils.CHART_COLORS.terceiro
      },
      data: [{ value: 5, groupId: 'animals' }, { value: 2, groupId: 'fruits' }],
      universalTransition: { enabled: true, divideShape: 'clone' }
    }]
  };
  visaoGeralChart.setOption(optionVisaoGeral);
  window.addEventListener('resize', () => {
    visaoGeralChart.resize();
  });

  visaoGeralChart.on('click', function(event) {
    const drilldownData = {
      animals: [['Gatos', 4], ['Cachorros', 2], ['Vacas', 1], ['Ovelhas', 2], ['Porcos', 1]],
      fruits: [['Maçãs', 4], ['Laranjas', 2]]
    }[event.data?.groupId];

    if (drilldownData) {
      visaoGeralChart.setOption({
        xAxis: { data: drilldownData.map(item => item[0]) },
        series: [{
          type: 'bar',
          id: 'sales',
          itemStyle: {
            color: (params) => [Utils.CHART_COLORS.primeiro, Utils.CHART_COLORS.segundo, Utils.CHART_COLORS.terceiro, Utils.CHART_COLORS.primeiro_alt, Utils.CHART_COLORS.segundo_alt][params.dataIndex % 5]
          },
          data: drilldownData.map(item => item[1]),
          universalTransition: { enabled: true, divideShape: 'clone' }
        }],
        graphic: [{
          type: 'text',
          left: 50,
          top: 20,
          style: { text: '⬅️ Voltar', fontSize: 16, cursor: 'pointer' },
          onclick: () => visaoGeralChart.setOption(optionVisaoGeral)
        }]
      });
    }
  });

  // ========== GRÁFICO 3: CRESCIMENTO DE FUNCIONÁRIOS (Doughnut - Chart.js) ==========
  new Chart(document.getElementById('grafico_crescimento_funcionarios'), {
    type: 'doughnut',
    data: {
      labels: ['2020', '2021', '2022', '2023'],
      datasets: [{
        data: [50, 70, 100, 130],
        backgroundColor: [
          Utils.transparentize(Utils.CHART_COLORS.primeiro, 0.6),
          Utils.transparentize(Utils.CHART_COLORS.segundo, 0.6),
          Utils.transparentize(Utils.CHART_COLORS.terceiro, 0.6),
          Utils.transparentize(Utils.CHART_COLORS.primeiro_alt, 0.6)
        ],
        hoverOffset: 6
      }]
    },
    options: { 
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { position: 'bottom' } } 
    }
  });

  // ========== GRÁFICO 4: DESPESAS (Barras Empilhadas - Chart.js) ==========
  new Chart(document.getElementById('grafico_despesas'), {
    type: 'bar',
    data: {
      labels: ['Janeiro', 'Fevereiro', 'Março'],
      datasets: [{
        label: 'Salários',
        data: [5000, 7000, 8000],
        backgroundColor: Utils.transparentize(Utils.CHART_COLORS.verde, 0.5),
      }, {
        label: 'Infraestrutura',
        data: [3000, 2000, 4000],
        backgroundColor: Utils.transparentize(Utils.CHART_COLORS.vermelho, 0.5),
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { position: 'bottom' } }
    }
  });

});
</script>
