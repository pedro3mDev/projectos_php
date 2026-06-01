<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
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
                    Requisições / Configurações / Categoria de Requisição / Novo
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
            <?php
            if (isset($category_data)) {
                $requestUrl = 'approvify/create_type/' . $category_data->id;
            } else {
                $requestUrl = 'approvify/create_type';
            }
            echo form_open(admin_url($requestUrl));
            ?>
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4>
                            <?php echo $title; ?>
                        </h4>
                        <hr>
                        <div class="row">
                            <?php if (isset($category_data)) : ?>
                            <?php if ($category_data->id == 1) : ?>
                            <div class="col-md-4">
                                <?php echo render_input('', 'approvify_category_name', $category_data->category_name ?? '', 'text', ['disabled' => 'disabled']); ?>
                            </div>
                            <?php else : ?>
                            <div class="col-md-4">
                                <?php echo render_input('category_name', 'approvify_category_name', $category_data->category_name ?? ''); ?>
                            </div>
                            <?php endif ?>
                            <?php else : ?>
                            <div class="col-md-4">
                                <?php echo render_input('category_name', 'approvify_category_name', $category_data->category_name ?? ''); ?>
                            </div>
                            <?php endif ?>
                            <div class="col-md-4">
                                <?php echo render_input('category_description', 'approvify_category_description', $category_data->category_description ?? ''); ?>
                            </div>
                            <div class="col-md-4">
                                <?php echo render_input('category_icon', 'approvify_category_icon', $category_data->category_icon ?? ''); ?>
                            </div>
                            <div class="col-md-12">
                                <?php
                                $selectedStaff = '';
                                if (isset($category_data)) {
                                    $selectedStaff = json_decode($category_data->approve_list ?? '');
                                }
                                echo render_select('approve_list[]', $staff_list, ['staffid', ['firstname', 'lastname']], 'approvify_approvers', $selectedStaff, ['multiple' => true], [], '', '', false);
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"
                                style=" display: flex; justify-content: flex-end; align-items: center;">
                                <button type="submit" class="btn btn-success"><?php echo _l('Salvar'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<?php init_tail(); ?>