<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div>
    <div class="clearfix"></div>
    <br>
    <table class="table dt-table">
        <thead>
            <th width="10%">#</th>
            <th width="30%"><?php echo _l('nivel_risco'); ?></th>
            <th width="30%"><?php echo _l('description'); ?></th>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            <?php foreach($nivel_risco as $c){ ?>
            <?php $i++; ?>
            <tr>
                <th><?= $i ?></th>
                <td><?php echo html_entity_decode($c['nome']); ?></td>
                <td><?php echo html_entity_decode($c['descricao']); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>