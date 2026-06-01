<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Exemplo de função no helper.
 *//* 
function exemplo_plan_forca_trabalho_helper()
{
    return "Esta é uma função de exemplo no helper.";
} */
function pft_status_exists($value){
    $CI = & get_instance();
    $i = count($CI->db->query('Select * from '.db_prefix()."pft_status where status = '{$value}' ")->result_array());
    if($i == 0){
        return 0;
    }
    if($i > 0){
        return 1;
    }
}

