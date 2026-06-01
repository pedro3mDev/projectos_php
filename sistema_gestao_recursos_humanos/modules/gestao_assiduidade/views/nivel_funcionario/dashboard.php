<?php init_head(); ?>
<div id="wrapper">
   <div class="content">

        <?php
            $data_view = [];
            $this->load->view('/admin/menu_modulo/menu', $data_view);
        ?>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Assiduidade 
                </a>
            </div>
            <div class="col-md-6" style=" display: flex; justify-content: flex-end; align-items: center;">
                <a class="dashboard-link" href="" style="font-size: 16px; color: red;">
                    Nivel do Funcionário
                </a>
            </div>
        </div>
        </br>

        <div class="row">
            <div class="col-md-10">
                <div class="panel_s" style="height:700px;">
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i>Grafico de Picagem
                        </h4>
                        <hr />
                        <div class="col-md-12">
                            <div class="chart-container" style="position: relative; width: 90%; height: 300px;">
                                <canvas id="taxa_rotatividade"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Script -->
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const ctx = document.getElementById('taxa_rotatividade').getContext('2d');

                        // Dados do gráfico
                        const labels = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho',
                            'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                        ];

                        const data = {
                            labels: labels,
                            datasets: [{
                                    label: 'Na Hora',
                                    data: [5, 4, 6, 7, 5, 6, 5, 7, 6, 5, 4, 6],
                                    backgroundColor: '#336',
                                    borderColor: 'rgba(255, 255, 255, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Atrazado',
                                    data: [2, 3, 2, 4, 3, 2, 3, 2, 4, 3, 2, 3],
                                    backgroundColor: 'rgba(139,0,0)',
                                    borderColor: 'rgba(255, 255, 255, 1)',
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
                                plugins: {
                                    legend: {
                                        position: 'top' // Exibe a legenda na parte superior
                                    }
                                },
                                scales: {
                                    x: {
                                        grid: {
                                            display: false // Remove as linhas de grade no eixo X
                                        }
                                    },
                                    y: {
                                        grid: {
                                            display: false // Remove as linhas de grade no eixo Y
                                        },
                                        beginAtZero: true,
                                        max: 10 // Limite superior ajustável
                                    }
                                }
                            }
                        };
                        // Cria o gráfico
                        new Chart(ctx, config);
                    });
                </script>
            </div>

            <div class="col-md-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel_s" style="max-height: 300px; width: 100%;">
                            <div class="panel-body">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Fazer Check In 
                                </h4>
                                <hr /> 
                                <div class="d-flex align-items-center justify-content-center">
                                    <button class="btn" style="width: 100%; color:#fff; 
                                        border-bottom: 1px solid red; 
                                        background-color: #2E8B57; 
                                        padding: 15px; font-size: 12px; 
                                        font-weight: bold; border-radius: 8px; 
                                        text-transform: uppercase;">
                                        <i class="fas fa-sign-in-alt me-2"></i> 
                                        Clique Aqui
                                    </button>
                                    <p style="font-size:14px; color:#2E8B57; text-align:center;">
                                        Check In Realizado
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="col-md-12">
                        <div class="panel_s" style="max-height: 300px; width: 100%; ">
                            <div class="panel-body">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Fazer Check-out 
                                </h4>
                                <hr />
                                <div class="d-flex align-items-center justify-content-center">
                                    <button class="btn" style="width: 100%; color:#fff; 
                                        border-bottom: 1px solid red; 
                                        background-color: #8B0000; 
                                        padding: 15px; font-size: 12px; 
                                        font-weight: bold; border-radius: 8px; 
                                        text-transform: uppercase;">
                                        <i class="fas fa-user-minus fontsize24 me-2"></i> 
                                        Clique Aqui
                                    </button>
                                    <p style="font-size:14px; color:#8B0000; text-align:center;">
                                        Check In Realizado
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            
            
        </div>
    </div>
   
</div>


<?php init_tail(); ?>
</body>
</html>