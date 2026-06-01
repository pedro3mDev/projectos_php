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
                    Gestão de Assiduidade / <?php echo _l('Gestão de Férias'); ?>
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
            <div class="col-md-12" id="small-table">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold"><i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    <?php echo _l($title); ?></h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class="_buttons col-md-12">
                                <?php if(is_admin() || has_permission('hrm_setting','','create')){ ?>
                                <a href="#" data-toggle="modal" data-target="#modal_add"
                                    class="btn btn-info pull-left display-block">
                                    <i class="fa fa-plus"></i> <?php echo _l(' Solicitar Férias'); ?>
                                </a>
                                <?php } ?>

                                <?php if(is_admin() || has_permission('hrm_setting','','create')){ ?>
                                <!-- <a style="margin-left: 9px" href="#"  data-toggle="modal" data-target="#modal_add" class="btn btn-default pull-left display-block">
                                <i class="fa fa-calendar"></i> <?php echo _l(' Planear Férias'); ?>
                              </a> -->
                                <?php } ?>

                                <?php if(is_admin() || has_permission('hrm_setting','','create')){ ?>
                                <a style="margin-left: 9px"
                                    href="<?php echo admin_url('gestao_assiduidade/gestao_de_ferias_funcionarios'); ?>"
                                    class="btn btn-success pull-left display-block">
                                    <i class="fa fa-users"></i> <?php echo _l(' Funcionários em férias'); ?>
                                </a>
                                <?php } ?>

                            </div>
                        </div>

                        <!--Alerts-->
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="alert alert-warning" role="alert">
                                    <h4 class="alert-heading">Alerta!</h4>
                                    <p>Saudações prezado, o limite máximo de dias de férias atual que foi estabelecido
                                        no sitema é de <?php echo get_conf_gestao_ferias()->limite_dias_ferias;  ?>
                                        dias.</p>
                                </div>
                            </div>
                        </div>
                        <!--End Alerts-->

                        <div class="row">
                            <div class="">
                                <!--filtros-->
                                <?php
                            if (!isset($filtros['departmentid'])) {
                              $filtros['departmentid'] = 0;
                            }
                            if (!isset($filtros['funcao_id'])) {
                              $filtros['funcao_id'] = 0;
                            }

                            if (!isset($filtros['estado'])) {
                              $filtros['estado'] = 0;
                            }

                            ?>
                                <form action="<?php echo admin_url('gestao_assiduidade/gestao_de_ferias'); ?>"
                                    id="filtros_select">
                                    <div class="col-md-3" style="margin-top: 22px; margin-bottom: 22px">
                                        <label for=""><?php echo _l('Departamentos'); ?></label>
                                        <select name="departmentid" class="selectpicker" id="departmentid"
                                            data-width="100%" data-actions-box="true" data-live-search="true"
                                            data-none-selected-text="">
                                            <option value="0">Nada selecionado</option>
                                            <?php 
                                             foreach ($opt_departments as $value) { ?>
                                            <option
                                                value="<?php echo new_html_entity_decode($value['departmentid']); ?>"
                                                <?php if($filtros['departmentid']==$value['departmentid']){ echo "selected";} ?>>
                                                <?php echo new_html_entity_decode($value['name']); ?></option>
                                            <?php }
                                          ?>
                                        </select>
                                    </div>

                                    <div class="col-md-3" style="margin-top: 22px; margin-bottom: 22px">
                                        <label for=""><?php echo _l('Função'); ?></label>
                                        <select name="funcao_id" class="selectpicker" id="funcao_id" data-width="100%"
                                            data-actions-box="true" data-live-search="true" data-none-selected-text="">
                                            <option value="0">Nada selecionado</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3" style="margin-top: 22px; margin-bottom: 22px">
                                        <label for=""><?php echo _l('Estado'); ?></label>
                                        <select name="estado" class="selectpicker" id="estado" data-width="100%"
                                            data-actions-box="true" data-live-search="true" data-none-selected-text="">
                                            <option value="0">Nada selecionado</option>
                                            <option value="P" <?php if($filtros['estado']=='P'){ echo "selected";} ?>>
                                                Pendente</option>
                                            <option value="A" <?php if($filtros['estado']=='A'){ echo "selected";} ?>>
                                                Aprovado</option>
                                            <option value="R" <?php if($filtros['estado']=='R'){ echo "selected";} ?>>
                                                Rejeitado</option>
                                            <option value="E" <?php if($filtros['estado']=='E'){ echo "selected";} ?>>Em
                                                uso</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3" style="margin-top: 22px; margin-top: 42px">
                                        <button id="btn_pesquisar" class="btn btn-primary"> Pesquisar </button>
                                    </div>
                                </form>
                                <!--end filtros-->
                            </div>

                        </div>
                        <br>

                        <br>
                        <!--Tabela-->
                        <div id="tabela">
                            <?php  echo $tabela; ?>
                        </div>

                        <!--end Tabela-->
                    </div>
                </div>
            </div>
            <div class="col-md-7 small-table-right-col">
                <div id="proposal_sm_view" class="hide">
                </div>
            </div>
        </div>
    </div>

</div>



<!-- Modal -->
<div class="modal fade" id="modal_add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Solicitar Férias
                </h4>
            </div>
            <div class="modal-body">


                <form action="<?php echo admin_url('gestao_assiduidade/add_gestao_ferias'); ?>" id="form_add">
                    <input type="hidden" id="id_mark" name="id">
                    <div class="row">
                        <div class="col-md-12" style="">
                            <label for=""><?php echo _l('Funcionário'); ?></label>
                            <select name="func_id" class="selectpicker" id="func_id" data-width="100%"
                                data-actions-box="true" data-live-search="true" data-none-selected-text="">
                                <option value="0">Nada selecionado</option>
                                <?php 
                                             foreach ($opt_func as $value) { ?>
                                <option value="<?php echo new_html_entity_decode($value['staffid']); ?>">
                                    <?php echo new_html_entity_decode($value['firstname'].' '.$value['lastname']); ?>
                                </option>
                                <?php }
                                          ?>
                            </select>
                            <br>
                            <br>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">De </label>
                            <input name="de" id="de" type="date" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">Até</label>
                            <input name="ate" id="ate" type="date" class="form-control">
                        </div>
                        <div class="col-md-12" style="margin-top: 22px">
                            <label for="" class="form-label">Descrição</label>
                            <textarea name="descricao" id="descricao" class="form-control"></textarea>
                        </div>
                    </div>



            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!--End Modal -->

<!-- Modal -->
<div class="modal fade" id="modal_editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Editar Solicitação
                </h4>
            </div>
            <div class="modal-body">


                <form action="<?php echo admin_url('gestao_assiduidade/add_gestao_ferias'); ?>" id="form_add">
                    <input type="hidden" id="id_mark" name="id">
                    <div class="row">
                        <div class="col-md-12" style="">
                            <label for=""><?php echo _l('Funcionário'); ?></label>
                            <select name="func_id" class="selectpicker" id="e_func_id" data-width="100%"
                                data-actions-box="true" data-live-search="true" data-none-selected-text="">
                                <option value="0">Nada selecionado</option>
                                <?php 
                                             foreach ($opt_func as $value) { ?>
                                <option value="<?php echo new_html_entity_decode($value['staffid']); ?>">
                                    <?php echo new_html_entity_decode($value['firstname'].' '.$value['lastname']); ?>
                                </option>
                                <?php }
                                          ?>
                            </select>
                            <br>
                            <br>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">De </label>
                            <input id="e_de" type="date" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">Até</label>
                            <input id="e_ate" type="date" class="form-control">
                        </div>
                        <div class="col-md-12" style="margin-top: 22px">
                            <label for="" class="form-label">Descrição</label>
                            <textarea name="descricao" id="e_descricao" class="form-control"></textarea>
                        </div>
                    </div>



            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!--End Modal -->



<?php init_tail(); ?>
<?php require('modules/gestao_assiduidade/assets/js/gestao_ferias_js.php'); ?>
</body>

</html>