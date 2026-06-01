<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div>
    <div class="clearfix"></div>
    <br>
    <table class="table dt-table">
        <thead>
            <th width="30%"><?php echo _l('impacto'); ?></th>
        </thead>
        <tbody>
            <?php foreach($impactos as $c){ ?>
            <tr>
                <td><?php echo html_entity_decode($c['valor_impacto']); ?></td>
                <td><?php echo html_entity_decode($c['impacto']); ?></td>
                <td style="background-color: <?= cor_risco($c['valor_impacto']) ?>;"></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>