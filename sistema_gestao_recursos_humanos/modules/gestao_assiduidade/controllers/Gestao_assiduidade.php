<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Recruitment Controller
 */
class gestao_assiduidade extends AdminController {

	public function __construct() {
		parent::__construct();
		$this->load->model('gestao_assiduidade_model');
		$this->gestao_assiduidade_model->get_conf_ferias();
		atualizar_assiduidade ();
		atualiza_dias_marcacoes();
	}

	public function index() {
		$data['title'] = _l('Registros de Assiduidade');
		$data['opt_departments'] = $this->gestao_assiduidade_model->get_departments();
		$data['opt_meses']       = array("Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
		$this->load->view('registros_de_assiduidade/registros_de_assiduidade', $data); 
	}

	public function dashboard() {
		$data['title'] = _l('Painel'); 
		$data['opt_departments'] = $this->gestao_assiduidade_model->get_departments();
		$data['cards'] = $this->gestao_assiduidade_model->get_cards();
		//var_dump($data['cards']);die;
	    $this->load->view('dashboard', $data);
	}

	public function gestao_de_ferias_geral() {
		if (!has_permission('recruitment', '', 'edit') && !is_admin()) {
			access_denied('recruitment');
		}
		$data['group'] = $this->input->get('group');
		$data['title'] = _l('Gestão de férias');
		$data['tab'][] = 'solicitar_ferias';
		$data['tab'][] = 'funcionarios_em_ferias';
		if ($data['group'] == '') {
			$data['group'] = 'solicitar_ferias'; 
			$data['opt_departments'] = $this->gestao_assiduidade_model->get_departments();
			$data['tabela']    = $this->tbl_gestao_ferias($this->gestao_assiduidade_model->get_gestao_ferias($this->input->get()));
			$data['opt_func']  = $this->gestao_assiduidade_model->get_staff('', ['active' => 1]);
			$data['filtros']   = $this->input->get();
		}elseif ($data['group'] == 'funcionarios_em_ferias') {
			$data['filtros']   = $this->input->get();
		    $data['estado']    = 'E';		
			$data['title'] = _l('Funcionários em Férias');
			$data['opt_departments'] = $this->gestao_assiduidade_model->get_departments();
			$data['tabela']    = $this->tbl_gestao_ferias_funcionarios($this->gestao_assiduidade_model->get_gestao_ferias_funcionarios($data));
			$data['opt_func']  = $this->gestao_assiduidade_model->get_staff('', ['active' => 1]); 
		}elseif ($data['group'] == 'solicitar_ferias') { 
			$data['title'] = _l('Gestão de Férias');
			$data['opt_departments'] = $this->gestao_assiduidade_model->get_departments();
			$data['tabela']    = $this->tbl_gestao_ferias($this->gestao_assiduidade_model->get_gestao_ferias($this->input->get()));
			$data['opt_func']  = $this->gestao_assiduidade_model->get_staff('', ['active' => 1]);
			$data['filtros']   = $this->input->get();
		}
		$data['tabs']['view'] = 'gestao_de_ferias/' . $data['group'];
		$this->load->view('manage_ferias', $data);

	}

	public function gestao_de_ferias() {
		$data['title'] = _l('Gestão de Férias');
		$data['opt_departments'] = $this->gestao_assiduidade_model->get_departments();
		$data['tabela']    = $this->tbl_gestao_ferias($this->gestao_assiduidade_model->get_gestao_ferias($this->input->get()));
		$data['opt_func']  = $this->gestao_assiduidade_model->get_staff('', ['active' => 1]);		
		$data['filtros']   = $this->input->get();
		$this->load->view('gestao_de_ferias/gestao_de_ferias', $data); 
	}

	public function gestao_de_ferias_funcionarios() {
		
		$data['filtros']   = $this->input->get();

		$data['estado']    = 'E';
		
		$data['title'] = _l('Funcionários em Férias');
		$data['opt_departments'] = $this->gestao_assiduidade_model->get_departments();
		$data['tabela']    = $this->tbl_gestao_ferias_funcionarios($this->gestao_assiduidade_model->get_gestao_ferias_funcionarios($data));
		$data['opt_func']  = $this->gestao_assiduidade_model->get_staff('', ['active' => 1]); 
		
		
		$this->load->view('gestao_de_ferias/funcionarios_ferias', $data); 
	}
	
	public function horario_turno() {
		if (!has_permission('recruitment', '', 'edit') && !is_admin()) {
			access_denied('recruitment');
		}
		$data['group'] = $this->input->get('group');
		$data['title'] = _l('Horários e Turnos');
		//$data['tab'][] = 'gestao_turnos';
		$data['tab'][] = 'atribuir_turnos_periodo_dpt'; 
		$data['tab'][] = 'criacao_turnos';


		if ($data['group'] == '') {
			$data['group'] = 'atribuir_turnos_periodo_dpt';
			$data['tabela'] = $this->gestao_assiduidade_model->get_departments();
		}elseif ($data['group'] == 'gestao_turnos') {
			$data['tabela'] = $this->gestao_assiduidade_model->get_periodos();
		}elseif ($data['group'] == 'atribuir_turnos_periodo') {
			$data['tabela'] = $this->gestao_assiduidade_model->get_staff('', ['active' => 1]);
		}elseif ($data['group'] == 'atribuir_turnos_periodo_dpt') {
			$pag = $this->input->get('pag');
			if (isset($pag) && $pag ==  'atribuir_turnos_periodo') {// se clicar no departamento
				$num = $this->input->get('num');
				$data['group'] = $pag;
				$data['num']   = $num;
				$data['tabela']     = $this->gestao_assiduidade_model->get_staff_by_department( $num);
				$data['opt_turnos'] = $this->gestao_assiduidade_model->get_horario_turno();
				$data['department'] = $this->gestao_assiduidade_model->get_departments_by_id($num); 


				$data['tabs']['view'] = 'horario_turno/' . $data['group'];
		        $this->load->view('manage_turnos', $data);
				return true;
			}
			$data['tabela'] = $this->gestao_assiduidade_model->get_departments();
		}elseif ($data['group'] == 'criacao_turnos') {
			$data['tabela'] = $this->gestao_assiduidade_model->get_horario_turno();
			$data['opt_periodos'] = $this->gestao_assiduidade_model->get_periodos();
			
		}
		$data['tabs']['view'] = 'horario_turno/' . $data['group'];
		$this->load->view('manage_turnos', $data);
	}
	public function relatorios() {

		if (!has_permission('recruitment', '', 'edit') && !is_admin()) {
			access_denied('recruitment');
		}
		$data['group'] = $this->input->get('group');
		$data['title'] = _l('Estatistícas');
		$data['tab'][] = 'minha_assiduidade';
		$data['tab'][] = 'assiduidade_por_departamento';
		$data['tab'][] = 'assiduidade_diaria';


		if ($data['group'] == '') {
			$data['group'] = 'minha_assiduidade';
			$data['opt_staff']  = $this->gestao_assiduidade_model->get_staff('', ['active' => 1]);
			$data['tabela']           = $this->get_assiduidade_dpt_ajax($this->input->get());
		}elseif ($data['group'] == 'minha_assiduidade') {
			$data['opt_staff']        = $this->gestao_assiduidade_model->get_staff('', ['active' => 1]);
			$data['tabela']           = $this->get_assiduidade_dpt_ajax($this->input->get());

		}elseif ($data['group'] == 'assiduidade_por_departamento') { 

			$data['tabela']           = $this->get_assiduidade_dpt_ajax($this->input->get());
			$data['opt_departments']  = $this->gestao_assiduidade_model->get_departments();
			$data['filtros']          = $this->input->get();
			

		}elseif ($data['group'] == 'assiduidade_diaria') {
			$data['opt_departments']  = $this->gestao_assiduidade_model->get_departments();
			$data['tabela']           = $this->get_assiduidade_diaria_ajax();
		}
		$data['tabs']['view'] = 'relatorios/' . $data['group'];
		$this->load->view('manage_relatorio', $data);

	}
	public function configuracoes() {

		if (!has_permission('recruitment', '', 'edit') && !is_admin()) {
			access_denied('recruitment');
		}
		$data['group'] = $this->input->get('group');
		$data['title'] = _l('Configurações');
		$data['tab'][] = 'periodo_laboral';
		$data['tab'][] = 'feriados';
		$data['tab'][] = 'biometricos';
		$data['tab'][] = 'conf_ferias'; 
		$data['tab'][] = 'geral';

		if ($data['group'] == '') {
			$data['group'] = 'periodo_laboral';
			$data['tabela'] = $this->gestao_assiduidade_model->get_periodos();
		}elseif ($data['group'] == 'periodo_laboral') {
			$data['tabela'] = $this->gestao_assiduidade_model->get_periodos();
		}elseif ($data['group'] == 'feriados') {
			$data['tabela'] = $this->gestao_assiduidade_model->get_feriados();
		}elseif ($data['group'] == 'biometricos') {
			$data['tabela'] = $this->gestao_assiduidade_model->get_biometricos();
		}elseif ($data['group'] == 'conf_ferias') {
			$data['dados'] = $this->gestao_assiduidade_model->get_conf_ferias()[0];
		}
		elseif ($data['group'] == 'geral') {
			$data['tabela'] = $this->gestao_assiduidade_model->get_biometricos();
		}
		$data['tabs']['view'] = 'configuracoes/' . $data['group'];
		$this->load->view('manage_setting', $data);
	}

	//PERIODO LABORAL
	public function add_periodos() { 
		$data["nome"]          = $this->input->post("nome");
        $data["data_inicial"]  = $this->input->post("data_inicial");
        $data["data_final"]    = $this->input->post("data_final");
        $data["intervalo"]     = $this->input->post("intervalo");
		$id = $this->gestao_assiduidade_model->add_periodos($data);
		if ($id) {
			$success = true;
			$message = _l('Adicionado com sucesso');
			set_alert('success', $message);
		}else {
			$message =  _l('Falha ao adicionar');
			set_alert('warning',$message);
		}
		redirect(admin_url('gestao_assiduidade/configuracoes?group=periodo_laboral'));
	}
	public function edit_periodos() { 
		$id                    = $this->input->post("id");
		$data["nome"]          = $this->input->post("nome");
        $data["data_inicial"]  = $this->input->post("data_inicial");
        $data["data_final"]    = $this->input->post("data_final");
        $data["intervalo"]     = $this->input->post("intervalo");
		$id = $this->gestao_assiduidade_model->edit_periodos($id,$data);
		if ($id) {
			$success = true;
			$message = _l('Alterado com sucesso');
			set_alert('success', $message);
		}else {
			$message =  _l('Falha ao alterar');
			set_alert('warning',$message);
		}
		redirect(admin_url('gestao_assiduidade/configuracoes?group=periodo_laboral'));
	}
	public function delete_periodos($id='') { 
		$id = $this->gestao_assiduidade_model->delete_periodos($id);
		if ($id) {
			$success = true;
			$message = _l('Eliminado com sucesso');
			set_alert('success', $message);
		}else {
			$message =  _l('Falha ao eliminar');
			set_alert('warning',$message);
		}
		redirect(admin_url('gestao_assiduidade/configuracoes?group=periodo_laboral'));
	}
	//END PERIIODO LABORAL

	//FERIADOS
	public function add_feriados() { 
		$data["nome"]          = $this->input->post("nome");
        $data["data_inicial"]  = $this->input->post("data_inicial");
        $data["data_final"]    = $this->input->post("data_final");
		$id = $this->gestao_assiduidade_model->add_feriados($data);
		if ($id) {
			$success = true;
			$message = _l('Adicionado com sucesso');
			set_alert('success', $message);
		}else {
			$message =  _l('Falha ao adicionar');
			set_alert('warning',$message);
		}
		redirect(admin_url('gestao_assiduidade/configuracoes?group=feriados'));
	}
	public function edit_feriados() { 
		$id                    = $this->input->post("id");
		$data["nome"]          = $this->input->post("nome");
        $data["data_inicial"]  = $this->input->post("data_inicial");
        $data["data_final"]    = $this->input->post("data_final");
		$id = $this->gestao_assiduidade_model->edit_feriados($id,$data);
		if ($id) {
			$success = true;
			$message = _l('Alterado com sucesso');
			set_alert('success', $message);
		}else {
			$message =  _l('Falha ao alterar');
			set_alert('warning',$message);
		}
		redirect(admin_url('gestao_assiduidade/configuracoes?group=feriados'));
	}
	public function delete_feriados($id='') { 
		$id = $this->gestao_assiduidade_model->delete_feriados($id);
		if ($id) {
			$success = true;
			$message = _l('Eliminado com sucesso');
			set_alert('success', $message);
		}else {
			$message =  _l('Falha ao eliminar');
			set_alert('warning',$message);
		}
		redirect(admin_url('gestao_assiduidade/configuracoes?group=feriados'));
	}
	//END FERIADOS

	//BIOMETRICOS
	public function add_biometricos() { 
		$data["nome"]          = $this->input->post("nome");
        $data["codigo"]        = $this->input->post("codigo");
        $data["ip"]            = $this->input->post("ip");
		$data["porta"]         = $this->input->post("porta");
		$data["local"]         = $this->input->post("local");
		$id = $this->gestao_assiduidade_model->add_biometricos($data);
		if ($id) {
			$success = true;
			$message = _l('Adicionado com sucesso');
			set_alert('success', $message);
		}else {
			$message =  _l('Falha ao adicionar');
			set_alert('warning',$message);
		}
		redirect(admin_url('gestao_assiduidade/configuracoes?group=biometricos'));
	}
	public function edit_biometricos() { 
		$id                    = $this->input->post("id");
		$data["nome"]          = $this->input->post("nome");
        $data["codigo"]        = $this->input->post("codigo");
        $data["ip"]            = $this->input->post("ip");
		$data["porta"]         = $this->input->post("porta");
		$data["local"]         = $this->input->post("local");
		$id = $this->gestao_assiduidade_model->edit_biometricos($id,$data);
		if ($id) {
			$success = true;
			$message = _l('Alterado com sucesso');
			set_alert('success', $message);
		}else {
			$message =  _l('Falha ao alterar');
			set_alert('warning',$message);
		}
		redirect(admin_url('gestao_assiduidade/configuracoes?group=biometricos'));
	}
	public function delete_biometricos($id='') { 
		$id = $this->gestao_assiduidade_model->delete_biometricos($id);
		if ($id) {
			$success = true;
			$message = _l('Eliminado com sucesso');
			set_alert('success', $message);
		}else {
			$message =  _l('Falha ao eliminar');
			set_alert('warning',$message);
		}
		redirect(admin_url('gestao_assiduidade/configuracoes?group=biometricos'));
	}
	//END BIOMETRICOS

		//TURNOS
		public function add_horario_turno() { 


			
			$dias_trabalho = '';
			$verf = $this->input->post("dias_trabalho");
			if (!isset($verf)) {
				set_alert('warning','Preencha os dias de trabalho.');
				return redirect(admin_url('gestao_assiduidade/horario_turno?group=criacao_turnos'));
			}
			$total_dias = count($this->input->post("dias_trabalho"));
			$j = 0;
			foreach ($this->input->post("dias_trabalho") as $key => $value) {

				if ($total_dias == 1) {
					$dias_trabalho .= $value.',';
				}elseif ($j == $total_dias-1) {
					$dias_trabalho .= $value;
				}else {
					$dias_trabalho .= $value.',';
				}
				$j ++;
			}

			$data["nome"]             = $this->input->post("nome");
			$data["periodo_id"]       = $this->input->post("periodo_id");
			$data["dias_trabalho"]    = $dias_trabalho;
			$data["freq_id"]          = $this->input->post("freq_id");
		
			$id = $this->gestao_assiduidade_model->add_horario_turno($data);
			if ($id) {
				$success = true;
				$message = _l('Adicionado com sucesso');
				set_alert('success', $message);
			}else {
				$message =  _l('Falha ao adicionar');
				set_alert('warning',$message);
			}
			redirect(admin_url('gestao_assiduidade/horario_turno?group=criacao_turnos'));
		}
		public function edit_horario_turno() { 
			$dias_trabalho = '';
			$total_dias = count($this->input->post("dias_trabalho"));
			if (count($this->input->post("dias_trabalho"))<=0) {
				set_alert('warning','Preencha os dias de trabalho.');
				return redirect(admin_url('gestao_assiduidade/horario_turno?group=criacao_turnos'));
			}
			$j = 0;
			foreach ($this->input->post("dias_trabalho") as $key => $value) {

				if ($total_dias == 1) {
					$dias_trabalho .= $value.',';
				}elseif ($j == $total_dias-1) {
					$dias_trabalho .= $value;
				}else {
					$dias_trabalho .= $value.',';
				}
				$j ++;
			}

			$id                       = $this->input->post("id");
			$data["nome"]             = $this->input->post("nome");
			$data["periodo_id"]       = $this->input->post("periodo_id");
			$data["dias_trabalho"]    = $dias_trabalho;
			$data["freq_id"]          = $this->input->post("freq_id");
            
			$id = $this->gestao_assiduidade_model->edit_horario_turno($id,$data);
			if ($id) {
				$success = true;
				$message = _l('Alterado com sucesso');
				set_alert('success', $message);
			}else {
				$message =  _l('Falha ao alterar');
				set_alert('warning',$message);
			}
			redirect(admin_url('gestao_assiduidade/horario_turno?group=criacao_turnos'));
		}
		public function delete_horario_turno($id='') { 
			$id = $this->gestao_assiduidade_model->delete_horario_turno($id);
			if ($id) {
				$success = true;
				$message = _l('Eliminado com sucesso');
				set_alert('success', $message);
			}else {
				$message =  _l('Falha ao eliminar');
				set_alert('warning',$message);
			}
			redirect(admin_url('gestao_assiduidade/horario_turno?group=criacao_turnos'));
		}
		//END TURNOS

		public function atr_horario_turno($id='') { 
			$ids           = $this->input->post('ids');
			$departmentid  = $this->input->post('departmentid');
			$turnos_id     = $this->input->post('turnos_id');
			$staffs        = $this->gestao_assiduidade_model->get_staff_by_department( $departmentid );
			
			$verf_id = [];
			if (isset($ids)) {
				foreach ($ids  as  $value) {
					$verf_id[$value] =  $value;
				}
			}else {
				set_alert('danger', "Marca pelo menos um funcionário");
			    return redirect(admin_url('gestao_assiduidade/horario_turno?group=atribuir_turnos_periodo_dpt&pag=atribuir_turnos_periodo&num='.$departmentid));
			}
            foreach ($staffs as $key => $value) {
				if (isset($verf_id[$value['staffid']])) {
					$ret = $this->gestao_assiduidade_model->atr_horario_turno($value['staffid'],['turnos_id'=>$turnos_id]);
				} 
			}
			set_alert('success', "Concluído sucesso");
			redirect(admin_url('gestao_assiduidade/horario_turno?group=atribuir_turnos_periodo_dpt&pag=atribuir_turnos_periodo&num='.$departmentid));
		}

		public function get_func_by_dpt_ajax() { 
			$id        = $this->input->get('id');
			$array     = $this->gestao_assiduidade_model->get_staff_by_department( $id );
			echo json_encode( $array );
		}
		public function get_marcacoes_ajax() { 
			$data['departmentid']     = $this->input->get('departmentid');
			$data['funcionarios_id']  = $this->input->get('funcionarios_id');
			$data['meses_id']         = $this->input->get('meses_id');
			$meses_id				  = $this->input->get('meses_id');
			$ano                      = date('Y');
			$array_dias               = $this->listarDiasMes($ano,$this->organizaMes($meses_id));

			$this->gestao_assiduidade_model->add_marcacoes($array_dias,$data );
			echo $this->form_maracacoes($array_dias,$data);
		}
        public function add_marcacoes_id_out_ajax(){
			$id        = $this->input->get('id');
			$entrada   = $this->input->get('entrada');
			$saida     = $this->input->get('saida');
			
			$data['marc_id']  = $id;
			$data['marc_in']  = $entrada;
			$data['marc_out'] = $saida;
			$this->gestao_assiduidade_model->add_marcacoes_in_out($data);
			echo  json_encode($this->gestao_assiduidade_model->get_marcacoes_in_out($id));
		}
		public function rem_marcacoes_id_out_ajax(){
			$id             = $this->input->get('id');
			$id_mark        = $this->input->get('id_mark');
			$this->gestao_assiduidade_model->rem_marcacoes_in_out($id,$id_mark);
			echo json_encode($this->gestao_assiduidade_model->get_marcacoes_in_out($id_mark ));
		}
		public function get_marcacoes_id_out_ajax(){
			$id        = $this->input->get('id');
			echo json_encode($this->gestao_assiduidade_model->get_marcacoes_in_out($id));
		}
		public function get_minha_assiduidade_ajax(){
			$funcionarios_id    = $this->input->get('funcionarios_id');
			$de                 = date('Y-m-d', strtotime( $this->input->get('de')));
			$ate                = date('Y-m-d', strtotime( $this->input->get('ate')));
			$data    = $this->gestao_assiduidade_model->get_minha_assiduidade($funcionarios_id,$de,$ate);
			$staff   =$this->gestao_assiduidade_model->get_staff($funcionarios_id);
			$turno   = $this->gestao_assiduidade_model->get_horario_turno_by_id($staff->turnos_id);
			
			$result = [];
			if (isset($turno)) {
			$periodo = $this->gestao_assiduidade_model->get_periodos_by_id($turno->periodo_id);
		    $periodo_entrada   =$periodo->data_inicial;
			$periodo_saida     =$periodo->data_final;
			
			$i = 0;
			foreach ($data as $key => $value) { 
				$dia_semana       = $this->diaDaSemana($value['data'],$turno->dias_trabalho);
				if ($dia_semana == true) {
						$marc_in_out = $this->gestao_assiduidade_model->get_marcacoes_in_out($value['id']);
						$entrada     = '00:00:00';
						$saida       = '00:00:00';
						if (count($marc_in_out)>0) {
							$num_marc_in_out = count($marc_in_out) - 1;
							$entrada     = $marc_in_out[0]['marc_in'];
							$saida       = $marc_in_out[$num_marc_in_out]['marc_out'];
						} 
						
						$result[$i]['nome']                  = $staff->firstname.' '.$staff->lastname;
						$result[$i]['data']                  = $value['data'];
						$result[$i]['entrada']               = $entrada;
						$result[$i]['saida']                 = $saida;
						$result[$i]['total_trabaladas']      = $value['horas_trabalhadas'];
						$result[$i]['horas_extras']          = $value['horas_extras'];
						

						if ($value['horas_trabalhadas'] <= 0 ) { //falta
							$result[$i]['falta']     = '8.00';
							$result[$i]['atraso']    = '0.00';
							$result[$i]['abandono']  = '0.00';
							$result[$i]['estado']    = 'falta';      
						}elseif($periodo_entrada < $entrada && $periodo_saida > $saida){ // atraso e abandono
							$dif_traso = $this->gestao_assiduidade_model->resolveHora($entrada,$periodo_entrada);
							$dif_traso_rs =  $dif_traso['hora_decimal'];
							if ($dif_traso_rs<0) {
								$dif_traso_rs = $dif_traso_rs * -1;
							}

							$dif_abandono = $this->gestao_assiduidade_model->resolveHora($periodo_saida,$saida);
							$dif_abandono_rs =  $dif_abandono['hora_decimal'];
							if ($dif_abandono_rs<0) {
								$dif_abandono_rs = $dif_abandono_rs * -1;
							}

							$result[$i]['falta']                 = '0.00';
							$result[$i]['atraso']                = number_format($dif_traso_rs,2);
							$result[$i]['abandono']              = number_format($dif_abandono_rs,2);
							$result[$i]['estado']                = 'atraso_abandono';
						}elseif($periodo_entrada < $entrada){ // atraso
							$dif = $this->gestao_assiduidade_model->resolveHora($entrada,$periodo_entrada);
							if ($dif['hora_decimal']<0) {
								$dif['hora_decimal'] = $dif['hora_decimal'] * -1;
							}
							$result[$i]['falta']                 = '0.00';
							$result[$i]['atraso']                = number_format($dif['hora_decimal'],2);
							$result[$i]['abandono']              = '0.00';
							$result[$i]['estado']                = 'atraso';
						}elseif($periodo_saida > $saida){ // abandon
							$dif = $this->gestao_assiduidade_model->resolveHora($periodo_saida,$saida);
							if ($dif['hora_decimal']<0) {
								$dif['hora_decimal'] = $dif['hora_decimal'] * -1;
							}
							$result[$i]['falta']                 = '0.00';
							$result[$i]['atraso']                = '0.00';
							$result[$i]['abandono']              = number_format($dif['hora_decimal'],2);
							$result[$i]['estado']                = 'abandono';
						}else {
							$result[$i]['falta']                 = '';
							$result[$i]['atraso']                = '';
							$result[$i]['abandono']              = '';
							$result[$i]['estado']                = 'presente';
						}
						
						$i++;
				}
			}
		}
			echo $this->tbl_assiduidade($result);
			

		}


		public function get_assiduidade_dpt_ajax($input = []){
			/*
			$dep_id             = $this->input->get('department_id');
			$de                 = date('Y-m-d', strtotime( $this->input->get('de')));
			$ate                = date('Y-m-d', strtotime( $this->input->get('ate')));
			*/
			$dep_id                                 = isset($input['department_id'])?$input['department_id']: '0';
			$de                                     = isset( $input['de'])? $input['de']: '';
			$ate                                    = isset($input['ate'])?$input['ate']: '';
			$data    = $this->gestao_assiduidade_model->get_assiduidade_dpt($dep_id,$de,$ate);

			$result = [];
			$i = 0;
			foreach ($data as $key => $value) { 
				$staff   =$this->gestao_assiduidade_model->get_staff($value['fun_id']);
				$turno   = $this->gestao_assiduidade_model->get_horario_turno_by_id($staff->turnos_id);
				
				

				if (isset($turno)) {
				$periodo = $this->gestao_assiduidade_model->get_periodos_by_id($turno->periodo_id);
				$periodo_entrada   =$periodo->data_inicial;
				$periodo_saida     =$periodo->data_final;
				$dia_semana       = $this->diaDaSemana($value['data'],$turno->dias_trabalho);
				if ($dia_semana == true) {
						$marc_in_out = $this->gestao_assiduidade_model->get_marcacoes_in_out($value['id']);
						$entrada     = '00:00:00';
						$saida       = '00:00:00';
						if (count($marc_in_out)>0) {
							$num_marc_in_out = count($marc_in_out) - 1;
							$entrada     = $marc_in_out[0]['marc_in'];
							$saida       = $marc_in_out[$num_marc_in_out]['marc_out'];
						} 
						
						$result[$i]['nome']                  = $staff->firstname.' '.$staff->lastname;
						$result[$i]['data']                  = $value['data'];
						$result[$i]['entrada']               = $entrada;
						$result[$i]['saida']                 = $saida;
						$result[$i]['total_trabaladas']      = $value['horas_trabalhadas'];
						$result[$i]['horas_extras']          = $value['horas_extras'];
						

						if ($value['horas_trabalhadas'] <= 0 ) { //falta
							$result[$i]['falta']     = '8.00';
							$result[$i]['atraso']    = '0.00';
							$result[$i]['abandono']  = '0.00';
							$result[$i]['estado']    = 'falta';      
						}elseif($periodo_entrada < $entrada && $periodo_saida > $saida){ // atraso e abandono
							$dif_traso = $this->gestao_assiduidade_model->resolveHora($entrada,$periodo_entrada);
							$dif_traso_rs =  $dif_traso['hora_decimal'];
							if ($dif_traso_rs<0) {
								$dif_traso_rs = $dif_traso_rs * -1;
							}

							$dif_abandono = $this->gestao_assiduidade_model->resolveHora($periodo_saida,$saida);
							$dif_abandono_rs =  $dif_abandono['hora_decimal'];
							if ($dif_abandono_rs<0) {
								$dif_abandono_rs = $dif_abandono_rs * -1;
							}

							$result[$i]['falta']                 = '0.00';
							$result[$i]['atraso']                = number_format($dif_traso_rs,2);
							$result[$i]['abandono']              = number_format($dif_abandono_rs,2);
							$result[$i]['estado']                = 'atraso_abandono';
						}elseif($periodo_entrada < $entrada){ // atraso
							$dif = $this->gestao_assiduidade_model->resolveHora($entrada,$periodo_entrada);
							if ($dif['hora_decimal']<0) {
								$dif['hora_decimal'] = $dif['hora_decimal'] * -1;
							}
							$result[$i]['falta']                 = '0.00';
							$result[$i]['atraso']                = number_format($dif['hora_decimal'],2);
							$result[$i]['abandono']              = '0.00';
							$result[$i]['estado']                = 'atraso';
						}elseif($periodo_saida > $saida){ // abandon
							$dif = $this->gestao_assiduidade_model->resolveHora($periodo_saida,$saida);
							if ($dif['hora_decimal']<0) {
								$dif['hora_decimal'] = $dif['hora_decimal'] * -1;
							}
							$result[$i]['falta']                 = '0.00';
							$result[$i]['atraso']                = '0.00';
							$result[$i]['abandono']              = number_format($dif['hora_decimal'],2);
							$result[$i]['estado']                = 'abandono';
						}else {
							$result[$i]['falta']                 = '';
							$result[$i]['atraso']                = '';
							$result[$i]['abandono']              = '';
							$result[$i]['estado']                = 'presente';
						}
						
						$i++;
				}
			  } 
			}
			
			return $this->tbl_assiduidade($result);
			

		}
		public function get_assiduidade_diaria_ajax($input=[]){
			$dep_id             = 0;
			$de                 = date('Y-m-d', strtotime( date('Y-m-d')));
			$ate                = date('Y-m-d', strtotime( date('Y-m-d')));
			$data    = $this->gestao_assiduidade_model->get_assiduidade_diaria_dpt($dep_id,$de,$ate);
		   
			$result = [];
			$i = 0;
			foreach ($data as $key => $value) { 
				$staff   =$this->gestao_assiduidade_model->get_staff($value['fun_id']);
				$turno   = $this->gestao_assiduidade_model->get_horario_turno_by_id($staff->turnos_id);
				

				if (isset($turno)) {
				$periodo = $this->gestao_assiduidade_model->get_periodos_by_id($turno->periodo_id);
				$periodo_entrada   =$periodo->data_inicial;
				$periodo_saida     =$periodo->data_final;

				$dia_semana       = $this->diaDaSemana($value['data'],$turno->dias_trabalho);
				if ($dia_semana == true) {
						$marc_in_out = $this->gestao_assiduidade_model->get_marcacoes_in_out($value['id']);
						$entrada     = '00:00:00';
						$saida       = '00:00:00';
						if (count($marc_in_out)>0) {
							$num_marc_in_out = count($marc_in_out) - 1;
							$entrada     = $marc_in_out[0]['marc_in'];
							$saida       = $marc_in_out[$num_marc_in_out]['marc_out'];
						} 
						
						$result[$i]['nome']                  = $staff->firstname.' '.$staff->lastname;
						$result[$i]['data']                  = $value['data'];
						$result[$i]['entrada']               = $entrada;
						$result[$i]['saida']                 = $saida;
						$result[$i]['total_trabaladas']      = $value['horas_trabalhadas'];
						$result[$i]['horas_extras']          = $value['horas_extras'];
						

						if ($value['horas_trabalhadas'] <= 0 ) { //falta
							$result[$i]['falta']     = '8.00';
							$result[$i]['atraso']    = '0.00';
							$result[$i]['abandono']  = '0.00';
							$result[$i]['estado']    = 'falta';      
						}elseif($periodo_entrada < $entrada && $periodo_saida > $saida){ // atraso e abandono
							$dif_traso = $this->gestao_assiduidade_model->resolveHora($entrada,$periodo_entrada);
							$dif_traso_rs =  $dif_traso['hora_decimal'];
							if ($dif_traso_rs<0) {
								$dif_traso_rs = $dif_traso_rs * -1;
							}

							$dif_abandono = $this->gestao_assiduidade_model->resolveHora($periodo_saida,$saida);
							$dif_abandono_rs =  $dif_abandono['hora_decimal'];
							if ($dif_abandono_rs<0) {
								$dif_abandono_rs = $dif_abandono_rs * -1;
							}

							$result[$i]['falta']                 = '0.00';
							$result[$i]['atraso']                = number_format($dif_traso_rs,2);
							$result[$i]['abandono']              = number_format($dif_abandono_rs,2);
							$result[$i]['estado']                = 'atraso_abandono';
						}elseif($periodo_entrada < $entrada){ // atraso
							$dif = $this->gestao_assiduidade_model->resolveHora($entrada,$periodo_entrada);
							if ($dif['hora_decimal']<0) {
								$dif['hora_decimal'] = $dif['hora_decimal'] * -1;
							}
							$result[$i]['falta']                 = '0.00';
							$result[$i]['atraso']                = number_format($dif['hora_decimal'],2);
							$result[$i]['abandono']              = '0.00';
							$result[$i]['estado']                = 'atraso';
						}elseif($periodo_saida > $saida){ // abandon
							$dif = $this->gestao_assiduidade_model->resolveHora($periodo_saida,$saida);
							if ($dif['hora_decimal']<0) {
								$dif['hora_decimal'] = $dif['hora_decimal'] * -1;
							}
							$result[$i]['falta']                 = '0.00';
							$result[$i]['atraso']                = '0.00';
							$result[$i]['abandono']              = number_format($dif['hora_decimal'],2);
							$result[$i]['estado']                = 'abandono';
						}else {
							$result[$i]['falta']                 = '';
							$result[$i]['atraso']                = '';
							$result[$i]['abandono']              = '';
							$result[$i]['estado']                = 'presente';
						}
						
						$i++;
				}
			  } 
			}
			
			return $this->tbl_assiduidade($result);
			

		}
		public function salvar_conf_ferias(){
			$rs = $this->gestao_assiduidade_model->salvar_conf_ferias($this->input->get());
			if ($rs) {
				$success = true;
				$message = _l('Salvo com sucesso');
				set_alert('success', $message);
			}else {
				$message =  _l('Falha ao salvar');
				set_alert('warning',$message);
			}
			redirect(admin_url('gestao_assiduidade/configuracoes?group=conf_ferias'));
		}
		//GESTAO DE FERIAS
		public function add_gestao_ferias(){
			$input  = $this->input->get();
			if ($input['func_id'] == '0') {
				$message =  _l('Não é possivel salvar, selecione um funcionário!');
				set_alert('warning',$message);
				return redirect(admin_url('gestao_assiduidade/gestao_de_ferias'));
			}

			$de     = new DateTime($input['de']);
			$ate    = new DateTime($input['ate']);
			$intervalo = $de->diff($ate);

			$this->db->where('func_id',$input['func_id']);
			$this->db->where('estado <>', 'R');
			// $this->db->where('estado', 'E');
			$this->db->where('ano_fiscal', date('Y'));
		    $result_principal = $this->db->get(db_prefix() . 'as_ferias')->result_array();

			$total_dias = $intervalo->days;
			foreach ($result_principal as $key => $value) {
				$total_dias      += $value['n_dias'];
				// $total_dias      += $value['dias_usados'];
			}
			if (get_conf_gestao_ferias()->limite_dias_ferias <= $total_dias) {
				$message =  _l('Não é possivel salvar, Esse funcionário não possui mais férias disponível!');
				set_alert('warning',$message);
				return redirect(admin_url('gestao_assiduidade/gestao_de_ferias'));
			}

			$staff  = get_turnos_by_id($input['func_id']);
			$rs_dpt = get_staff_dpt_by_id($input['func_id']);
			$dpt = 0;
			if (isset($rs_dpt)) {
				$dpt = $rs_dpt->departmentid;
			}

			if ($intervalo->days <= 0) {
				$message =  _l('Não é possivel salvar, selecione um intervalo de dias superior que zero!');
				set_alert('warning',$message);
				return redirect(admin_url('gestao_assiduidade/gestao_de_ferias'));
			}

			if (get_conf_gestao_ferias()->limite_dias_ferias < $intervalo->days) {
				$message =  _l('Não é possivel salvar, Ultrapassou o limite máximo de dias de férias!');
				set_alert('warning',$message);
				return redirect(admin_url('gestao_assiduidade/gestao_de_ferias'));
			}

			// Verificar coicidencias nas datas activas
			if ($this->gestao_assiduidade_model->vf_ferias_existe($input['func_id'], $input['de'], $input['ate'])) {
				$message =  _l('A data selecionada já esta associada a uma féria AAAA');
				set_alert('warning', $message);
				return redirect(admin_url('gestao_assiduidade/gestao_de_ferias'));
			}

			$dados =
			[
                'descricao'                      => $input['descricao'],
                'func_id'                        => $input['func_id'],
                'dep_id'                         => $dpt,
                'funcao_id'                      => 1,//$input['funcao_id'],
                'estado'                         => 'P',
                'de'                             => $input['de'],
                'ate'                            => $input['ate'],
				'data'                           => date('Y-m-d'),
                'n_dias'                         => $intervalo->days,
            ];
			$rs = $this->gestao_assiduidade_model->add_gestao_ferias($dados);
			if ($rs) {
				$success = true;
				$message = _l('Salvo com sucesso');
				set_alert('success', $message);
			}else {
				$message =  _l('Falha ao salvar');
				set_alert('warning',$message);
			}
			redirect(admin_url('gestao_assiduidade/gestao_de_ferias'));
		}
		public function update_estado_gestao_ferias(){

			$data['id']     = $this->input->get('id');
			$data['estado'] = $this->input->get('estado');
			
			
				$this->db->where('id',$data['id']);
				$result_principal = $this->db->get(db_prefix() . 'as_ferias')->row();
				if ($data['estado'] == 'A' || $data['estado'] == 'E') {
					$this->db->where('func_id',$result_principal->func_id);
					$this->db->where('id !=',$data['id']);
					$this->db->where('estado','A');
					
					
					$result = $this->db->get(db_prefix() . 'as_ferias')->result_array();
					if (count($result)>0) { // se tiver ferias aprovadas ou em uso
						$success = true;
						$message = _l('Esse funcionário já possui férias aprovadas ou em uso!');
						set_alert('warning', $message);
						redirect(admin_url('gestao_assiduidade/gestao_de_ferias'));
					}
				}
			
			$rs = $this->gestao_assiduidade_model->update_estado_gestao_ferias($data);
			if ($rs) {
				$staff_email = $this->gestao_assiduidade_model->get_staff($result_principal->func_id);
				if ($data['estado'] == 'A') {
					$assunto   =  'Aprovação da Solicitação de Férias';
					$mensagem  =  'Sr. '.$staff_email->firstname. ' Informamos que a sua solicitação de férias foi aprovada!';
					send_email_assiduidade($staff_email->email,$assunto,$mensagem);
				}elseif ($data['estado'] == 'R') {
					$assunto   =  'Rejeição da Solicitação de Férias';
					$mensagem  =  'Sr. '.$staff_email->firstname. ' Informamos que a sua solicitação de férias foi rejeitada!';
					send_email_assiduidade($staff_email->email,$assunto,$mensagem);
				}elseif ($data['estado'] == 'E') {
					$assunto   =  'Início de Gozo de Férias';
					$mensagem  =  'Sr. '.$staff_email->firstname. ' Informamos que começa hoje a contar os dias diponibilizados para as férias!';
					send_email_assiduidade($staff_email->email,$assunto,$mensagem);
				}
				$success = true;
				$message = _l('Atualizado com sucesso');
				set_alert('success', $message);
			}else {
				$message =  _l('Falha ao Atualizar');
				set_alert('warning',$message);
			}
			redirect(admin_url('gestao_assiduidade/gestao_de_ferias'));
		} 

		public function add_marcacoes_id_out_painel(){
			$rs = $this->gestao_assiduidade_model->add_marcacoes_in_out_painel();
			if ($rs == true) {
				set_alert('success', "Concluído sucesso");
			}else {
				set_alert('warning', "Falha ao cadastrar, verifique se esse usuário possui um turno!");
			}
			
			redirect(admin_url());
		}

		//outras operacoes
		public function listarDiasMes($ano, $mes) {
			$diasNoMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
			$dias = [];
			for ($dia = 1; $dia <= $diasNoMes; $dia++) {
				$data = sprintf("%04d-%02d-%02d", $ano, $mes, $dia);
				$dias[] = $data;
			}
			return $dias;
		}
		public function organizaMes($mes = ''){
			if ($mes <= 9) {
				return '0'.$mes;
			}else{
				return $mes;
			}

		}  
		public function diaDaSemana($data,$dias_trabalho) {
			$timestamp = strtotime($data);
			$diaDaSemana = date('N', $timestamp); // 1 (para segunda-feira) até 7 (para domingo)
			// Retornar o dia da semana como um nome
			$diasDaSemana = array(
				1 => 'Monday',
				2 => 'Tuesday',
				3 => 'Wednesday',
				4 => 'Thursday',
				5 => 'Friday',
				6 => 'Saturday',
				7 => 'Sunday'
			);
			$array_dias = explode(',',$dias_trabalho);
			$array_dias_verf = [];
			foreach ($array_dias as $key => $value) {
				$array_dias_verf[$value]= $value;
			}

			$ret_dia =  $diasDaSemana[$diaDaSemana];
			if (isset($array_dias_verf[$ret_dia])) {
				return true;
			}else{
				return false;
			}
		}
 
                             
		public function form_maracacoes($data= [],$parms= []){
			$func  = $this->gestao_assiduidade_model->get_staff($parms['funcionarios_id']);
			$turno = $this->gestao_assiduidade_model->get_horario_turno_by_id($func->turnos_id);
			$html  = '';
		    if ($func->turnos_id != '' && $func->turnos_id != NULL && $func->turnos_id != 0 && isset($turno)) {
					$html .= '<table class="table table-bordered table-hover">';
					$html .= '	<thead class="thead-dark">';
					$html .= '		 <tr>';
					$html .= '			<th>Data</th>';
					$html .= '			<th>Entrada - Saida</th>';
					$html .= '			<th>Tipo</th>';
					$html .= '			<th>Assiduidade</th>';
					$html .= '			<th>Opções</th>';
					$html .= '		</tr>';
					$html .= '	</thead>';
					$html .= ' <tbody>';
					if (count($data)>0) {
						foreach ($data as $key => $value) {
							$tipo          = '<span class="badge bg-primary">Padrão</span>';
							$assiduidade   = '';
							$tr_class      = '';

							$estado['manual'] = '<span class="badge bg-success">Manual</span>';
							$estado['presente'] = '<span class="badge bg-success">Presente</span>';
							$estado['ausente'] = '<span class="badge bg-danger">Ausente</span>';
							$marcacoes        = $this->gestao_assiduidade_model->get_marcacoes_by_data_and_id_func($value,$parms['funcionarios_id']);
							$dia_semana       = $this->diaDaSemana($marcacoes->data,$turno->dias_trabalho);
							$marcacoes_in_out = $this->gestao_assiduidade_model->get_marcacoes_in_out($marcacoes->id);
						
							if ($dia_semana==false) {
								$tipo     = '<span class="badge bg-warning">Folga</span>';
								$tr_class = 'class=""';
							}
							
							$html .= '<tr  '.$tr_class.'>';
							$html .= '	<td>'.$marcacoes->data.'</td>';

							$html .= '	<td>';
							foreach ($marcacoes_in_out as $key => $val) {
								$html .= $val['marc_in'].' - '. $val['marc_out'].'<br>';
							}
							$html .= '	</td>';

							$html .= '	<td>'.$tipo.'</td>';
							$html .= '	<td>'.$estado['manual'].'</td>';
							$html .= '	<td>';
							$html .= '		<button onclick="btnAddMark('.$marcacoes->id.')" type="button" class="btn btn-primary"><i class="fa fa-edit"></i></button>';
							$html .= '	</td>';
							$html .= '</tr>';
						}
					}else {
						$html .= '<tr>';
						$html .= '	<td colspan="5">por favor, seleciona os filtros para apresentar a informação</td>';
						$html .= '</tr>';
						
					}
					$html .= ' </tbody>';
					$html .= '</table>';


					
		  }else {
			$html  .= '<span>Esse funcionário não possui um turno, deves atribuir um turno para continuar!</span>';
		  }
		 
		  return $html;


		}
		public function tbl_assiduidade($data = []){
			$estado['presente'] = '<span class="badge bg-success">Presente</span>';
			$estado['atraso']   = '<span class="badge bg-warning">Atraso</span>';
			$estado['abandono'] = '<span class="badge bg-primary">Abandono</span>';
			$estado['atraso_abandono'] = '<span class="badge bg-info">Atraso e Abandono</span>';
			$estado['falta'] = '<span class="badge bg-danger">Falta</span>';

			$html  = '';
			$html .= '<table class="dt-table table table-bordered table-hover" >';
			$html .= '	<thead class="thead-dark">';
			$html .= '		 <tr>';
			$html .= '			<th>Nome</th>';
			$html .= '			<th>Data</th>';
			$html .= '			<th>Entrada - Saida</th>';
			$html .= '			<th>H.T</th>';
			$html .= '			<th>H.E</th>';
			$html .= '			<th>Falta</th>';
			$html .= '			<th>Atraso</th>';
			$html .= '			<th>Abandono</th>';
			$html .= '			<th>Estado</th>';
			$html .= '		</tr>';
			$html .= '	</thead>';
			$html .= ' <tbody>';
			foreach ($data as $key => $value) {

				$html .= '		 <tr>';
				$html .= '			<td>'.$value['nome'].'</td>';
				$html .= '			<td>'.$value['data'].'</td>';
				$html .= '			<td>'.$value['entrada'].' - '.$value['saida'].'</td>';
				$html .= '			<td>'.$value['total_trabaladas'].'</td>';
				$html .= '			<td>'.$value['horas_extras'].'</td>';
				$html .= '			<td>'.$value['falta'].'</td>';
				$html .= '			<td>'.$value['atraso'].'</td>';
				$html .= '			<td>'.$value['abandono'].'</td>';
				$html .= '			<td>'.$estado[$value['estado']].'</td>';
				$html .= '		</tr>';
			}
			$html .= ' </tbody>';
			$html .= '</table>';
			return $html;
		}
		

		public function tbl_gestao_ferias($data = []){
			$html  = '';
			$html .= '<table class="tabela table table-bordered table-hover dt-table">';
			$html .= '	<thead class="thead-dark">';
			$html .= '		 <tr>';
			$html .= '			<th>Funcionario</th>';
			$html .= '			<th>De</th>';
			$html .= '			<th>Até</th>';
			$html .= '			<th>N. Dias</th>';
			$html .= '			<th>Departamento</th>';
			$html .= '			<th>Estado</th>';
			$html .= '			<th>Opções</th>';
			$html .= '		</tr>';
			$html .= '	</thead>';
			$html .= ' <tbody>';
			foreach ($data as $key => $value) {
				$estado['P'] = '<span class="badge bg-warning">Pendente</span>';
				$estado['A']   = '<span class="badge bg-success">Aprovado</span>';
				$estado['R'] = '<span class="badge bg-danger">Rejeitado</span>';
				$estado['E'] = '<span class="badge bg-info">Em uso</span>';
				$estado['F'] = '<span class="badge bg-danger">Expirado</span>';
				$staff = get_func_by_id($value['func_id']);
				$dpt   = get_dpt_by_id($value['dep_id']);
				
				$staff_name = '-- -- --';
				$dpt_name   = '-- -- --';
				if (isset($staff)) {
					$staff_name = $staff->firstname.' '.$staff->lastname;
				}
				if (isset($dpt)) {
					$dpt_name = $dpt->name;
				}

				$html .= '		 <tr>';
				$html .= '			<td>'.$staff_name.'</td>';
				$html .= '			<td>'. formatarData($value['de']).'</td>';
				$html .= '			<td>'.formatarData($value['ate']).'</td>';
				$html .= '			<td>'.$value['n_dias'].' Dias</td>';
				$html .= '			<td>'.$dpt_name.'</td>';
				$html .= '			<td>'.$estado[$value['estado']].'</td>';
				$html .= '			<td>';
				if ($value['estado']=='P') {
					$html .= '             <a href="'.admin_url('gestao_assiduidade/update_estado_gestao_ferias?id='.$value['id'].'&estado=A').'"><button class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Aprovar"><i class="fa fa-check"></i></button></a>';
				    $html .= '             <a href="'.admin_url('gestao_assiduidade/update_estado_gestao_ferias?id='.$value['id'].'&estado=R').'"><button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Rejeitar"><i class="fa fa-close"></i></button></a>';
				}elseif ($value['estado']=='A') {
					$html .= '             <a href="'.admin_url('gestao_assiduidade/update_estado_gestao_ferias?id='.$value['id'].'&estado=P').'"><button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Devolver"><i class="fa fa-arrow-left"></i></button></a>';
					$html .= '             <a href="'.admin_url('gestao_assiduidade/update_estado_gestao_ferias?id='.$value['id'].'&estado=E').'"><button class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Inicializar"><i class="fa fa-tag"></i></button></a>';
				}elseif ($value['estado']=='R') {
					$html .= '             <a href="'.admin_url('gestao_assiduidade/update_estado_gestao_ferias?id='.$value['id'].'&estado=P').'"><button class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Devolver"><i class="fa fa-arrow-left"></i></button></a>';
				}

				//$html .= '             <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Detalhes"><i class="fa fa-eye"></i></button>';
				$html .= '			</td>';
				$html .= '		</tr>';
			}
			$html .= ' </tbody>';
			$html .= '</table>';
			return $html;
		}

		public function tbl_gestao_ferias_funcionarios($data = []){
			$html  = '';
			$html .= '<table class="tabela table table-bordered table-hover dt-table">';
			$html .= '	<thead class="thead-dark">';
			$html .= '		 <tr>';
			$html .= '			<th>Funcionario</th>';
			$html .= '			<th>De</th>';
			$html .= '			<th>Até</th>';
			$html .= '			<th>Departamento</th>';
			$html .= '			<th>N. Dias</th>';
			$html .= '			<th>Dias Usados</th>';
			$html .= '			<th>Dias Restantes</th>';
			$html .= '			<th>Dias em Reserva</th>';
			$html .= '			<th>Estado</th>';
			$html .= '			<th>Opções</th>';
			$html .= '		</tr>';
			$html .= '	</thead>';
			$html .= ' <tbody>';
			foreach ($data as $key => $value) {
				$n_dias 				= (int) $value['n_dias'] - (int)$value['dias_usados'];
				$dias_usados_geral      = get_dias_restantes_geral($value['func_id']);
				$estado['P'] = '<span class="badge bg-warning">Pendente</span>';
				$estado['A']   = '<span class="badge bg-success">Aprovado</span>';
				$estado['R'] = '<span class="badge bg-danger">Rejeitado</span>';
				$estado['E'] = '<span class="badge bg-info">Em uso</span>';
				$estado['F'] = '<span class="badge bg-danger">Expirado</span>';
				$staff = get_func_by_id($value['func_id']);
				$dpt   = get_dpt_by_id($value['dep_id']);
				
				$staff_name = '-- -- --';
				$dpt_name   = '-- -- --';
				if (isset($staff)) {
					$staff_name = $staff->firstname.' '.$staff->lastname;
				}
				if (isset($dpt)) {
					$dpt_name = $dpt->name;
				}

				$html .= '		 <tr>';
				$html .= '			<td>'.$staff_name.'</td>';
				$html .= '			<td>'. formatarData($value['de']).'</td>';
				$html .= '			<td>'.formatarData($value['ate']).'</td>';
				$html .= '			<td>'.$dpt_name.'</td>';
				$html .= '			<td>'.$value['n_dias'].' Dias</td>';
				$html .= '			<td>'.$value['dias_usados'].' Dias</td>';
				$html .= '			<td>'.$n_dias.'</td>';
				$html .= '			<td>'.((int)get_conf_gestao_ferias()->limite_dias_ferias - (int)$dias_usados_geral - $n_dias).'</td>';
				$html .= '			<td>'.$estado[$value['estado']].'</td>';
				$html .= '			<td>';
				if ($value['estado']=='P') {
					$html .= '             <a href="'.admin_url('gestao_assiduidade/update_estado_gestao_ferias?id='.$value['id'].'&estado=A').'"><button class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Aprovar"><i class="fa fa-check"></i></button></a>';
				    $html .= '             <a href="'.admin_url('gestao_assiduidade/update_estado_gestao_ferias?id='.$value['id'].'&estado=R').'"><button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Rejeitar"><i class="fa fa-close"></i></button></a>';
				}elseif ($value['estado']=='A') {
					$html .= '             <a href="'.admin_url('gestao_assiduidade/update_estado_gestao_ferias?id='.$value['id'].'&estado=P').'"><button class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Devolver"><i class="fa fa-arrow-left"></i></button></a>';
					$html .= '             <a href="'.admin_url('gestao_assiduidade/update_estado_gestao_ferias?id='.$value['id'].'&estado=E').'"><button class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Inicializar"><i class="fa fa-tag"></i></button></a>';
				}elseif ($value['estado']=='R') {
					$html .= '             <a href="'.admin_url('gestao_assiduidade/update_estado_gestao_ferias?id='.$value['id'].'&estado=P').'"><button class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Devolver"><i class="fa fa-arrow-left"></i></button></a>';
				}
				
				//$html .= '             <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Detalhes"><i class="fa fa-eye"></i></button>';
				$html .= '			</td>';
				$html .= '		</tr>';
			}
			$html .= ' </tbody>';
			$html .= '</table>';
			return $html;
		}
}