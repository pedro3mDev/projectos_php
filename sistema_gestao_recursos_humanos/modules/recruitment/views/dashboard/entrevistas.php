<div class="row"> 
    
    <div class="col-md-12">
        <div class="top_stats_wrapper minheight85">
            <p class="bold margintop15-color"><?php echo _l('upcoming_interview'); ?></p>
                <hr class="margintop15-color" />
                <table class="table dt-table">
                    <thead>
                        <th><?php echo _l('interview_schedules_name'); ?></th>
                        <th><?php echo _l('recruitment_campaign'); ?></th>
                        <th><?php echo _l('rec_time'); ?></th>
                        <th><?php echo _l('interview_day'); ?></th>
                    </thead>
                    <tbody>
                        <?php foreach ($upcoming_interview as $intv) { ?>
                        <tr>
                            <td><?php echo html_entity_decode($intv['is_name']); ?></td>
                            <td><?php $cp = get_rec_campaign_hp($intv['campaign']);
                                $_data = '';
                                if (isset($cp)) {
                                    $_data = $cp->campaign_code . ' - ' . $cp->campaign_name;
                                } else {
                                    $_data = '';
                                }
                                echo html_entity_decode($_data);
                                ?>
                            </td>
                            <td><?php echo html_entity_decode($intv['from_time'] . ' - ' . $intv['to_time']); ?></td>
                            <td><?php echo _d($intv['interview_day']); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>