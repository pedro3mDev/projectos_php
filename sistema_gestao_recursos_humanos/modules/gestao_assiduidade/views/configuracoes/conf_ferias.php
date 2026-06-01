<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<div>
<h4>Configurações de Ferías</h4>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>
    <form action="<?php echo admin_url('gestao_assiduidade/salvar_conf_ferias'); ?>" method="get">
    <div class="row">
        <div class="form-group col-md-6">
            <label for="">Limite de dias(Para as Férias)</label>
            <input type="hidden" name="id" id="id" value="<?php echo $dados['id']?>">
            <input name="limite_dias_ferias" id="limite_dias_ferias" type="number" class="form-control" value="<?php echo $dados['limite_dias_ferias']?>" required>
        </div>
        <div class="form-group col-md-6">
            <label for="">Limite de Funcionarios(Funcionarios em Férias)</label>
            <input name="n_func_em_ferias" id="n_func_em_ferias" type="number" class="form-control" value="<?php echo $dados['n_func_em_ferias']?>">
        </div>
        <div class="form-group col-md-12">
            <label for="">Email de Notificação(Início de férias)</label>
            <textarea name="email_notificacao_inicio" id="email_notificacao_inicio" class="form-control">
                <?php echo $dados['email_notificacao_inicio']?>
            </textarea>
        </div>
        <div class="form-group col-md-12">
            <label for="">Email de Notificação(Término de férias)</label>
            <textarea name="email_notificacao_termino" id="email_notificacao_termino" class="form-control">
            <?php echo $dados['email_notificacao_termino']?>
            </textarea>
        </div>
    </div>

    <div class="_buttons">
    <button class="btn btn-primary"> <?php echo _l('Salvar'); ?></button>
    </div>
</form>
</div>
</body>
</html>
