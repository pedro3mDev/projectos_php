<?php init_head(); ?>
<div id="wrapper">
    <div class="content">

        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Desenvolvimento Individual / Recomendações de Planos
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>

        </br>
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Recomendar Planos
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="<?php echo admin_url('gestao_desenv_individual/avaliacoes') ?>" class="btn"
                                    style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Avaliações de Desempenho
                                </a>
                                <a href="<?php echo admin_url('gestao_desenv_individual/analise') ?>" class="btn"
                                    style="background-color: #2F4F4F; border-color: #2F4F4F; color: white;">
                                    <i class="fa-regular "></i>
                                    Análise
                                </a>



                            </div>

                        </div>
                        <div class="row">
                            <div class=" col-md-9">
                            </div>

                            <div class=" col-md-3">
                                <select name="estado_f" id="estado_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Estado'); ?>">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Avaliação</th>
                                <th>Meta do Plano</th>
                                <th>Pontuação Recomendada do Plano</th>
                            </thead>
                            <tbody>
                              
                                    <?php foreach ($recomendar_plano as $dados): ?>
                                        <tr>
                                            <td><a href="#"><?= htmlspecialchars($dados['avaliacao_nome']); ?></a></td>
                                            <td><a href="#"><?= htmlspecialchars($dados['meta']); ?></a></td>
                                            <td><a href="#"><?= htmlspecialchars($dados['pontuacao_recomendado']); ?></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                               
                                  <!--   <tr>
                                        <td colspan="10" class="text-center">Nenhum plano a recomendar</td>
                                    </tr> -->
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="btn-bottom-pusher"></div>
</div>
</div>
<div id="new_version"></div>


<?= form_close() ?>
<?php init_tail(); ?>

</body>

</html>