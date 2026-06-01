<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Exemplo de função no helper.
 */
/* function exemplo_gestao_remuneracao_helper()
{
    return "Esta é uma função de exemplo no helper.";
}  */

function gr_status_exists($value){
    $CI = & get_instance();
    $i = count($CI->db->query('Select * from '.db_prefix()."gr_status where status = '{$value}' ")->result_array());
    if($i == 0){
        return 0;
    }
    if($i > 0){
        return 1;
    }
}
