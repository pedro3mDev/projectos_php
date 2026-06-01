<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="tw-mb-6">
                    <div class="tw-mb-3">
                        <h4 class="tw-my-0 tw-font-bold tw-text-xl"><?php echo $politica['titulo']; ?></h4>
                        <a href="<?php echo admin_url('politicas_empresa'); ?>">
                            <?php echo _l('pe_politica_empresa'); ?> → </a>
                        <a href="<?php echo admin_url('politicas_empresa/seguranca_escritorio'); ?>">
                            <?php echo _l('pe_seguranca_escritorio'); ?> →
                        </a>
                        <span class="text-dark"><?php echo $politica['titulo']; ?></span>
                    </div>
                </div>

                <div class="tw-flex tw-justify-start tw-items-center tw-gap-x-6">
                    <div class="tw-flex tw-justify-between tw-items-center tw-gap-x-1">
                        <a href="<?php echo admin_url('politicas_empresa/seguranca_escritorio/politica_editar/'.$politica['id']); ?>"
                            class="btn btn-primary">
                            <i class="fa-regular fa-edit tw-mr-1"></i> Editar </a>

                        <a onclick="return confirm('Tens certeza que desejas eliminar esta Politica?'); "
                            href="<?php echo admin_url('politicas_empresa/seguranca_escritorio/politica_eliminar/'.$politica['id']); ?>"
                            class="btn btn-danger">
                            <i class="fa-regular fa-trash tw-mr-1"></i> Eliminar </a>
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
                                <td class="bold" width="40%">Politica</td>
                                <td><?php echo $politica['titulo']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Criado Por</td>
                                <td><?php echo $politica['firstname'] .' '. $politica['lastname']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Criado em</td>
                                <td><?php echo $politica['created_at']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Ultima actualização em</td>
                                <td><?php echo $politica['updated_at']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <h5>Descrição</h5>
                    <p><?= $politica['descricao'];?></p>
                    <?php if (!empty($politica['arquivo'])) : ?>
                    <h5>Anexo</h5>
                    <a target="_blank"
                        href="<?= base_url('modules/politicas_empresa/uploads/'.$politica['arquivo']); ?>"><?= $politica['arquivo']; ?></a>
                    <?php else : ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <h5 class="bold">Staff de Viagem</h5>
            <div>
                <?php echo form_open(admin_url('politicas_empresa/seguranca_escritorio/add_politica_categoria/'.$politica['id']), array('method' => 'post')); ?>
                <div class="form-group">
                    <label for="company" class="control-label">Adicionar<small class="req text-danger">*
                        </small></label>
                    <div class="d-flex">
                        <select class="form-control" name="categoria">
                            <option value=''></option>
                            <?php
                                foreach ($categorias as $categoria) {
                            ?>
                            <option value="<?php echo $categoria['id']; ?>">
                                <?php echo $categoria['categoria']; ?></option>
                            <?php } ?>
                        </select>
                        <div class="text-danger"><?php echo validation_errors(); ?></div>
                        <button class="btn btn-primary tw-mt-1"> Adicionar </button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
            <table class="table border table-striped ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th><i class="fas fa-cog"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                            if ($categorias_politica == NULL) {
                                echo "<tr><th colspan='3'> Sem resultado. </th></tr>";
                            }
                            else {
                            $i = 0;
                            foreach ($categorias_politica as $cat_p) {
                                $i++;
                        ?>
                    <tr class="project-overview">
                        <th> <?php echo $i; ?> </th>
                        <td><?php echo  $cat_p['categoria']; ?>
                        </td>
                        <td><a onclick="return confirm('Tens certeza que desejas eliminar esta Categoria?');"
                                href="<?php echo admin_url('politicas_empresa/seguranca_escritorio/remover_politica_categoria/'.$politica['id'].'/'.$cat_p['id']); ?>"
                                class="text-danger">Remover</a></td>
                    </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <h4>Acessos</h4>
            <table class="table border table-striped ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Acao</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                            if ($acessos == NULL) {
                                echo "<tr><th colspan='3'> Sem resultado. </th></tr>";
                            }
                            else {
                            $i = 0;
                            foreach ($acessos as $acesso) {
                                $i++;
                        ?>
                    <tr class="project-overview">
                        <th> <?php echo $i; ?> </th>
                        <td><?php echo  $acesso['firstname'] .' '. $acesso['lastname'] ; ?></td>
                        <td><?php echo  $acesso['acao']; ?></td>
                        <td><?php echo  $acesso['created_at']; ?></td>
                    </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="new_version"></div>
<?php init_tail(); ?>
<?php require('modules/recruitment/assets/js/company_js.php'); ?>