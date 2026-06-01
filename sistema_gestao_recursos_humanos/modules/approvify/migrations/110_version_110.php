<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_110 extends App_module_migration
{
    public function up()
    {
        $CI = &get_instance();

        $CI->db->query('ALTER TABLE `' . db_prefix() . 'approvify_request_activity` ADD `request_message` TEXT AFTER `description`;');

    }
}