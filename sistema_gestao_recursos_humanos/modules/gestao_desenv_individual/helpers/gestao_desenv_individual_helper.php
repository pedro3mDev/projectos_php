<?php
defined('BASEPATH') or exit('No direct script access allowed');

function gdi_status_exists($value){
    $CI = & get_instance();
    $i = count($CI->db->query('Select * from '.db_prefix()."gdi_status where status = '{$value}' ")->result_array());
    if($i == 0){
        return 0;
    }
    if($i > 0){
        return 1;
    }
}

