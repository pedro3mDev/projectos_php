<?php

use function Clue\StreamFilter\fun;

defined('BASEPATH') or exit('No direct script access allowed');

    function limitarPalavra ($texto, $limite = 100) {
        $palavras = explode(' ', $texto);
        if (count($palavras) > $limite) {
            return implode(' ', array_slice($palavras, 0, $limite)) . ' ...';
        }
        return $texto;
    }

    function get_pl_staff_fullname($id){
		$CI           = & get_instance();
		if($id != 0){
			$CI->db->where('staffid',$id);
			$dpm = $CI->db->get(db_prefix().'staff')->row();
			if($dpm->firstname){
				return $dpm->firstname .' '. $dpm->lastname;
			}else{
				return '';
			}
		}else{
			return '';
		}
	}

	function pl_valor_probabilidade_exists($name){
		$CI = & get_instance();
		$i = count($CI->db->query('Select * from '.db_prefix().'pe_probabilidade where valor_probabilidade = '.$name)->result_array());
		if($i == 0){
			return 0;
		}
		if($i > 0){
			return 1;
		}
	}
	function pl_valor_impacto_exists($value){
		$CI = & get_instance();
		$i = count($CI->db->query('Select * from '.db_prefix().'pe_impacto where valor_impacto = '.$value)->result_array());
		if($i == 0){
			return 0;
		}
		if($i > 0){
			return 1;
		}
	}

	function risco_matriz_exists($dados){
		$CI = & get_instance();

		$CI->db->select('
            pe_risco.*,
            staff.firstname, staff.lastname,
            pe_politica.titulo,
            pe_impacto.impacto, pe_impacto.valor_impacto,
            pe_probabilidade.descricao as descricao_p, pe_probabilidade.valor_probabilidade,

			(valor_probabilidade * valor_impacto) as nivel_risco
        ');
        $CI->db->from('pe_risco');
        $CI->db->join('staff', 'staff.staffid = pe_risco.staff_id', 'left');
        $CI->db->join('pe_politica', 'pe_politica.id = pe_risco.politica_id', 'left');
        $CI->db->join('pe_impacto', 'pe_impacto.id = pe_risco.impacto_id', 'left');
        $CI->db->join('pe_probabilidade', 'pe_probabilidade.id = pe_risco.probabilidade_id', 'left');
        $CI->db->where('pe_risco.impacto_id', $dados[0] ?? '');
        $CI->db->where('pe_risco.probabilidade_id', $dados[1] ?? '');

        $query = $CI->db->get()->row_array();
        if (!$query) {
            return '';
        }

        return
			$query['titulo']
				. '<br> ('.limitarPalavra($query['medidas_metigacao'], 7).') <br>'
				. '('.limitarPalavra($query['descricao'], 5).')'
		;
	}
	function estado_matriz_risco ($valor) {
		if ($valor == 1) {
			return 'Muito Baixa';
		}
		elseif ($valor <= 5) {
			return 'Baixa';
		}
		elseif ($valor <= 10) {
			return 'Moderada';
		}
		elseif ($valor <= 15) {
			return 'Alta';
		}
		else {
			return 'Muito Alta';
		}
	}
	function cor_matriz_risco ($valor) {
		if ($valor == 1) {
			return '#D4E157';
		}
		elseif ($valor <= 5) {
			return '#FFEB3B';
		}
		elseif ($valor <= 10) {
			return '#FF9800';
		}
		elseif ($valor <= 15) {
			return '#F44336';
		}
		else {
			return '#B71C1C';
		}
	}
	function cor_risco ($valor) {
		if ($valor == 1) {
			return '#D4E157';
		}
		elseif ($valor == 2) {
			return '#FFEB3B';
		}
		elseif ($valor == 3) {
			return '#FF9800';
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
?>