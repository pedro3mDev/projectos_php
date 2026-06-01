<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
<?php
// Preparando os dados para o gráfico
  $nomes = [];
  $valores = [];

  $funcionario = [];
  $bonus = [];

  foreach ($processamento_pagamento_valores as $row) {
    $nomes[] = $row['primeiro_nome'] . ' ' . $row['segundo_nome'];
    $valores[] = (float) $row['valor'];
  }

  foreach ($bonus_valores as $linha) {
    $funcionario[] = $linha['primeiro_nome'] . ' ' . $linha['segundo_nome'];
    $bonus[] = (float) $linha['bonus'];
  }
?>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Função para inicializar gráficos ECharts de barra
    function initBarChart(elementId, yData, seriesName, dataValues, color) {
      var chartElement = document.getElementById(elementId);
      if (chartElement) {
        var chart = echarts.init(chartElement);

        var options = {
          tooltip: { trigger: "axis", axisPointer: { type: "shadow" }, confine: true },
          grid: { left: "3%", right: "4%", bottom: "3%", containLabel: true },
          xAxis: { type: "value", boundaryGap: [0, 0.01] },
          yAxis: { type: "category", data: yData },
          series: [{
            name: seriesName,
            type: "bar",
            barWidth: "60%",
            itemStyle: { color: color },
            data: dataValues
          }]
        };

        chart.setOption(options);
        addResizeListener(chart);
      }
    }

    // Função para adicionar responsividade aos gráficos ECharts
    function addResizeListener(chart) {
      window.addEventListener("resize", () => {
        setTimeout(() => {
          chart.resize();
        }, 200);
      });
    }
    var nomes = <?= json_encode(array_values($nomes), JSON_UNESCAPED_UNICODE); ?>;
    var valores = <?= json_encode(array_values($valores)); ?>;

    initBarChart("Por_Evento_Folha", nomes, "2025 & 2026", valores, "#336");

    var funcionario = <?= json_encode(array_values($funcionario), JSON_UNESCAPED_UNICODE); ?>;
    var bonus = <?= json_encode(array_values($bonus)); ?>;
    initBarChart("Top_Despesas", funcionario, "Despesas", bonus, "#800000");

    // Gráfico de Meta de Investimento (Gauge)
    const chartMetaInvestimento = echarts.init(document.getElementById("Meta_Investimento"));
    if (chartMetaInvestimento) {
      chartMetaInvestimento.setOption({
        series: [{
          type: "gauge",
          progress: {
            show: true,
            width: 14,
            itemStyle: { color: "#336" }
          },
          axisLine: {
            lineStyle: {
              width: 14,
              color: [[1, "#ccc"]]
            }
          },
          pointer: {
            itemStyle: { color: "#336" }
          },
          detail: {
            valueAnimation: true,
            fontSize: 24,
            offsetCenter: [0, "80%"],
            formatter: "{value}%"
          },
          data: [{ value: <?php echo $contar_subsidio_ferias ?> }]
        }]
      });
      addResizeListener(chartMetaInvestimento);
    }

    // Gráficos Chart.js - Adicionando responsividade
    function initChartJS(id, type, data, options) {
      const ctx = document.getElementById(id)?.getContext("2d");
      if (ctx) {
        let chart = new Chart(ctx, { type, data, options });

        // Ajusta o tamanho ao redimensionar a tela
        window.addEventListener("resize", () => {
          setTimeout(() => {
            chart.resize();
          }, 200);
        });
      }
    }

    // Chart.js - Por Tipo de Evento
    initChartJS("Por_Tipo_Evento", "pie", {
      labels: ["Pendentes", "Aprovados", "Rejeitados"],
      datasets: [{
        label: "Eventos",
        data: [
          <?php echo $contar_dados_ajuste_salarial['pendentes'] ?>,
          <?php echo $contar_dados_ajuste_salarial['aprovados'] ?>,
          <?php echo $contar_dados_ajuste_salarial['rejeitados'] ?>,
        ],
        backgroundColor: ["#336", " #DAA520", "#800000", "#915a17", "#ff0000"]
      }]
    }, {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { position: "top" },
        title: { display: true, text: "Por Tipo de Evento - 2025 & 2026" }
      }
    });

    // Chart.js - Evolução de Lucros
    initChartJS("Evolucao_Lucros", "doughnut", {
      labels: ["Pendentes", "Aprovados","Rejeitados"],
      datasets: [{
        data: [
          <?php echo $contar_dados_pacote_beneficio['pendentes']?>, 
          <?php echo $contar_dados_pacote_beneficio['aprovados']?>,
          <?php echo $contar_dados_pacote_beneficio['rejeitados']?>,
        ],
        backgroundColor: ["#336", "#DAA520"]
      }]
    }, {
      responsive: true,
      maintainAspectRatio: false,
      cutout: "60%",
      layout: { padding: { top: 20, bottom: 20 } },
      plugins: {
        legend: { position: "top" },
        title: { display: true, text: "Distribuição de Lucros" }
      }
    });

  });

</script>