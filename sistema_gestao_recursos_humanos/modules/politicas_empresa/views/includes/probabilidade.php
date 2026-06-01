<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div>
    <div class="clearfix"></div>
    <br>
    <table class="table dt-table">
        <thead>
            <th width="30%"><?php echo _l('valor_probabilidade'); ?></th>
            <th><?php echo _l('description'); ?></th>
            <th></th>
        </thead>
        <tbody>
            <?php foreach($probabilidades as $c){ ?>
            <tr>
                <td><?php echo html_entity_decode($c['valor_probabilidade']); ?></td>
                <td><?= limitarPalavra(html_entity_decode($c['descricao']), 30); ?></td>
                <td style="background-color: <?= cor_risco($c['valor_probabilidade']) ?>;"></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>