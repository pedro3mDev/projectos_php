<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Politicas de Empresa / Riscos / Matriz
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
                        <!-- A Matriz deve estar aqui! -->
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr style="background-color: #336; color:#fff;">
                                        <th rowspan="2" class="align-middle text-center" style="text-align: center;">
                                            Probabilidade</th>
                                        <th colspan="5" class="text-center" style="text-align: center;">Impacto</th>
                                    </tr>
                                    <tr>
                                        <?php foreach ($impactos as $i) : ?>
                                        <th><?php echo html_entity_decode($i['impacto'] ?? ''); ?></th>
                                        <?php endforeach ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($probabilidades as $prob) : ?>
                                    <tr>

                                        <th>
                                            <?= $prob['descricao'] ?>
                                        </th>

                                        <?php foreach ($impactos as $i) : ?>
                                        <td
                                            style='background: <?= cor_matriz_risco($prob['valor_probabilidade'] * $i['valor_impacto']) ?>; color: black; font-weight: bold;'>
                                            <?= risco_matriz_exists([$i['id'], $prob['id']]) ?>
                                        </td>
                                        <?php endforeach ?>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>

                            <br>
                            <table class="table table-bordered text-center dt-table">
                                <thead>
                                    <tr>
                                        <th>Risco</th>
                                        <th>Impacto</th>
                                        <th>Probabilidade</th>
                                        <th>Nivel do Risco(Valor)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($riscos as $r) : ?>
                                    <tr>

                                        <th>
                                            <?= $r['titulo'] ?> <br>
                                            (<?= limitarPalavra(html_entity_decode($r['medidas_metigacao'] ?? ''), 7); ?>)
                                            <br>
                                            (<?= limitarPalavra(html_entity_decode($r['descricao'] ?? ''), 5); ?>)
                                        </th>
                                        <td
                                            style='background: <?= cor_risco($r['valor_impacto']) ?>; color: black; font-weight: bold;'>
                                            <?= $r['impacto'] ?></td>
                                        <td
                                            style='background: <?= cor_risco($r['valor_probabilidade']) ?>; color: black; font-weight: bold;'>
                                            <?= $r['descricao_p'] ?></td>
                                        <td
                                            style='background: <?= cor_matriz_risco($r['valor_probabilidade'] * $r['valor_impacto']) ?>; color: black; font-weight: bold;'>
                                            <?= estado_matriz_risco($r['nivel_risco']) ?> (<?= $r['nivel_risco'] ?>)
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