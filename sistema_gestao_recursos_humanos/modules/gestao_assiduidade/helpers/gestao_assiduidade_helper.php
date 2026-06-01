<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * get hr profile option
 * @param  string $name 
 */

	function get_periodo_laboral_by_id($id){
		$CI = &get_instance();
		return $CI->db->query('SELECT * FROM '.db_prefix().'as_periodo_laboral WHERE id = '.$id)->row();
	}
	function organiza_dias_trabalho($dias = ''){
         $d = explode(',',$dias);
		 $rs = '';
		 
		 $array_org['Sunday']     = 'Domingo';
		 $array_org['Monday']     = 'Segunda';
		 $array_org['Tuesday']    = 'Terça';
		 $array_org['Wednesday']  = 'Quarta';
		 $array_org['Thursday']   = 'Quinta';
		 $array_org['Friday']     = 'Sexta';
		 $array_org['Saturday']   = 'Sábado';
		 foreach ( $d as $key => $value) {
			if ($value!='') {
				$rs .= $array_org[$value].', ';
			}
		 }
		 return $rs;
	}

	function get_turnos_by_id($id){
		$CI = &get_instance();
		return $CI->db->query('SELECT * FROM '.db_prefix().'as_turnos WHERE id = '.$id)->row();
	}
	function get_func_by_id($id){
		$CI = &get_instance();
		return $CI->db->query('SELECT * FROM '.db_prefix().'staff WHERE staffid = '.$id)->row();
	}
	function get_dpt_by_id($id){
		$CI = &get_instance();
		return $CI->db->query('SELECT * FROM '.db_prefix().'departments WHERE departmentid = '.$id)->row();
	}
	function get_staff_dpt_by_id($id){
		$CI = &get_instance();
		return $CI->db->query('SELECT * FROM '.db_prefix().'staff_departments WHERE staffid = '.$id)->row();
	}
	function get_conf_gestao_ferias(){
		$CI = &get_instance();
		return $CI->db->query('SELECT * FROM '.db_prefix().'as_conf_ferias ')->row();
	}

	function formatarData($data) {
		$meses = array(
			'jan' => 'janeiro',
			'fev' => 'fevereiro',
			'mar' => 'março',
			'abr' => 'abril',
			'mai' => 'maio',
			'jun' => 'junho',
			'jul' => 'julho',
			'ago' => 'agosto',
			'set' => 'setembro',
			'out' => 'outubro',
			'nov' => 'novembro',
			'dez' => 'dezembro'
		);
	
		$data_formatada = date_create_from_format('Y-m-d', $data)->format('d \d\e M \d\e Y');
		
		// Substituir o mês pelo seu nome completo
		foreach ($meses as $abreviacao => $nome) {
			$data_formatada = str_replace($abreviacao, $nome, $data_formatada);
		}
	
		return $data_formatada;
	}
	function get_dias_restantes_geral ($id_func){
		$CI = &get_instance();
		$CI->db->where('func_id',$id_func);
		$CI->db->where('estado', 'E');
		$CI->db->where('ano_fiscal', date('Y'));
		$result_principal = $CI->db->get(db_prefix() . 'as_ferias')->result_array();
	
		$total_dias = 0;
		foreach ($result_principal as $key => $value) {
			$total_dias      += $value['dias_usados'];
		}
		return $total_dias;
	}	
	function update_dias_restantes_geral (){ // atualiza todos os dias usados
		$CI = &get_instance();
		$result_principal = $CI->db->get(db_prefix() . 'as_ferias')->result_array();
	
		$total_dias = 0;
		foreach ($result_principal as $key => $value) {
			$total_dias      += $value['dias_usados'];
		}
		return $total_dias;
	}
	function send_email_assiduidade($to='',$subject='',$message=''){
		$CI = &get_instance();
		$CI->load->library('email');
	    $config = array(
				'protocol' => 'smtp',
				'smtp_host' => 'mail.petabytelda.com',
				'smtp_port' => '587',
				'smtp_user' => 'webmaster@petabytelda.com',
				'smtp_pass' => 'Master.2040', 
				'smtp_crypto' => 'tls', // ou ssl se necessário
				'charset' => 'utf-8',
				'mailtype' => 'html',
				'newline' => "\r\n"
		);

		$CI->email->initialize($config);
		$CI->email->from('webmaster@petabytelda.com', 'CSC Angola');
		$CI->email->to($to);
		$CI->email->subject($subject);
		$CI->email->message($message);

			if ($CI->email->send()) {
				echo 'E-mail enviado com sucesso.';
			} else {
				echo 'Erro ao enviar o e-mail: ' . $CI->email->print_debugger();
			}
	}


	function atualizar_assiduidade (){ // atualiza todos valores
	
		$CI = &get_instance();
		//ATUALIZAR DIAS
		$CI->db->where('estado','E');
		$result_principal_1 = $CI->db->get(db_prefix() . 'as_ferias')->result_array();
		foreach ($result_principal_1 as $key => $value) {
		   $dif  =   diferencaDias(date('Y-m-d'),$value['data_inicio']);
		   $CI->db->where('id',$value['id']);
		   $CI->db->update(db_prefix() . 'as_ferias',['dias_usados'=>$dif]);
		}


		// VARREDURA PARA REQ EXPIRADAS
		$CI->db->where('ate <= ',date('Y-m-d'));
		$result_principal = $CI->db->get(db_prefix() . 'as_ferias')->result_array();
		foreach ($result_principal as $key => $value) {
			if ($value['estado'] == 'P' || $value['estado'] == 'E' || $value['estado'] == 'A') {
				$CI->db->where('id',$value['id']);
				$CI->db->update(db_prefix() . 'as_ferias',['estado'=>'F']);
			}
		}
	}

	function diferencaDias($data1, $data2) {
		$data1 = new DateTime($data1);
		$data2 = new DateTime($data2);
		
		$intervalo = $data1->diff($data2);
		
		return $intervalo->days;
	}

	function atualiza_dias_marcacoes(){
		$CI     = &get_instance();
		$staff  = $CI->db->query('SELECT * FROM '.db_prefix().'staff')->result_array();
		$array_dias               = listarDiasMes(date('Y'),date('m')); 
		$id_dpt = '0';
       

		
		foreach ($staff as $key => $staff_item) {
			$id_dpt = '0';
			$department = get_staff_dpt_by_id($staff_item['staffid']);
			if(isset($department)) {
				$id_dpt = $department->departmentid;
			}
			foreach ($array_dias as $key => $value) {
				try {
					$CI->db->where('fun_id', $staff_item['staffid']);
					$CI->db->where('data',    $value);
					$rs = $CI->db->get(db_prefix() . 'as_marcacoes')->result_array();
					if (count($rs)<=0) {
						 $CI->db->insert(db_prefix() . 'as_marcacoes', [
							'data'  => $value,
							'fun_id'=> $staff_item['staffid'],
							'dep_id'=> $id_dpt,
						 ]);
					}
				} catch (\Throwable $th) {
				} 
		   }
		}
		
  }

 function listarDiasMes($ano, $mes) {
	$diasNoMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
	$dias = [];
	for ($dia = 1; $dia <= $diasNoMes; $dia++) {
		$data = sprintf("%04d-%02d-%02d", $ano, $mes, $dia);
		$dias[] = $data;
	}
	return $dias;
}

	
