<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Plano Sucessão e Liderança / Matriz de Risco
                </a>
            </div>
            <div class="col-md-6" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>
        </br>

        <div class="row">
            <div class="col-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Matriz de Risco Resultado
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="<?php echo admin_url('plan_sucess_lideranca/analise_risco_resultado')?>"
                                    class="btn" style="background-color: #2E8B57; border-color: #2E8B57; color: white;">
                                    <i class="fa-regular "></i>
                                    Resultado
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/analise_risco')?>" class="btn"
                                    style="background-color: #4B0082; border-color: #4B0082; color: white;">
                                    <i class="fa-regular "></i>
                                    Risco
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/analise_risco_impacto')?>"
                                    class="btn" style="background-color: #FFD700; border-color: #FFD700; color: white;">
                                    <i class="fa-regular "></i>
                                    Impacto
                                </a>

                            </div>

                        </div>
                        <!-- A Matriz deve estar aqui! -->
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr style="background-color: #336; color:#fff;">
                                        <th rowspan="2" class="align-middle text-center" style="text-align: center;">
                                            Risco</th>
                                        <th colspan="5" class="text-center" style="text-align: center;">Impacto</th>
                                    </tr>
                                    <tr>
                                        <?php foreach ($impacto as $i) : ?>
                                        <th><?php echo html_entity_decode($i['nome'] ?? ''); ?></th>
                                        <?php endforeach ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($nivel_risco as $prob) : ?>
                                    <?php
                                        switch ($prob['nome']) {
                                            case 'Pequeno': $valor_nivel_risco = 1; break;
                                            case 'Medio': $valor_nivel_risco = 2; break;
                                            case 'Alto': $valor_nivel_risco = 3; break;
                                            default: $valor_nivel_risco = 0; break;
                                        }
                                    ?>
                                    <tr>
                                        <th>
                                            <?= $prob['nome'] ?>
                                        </th>
                                        <?php foreach ($impacto as $i) : ?>
                                        <?php
                                            switch ($i['nome']) {
                                                case 'Pequeno': $valor_empacto = 1; break;
                                                case 'Medio': $valor_empacto = 2; break;
                                                case 'Grande': $valor_empacto = 3; break;
                                                default: $valor_empacto = 0; break;
                                            }
                                        ?>
                                        <td
                                            style='background: <?= psl_cor_matriz_risco($valor_nivel_risco * $valor_empacto) ?>; color: black; font-weight: bold;'>
                                            <?= psl_estado_matriz_risco($valor_nivel_risco * $valor_empacto) ?>
                                            <?= psl_risco_matriz_exists([$prob['id'], $i['id']]) ?>
                                        </td>
                                        <?php endforeach ?>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>

                            <br>
                            <table class="table table-hover table-bordered table-responsive dt-table">
                                <thead class="thead-custom">
                                    <th>Risco</th>
                                    <th>Impacto</th>
                                    <th>Nivel de Risco(Valor)</th>
                                </thead>
                                <tbody>
                                    <?php $array = ['Pequeno', 'Medio', 'Grande']; ?>
                                    <?php foreach($array as $item) : ?>
                                    <?php
                                        switch ($item) {
                                            case 'Pequeno': $valor_nivel_risco = 1; break;
                                            case 'Medio': $valor_nivel_risco = 2; break;
                                            case 'Grande': $valor_nivel_risco = 3; break;
                                            default: $valor_nivel_risco = 0; break;
                                        }
                                        switch ($item) {
                                            case 'Pequeno': $valor_empacto = 1; break;
                                            case 'Medio': $valor_empacto = 2; break;
                                            case 'Grande': $valor_empacto = 3; break;
                                            default: $valor_empacto = 0; break;
                                        }
                                    ?>
                                    <tr>
                                        <td
                                            style='background: <?= psl_cor_risco($valor_nivel_risco) ?>; color: black; font-weight: bold;'>
                                            <?= $item ?></td>
                                        <td
                                            style='background: <?= psl_cor_risco($valor_empacto) ?>; color: black; font-weight: bold;'>
                                            <?= $item ?></td>
                                        <td
                                            style='background: <?= psl_cor_matriz_risco($valor_nivel_risco * $valor_empacto) ?>; color: black; font-weight: bold;'>
                                            <?= psl_estado_matriz_risco($valor_nivel_risco * $valor_empacto) ?>
                                            (<?= ($valor_nivel_risco * $valor_empacto) ?>)
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>


                            <!-- <table class="table table-bordered text-center">
                                <thead>
                                    <tr style="background-color: #336; color:#fff;">
                                        <th rowspan="2" class="align-middle text-center" style="text-align: center;">
                                            Probabilidade</th>
                                        <th colspan="5" class="text-center" style="text-align: center;">Impacto</th>
                                    </tr>
                                    <tr>
                                        <th>Muito Baixo</th>
                                        <th>Baixo</th>
                                        <th>Médio</th>
                                        <th>Alto</th>
                                        <th>Muito Alto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $probabilidades = ['Muito Baixo', 'Baixo', 'Médio', 'Alto', 'Muito Alto'];
                                    $cores = [
                                        'Muito Baixo' => '#D4E157', // Verde claro
                                        'Baixo' => '#FFEB3B', // Amarelo
                                        'Médio' => '#FF9800', // Laranja
                                        'Alto' => '#F44336', // Vermelho
                                        'Muito Alto' => '#B71C1C' // Vermelho escuro
                                    ];

                                    for ($i = 4; $i >= 0; $i--) {
                                        echo "<tr>";
                                        echo "<td><strong>{$probabilidades[$i]}</strong></td>";

                                        for ($j = 0; $j < 5; $j++) {
                                            $nivel = $probabilidades[max($i, $j)]; // Define o nível de risco
                                            echo "<td style='background-color: {$cores[$nivel]}; color: black; font-weight: bold;'>{$nivel}</td>";
                                        }
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table> -->
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="btn-bottom-pusher"></div>
        </div>
    </div>
    <div id="new_version"></div>


    <?php init_tail(); ?>
    <?php require('modules/politicas_empresa/assets/js/company_js.php'); ?>
    </body>

    </html>