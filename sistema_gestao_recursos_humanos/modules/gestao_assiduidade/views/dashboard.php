<?php init_head(); ?>
<div id="wrapper">
   <div class="content">

      <?php
         $data_view = [];
         $this->load->view('/admin/menu_modulo/menu', $data_view);
      ?>
      <div class="row">
         <div class="col-md-10">
            <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
               Gestão de Assiduidade / Dashboard
            </a>
         </div>
      
         
      </div>
      </br>

      </br>

      <div class="row">
            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000; height:110px; overflow-y: auto;">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35"
                            style="font-size: 14px; font-weight: bold; color:#DAA520;">
                            Total de Funcionários
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;"> 
                                <i class="fas fa-users fontsize24 me-2"></i>
                                 <?php echo $cards['total_funcionarios']; ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000; height:110px; overflow-y: auto;">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35"
                            style="font-size: 14px; font-weight: bold; color:#DAA520;">
                            Total de Registos - <?php echo date('Y'); ?> 
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fas fa-file fontsize24 me-2"></i>
                                <?php echo $cards['total_registros']; ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000; height:110px; overflow-y: auto;">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35"
                            style="font-size: 14px; font-weight: bold; color:#DAA520;">
                            Horarios
                        </p> 
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                            <i class="fas fa-user-plus fontsize24 me-2"></i>
                            <?php echo $cards['total_turnos']; ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000; height:110px; overflow-y: auto;">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35"
                            style="font-size: 14px; font-weight: bold; color:#DAA520;">
                            Total de Feriados
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fas fa-calendar fontsize24 me-2"></i>
                                0  

                            </p>
                        </div>
                    </a>
                </div>
            </div>

      </div>
      <!-- -->
      
      </br>
      <div class="row">
            <div class="col-md-6">
                <div class="panel_s" style="height: auto;">
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i>Excepções
                        </h4>
                        <hr />
                        <div class="row" style="padding:10px;">
                            <div class="col-md-6">
                                <button 
                                    class="btn" 
                                    style="width: 100%; color:#fff; border-bottom: 1px solid red; background-color: #336; padding: 15px; font-size: 12px; font-weight: bold; border-radius: 8px; text-transform: uppercase;">
                                    
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button 
                                    class="btn" 
                                    style="width: 100%; color:#fff; border-bottom: 1px solid red; background-color: #336; padding: 15px; font-size: 12px; font-weight: bold; border-radius: 8px; text-transform: uppercase;">
                                    
                                </button>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel_s" style="height: auto;">
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i>Requisições Pendentes
                        </h4>
                        <hr />
                        <div class="row" style="padding:10px;">
                            <div class="col-md-6">
                                <button 
                                    class="btn" 
                                    style="width: 100%; color:#fff; border-bottom: 1px solid red; background-color: #336; padding: 15px; font-size: 12px; font-weight: bold; border-radius: 8px; text-transform: uppercase;">
                                    
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button 
                                    class="btn" 
                                    style="width: 100%; color:#fff; border-bottom: 1px solid red; background-color: #336; padding: 15px; font-size: 12px; font-weight: bold; border-radius: 8px; text-transform: uppercase;">
                                    
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
      </div>
      </br>
      <div class="row">

         <!-- 1º Gráfico -->
         <div class="col-md-4"> 
            <div class="panel_s" style="min-height: 300px; width: 100%;">
               <div class="panel-body">
                  <h4 class="no-margin font-bold">
                     <i class="fa fa-address-card-o" aria-hidden="true"></i> Estatisticas
                  </h4>
                  <hr />
                  <div class="chart-container justify-content-center"
                     style="position: relative; width: 100%; height: 190px;">
                     <canvas id="funcionario_genero"></canvas>
                  </div>
               </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
               window.onload = function() {
                     // Inicializar o gráfico "tipo_contrato_emprego"
                     var ctx3 = document.getElementById('funcionario_genero').getContext('2d');
                     var tipoContratoEmpregoChart = new Chart(ctx3, {
                        type: 'doughnut',
                        data: {
                           labels: ['Check In', 'Horas Extras'],
                           datasets: [{
                                 label: 'Funcionários',
                                 data: ["<?php echo $cards['estatisticas']['check_in']; ?>", "<?php echo $cards['estatisticas']['horas_extras']; ?> "],
                                 backgroundColor: ['#336', '#DAA520'],
                                 hoverBackgroundColor: ['#36A2EB', '#FFCD56']
                           }]
                        },
                        options: {
                           responsive: true,
                           maintainAspectRatio: false,
                           cutoutPercentage: 60,
                           legend: {
                                 position: 'top',
                                 labels: {
                                    fontSize: 14,
                                    boxWidth: 15
                                 }
                           },
                           tooltips: {
                                 enabled: true
                           },
                           rotation: Math.PI
                        }
                     });
                     
               };
            </script>
         </div>
         
         <!-- 2º Gráfico -->
         <!--div class="col-md-2">
            <div class="panel_s" style="max-height: 300px; width: 100%;">
               <div class="panel-body">
                     <h4 class="no-margin font-bold">
                        <i class="fa fa-address-card-o" aria-hidden="true"></i> Sem check in 
                     </h4>
                     <hr />
                     <div class="d-flex align-items-center justify-content-center">
                        <p style="font-size:100px; color:#336; text-align:center;">
                           <i class="fas fa-ban users fontsize24 me-2"></i> 
                        </p>
                        <p style="font-size:20px; color:#336; text-align:center;">
                          0 
                        </p>
                     </div>
               </div>
            </div>
         </div-->

         <!-- 2º Card --> 
         <div class="col-md-2">
            <div class="panel_s" style="max-height: 300px; width: 100%;">
               <div class="panel-body">
                  <h4 class="no-margin font-bold">
                     <i class="fa fa-address-card-o" aria-hidden="true"></i> Em licença 
                  </h4>
                  <hr />
                  <div class="d-flex align-items-center justify-content-center">
                     <p style="font-size:100px; color:#336; text-align:center;">
                        <i class="fas fa-users fontsize24 me-2"></i> 
                     </p>
                     <p style="font-size:20px; color:#336; text-align:center;">
                         <?php echo $cards['em_lecencas']; ?> 
                     </p>
                  </div>
               </div>
            </div>
         </div>

         <!-- 3º Card -->
         <div class="col-md-2">
            <div class="panel_s" style="max-height: 300px; width: 100%;">
               <div class="panel-body">
                  <h4 class="no-margin font-bold">
                     <i class="fa fa-address-card-o" aria-hidden="true"></i> Feriados 
                  </h4>
                  <hr />
                  <div class="d-flex align-items-center justify-content-center">
                     <p style="font-size:100px; color:#336; text-align:center;">
                        <i class="fas fa-calendar fontsize24 me-2"></i> 
                     </p>
                     <p style="font-size:20px; color:#336; text-align:center;">
                     <?php echo $cards['total_feriados']; ?> 
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <!-- 2º Card -->
         <div class="col-md-2">
            <div class="panel_s" style="max-height: 300px; width: 100%;">
               <div class="panel-body">
                  <h4 class="no-margin font-bold">
                     <i class="fa fa-address-card-o" aria-hidden="true"></i> Check In 
                  </h4>
                  <hr />
                  <div class="d-flex align-items-center justify-content-center">
                     <p style="font-size:100px; color:#336; text-align:center;">
                        <i class="fas fa-sign-in-alt fontsize24 me-2"></i> 
                     </p>
                     <p style="font-size:20px; color:#336; text-align:center;">
                        1
                     </p>
                  </div>
               </div>
            </div>
         </div>
         
         <!-- 4º Card -->
         <div class="col-md-2">
            <div class="panel_s" style="max-height: 300px; width: 100%;">
               <div class="panel-body">
                  <h4 class="no-margin font-bold">
                     <i class="fa fa-address-card-o" aria-hidden="true"></i> Check-out 
                  </h4>
                  <hr />
                  <div class="d-flex align-items-center justify-content-center">
                     <p style="font-size:100px; color:#336; text-align:center;">
                        <i class="fas fa-sign-out-alt fontsize24"></i> 
                     </p>
                     <p style="font-size:20px; color:#336; text-align:center;">
                        <?php echo $cards['estatisticas']['check_in']; ?>
                     </p>
                  </div>
               </div>
            </div>
         </div>
         
         
      </div>

      <div class="row">
      <div class="col-md-4">
                <div class="panel_s" style="height: 410px;">
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i>Check-in  | Mês
                        </h4>
                        <hr />
                        <div class="col-md-12">
                            <div class="chart-container" style="position: relative; width: 100%; height: 300px;">
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
                                label: 'Presenças',
                                data:  ["<?php echo $cards['grafico_presenca']['01']; ?>", "<?php echo $cards['grafico_presenca']['02']; ?>", "<?php echo $cards['grafico_presenca']['03']; ?>", "<?php echo $cards['grafico_presenca']['04']; ?>", "<?php echo $cards['grafico_presenca']['05']; ?>", "<?php echo $cards['grafico_presenca']['06']; ?>", "<?php echo $cards['grafico_presenca']['07']; ?>", "<?php echo $cards['grafico_presenca']['08']; ?>", "<?php echo $cards['grafico_presenca']['09']; ?>", "<?php echo $cards['grafico_presenca']['10']; ?>", "<?php echo $cards['grafico_presenca']['11']; ?>", "<?php echo $cards['grafico_presenca']['12']; ?>"],
                                backgroundColor: '#336',
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

            <div class="col-md-4">
                <div class="panel_s" style="height: 410px;">
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i>Horas Extras
                        </h4>
                        <hr />
                        <div class="col-md-12">
                            <div class="chart-container" style="position: relative; width: 100%; height: 300px;">
                                <canvas id="horas"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Script -->
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const ctx = document.getElementById('horas').getContext('2d');

                    // Dados do gráfico
                    const labels = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho',
                        'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                    ];

                    const data = {
                        labels: labels,
                        datasets: [{
                                label: 'Voluntária (%)',
                                data: ["<?php echo $cards['grafico_he']['01']; ?>", "<?php echo $cards['grafico_he']['02']; ?>", "<?php echo $cards['grafico_he']['03']; ?>", "<?php echo $cards['grafico_he']['04']; ?>", "<?php echo $cards['grafico_he']['05']; ?>", "<?php echo $cards['grafico_he']['06']; ?>", "<?php echo $cards['grafico_he']['07']; ?>", "<?php echo $cards['grafico_he']['08']; ?>", "<?php echo $cards['grafico_he']['09']; ?>", "<?php echo $cards['grafico_he']['10']; ?>", "<?php echo $cards['grafico_he']['11']; ?>", "<?php echo $cards['grafico_he']['12']; ?>"],
                                backgroundColor: 'rgba(218,165,32)',
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
            <div class="col-md-4">
               <div class="panel_s" style="height: 410px;">
                  <div class="panel-body">
                     <h4 class="no-margin font-bold">
                        <i class="fa fa-address-card-o" aria-hidden="true"></i>Dispositivos
                     </h4>
                     <hr />
                     <div class="row" style="padding:10px;">


                    
                     <?php  foreach ($cards['biometricos'] as $key => $value) { ?>
                        <div class="col-md-6">
                           <button 
                              class="btn" 
                              style="width: 100%; color:#fff; border-bottom: 1px solid red; background-color: #336; padding: 15px; font-size: 12px; font-weight: bold; border-radius: 8px; text-transform: uppercase;">
                             <?php echo $value['nome']; ?>
                           </button>
                        </div>
                      <?php }  ?> 
                      
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