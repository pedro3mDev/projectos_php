<?php
defined('BASEPATH') or exit('No direct script access allowed');

function psl_status_exists($value){
    $CI = & get_instance();
    $i = count($CI->db->query('Select * from '.db_prefix()."psl_status where status = '{$value}' ")->result_array());
    if($i == 0){
        return 0;
    }
    if($i > 0){
        return 1;
    }
}
function psl_desempenho_exists($value){
    $CI = & get_instance();
    $i = count($CI->db->query('Select * from '.db_prefix()."psl_desempenho where nome = '{$value}' ")->result_array());
    if($i == 0){
        return 0;
    }
    if($i > 0){
        return 1;
    }
}
function psl_potencial_exists($value){
    $CI = & get_instance();
    $i = count($CI->db->query('Select * from '.db_prefix()."psl_potencial where nome = '{$value}' ")->result_array());
    if($i == 0){
        return 0;
    }
    if($i > 0){
        return 1;
    }
}
function psl_nivel_critico_exists($value){
    $CI = & get_instance();
    $i = count($CI->db->query('Select * from '.db_prefix()."psl_nivel_critico where nome = '{$value}' ")->result_array());
    if($i == 0){
        return 0;
    }
    if($i > 0){
        return 1;
    }
}
function psl_competencias_talentos($talento){
    $CI = & get_instance();
    $CI->db->select('
        psl_talento_competencia.*,
        psl_competencia.nome
    ');
    $CI->db->from('psl_talento_competencia');
    $CI->db->join('psl_competencia', 'psl_competencia.id = psl_talento_competencia.competencia_id', 'left');
    $CI->db->where('psl_talento_competencia.talento_id', $talento);
    $query = $CI->db->get()->result_array();

    $competencias = '';
    foreach($query as $i) {
        $competencias .= '<span style="background-color: #ccc; color:#000; padding: 5px; border-radius:10px; margin:2px;">'.$i['nome'].'</span>';
    }

    return $competencias;
}
function psl_competencias_talentos_array($talento){
    $CI = & get_instance();
    $CI->db->select('
        psl_talento_competencia.*,
        psl_competencia.nome
    ');
    $CI->db->from('psl_talento_competencia');
    $CI->db->join('psl_competencia', 'psl_competencia.id = psl_talento_competencia.competencia_id', 'left');
    $CI->db->where('psl_talento_competencia.talento_id', $talento);
    $query = $CI->db->get()->result_array();

    $competencias = '[';
    foreach($query as $i) {
        // $competencias .= '"'.$i['competencia_id'].'",';
        if ($i === end($query)) {
            $competencias .= '"' .$i['competencia_id']. '"';
        }
        else {
            $competencias .= '"' .$i['competencia_id']. '",';
        }
    }
    $competencias .= ']';
    return $competencias;
}

function psl_feedback_exists($value){
    $CI = & get_instance();
    $i = count($CI->db->query('Select * from '.db_prefix()."psl_feedback where nome = '{$value}' ")->result_array());
    if($i == 0){
        return 0;
    }
    if($i > 0){
        return 1;
    }
}

function psl_impacto_exists($value){
    $CI = & get_instance();
    $i = count($CI->db->query('Select * from '.db_prefix()."psl_impacto where nome = '{$value}' ")->result_array());
    if($i == 0){
        return 0;
    }
    if($i > 0){
        return 1;
    }
}
function psl_nivel_risco_exists($value){
    $CI = & get_instance();
    $i = count($CI->db->query('Select * from '.db_prefix()."psl_nivel_risco where nome = '{$value}' ")->result_array());
    if($i == 0){
        return 0;
    }
    if($i > 0){
        return 1;
    }
}

function psl_contar_engajamento($id){
    $CI = & get_instance();
    $CI->db->where('estrategia_engajamento_id', $id);
    $query = $CI->db->get('psl_programa_retencao')->num_rows();
    return $query;
}

function psl_estado_matriz_risco ($valor) {
    if ($valor == 1) {
        return 'Baixa';
    }
    elseif ($valor <= 3) {
        return 'Moderada';
    }
    elseif ($valor <= 4) {
        return 'Alta';
    }
    else {
        return 'Muito Alta';
    }
}
function psl_cor_matriz_risco ($valor) {
    if ($valor == 1) {
        return '#D4E157';
    }
    elseif ($valor <= 3) {
        return '#FF9800';
    }
    elseif ($valor <= 4) {
        return '#F44336';
    }
    else {
        return '#B71C1C';
    }
}
function psl_cor_risco ($valor) {
    if ($valor == 1) {
        return '#D4E157';
    }
    elseif ($valor == 2) {
        return '#FF9800';
    }
    elseif ($valor == 3) {
        return '#B71C1C';
    }
    elseif ($valor == 4) {
        return '#F44336';
    }
    elseif ($valor == 5) {
        return '#B71C1C';
    }
    else {
        return '';
    }
}
function psl_risco_matriz_exists($dados){
    $CI = & get_instance();

    $CI->db->select('
        psl_risco_sucessao.*,
        hr_job_position.position_name as cargo,
        psl_nivel_risco.nome as nivel_risco,
        psl_impacto.nome as impacto
    ');
    $CI->db->from('psl_risco_sucessao');
    $CI->db->join('hr_job_position', 'hr_job_position.position_id  = psl_risco_sucessao.cargo_id', 'left');
    $CI->db->join('psl_nivel_risco', 'psl_nivel_risco.id = psl_risco_sucessao.nivel_risco_id', 'left');
    $CI->db->join('psl_impacto', 'psl_impacto.id = psl_risco_sucessao.impacto_id', 'left');
    $CI->db->where('psl_risco_sucessao.nivel_risco_id', $dados[0] ?? '');
    $CI->db->where('psl_risco_sucessao.impacto_id', $dados[1] ?? '');

    $query = $CI->db->get()->row_array();
    if (!$query) {
        return '';
    }

    return '<br>'.
        $query['plano_contingencia']
            . '<br>'
            . '('.limitarPalavra($query['cargo'], 5).')'
    ;
}