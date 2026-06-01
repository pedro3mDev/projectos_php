<?php
defined('BASEPATH') or exit('No direct script access allowed');

function gets_status_exists($value){
    $CI = & get_instance();
    $i = count($CI->db->query('Select * from '.db_prefix()."gets_status where status = '{$value}' ")->result_array());
    if($i == 0){
        return 0;
    }
    if($i > 0){
        return 1;
    }
}

function gets_pesquisa_engajemento($id){
    $CI = & get_instance();

    $CI->db->select('
        gets_pesquisa_engajamento.*,
        gets_status.status,
    ');
    $CI->db->from('gets_pesquisa_engajamento');
    $CI->db->join('gets_status', 'gets_status.id  = gets_pesquisa_engajamento.status_id', 'left');
    $CI->db->where('gets_pesquisa_engajamento.id', $id);
    $query = $CI->db->get()->row_array();

    return $query;
}