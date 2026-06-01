<?php
defined('BASEPATH') or exit('No direct script access allowed');

function gf_status_exists($value){
    $CI = & get_instance();
    $i = count($CI->db->query('Select * from '.db_prefix()."gf_status where status = '{$value}' ")->result_array());
    if($i == 0){
        return 0;
    }
    if($i > 0){
        return 1;
    }
}

function gf_nivel_risco_exists($value){
    $CI = & get_instance();
    $i = count($CI->db->query('Select * from '.db_prefix()."gf_nivel_risco where nome = '{$value}' ")->result_array());
    if($i == 0){
        return 0;
    }
    if($i > 0){
        return 1;
    }

}
function gf_vagas_dosponiveis($vaga, $total_vaga)
{
    $CI = & get_instance();
    $CI->db->where('status_id', 2);
    $CI->db->where('vaga_id', $vaga);
    $query = $CI->db->get('gf_inscricao')->num_rows();

    $total = $total_vaga - $query;
    if ($total >= 0) {
        return $total;
    }
    return 0;
}