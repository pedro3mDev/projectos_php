<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="tw-mb-6">
                    <div class="tw-mb-3">
                        <h4 class="tw-my-0 tw-font-bold tw-text-xl"> <?php echo $title ?> </h4>
                        <a href="<?php echo admin_url('politicas_empresa'); ?>">
                            <?php echo _l('pe_politica_empresa'); ?> → </a>
                        <a href="<?php echo admin_url('politicas_empresa/conduta_etica'); ?>">
                            <?php echo _l('pe_codigo_conduta_entica'); ?> →
                        </a>
                        <span class="text-dark"><?php echo $title; ?></span> →
                        <span class="text-dark"><?php echo $treinamento['nome']; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="bold">Informação Geral</h4>
                    <table class="table border table-striped ">
                        <tbody>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Conduta</td>
                                <td><?php echo $treinamento['nome']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Estado</td>
                                <td><?php echo $treinamento['status']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Data Treinamento</td>
                                <td><?php echo $treinamento['data_treinamento']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Criado Por</td>
                                <td><?php echo $treinamento['firstname'] .' '. $treinamento['lastname']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Criado em</td>
                                <td><?php echo $treinamento['created_at']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Ultima actualização em</td>
                                <td><?php echo $treinamento['updated_at']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    <h4>Participantes</h4>
                    <a href="<?php echo admin_url('politicas_empresa/conduta_etica/add_participante/'.$treinamento['id']); ?>"
                        class="btn btn-primary">Adicionar</a>
                    <table class="table table-hover table-bordered table-responsive">
                        <thead>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Resultado</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php if ($participantes == null) : ?>
                            <tr>
                                <td colspan="4">Sem Resultado</td>
                            </tr>
                            <?php
                            else :
                                $i = 0;
                                foreach($participantes as $partcipante) {
                                    $i++;
                            ?>
                            <tr>
                                <th><?= $i ?></th>
                                <td><?php echo $partcipante['firstname'] .' '.$partcipante['lastname']; ?></td>
                                <td>
                                    <?php echo form_open(admin_url('politicas_empresa/conduta_etica/editar_participante_treinamento/'.$partcipante['id']), array('method' => 'post')); ?>
                                    <div class="tw-flex tw-justify-start">
                                        <select class="form-control" name="resultado" id="resultado">
                                            <option value="pendente"
                                                <?php if ($partcipante['resultado'] == 'pendente') { echo 'selected'; } ?>>
                                                Pendente</option>
                                            <option value="aprovado"
                                                <?php if ($partcipante['resultado'] == 'aprovado') { echo 'selected'; } ?>>
                                                Aprovado</option>
                                            <option value="reprovado"
                                                <?php if ($partcipante['resultado'] == 'reprovado') { echo 'selected'; } ?>>
                                                Reprovado</option>
                                        </select>
                                        <div>
                                            <button type="submit" class="btn btn-primary">Actualizar</button>
                                        </div>
                                    </div>
                                    <?php echo form_close() ?>
                                </td>
                                <td class="tw-flex tw-justify-between">
                                    <a class="text-danger"
                                        onclick="return confirm('Tens certeza que desejas eliminar este Participante?'); "
                                        href="<?php echo admin_url('politicas_empresa/conduta_etica/treinamento_participante_eliminar/'.$partcipante['id']); ?>"><i
                                            class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php
                        }
                        endif
                    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="new_version"></div>
<?php init_tail(); ?>
<?php require('modules/recruitment/assets/js/company_js.php'); ?>