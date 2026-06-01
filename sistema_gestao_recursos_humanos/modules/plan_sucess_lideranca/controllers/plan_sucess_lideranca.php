<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Recruitment Controller
 */
class Plan_sucess_lideranca extends AdminController {
	public function __construct() {
		parent::__construct();
		$this->load->model('Psl_plan_sucess_lideranca_model');
		$this->load->library(['form_validation', 'upload']);
	}
	private function http_method ($vfMethod) {
        if ($_SERVER['REQUEST_METHOD'] !== $vfMethod) {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['status' => false, 'message' => 'Metodo não permitido']);
            exit;
        }
    }
	/**
	 * Tela de Dashboard
	 */
	public function dashboard() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}

		$data['total_pendentes_grafico_desenvolvimento'] = $this->Psl_plan_sucess_lideranca_model->programa_lideranca_total(1);
        $data['total_aprovados_grafico_desenvolvimento'] = $this->Psl_plan_sucess_lideranca_model->programa_lideranca_total(2);
        $data['total_rejeitado_grafico_desenvolvimento'] = $this->Psl_plan_sucess_lideranca_model->programa_lideranca_total(3);

		$data['total_pendentes_avaliacao_competencias_total'] = $this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_total(1);
		$data['total_aprovados_avaliacao_competencias_total'] = $this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_total(2);
		$data['total_rejeitado_avaliacao_competencias_total'] = $this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_total(3);

		$data['total_pendentes_programa_lideranca'] = $this->Psl_plan_sucess_lideranca_model->programa_lideranca_total(1);
		$data['total_aprovados_programa_lideranca'] = $this->Psl_plan_sucess_lideranca_model->programa_lideranca_total(2);
		$data['total_rejeitado_programa_lideranca'] = $this->Psl_plan_sucess_lideranca_model->programa_lideranca_total(3);

		$data['total_pendentes_plano_aquisicao_competencia'] = $this->Psl_plan_sucess_lideranca_model->plano_aquisicao_competencia_total(1);
		$data['total_aprovados_plano_aquisicao_competencia'] = $this->Psl_plan_sucess_lideranca_model->plano_aquisicao_competencia_total(2);
		$data['total_rejeitado_plano_aquisicao_competencia'] = $this->Psl_plan_sucess_lideranca_model->plano_aquisicao_competencia_total(3);

        $data['total_pendente_mentoria_total'] = $this->Psl_plan_sucess_lideranca_model->mentoria_total(1);
        $data['total_aprovados_mentoria_total'] = $this->Psl_plan_sucess_lideranca_model->mentoria_total(2);
        $data['total_rejeitado_mentoria_total'] = $this->Psl_plan_sucess_lideranca_model->mentoria_total(3);

		$data['total_pendente_potencial_desenvolvimento'] = $this->Psl_plan_sucess_lideranca_model->potencial_desenvolvimento_total(1);
		$data['total_aprovados_potencial_desenvolvimento'] = $this->Psl_plan_sucess_lideranca_model->potencial_desenvolvimento_total(2);
		$data['total_rejeitado_potencial_desenvolvimento'] = $this->Psl_plan_sucess_lideranca_model->potencial_desenvolvimento_total(3);

		$data['total_pendente_talentos'] = $this->Psl_plan_sucess_lideranca_model->talento_total(1);
		$data['total_aprovados_talentos'] = $this->Psl_plan_sucess_lideranca_model->talento_total(2);
		$data['total_rejeitado_talentos'] = $this->Psl_plan_sucess_lideranca_model->talento_total(3);

		$data['total_mapa_sucessao'] = $this->Psl_plan_sucess_lideranca_model->mapa_sucessao_total();
		$data['total_programa_lideranca'] = $this->Psl_plan_sucess_lideranca_model->programa_lideranca_total();
		$data['total_plano_aquisicao_competencia'] = $this->Psl_plan_sucess_lideranca_model->plano_aquisicao_competencia_total();
        $data['mentoria_total'] = $this->Psl_plan_sucess_lideranca_model->mentoria_total();

		// Grafico de Identificação de Talentos
		$data['avaliacao_competencias_total_n_classificado'] = $this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_total(2, ['res' => '<=', 'nota' => 9]);
		$data['avaliacao_competencias_total_classificado'] = $this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_total(2, ['res' => '<=', 'nota' => 14]);
		$data['avaliacao_competencias_total_potencial'] = $this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_total(2, ['res' => '>=', 'nota' => 15]);

		$data['title'] = _l('Dashboard');
		$this->load->view('dashboard/index', $data);
	}

	/******************************************************************************* */

	/*
	 * Tela de Resultados (Identificação)
	 */
	public function identificacao_resultado() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Resultado');
		$data['avaliacoes_competencia'] = $this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_get(2);

		$data['avaliacao_competencias_total'] = $this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_total(2);
		$data['avaliacao_competencias_total_n_classificado'] = $this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_total(2, ['res' => '<=', 'nota' => 9]);
		$data['avaliacao_competencias_total_classificado'] = $this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_total(2, ['res' => '<=', 'nota' => 14]);
		$data['avaliacao_competencias_total_potencial'] = $this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_total(2, ['res' => '>=', 'nota' => 15]);

		$this->load->view('identificacao/index_resultado', $data);
	}

	/*
	 * Tela de identificacao
	 **/
	// public function identificacao() {
	// 	if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
	// 		access_denied('plan_sucess_lideranca');
	// 	}
	// 	$data['title'] = _l('identificacao');
	// 	$data['staff_list'] = $this->Psl_plan_sucess_lideranca_model->staffs_admin();
    //     $data['staffs'] = $this->Psl_plan_sucess_lideranca_model->staffs();
    //     $data['status'] = $this->Psl_plan_sucess_lideranca_model->get_status();

	// 	$data['desempenhos'] = $this->Psl_plan_sucess_lideranca_model->get_desempenho();
	// 	$data['potencial'] = $this->Psl_plan_sucess_lideranca_model->get_potencial();
	// 	$data['competencia'] = $this->Psl_plan_sucess_lideranca_model->get_competencia();

	// 	$data['group'] = $this->input->get('group');
	// 	$data['tab'][] = 'talentos';
	// 	$data['tab'][] = 'avaliacao_competencias';
	// 	$data['tab'][] = 'potencial_desenvolvimento';
	// 	if ($data['group'] == '') {
	// 		$data['group'] = 'talentos';
    //         $data['talentos'] = $this->Psl_plan_sucess_lideranca_model->talento_get();
	// 	}
	// 	elseif ($data['group'] == 'talentos') {
    //         $data['group'] = 'talentos';
    //         $data['talentos'] = $this->Psl_plan_sucess_lideranca_model->talento_get();
    //     }
	// 	elseif ($data['group'] == 'avaliacao_competencias') {
    //         $data['group'] = 'avaliacao_competencias';
    //         $data['avaliacoes_competencia'] = $this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_get();
    //     } elseif ($data['group'] == 'potencial_desenvolvimento') {
    //         $data['group'] = 'potencial_desenvolvimento';
    //         $data['potencial_desenvolvimento'] = $this->Psl_plan_sucess_lideranca_model->potencial_desenvolvimento_get();
    //     }
	// 	else {
	// 		set_alert('danger',"Configuração não encontrada");
	// 		redirect('plan_sucess_lideranca/identificacao?group=talentos');
	// 	}
	// 	$data['tabs']['view'] = 'identificacao/' . $data['group'];

	// 	$this->load->view('identificacao/index', $data);
	// }
	public function identificacao() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('identificacao');
		$data['staff_list'] = $this->Psl_plan_sucess_lideranca_model->staffs_admin();
        $data['staffs'] = $this->Psl_plan_sucess_lideranca_model->staffs();
        $data['status'] = $this->Psl_plan_sucess_lideranca_model->get_status();

		$data['desempenhos'] = $this->Psl_plan_sucess_lideranca_model->get_desempenho();
		$data['potencial'] = $this->Psl_plan_sucess_lideranca_model->get_potencial();
		$data['competencia'] = $this->Psl_plan_sucess_lideranca_model->get_competencia();

		// $data['group'] = $this->input->get('group');
		// $data['tab'][] = 'talentos';
		// $data['tab'][] = 'avaliacao_competencias';
		// $data['tab'][] = 'potencial_desenvolvimento';
		// if ($data['group'] == '') {
		// 	$data['group'] = 'talentos';
        //     $data['talentos'] = $this->Psl_plan_sucess_lideranca_model->talento_get();
		// }
		// elseif ($data['group'] == 'talentos') {
        //     $data['group'] = 'talentos';
        //     $data['talentos'] = $this->Psl_plan_sucess_lideranca_model->talento_get();
        // }
		// elseif ($data['group'] == 'avaliacao_competencias') {
        //     $data['group'] = 'avaliacao_competencias';
        //     $data['avaliacoes_competencia'] = $this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_get();
        // } elseif ($data['group'] == 'potencial_desenvolvimento') {
        //     $data['group'] = 'potencial_desenvolvimento';
        //     $data['potencial_desenvolvimento'] = $this->Psl_plan_sucess_lideranca_model->potencial_desenvolvimento_get();
        // }
		// else {
		// 	set_alert('danger',"Configuração não encontrada");
		// 	redirect('plan_sucess_lideranca/identificacao?group=talentos');
		// }
		// $data['tabs']['view'] = 'identificacao/' . $data['group'];
		$data['talentos'] = $this->Psl_plan_sucess_lideranca_model->talento_get();

		$this->load->view('identificacao/talentos', $data);
	}
	public function adicionar_talento () {
        $this->http_method('POST');

        $data = [
            'status_id' => 1,
            'staff_id' => $this->input->post('funcionario') ?? '',
            'potencial_id' => $this->input->post('potencial') ?? '',
            'desempenho_id' => $this->input->post('desempenho') ?? '',
            'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $competencias = $this->input->post('competencias[]') ?? '';

        $this->form_validation->set_rules('funcionario', 'funcionario', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('potencial', 'potencial', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('desempenho', 'desempenho', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('competencias[]', 'competencias', 'required', ['required' => 'Preencha o campo {field}']);

        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/identificacao/');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->talento_create($data, $competencias);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/identificacao/');
		}
    }
	public function editar_talento ($id) {
        $this->http_method('POST');
		$this->Psl_plan_sucess_lideranca_model->talento_first($id);

        $data = [
            'staff_id' => $this->input->post('e_funcionario') ?? '',
            'potencial_id' => $this->input->post('e_potencial') ?? '',
            'desempenho_id' => $this->input->post('e_desempenho') ?? '',
            'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];

        $competencias = $this->input->post('e_competencias[]') ?? '';

        $this->form_validation->set_rules('e_funcionario', 'funcionario', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_potencial', 'potencial', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_desempenho', 'desempenho', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_competencias[]', 'competencias', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/identificacao/');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->talento_update($data, $competencias, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('plan_sucess_lideranca/identificacao/');
		}
    }
	public function talento_delete ($id) {
		$this->Psl_plan_sucess_lideranca_model->talento_first($id);
		$this->Psl_plan_sucess_lideranca_model->talento_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('plan_sucess_lideranca/identificacao');
	}
	public function talento_aprovar($id) {
        $vf = $this->Psl_plan_sucess_lideranca_model->talento_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/identificacao');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/identificacao');
		}
		$this->Psl_plan_sucess_lideranca_model->talento_update_status(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('plan_sucess_lideranca/identificacao');
    }
    public function talento_rejeitar($id) {
        $vf = $this->Psl_plan_sucess_lideranca_model->talento_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/identificacao');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/identificacao');
		}
		$this->Psl_plan_sucess_lideranca_model->talento_update_status(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('plan_sucess_lideranca/identificacao');
    }

	public function avaliacao_competencias() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('avaliacao_competencias');
		$data['staff_list'] = $this->Psl_plan_sucess_lideranca_model->staffs_admin();
        $data['staffs'] = $this->Psl_plan_sucess_lideranca_model->staffs();
        $data['status'] = $this->Psl_plan_sucess_lideranca_model->get_status();

		$data['desempenhos'] = $this->Psl_plan_sucess_lideranca_model->get_desempenho();
		$data['potencial'] = $this->Psl_plan_sucess_lideranca_model->get_potencial();
		$data['competencia'] = $this->Psl_plan_sucess_lideranca_model->get_competencia();

		$data['avaliacoes_competencia'] = $this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_get();

		$this->load->view('identificacao/avaliacao_competencias', $data);
	}
	public function adicionar_avaliacao_competencias () {
        $this->http_method('POST');

        $data = [
            'status_id' => 1,
            'staff_id' => $this->input->post('funcionario') ?? '',
            'competencia_id' => $this->input->post('competencia') ?? '',
            'data_avaliacao' => $this->input->post('data_avaliacao') ?? '',
            'nota' => $this->input->post('nota') ?? '',
            'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('funcionario', 'funcionario', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_avaliacao', 'data_avaliacao', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('nota', 'nota', 'required|integer|greater_than_equal_to[0]|less_than_equal_to[20]', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('competencia', 'competencia', 'required', ['required' => 'Preencha o campo {field}']);

        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return; 
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/avaliacao_competencias');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/avaliacao_competencias');
		}
    }
	public function editar_avaliacao_competencias ($id) {
        $this->http_method('POST');
		$this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_first($id);

        $data = [
            'staff_id' => $this->input->post('e_funcionario') ?? '',
            'competencia_id' => $this->input->post('e_competencia') ?? '',
            'data_avaliacao' => $this->input->post('e_data_avaliacao') ?? '',
            'nota' => $this->input->post('e_nota') ?? '',
            'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('e_funcionario', 'funcionario', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_data_avaliacao', 'data_avaliacao', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_nota', 'nota', 'required|integer|greater_than_equal_to[0]|less_than_equal_to[20]', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_competencia', 'competencia', 'required', ['required' => 'Preencha o campo {field}']);

        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/avaliacao_competencias');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('plan_sucess_lideranca/avaliacao_competencias');
		}
    }
	public function avaliacao_competencias_delete ($id) {
		$this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_first($id);
		$this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('plan_sucess_lideranca/avaliacao_competencias');
	}
	public function avaliacao_competencias_aprovar($id) {
        $vf = $this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/avaliacao_competencias');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/avaliacao_competencias');
		}
		$this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_update_status(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('plan_sucess_lideranca/avaliacao_competencias');
    }
    public function avaliacao_competencias_rejeitar($id) {
        $vf = $this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/avaliacao_competencias');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/avaliacao_competencias');
		}
		$this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_update_status(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('plan_sucess_lideranca/avaliacao_competencias');
    }

	public function potencial_desenvolvimento() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('potencial_desenvolvimento');
		$data['staff_list'] = $this->Psl_plan_sucess_lideranca_model->staffs_admin();
        $data['staffs'] = $this->Psl_plan_sucess_lideranca_model->staffs();
        $data['status'] = $this->Psl_plan_sucess_lideranca_model->get_status();

		$data['desempenhos'] = $this->Psl_plan_sucess_lideranca_model->get_desempenho();
		$data['potencial'] = $this->Psl_plan_sucess_lideranca_model->get_potencial();
		$data['competencia'] = $this->Psl_plan_sucess_lideranca_model->get_competencia();

		$data['potencial_desenvolvimento'] = $this->Psl_plan_sucess_lideranca_model->potencial_desenvolvimento_get();

		$this->load->view('identificacao/potencial_desenvolvimento', $data);
	}
	public function adicionar_potencial_desenvolvimento () {
        $this->http_method('POST');

        $data = [
            'status_id' => 1,
            'staff_id' => $this->input->post('funcionario') ?? '',
            'potencial_id' => $this->input->post('potencial') ?? '',
            'sugestao_desenvolvimento' => $this->input->post('sugestao_desenvolvimento') ?? '',
            'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('funcionario', 'funcionario', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('potencial', 'potencial', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('sugestao_desenvolvimento', 'sugestao_desenvolvimento', 'required', ['required' => 'Preencha o campo {field}']);

        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);
        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/potencial_desenvolvimento');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->potencial_desenvolvimento_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/potencial_desenvolvimento');
		}
    }
	public function editar_potencial_desenvolvimento ($id) {
        $this->http_method('POST');
		$this->Psl_plan_sucess_lideranca_model->potencial_desenvolvimento_first($id);

        $data = [
            'staff_id' => $this->input->post('e_funcionario') ?? '',
            'potencial_id' => $this->input->post('e_potencial') ?? '',
            'sugestao_desenvolvimento' => $this->input->post('e_sugestao_desenvolvimento') ?? '',
            'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('e_funcionario', 'funcionario', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_potencial', 'potencial', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_sugestao_desenvolvimento', 'sugestao_desenvolvimento', 'required', ['required' => 'Preencha o campo {field}']);

        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);
        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/potencial_desenvolvimento');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->potencial_desenvolvimento_update($data, $id);
			set_alert('success',"Actualização com sucesso");
			redirect('plan_sucess_lideranca/potencial_desenvolvimento');
		}
    }
	public function potencial_desenvolvimento_delete ($id) {
		$this->Psl_plan_sucess_lideranca_model->potencial_desenvolvimento_first($id);
		$this->Psl_plan_sucess_lideranca_model->potencial_desenvolvimento_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('plan_sucess_lideranca/potencial_desenvolvimento');
	}
	public function potencial_desenvolvimento_aprovar($id) {
        $vf = $this->Psl_plan_sucess_lideranca_model->potencial_desenvolvimento_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/potencial_desenvolvimento');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/potencial_desenvolvimento');
		}
		$this->Psl_plan_sucess_lideranca_model->potencial_desenvolvimento_update_status(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('plan_sucess_lideranca/potencial_desenvolvimento');
    }
    public function potencial_desenvolvimento_rejeitar($id) {
        $vf = $this->Psl_plan_sucess_lideranca_model->potencial_desenvolvimento_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/potencial_desenvolvimento');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/potencial_desenvolvimento');
		}
		$this->Psl_plan_sucess_lideranca_model->potencial_desenvolvimento_update_status(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('plan_sucess_lideranca/potencial_desenvolvimento');
    }

	public function identificacao_avaliacao() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Avaliação');
		$this->load->view('identificacao/index_avaliacao', $data);
	}

	public function identificacao_potencial() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Potencial');
		$this->load->view('identificacao/index_potencial', $data);
	}

	public function identificacao_identificacao_visualizar() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Visualizar');
		$this->load->view('identificacao/identificacao_visualizar', $data);
	}

	public function identificacao_visualizar_avaliacao($id) {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Visualizar');
		$data['avaliacao'] = $this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_first($id);
		$this->load->view('identificacao/visualizar_avaliacao', $data);
	}
 
	public function identificacao_visualizar_potencial($id) {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Visualizar');
		$data['potencial'] = $this->Psl_plan_sucess_lideranca_model->potencial_desenvolvimento_first($id);
		$this->load->view('identificacao/visualizar_potencial', $data);
	}

	public function identificacao_visualizar_talentos($id) {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Visualizar');
		$data['talento'] = $this->Psl_plan_sucess_lideranca_model->talento_first($id);
		$this->load->view('identificacao/visualizar_talentos', $data);
	}

	/************************************************************************ */

	/*
	 * Tela de Resultados (Identificação)
	 */
	public function planeamento_resultado() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Resultado');
		$data['plano_desenvolvimento'] = $this->Psl_plan_sucess_lideranca_model->plano_desenvolvimento_get(2);

		$data['plano_desenvolvimento_total'] = $this->Psl_plan_sucess_lideranca_model->plano_desenvolvimento_total(2);
		$data['plano_desenvolvimento_n_sucessor'] = $this->Psl_plan_sucess_lideranca_model->plano_desenvolvimento_total(2, 'Pequeno');
		$data['plano_desenvolvimento_sucessor'] = $this->Psl_plan_sucess_lideranca_model->plano_desenvolvimento_total(2, 'Medio');
		$data['plano_desenvolvimento_p_sucessor'] = $this->Psl_plan_sucess_lideranca_model->plano_desenvolvimento_total(2, 'Alto');

		$this->load->view('planeamento/index_resultado', $data);
	}

	public function planeamento() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('planeamento');
		$data['staff_list'] = $this->Psl_plan_sucess_lideranca_model->staffs_admin();
        $data['staffs'] = $this->Psl_plan_sucess_lideranca_model->staffs();
        $data['status'] = $this->Psl_plan_sucess_lideranca_model->get_status();
        $data['cargos'] = $this->Psl_plan_sucess_lideranca_model->cargos_get();

		$data['competencia'] = $this->Psl_plan_sucess_lideranca_model->get_competencia();
		$data['mapa_sucessao'] = $this->Psl_plan_sucess_lideranca_model->mapa_sucessao_get();
		$this->load->view('planeamento/mapa_sucessao', $data);
	}
	public function adicionar_mapa_sucessao () {
        $this->http_method('POST');

        $data = [
            'status_id' => 1,
            'cargo_id' => $this->input->post('cargo') ?? '',
            'competencia_id' => $this->input->post('competencia') ?? '',
            'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('cargo', 'cargo', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('competencia', 'competencia', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/planeamento/');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->mapa_sucessao_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/planeamento/');
		}
    }
	public function editar_mapa_sucessao ($id) {
        $this->http_method('POST');
		$this->Psl_plan_sucess_lideranca_model->mapa_sucessao_first($id);

        $data = [
            'cargo_id' => $this->input->post('e_cargo') ?? '',
            'competencia_id' => $this->input->post('e_competencia') ?? '',
            'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('e_cargo', 'cargo', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_competencia', 'competencia', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/planeamento/');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->mapa_sucessao_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('plan_sucess_lideranca/planeamento/');
		}
    }
	public function mapa_sucessao_aprovar($id) {
        $vf = $this->Psl_plan_sucess_lideranca_model->mapa_sucessao_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/planeamento');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/planeamento');
		}
		$this->Psl_plan_sucess_lideranca_model->mapa_sucessao_update_status(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('plan_sucess_lideranca/planeamento');
    }
    public function mapa_sucessao_rejeitar($id) {
        $vf = $this->Psl_plan_sucess_lideranca_model->mapa_sucessao_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/planeamento');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/planeamento');
		}
		$this->Psl_plan_sucess_lideranca_model->mapa_sucessao_update_status(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('plan_sucess_lideranca/planeamento');
    }
	public function mapa_sucessao_delete ($id) {
		$this->Psl_plan_sucess_lideranca_model->mapa_sucessao_first($id);
		$this->Psl_plan_sucess_lideranca_model->mapa_sucessao_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('plan_sucess_lideranca/planeamento');
	}

	public function plano_desenvolvimento() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('plano_desenvolvimento');
		$data['staff_list'] = $this->Psl_plan_sucess_lideranca_model->staffs_admin();
        $data['staffs'] = $this->Psl_plan_sucess_lideranca_model->staffs();
        $data['status'] = $this->Psl_plan_sucess_lideranca_model->get_status();

		$data['competencia'] = $this->Psl_plan_sucess_lideranca_model->get_competencia();
		$data['plano_desenvolvimento'] = $this->Psl_plan_sucess_lideranca_model->plano_desenvolvimento_get();
		$data['mapa_sucessao'] = $this->Psl_plan_sucess_lideranca_model->mapa_sucessao_get(2);
		$data['posicao_chave'] = $this->Psl_plan_sucess_lideranca_model->posicao_chave_get();

		$this->load->view('planeamento/plano_desenvolvimento', $data);
	}
	public function adicionar_plano_desenvolvimento () {
        $this->http_method('POST');

        $data = [
            'status_id' => 1,
            'staff_id' => $this->input->post('funcionario') ?? '',
            'mapa_sucessao_id' => $this->input->post('mapa_sucessao') ?? '',
            'posicao_chave_id' => $this->input->post('posicao_chave') ?? '',
            'treinamento_sugerido' => $this->input->post('sugestao_treinamento') ?? '',
            'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('funcionario', 'funcionario', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('sugestao_treinamento', 'sugestao_treinamento', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('mapa_sucessao', 'mapa_sucessao', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('posicao_chave', 'posicao_chave', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/plano_desenvolvimento');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->plano_desenvolvimento_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/plano_desenvolvimento');
		}
    }
	public function editar_plano_desenvolvimento ($id) {
        $this->http_method('POST');
		$this->Psl_plan_sucess_lideranca_model->plano_desenvolvimento_first($id);

        $data = [
            'staff_id' => $this->input->post('e_funcionario') ?? '',
            'mapa_sucessao_id' => $this->input->post('e_mapa_sucessao') ?? '',
            'posicao_chave_id' => $this->input->post('e_posicao_chave') ?? '',
            'treinamento_sugerido' => $this->input->post('e_sugestao_treinamento') ?? '',
            'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('e_funcionario', 'funcionario', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_sugestao_treinamento', 'sugestao_treinamento', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_mapa_sucessao', 'mapa_sucessao', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_posicao_chave', 'posicao_chave', 'required', ['required' => 'Preencha o campo {field}']);        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/plano_desenvolvimento');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->plano_desenvolvimento_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('plan_sucess_lideranca/plano_desenvolvimento');
		}
    }
	public function plano_desenvolvimento_aprovar($id) {
        $vf = $this->Psl_plan_sucess_lideranca_model->plano_desenvolvimento_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/plano_desenvolvimento');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/plano_desenvolvimento');
		}
		$this->Psl_plan_sucess_lideranca_model->plano_desenvolvimento_update(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('plan_sucess_lideranca/plano_desenvolvimento');
    }
    public function plano_desenvolvimento_rejeitar($id) {
        $vf = $this->Psl_plan_sucess_lideranca_model->plano_desenvolvimento_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/plano_desenvolvimento');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/plano_desenvolvimento');
		}
		$this->Psl_plan_sucess_lideranca_model->plano_desenvolvimento_update(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('plan_sucess_lideranca/plano_desenvolvimento');
    }
	public function plano_desenvolvimento_delete ($id) {
		$this->Psl_plan_sucess_lideranca_model->plano_desenvolvimento_first($id);
		$this->Psl_plan_sucess_lideranca_model->plano_desenvolvimento_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('plan_sucess_lideranca/plano_desenvolvimento');
	}

	public function posicao_chave() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('posicao_chave');
		$data['nivel_critico'] = $this->Psl_plan_sucess_lideranca_model->get_nivel_critico();

		$data['posicao_chave'] = $this->Psl_plan_sucess_lideranca_model->posicao_chave_get();
		$this->load->view('planeamento/posicao_chave', $data);
	}
	public function adicionar_posicao_chave () {
        $this->http_method('POST');

        $data = [
            'nome' => $this->input->post('nome') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
            'nivel_critico_id' => $this->input->post('nivel_critico') ?? '',
        ];

        $this->form_validation->set_rules('nome', 'nome', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('descricao', 'descricao', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('nivel_critico', 'nivel_critico', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/posicao_chave');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->posicao_chave_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/posicao_chave');
		}
    }
	public function editar_posicao_chave ($id) {
        $this->http_method('POST');
		$this->Psl_plan_sucess_lideranca_model->posicao_chave_first($id);

        $data = [
            'nome' => $this->input->post('e_nome') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
            'nivel_critico_id' => $this->input->post('e_nivel_critico') ?? '',
        ];

        $this->form_validation->set_rules('e_nome', 'nome', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_descricao', 'descricao', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_nivel_critico', 'nivel_critico', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/posicao_chave');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->posicao_chave_update($data, $id);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/posicao_chave');
		}
    }
	public function posicao_chave_delete ($id) {
		$this->Psl_plan_sucess_lideranca_model->posicao_chave_first($id);
		$this->Psl_plan_sucess_lideranca_model->posicao_chave_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('plan_sucess_lideranca/posicao_chave');
	}

	public function planeamento_plano() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Plano');
		$this->load->view('planeamento/index_plano', $data);
	}

	public function planeamento_posicao() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Posicao');
		$this->load->view('planeamento/index_posicao', $data);
	}

	public function planeamento_visualizar_mapa($id) {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Visualizar');
		$data['mapa'] = $this->Psl_plan_sucess_lideranca_model->mapa_sucessao_first($id);
		$this->load->view('planeamento/visualizar_mapa', $data);
	}

	public function planeamento_visualizar_plano($id) {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Visualizar');
		$data['plano'] = $this->Psl_plan_sucess_lideranca_model->plano_desenvolvimento_first($id);
		$this->load->view('planeamento/visualizar_plano', $data);
	}

	public function planeamento_visualizar_posicao($id) {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Visualizar');
		$data['chave'] = $this->Psl_plan_sucess_lideranca_model->posicao_chave_first($id);
		$this->load->view('planeamento/visualizar_posicao', $data);
	}





	/************************************************************************
	 * Telas de desenvolvimento
	 ***********************************************************************/
	public function desenvolvimento_resultado() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Desenvolvimento Resultado');
		$data['feedback'] = $this->Psl_plan_sucess_lideranca_model->get_feedback();

		$data['avaliacao_lideranca'] = $this->Psl_plan_sucess_lideranca_model->avaliacao_lideranca_get(2);

		$this->load->view('desenvolvimento/index_resultado', $data);
	}
	 public function desenvolvimento() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('desenvolvimento');
		$data['staff_list'] = $this->Psl_plan_sucess_lideranca_model->staffs_admin();
        $data['staffs'] = $this->Psl_plan_sucess_lideranca_model->staffs();
        $data['status'] = $this->Psl_plan_sucess_lideranca_model->get_status();

        $data['total_licenca'] = $this->Psl_plan_sucess_lideranca_model->programa_lideranca_total();
        $data['total_pendentes'] = $this->Psl_plan_sucess_lideranca_model->programa_lideranca_total(1);
        $data['total_aprovados'] = $this->Psl_plan_sucess_lideranca_model->programa_lideranca_total(2);
        $data['total_rejeitado'] = $this->Psl_plan_sucess_lideranca_model->programa_lideranca_total(3);

		$data['programa_lideranca'] = $this->Psl_plan_sucess_lideranca_model->programa_lideranca_get();
		
		$this->load->view('desenvolvimento/index', $data);
	}
	public function adicionar_programa_lideranca () {
        $this->http_method('POST');

        $data = [
            'status_id' => 1,
            'nome' => $this->input->post('nome') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
            'data_inicio' => $this->input->post('data_inicio') ?? '',
            'data_fim' => $this->input->post('data_fim') ?? '',
            'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('nome', 'nome', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('descricao', 'descricao', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_inicio', 'data_inicio', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_fim', 'data_fim', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/desenvolvimento/?group=programa_lideranca');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->programa_lideranca_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/desenvolvimento/?group=programa_lideranca');
		}
    }
	public function editar_programa_lideranca ($id) {
        $this->http_method('POST');
		$this->Psl_plan_sucess_lideranca_model->programa_lideranca_first($id);

        $data = [
            'nome' => $this->input->post('e_nome') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
            'data_inicio' => $this->input->post('e_data_inicio') ?? '',
            'data_fim' => $this->input->post('e_data_fim') ?? '',
            'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('e_nome', 'nome', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_descricao', 'descricao', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_data_inicio', 'data_inicio', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_data_fim', 'data_fim', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/desenvolvimento/');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->programa_lideranca_update($data, $id);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/desenvolvimento/');
		}
    }
	public function programa_lideranca_delete ($id) {
		$this->Psl_plan_sucess_lideranca_model->programa_lideranca_first($id);
		$this->Psl_plan_sucess_lideranca_model->programa_lideranca_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('plan_sucess_lideranca/desenvolvimento');
	}
	public function programa_lideranca_aprovar($id) {
        $vf = $this->Psl_plan_sucess_lideranca_model->programa_lideranca_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/desenvolvimento');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/desenvolvimento');
		}
		$this->Psl_plan_sucess_lideranca_model->programa_lideranca_update(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('plan_sucess_lideranca/desenvolvimento');
    }
    public function programa_lideranca_rejeitar($id) {
        $vf = $this->Psl_plan_sucess_lideranca_model->programa_lideranca_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/desenvolvimento');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/desenvolvimento');
		}
		$this->Psl_plan_sucess_lideranca_model->programa_lideranca_update(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('plan_sucess_lideranca/desenvolvimento');
    }

	public function desenvolvimento_treinamento() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Treinamento');
		$data['staff_list'] = $this->Psl_plan_sucess_lideranca_model->staffs_admin();
        $data['status'] = $this->Psl_plan_sucess_lideranca_model->get_status();

		$data['programa_lideranca'] = $this->Psl_plan_sucess_lideranca_model->programa_lideranca_get(2);
	
		$data['treinamento_lideranca'] = $this->Psl_plan_sucess_lideranca_model->treinamento_lideranca_get();

		$this->load->view('desenvolvimento/index_treinamento', $data);
	}
	public function adicionar_treinamento_lideranca () {
        $this->http_method('POST');

        $data = [
            'status_id' => 1,
            'programa_lideranca_id' => $this->input->post('programa_lideranca') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
            'carga_horaria' => $this->input->post('carga_horaria') ?? '',
            'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('programa_lideranca', 'programa_lideranca', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('descricao', 'descricao', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('carga_horaria', 'carga_horaria', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/desenvolvimento_treinamento');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->treinamento_lideranca_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/desenvolvimento_treinamento');
		}
    }
	public function editar_treinamento_lideranca ($id) {
        $this->http_method('POST');
		$this->Psl_plan_sucess_lideranca_model->treinamento_lideranca_first($id);

        $data = [
            'programa_lideranca_id' => $this->input->post('e_programa_lideranca') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
            'carga_horaria' => $this->input->post('e_carga_horaria') ?? '',
            'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('e_programa_lideranca', 'programa_lideranca', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_descricao', 'descricao', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_carga_horaria', 'carga_horaria', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/desenvolvimento_treinamento');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->treinamento_lideranca_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('plan_sucess_lideranca/desenvolvimento_treinamento');
		}
    }
	public function treinamento_lideranca_aprovar($id) {
        $vf = $this->Psl_plan_sucess_lideranca_model->treinamento_lideranca_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/desenvolvimento_treinamento');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/desenvolvimento_treinamento');
		}
		$this->Psl_plan_sucess_lideranca_model->treinamento_lideranca_update(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('plan_sucess_lideranca/desenvolvimento_treinamento');
    }
    public function treinamento_lideranca_rejeitar($id) {
        $vf = $this->Psl_plan_sucess_lideranca_model->treinamento_lideranca_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/desenvolvimento_treinamento');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/desenvolvimento_treinamento');
		}
		$this->Psl_plan_sucess_lideranca_model->treinamento_lideranca_update(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('plan_sucess_lideranca/desenvolvimento_treinamento');
    }
	public function treinamento_lideranca_delete ($id) {
		$this->Psl_plan_sucess_lideranca_model->treinamento_lideranca_first($id);
		$this->Psl_plan_sucess_lideranca_model->treinamento_lideranca_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('plan_sucess_lideranca/desenvolvimento_treinamento');
	}

	public function desenvolvimento_avaliacao1() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Avaliacao');
		$data['treinamento_lideranca'] = $this->Psl_plan_sucess_lideranca_model->treinamento_lideranca_get(2);
		$data['staff_list'] = $this->Psl_plan_sucess_lideranca_model->staffs_admin();
        $data['staffs'] = $this->Psl_plan_sucess_lideranca_model->staffs();

        $data['status'] = $this->Psl_plan_sucess_lideranca_model->get_status();
        $data['feedback'] = $this->Psl_plan_sucess_lideranca_model->get_feedback();
		$data['talentos'] = $this->Psl_plan_sucess_lideranca_model->talento_get(2);

		$data['avaliacao_lideranca'] = $this->Psl_plan_sucess_lideranca_model->avaliacao_lideranca_get();
		$this->load->view('desenvolvimento/index_avaliacao1', $data);
	}
	public function adicionar_avaliacao_lideranca () {
        $this->http_method('POST');

        $data = [
            'status_id' => 1,
            'talento_id' => $this->input->post('talento') ?? '',
            'treinamento_lideranca_id' => $this->input->post('treinamento_lideranca') ?? '',
            'feedback_id' => $this->input->post('feedback') ?? '',
            'nota' => $this->input->post('nota') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
        ];

        $this->form_validation->set_rules('talento', 'talento', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('treinamento_lideranca', 'treinamento_lideranca', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('feedback', 'feedback', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('nota', 'nota', 'required|integer|greater_than_equal_to[0]|less_than_equal_to[20]', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('descricao', 'descricao', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/desenvolvimento_avaliacao1');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->avaliacao_lideranca_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/desenvolvimento_avaliacao1');
		}
    }
	public function editar_avaliacao_lideranca ($id) {
        $this->http_method('POST');
		$this->Psl_plan_sucess_lideranca_model->avaliacao_lideranca_first($id);

        $data = [
            'talento_id' => $this->input->post('e_talento') ?? '',
            'treinamento_lideranca_id' => $this->input->post('e_treinamento_lideranca') ?? '',
            'feedback_id' => $this->input->post('e_feedback') ?? '',
            'nota' => $this->input->post('e_nota') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
        ];

        $this->form_validation->set_rules('e_talento', 'talento', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_treinamento_lideranca', 'treinamento_lideranca', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_feedback', 'feedback', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_nota', 'nota', 'required|integer|greater_than_equal_to[0]|less_than_equal_to[20]', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_descricao', 'descricao', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/desenvolvimento_avaliacao1');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->avaliacao_lideranca_update($data, $id);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/desenvolvimento_avaliacao1');
		}
    }
	public function avaliacao_lideranca_delete ($id) {
		$this->Psl_plan_sucess_lideranca_model->avaliacao_lideranca_first($id);
		$this->Psl_plan_sucess_lideranca_model->avaliacao_lideranca_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('plan_sucess_lideranca/desenvolvimento_avaliacao1');
	}
	public function avaliacao_lideranca_aprovar($id) {
		$vf = $this->Psl_plan_sucess_lideranca_model->avaliacao_lideranca_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/desenvolvimento_avaliacao1');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/desenvolvimento_avaliacao1');
		}
		$this->Psl_plan_sucess_lideranca_model->avaliacao_lideranca_update(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('plan_sucess_lideranca/desenvolvimento_avaliacao1');
    }
    public function avaliacao_lideranca_rejeitar($id) {
        $vf = $this->Psl_plan_sucess_lideranca_model->avaliacao_lideranca_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/desenvolvimento_avaliacao1');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/desenvolvimento_avaliacao1');
		}
		$this->Psl_plan_sucess_lideranca_model->avaliacao_lideranca_update(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('plan_sucess_lideranca/desenvolvimento_avaliacao1');
    }


	public function desenvolvimento_visualizar_desenvolvimento($id) {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Visualizr');
		$data['programa'] = $this->Psl_plan_sucess_lideranca_model->programa_lideranca_first($id); 
		$this->load->view('desenvolvimento/visualizar_desenvolvimento', $data);
	}

	public function desenvolvimento_visualizar_treinamento($id) {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Visualizr');
		$data['treinamento'] = $this->Psl_plan_sucess_lideranca_model->treinamento_lideranca_first($id); 
		$this->load->view('desenvolvimento/visualizar_treinamento', $data);
	}

	public function desenvolvimento_visualizar_avaliacao($id) {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Visualizr');
		$data['lideranca'] = $this->Psl_plan_sucess_lideranca_model->avaliacao_lideranca_first($id); 
		$this->load->view('desenvolvimento/visualizar_avaliacao', $data);
	}

	/*******************************************************************************
	 * Telas de competencias
	 *******************************************************************************/
	public function competencias() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('competencias');

		$data['staff_list'] = $this->Psl_plan_sucess_lideranca_model->staffs_admin();
        $data['staffs'] = $this->Psl_plan_sucess_lideranca_model->staffs();
        $data['status'] = $this->Psl_plan_sucess_lideranca_model->get_status();
		
		$data['cargos'] = $this->Psl_plan_sucess_lideranca_model->cargos_get();
		$data['competencia'] = $this->Psl_plan_sucess_lideranca_model->get_competencia();

		$data['competencia_cargo'] = $this->Psl_plan_sucess_lideranca_model->competencia_cargo_get();

		$this->load->view('competencias/index', $data);
	}
	public function adicionar_competencia_cargo () {
        $this->http_method('POST');

        $data = [
            'competencia_id' => $this->input->post('competencia') ?? '',
            'cargo_id' => $this->input->post('cargo') ?? '',
        ];

        $this->form_validation->set_rules('competencia', 'competencia', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('cargo', 'cargo', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/competencias');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->competencia_cargo_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/competencias');
		}
    }
	public function editar_competencia_cargo ($id) {
        $this->http_method('POST');
		$this->Psl_plan_sucess_lideranca_model->competencia_cargo_first($id);

        $data = [
            'competencia_id' => $this->input->post('e_competencia') ?? '',
            'cargo_id' => $this->input->post('e_cargo') ?? '',
        ];

        $this->form_validation->set_rules('e_competencia', 'competencia', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_cargo', 'cargo', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/competencias');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->competencia_cargo_update($data, $id);
			set_alert('success',"Actualizar com sucesso");
			redirect('plan_sucess_lideranca/competencias');
		}
    }
	public function competencia_cargo_delete ($id) {
		$this->Psl_plan_sucess_lideranca_model->competencia_cargo_first($id);
		$this->Psl_plan_sucess_lideranca_model->competencia_cargo_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('plan_sucess_lideranca/competencias');
	}



	public function competencias_avaliacao2() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Avaliacao');
		$data['staff_list'] = $this->Psl_plan_sucess_lideranca_model->staffs_admin();
        $data['staffs'] = $this->Psl_plan_sucess_lideranca_model->staffs();
        $data['potencial'] = $this->Psl_plan_sucess_lideranca_model->get_potencial();
		$data['avaliacao_competencias'] = $this->Psl_plan_sucess_lideranca_model->avaliacao_competencias_get(2);

		$data['avaliacao_nivel'] = $this->Psl_plan_sucess_lideranca_model->avaliacao_nivel_get();

		$this->load->view('competencias/index_avaliacao2', $data);
	}
	public function adicionar_avaliacao_nivel () {
        $this->http_method('POST');

        $data = [
            'avaliacao_competencia_id' => $this->input->post('avaliacao_competencias') ?? '',
            'potencial_id' => $this->input->post('potencial') ?? '',
        ];

        $this->form_validation->set_rules('avaliacao_competencias', 'avaliacao_competencias', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('potencial', 'potencial', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/competencias_avaliacao2');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->avaliacao_nivel_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/competencias_avaliacao2');
		}
    }
	public function editar_avaliacao_nivel ($id) {
        $this->http_method('POST');
		$this->Psl_plan_sucess_lideranca_model->avaliacao_nivel_first($id);

        $data = [
            'avaliacao_competencia_id' => $this->input->post('e_avaliacao_competencias') ?? '',
            'potencial_id' => $this->input->post('e_potencial') ?? '',
        ];

        $this->form_validation->set_rules('e_avaliacao_competencias', 'avaliacao_competencias', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_potencial', 'potencial', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/competencias_avaliacao2');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->avaliacao_nivel_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('plan_sucess_lideranca/competencias_avaliacao2');
		}
    }
	public function avaliacao_nivel_delete ($id) {
		$this->Psl_plan_sucess_lideranca_model->avaliacao_nivel_first($id);
		$this->Psl_plan_sucess_lideranca_model->avaliacao_nivel_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('plan_sucess_lideranca/competencias_avaliacao2');
	}




	public function competencias_aquisicao() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Aquisicao');

		$data['staff_list'] = $this->Psl_plan_sucess_lideranca_model->staffs_admin();
        $data['staffs'] = $this->Psl_plan_sucess_lideranca_model->staffs();
        $data['status'] = $this->Psl_plan_sucess_lideranca_model->get_status();
		$data['competencia'] = $this->Psl_plan_sucess_lideranca_model->get_competencia();

		$data['plano_aquisicao_competencia'] = $this->Psl_plan_sucess_lideranca_model->plano_aquisicao_competencia_get();

		$this->load->view('competencias/index_aquisicao', $data);
	}
	public function adicionar_plano_aquisicao_competencia () {
        $this->http_method('POST');

        $data = [
			'status_id' => 1,
            'staff_id' => $this->input->post('funcionario') ?? '',
            'competencia_id' => $this->input->post('competencia') ?? '',
            'data_prevista' => $this->input->post('data_prevista') ?? '',
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('funcionario', 'funcionario', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('competencia', 'competencia', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('data_prevista', 'data_prevista', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/competencias_aquisicao');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->plano_aquisicao_competencia_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/competencias_aquisicao');
		}
    }
	public function editar_plano_aquisicao_competencia ($id) {
        $this->http_method('POST');
		$this->Psl_plan_sucess_lideranca_model->plano_aquisicao_competencia_first($id);

        $data = [
            'staff_id' => $this->input->post('e_funcionario') ?? '',
            'competencia_id' => $this->input->post('e_competencia') ?? '',
            'data_prevista' => $this->input->post('e_data_prevista') ?? '',
			'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('e_funcionario', 'funcionario', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_competencia', 'competencia', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_data_prevista', 'data_prevista', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/competencias_aquisicao');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->plano_aquisicao_competencia_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('plan_sucess_lideranca/competencias_aquisicao');
		}
    }
	public function plano_aquisicao_competencia_delete ($id) {
		$this->Psl_plan_sucess_lideranca_model->plano_aquisicao_competencia_first($id);
		$this->Psl_plan_sucess_lideranca_model->plano_aquisicao_competencia_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('plan_sucess_lideranca/competencias_aquisicao');
	}
	public function plano_aquisicao_competencia_aprovar($id) {
		$vf = $this->Psl_plan_sucess_lideranca_model->plano_aquisicao_competencia_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/competencias_aquisicao');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/competencias_aquisicao');
		}
		$this->Psl_plan_sucess_lideranca_model->plano_aquisicao_competencia_update(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('plan_sucess_lideranca/competencias_aquisicao');
    }
    public function plano_aquisicao_competencia_rejeitar($id) {
        $vf = $this->Psl_plan_sucess_lideranca_model->plano_aquisicao_competencia_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/competencias_aquisicao');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/competencias_aquisicao');
		}
		$this->Psl_plan_sucess_lideranca_model->avaliacao_lideranca_update(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('plan_sucess_lideranca/competencias_aquisicao');
    }




	public function competencias_visualizar_competencias($id) {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Visualizar');
		$data['cargo'] = $this->Psl_plan_sucess_lideranca_model->competencia_cargo_first($id);
		$this->load->view('competencias/visualizar_competencias', $data);
	}

	public function competencias_visualizar_avaliacao($id) {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Visualizar');
		$data['av'] = $this->Psl_plan_sucess_lideranca_model->avaliacao_nivel_first($id);
		$this->load->view('competencias/visualizar_avaliacao', $data);
	}

	public function competencias_visualizar_aquisicao($id) {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Visualizar');
		$data['aquisicao'] = $this->Psl_plan_sucess_lideranca_model->plano_aquisicao_competencia_first($id);;
		$this->load->view('competencias/visualizar_aquisicao', $data);
	}

	/**
	 * Tela de mentoria_coaching
	 */
	public function mentoria_coaching() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('mentoria_coaching');
		$data['staff_list'] = $this->Psl_plan_sucess_lideranca_model->staffs_admin();
        $data['staffs'] = $this->Psl_plan_sucess_lideranca_model->staffs();
        $data['status'] = $this->Psl_plan_sucess_lideranca_model->get_status();

        $data['mentoria'] = $this->Psl_plan_sucess_lideranca_model->mentoria_get();
        $data['mentoria_total'] = $this->Psl_plan_sucess_lideranca_model->mentoria_total();
        $data['mentoria_pendente'] = $this->Psl_plan_sucess_lideranca_model->mentoria_total(1);
        $data['mentoria_aprovados'] = $this->Psl_plan_sucess_lideranca_model->mentoria_total(2);
        $data['mentoria_rejeitados'] = $this->Psl_plan_sucess_lideranca_model->mentoria_total(3);

		$this->load->view('mentoria_coaching/index', $data);
	}
	public function adicionar_mentoria () {
        $this->http_method('POST');

        $data = [
			'status_id' => 1,
            'mentor_id' => $this->input->post('mentor') ?? '',
            'mentorado_id' => $this->input->post('mentorado') ?? '',
            'feedback' => $this->input->post('feedback') ?? '',
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('mentor', 'mentor', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('mentorado', 'mentorado', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('feedback', 'feedback', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

		if ($data['mentor_id'] == $data['mentorado_id']) {
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/mentoria_coaching');
		}
        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/mentoria_coaching');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->mentoria_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/mentoria_coaching');
		}
    }
	public function editar_mentoria ($id) {
        $this->http_method('POST');
		$this->Psl_plan_sucess_lideranca_model->mentoria_first($id);

        $data = [
            'mentor_id' => $this->input->post('e_mentor') ?? '',
            'mentorado_id' => $this->input->post('e_mentorado') ?? '',
            'feedback' => $this->input->post('e_feedback') ?? '',
			'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('e_mentor', 'mentor', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_mentorado', 'mentorado', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_feedback', 'feedback', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

		if ($data['mentor_id'] == $data['mentorado_id']) {
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/mentoria_coaching');
		}
        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/mentoria_coaching');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->mentoria_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('plan_sucess_lideranca/mentoria_coaching');
		}
    }
	public function mentoria_aprovar($id) {
		$vf = $this->Psl_plan_sucess_lideranca_model->mentoria_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/mentoria_coaching');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/mentoria_coaching');
		}
		$this->Psl_plan_sucess_lideranca_model->mentoria_update(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('plan_sucess_lideranca/mentoria_coaching');
    }
    public function mentoria_rejeitar($id) {
        $vf = $this->Psl_plan_sucess_lideranca_model->mentoria_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/mentoria_coaching');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/mentoria_coaching');
		}
		$this->Psl_plan_sucess_lideranca_model->mentoria_update(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('plan_sucess_lideranca/mentoria_coaching');
    }
	public function mentoria_delete ($id) {
		$this->Psl_plan_sucess_lideranca_model->mentoria_first($id);
		$this->Psl_plan_sucess_lideranca_model->mentoria_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('plan_sucess_lideranca/mentoria_coaching');
	}




	public function mentoria_coaching_coaching() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Coaching');
		$data['staff_list'] = $this->Psl_plan_sucess_lideranca_model->staffs_admin();
        $data['staffs'] = $this->Psl_plan_sucess_lideranca_model->staffs();
        $data['status'] = $this->Psl_plan_sucess_lideranca_model->get_status();

        $data['coaching'] = $this->Psl_plan_sucess_lideranca_model->coaching_get();

		$this->load->view('mentoria_coaching/index_coaching', $data);
	}
	public function adicionar_coaching () {
        $this->http_method('POST');

        $data = [
			'status_id' => 1,
            'coach_id' => $this->input->post('coach') ?? '',
            'staff_id' => $this->input->post('funcionario') ?? '',
            'objetivo' => $this->input->post('objetivo') ?? '',
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('coach', 'coach', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('funcionario', 'funcionario', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('objetivo', 'objetivo', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

		if ($data['coach_id'] == $data['staff_id']) {
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/mentoria_coaching_coaching');
		}
        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/mentoria_coaching_coaching');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->coaching_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/mentoria_coaching_coaching');
		}
    }
	public function editar_coaching ($id) {
        $this->http_method('POST');
		$this->Psl_plan_sucess_lideranca_model->coaching_first($id);

        $data = [
            'coach_id' => $this->input->post('e_coach') ?? '',
            'staff_id' => $this->input->post('e_funcionario') ?? '',
            'objetivo' => $this->input->post('e_objetivo') ?? '',
			'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('e_coach', 'coach', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_funcionario', 'funcionario', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_objetivo', 'objetivo', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

		if ($data['coach_id'] == $data['staff_id']) {
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/mentoria_coaching_coaching');
		}
        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/mentoria_coaching_coaching');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->coaching_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('plan_sucess_lideranca/mentoria_coaching_coaching');
		}
    }
	public function coaching_aprovar($id) {
		$vf = $this->Psl_plan_sucess_lideranca_model->coaching_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/mentoria_coaching_coaching');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/mentoria_coaching_coaching');
		}
		$this->Psl_plan_sucess_lideranca_model->coaching_update(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('plan_sucess_lideranca/mentoria_coaching_coaching');
    }
    public function coaching_rejeitar($id) {
        $vf = $this->Psl_plan_sucess_lideranca_model->coaching_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/mentoria_coaching_coaching');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/mentoria_coaching_coaching');
		}
		$this->Psl_plan_sucess_lideranca_model->coaching_update(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('plan_sucess_lideranca/mentoria_coaching_coaching');
    }
	public function coaching_delete ($id) {
		$this->Psl_plan_sucess_lideranca_model->coaching_first($id);
		$this->Psl_plan_sucess_lideranca_model->coaching_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('plan_sucess_lideranca/mentoria_coaching_coaching');
	}





	public function mentoria_coaching_feedback() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Feedback');
		$data['staff_list'] = $this->Psl_plan_sucess_lideranca_model->staffs_admin();
        $data['staffs'] = $this->Psl_plan_sucess_lideranca_model->staffs();
        $data['status'] = $this->Psl_plan_sucess_lideranca_model->get_status();

        $data['feedback_lideranca'] = $this->Psl_plan_sucess_lideranca_model->feedback_lideranca_get();

		$this->load->view('mentoria_coaching/index_feedback', $data);
	}
	public function adicionar_feedback_lideranca () {
        $this->http_method('POST');

        $data = [
            'mentor_id' => $this->input->post('mentor') ?? '',
            'staff_id' => $this->input->post('funcionario') ?? '',
            'data_feedback' => $this->input->post('data_feedback') ?? '',
            'comentario' => $this->input->post('comentario') ?? '',
        ];

        $this->form_validation->set_rules('mentor', 'mentor', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('funcionario', 'funcionario', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('data_feedback', 'data_feedback', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('comentario', 'comentario', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/mentoria_coaching_feedback');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->feedback_lideranca_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/mentoria_coaching_feedback');
		}
    }
	public function editar_feedback_lideranca ($id) {
        $this->http_method('POST');
		$this->Psl_plan_sucess_lideranca_model->feedback_lideranca_first($id);

        $data = [
            'mentor_id' => $this->input->post('mentor') ?? '',
            'staff_id' => $this->input->post('funcionario') ?? '',
            'data_feedback' => $this->input->post('data_feedback') ?? '',
            'comentario' => $this->input->post('comentario') ?? '',
        ];

        $this->form_validation->set_rules('mentor', 'mentor', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('funcionario', 'funcionario', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('data_feedback', 'data_feedback', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('comentario', 'comentario', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/mentoria_coaching_feedback');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->feedback_lideranca_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('plan_sucess_lideranca/mentoria_coaching_feedback');
		}
    }
	public function feedback_lideranca_delete ($id) {
		$this->Psl_plan_sucess_lideranca_model->feedback_lideranca_first($id);
		$this->Psl_plan_sucess_lideranca_model->feedback_lideranca_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('plan_sucess_lideranca/mentoria_coaching_feedback');
	}

	public function mentoria_visualizar_mentoria($id) {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Visualizr');
		$data['mentoria'] = $this->Psl_plan_sucess_lideranca_model->mentoria_first($id);
		$this->load->view('mentoria_coaching/visualizar_mentoria', $data);
	}

	public function mentoria_visualizar_coaching($id) {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Visualizr');
		$data['coaching'] = $this->Psl_plan_sucess_lideranca_model->coaching_first($id);
		$this->load->view('mentoria_coaching/visualizar_coaching', $data);
	}

	public function mentoria_visualizar_feedback($id) {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Visualizr');
		$data['feedback'] = $this->Psl_plan_sucess_lideranca_model->feedback_lideranca_first($id);
		$this->load->view('mentoria_coaching/visualizar_feedback', $data);
	}

	/***********************************************************************
	 * Telas de analise_risco
	 **********************************************************************/
	public function matriz_risco() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Matriz de Risco');
		$data['risco_sucessao'] = $this->Psl_plan_sucess_lideranca_model->risco_sucessao_get();

		$data['impacto'] = $this->Psl_plan_sucess_lideranca_model->get_impacto();
		$data['nivel_risco'] = $this->Psl_plan_sucess_lideranca_model->get_nivel_risco();

		$this->load->view('analise_risco/index_matriz_risco', $data);
	}
	 public function analise_risco_resultado() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Analise_risco Resultado');
		$data['risco_sucessao'] = $this->Psl_plan_sucess_lideranca_model->risco_sucessao_get();

		$this->load->view('analise_risco/index_resultado', $data);
	}
	 public function analise_risco() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('analise_risco');
		$data['cargos'] = $this->Psl_plan_sucess_lideranca_model->cargos_get();
		$data['impacto'] = $this->Psl_plan_sucess_lideranca_model->get_impacto();
		$data['nivel_risco'] = $this->Psl_plan_sucess_lideranca_model->get_nivel_risco();

		$data['risco_sucessao'] = $this->Psl_plan_sucess_lideranca_model->risco_sucessao_get();

		$this->load->view('analise_risco/index', $data);
	}
	public function adicionar_risco_sucessao () {
        $this->http_method('POST');

        $data = [
            'cargo_id' => $this->input->post('cargo') ?? '',
            'impacto_id' => $this->input->post('impacto') ?? '',
            'nivel_risco_id' => $this->input->post('nivel_risco') ?? '',
            'plano_contingencia' => $this->input->post('plano_contingencia') ?? '',
        ];

        $this->form_validation->set_rules('cargo', 'cargo', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('impacto', 'impacto', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('nivel_risco', 'nivel_risco', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('plano_contingencia', 'plano_contingencia', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/analise_risco');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->risco_sucessao_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/analise_risco');
		}
    }
	public function editar_risco_sucessao ($id) {
        $this->http_method('POST');
		$this->Psl_plan_sucess_lideranca_model->risco_sucessao_first($id);

        $data = [
            'cargo_id' => $this->input->post('e_cargo') ?? '',
            'impacto_id' => $this->input->post('e_impacto') ?? '',
            'nivel_risco_id' => $this->input->post('e_nivel_risco') ?? '',
            'plano_contingencia' => $this->input->post('e_plano_contingencia') ?? '',
        ];

        $this->form_validation->set_rules('e_cargo', 'cargo', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_impacto', 'impacto', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_nivel_risco', 'nivel_risco', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_plano_contingencia', 'plano_contingencia', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/analise_risco');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->risco_sucessao_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('plan_sucess_lideranca/analise_risco');
		}
    }
	public function risco_sucessao_delete ($id) {
		$this->Psl_plan_sucess_lideranca_model->risco_sucessao_first($id);
		$this->Psl_plan_sucess_lideranca_model->risco_sucessao_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('plan_sucess_lideranca/analise_risco');
	}

	public function analise_risco_impacto() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Impacto');
		$data['impacto'] = $this->Psl_plan_sucess_lideranca_model->get_impacto();
		$data['staffs'] = $this->Psl_plan_sucess_lideranca_model->staffs();

		$data['impacto_perda_talento'] = $this->Psl_plan_sucess_lideranca_model->impacto_perda_talento_get();
		$this->load->view('analise_risco/index_impacto', $data);
	}
	public function adicionar_impacto_perda_talento () {
        $this->http_method('POST');

        $data = [
            'staff_id' => $this->input->post('funcionario') ?? '',
            'impacto_id' => $this->input->post('impacto') ?? '',
            'sugestao_mitigacao' => $this->input->post('sugestao_mitigacao') ?? '',
        ];

        $this->form_validation->set_rules('funcionario', 'funcionario', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('impacto', 'impacto', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('sugestao_mitigacao', 'sugestao_mitigacao', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/analise_risco_impacto');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->impacto_perda_talento_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/analise_risco_impacto');
		}
    }
	public function editar_impacto_perda_talento ($id) {
        $this->http_method('POST');
		$this->Psl_plan_sucess_lideranca_model->impacto_perda_talento_first($id);

        $data = [
            'staff_id' => $this->input->post('e_funcionario') ?? '',
            'impacto_id' => $this->input->post('e_impacto') ?? '',
            'sugestao_mitigacao' => $this->input->post('e_sugestao_mitigacao') ?? '',
        ];

        $this->form_validation->set_rules('e_funcionario', 'funcionario', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_impacto', 'impacto', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_sugestao_mitigacao', 'sugestao_mitigacao', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/analise_risco_impacto');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->impacto_perda_talento_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('plan_sucess_lideranca/analise_risco_impacto');
		}
    }
	public function impacto_perda_talento_delete ($id) {
		$this->Psl_plan_sucess_lideranca_model->impacto_perda_talento_first($id);
		$this->Psl_plan_sucess_lideranca_model->impacto_perda_talento_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('plan_sucess_lideranca/analise_risco_impacto');
	}

	public function analise_visualizar_analise($id) {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Visualizar');
		$data['riscos'] = $this->Psl_plan_sucess_lideranca_model->risco_sucessao_first($id);
		$this->load->view('analise_risco/visualizar_analise', $data);
	}

	public function analise_visualizar_impacto($id) {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Visualizar');
		$data['impacto'] = $this->Psl_plan_sucess_lideranca_model->impacto_perda_talento_first($id);
		$this->load->view('analise_risco/visualizar_impacto', $data);
	}

	/****************************************************************************
	 * Telas de engajamento
	 ***************************************************************************/
	public function engajamento_resultado() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('engajamento');
		$data['estrategia_engajamento'] = $this->Psl_plan_sucess_lideranca_model->estrategia_engajamento_get(2);

		$this->load->view('engajamento/index_resultado', $data);
	}
	 public function engajamento() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('engajamento');
		$data['staff_list'] = $this->Psl_plan_sucess_lideranca_model->staffs_admin();
		$data['staffs'] = $this->Psl_plan_sucess_lideranca_model->staffs();
        $data['status'] = $this->Psl_plan_sucess_lideranca_model->get_status();
        $data['total'] = $this->Psl_plan_sucess_lideranca_model->estrategia_engajamento_total();
        $data['pendente'] = $this->Psl_plan_sucess_lideranca_model->estrategia_engajamento_total(1);
        $data['aprovado'] = $this->Psl_plan_sucess_lideranca_model->estrategia_engajamento_total(2);
        $data['rejeitado'] = $this->Psl_plan_sucess_lideranca_model->estrategia_engajamento_total(3);
		$data['talentos'] = $this->Psl_plan_sucess_lideranca_model->talento_get(2);

		$data['estrategia_engajamento'] = $this->Psl_plan_sucess_lideranca_model->estrategia_engajamento_get();
		$this->load->view('engajamento/index', $data);
	}
	public function adicionar_estrategia_engajamento () {
        $this->http_method('POST');

        $data = [
			'status_id' => 1,
            'talento_id' => $this->input->post('talento') ?? '',
            'estrategia' => $this->input->post('estrategia') ?? '',
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('talento', 'talento', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('estrategia', 'estrategia', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/engajamento');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->estrategia_engajamento_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/engajamento');
		}
    }
	public function editar_estrategia_engajamento ($id) {
        $this->http_method('POST');
		$this->Psl_plan_sucess_lideranca_model->estrategia_engajamento_first($id);

        $data = [
            'talento_id' => $this->input->post('e_talento') ?? '',
            'estrategia' => $this->input->post('e_estrategia') ?? '',
			'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('e_talento', 'talento', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_estrategia', 'estrategia', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/engajamento');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->estrategia_engajamento_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('plan_sucess_lideranca/engajamento');
		}
    }
	public function estrategia_engajamento_aprovar($id) {
		$vf = $this->Psl_plan_sucess_lideranca_model->estrategia_engajamento_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/engajamento');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/engajamento');
		}
		$this->Psl_plan_sucess_lideranca_model->estrategia_engajamento_update(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('plan_sucess_lideranca/engajamento');
    }
    public function estrategia_engajamento_rejeitar($id) {
        $vf = $this->Psl_plan_sucess_lideranca_model->estrategia_engajamento_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_sucess_lideranca/engajamento');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('plan_sucess_lideranca/engajamento');
		}
		$this->Psl_plan_sucess_lideranca_model->estrategia_engajamento_update(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('plan_sucess_lideranca/engajamento');
    }
	public function estrategia_engajamento_delete ($id) {
		$this->Psl_plan_sucess_lideranca_model->estrategia_engajamento_first($id);
		$this->Psl_plan_sucess_lideranca_model->estrategia_engajamento_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('plan_sucess_lideranca/engajamento');
	}

	public function engajamento_programa() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Programa');
		$data['staffs'] = $this->Psl_plan_sucess_lideranca_model->staffs();
		$data['estrategia_engajamento'] = $this->Psl_plan_sucess_lideranca_model->estrategia_engajamento_get(2);

		$data['programa_retencao'] = $this->Psl_plan_sucess_lideranca_model->programa_retencao_get();
		$this->load->view('engajamento/index_programa', $data);
	}
	public function adicionar_programa_retencao () {
        $this->http_method('POST');

        $data = [
            'estrategia_engajamento_id' => $this->input->post('estrategia_engajamento') ?? '',
            'beneficio' => $this->input->post('beneficio') ?? '',
            'feedback' => $this->input->post('feedback') ?? '',
        ];

        $this->form_validation->set_rules('estrategia_engajamento', 'estrategia_engajamento', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('beneficio', 'beneficio', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('feedback', 'feedback', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/engajamento_programa');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->programa_retencao_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/engajamento_programa');
		}
    }
	public function editar_programa_retencao ($id) {
        $this->http_method('POST');
		$this->Psl_plan_sucess_lideranca_model->programa_retencao_first($id);

        $data = [
            'estrategia_engajamento_id' => $this->input->post('e_estrategia_engajamento') ?? '',
            'beneficio' => $this->input->post('e_beneficio') ?? '',
            'feedback' => $this->input->post('e_feedback') ?? '',
        ];

        $this->form_validation->set_rules('e_estrategia_engajamento', 'estrategia_engajamento', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_beneficio', 'beneficio', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_feedback', 'feedback', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('plan_sucess_lideranca/engajamento_programa');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->programa_retencao_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('plan_sucess_lideranca/engajamento_programa');
		}
    }
	public function programa_retencao_delete ($id) {
		$this->Psl_plan_sucess_lideranca_model->programa_retencao_first($id);
		$this->Psl_plan_sucess_lideranca_model->programa_retencao_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('plan_sucess_lideranca/engajamento_programa');
	}




	public function engajamento_visualizar_engajamento($id) {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Visualizar');
		$data['angajamento'] = $this->Psl_plan_sucess_lideranca_model->estrategia_engajamento_first($id);
		$this->load->view('engajamento/visualizar_engajamento', $data);
	}

	public function engajamento_visualizar_programa($id) {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('Visualizar');
		$data['programa'] = $this->Psl_plan_sucess_lideranca_model->programa_retencao_first($id);
		$this->load->view('engajamento/visualizar_programa', $data);
	}


	/**
	 * Tela de configuracoes
	 */
	public function configuracoes() {
		if (!has_permission('plan_sucess_lideranca', '', 'edit') && !is_admin()) {
			access_denied('plan_sucess_lideranca');
		}
		$data['title'] = _l('configuracoes');

		$data['group'] = $this->input->get('group');
		$data['tab'][] = 'desempenho';
		$data['tab'][] = 'potencial';
		$data['tab'][] = 'competencia';
		$data['tab'][] = 'status';
		$data['tab'][] = 'nivel_critico';
		$data['tab'][] = 'feedback';
		$data['tab'][] = 'impacto';
		$data['tab'][] = 'nivel_risco';

		if ($data['group'] == '') {
			$data['title'] = _l('desempenhos');
			$data['group'] = 'desempenho';
			$data['desempenhos'] = $this->Psl_plan_sucess_lideranca_model->get_desempenho();
		} elseif ($data['group'] == 'desempenho') {
			$data['title'] = _l('desempenhos');
			$data['desempenhos'] = $this->Psl_plan_sucess_lideranca_model->get_desempenho();
		} elseif ($data['group'] == 'potencial') {
			$data['title'] = _l('potenciais');
			$data['potencial'] = $this->Psl_plan_sucess_lideranca_model->get_potencial();
		} elseif ($data['group'] == 'competencia') {
			$data['title'] = _l('competencias');
			$data['competencia'] = $this->Psl_plan_sucess_lideranca_model->get_competencia();
		} elseif ($data['group'] == 'status') {
			$data['title'] = _l('status');
			$data['status'] = $this->Psl_plan_sucess_lideranca_model->get_status();
		} elseif ($data['group'] == 'nivel_critico') {
			$data['title'] = _l('nivel_critico');
			$data['nivel_critico'] = $this->Psl_plan_sucess_lideranca_model->get_nivel_critico();
		} elseif ($data['group'] == 'feedback') {
			$data['title'] = _l('feedback');
			$data['feedback'] = $this->Psl_plan_sucess_lideranca_model->get_feedback();
		} elseif ($data['group'] == 'impacto') {
			$data['title'] = _l('impacto');
			$data['impacto'] = $this->Psl_plan_sucess_lideranca_model->get_impacto();
		} elseif ($data['group'] == 'nivel_risco') {
			$data['title'] = _l('nivel_risco');
			$data['nivel_risco'] = $this->Psl_plan_sucess_lideranca_model->get_nivel_risco();
		} else {
			set_alert('danger',"Configuração não encontrada");
			redirect('plan_sucess_lideranca/configuracoes?group=desempenho');
		}

		$data['tabs']['view'] = 'includes/' . $data['group'];

		$this->load->view('configuracoes/index', $data);
	}

	public function add_competencia () {
		$this->http_method('POST');

		$data = [
            'nome' => $this->input->post('competencia') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
        ];
		$this->form_validation->set_rules('competencia', _l('competencia'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('plan_sucess_lideranca/configuracoes?group=competencia');
        }
		else {
			$insert = $this->Psl_plan_sucess_lideranca_model->create_competencia($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('plan_sucess_lideranca/configuracoes?group=competencia');
		}
	}
	public function editar_competencia ($id) {
		$this->http_method('POST');
		$this->Psl_plan_sucess_lideranca_model->first_competencia($id);

		$data = [
            'nome' => $this->input->post('e_competencia') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
        ];
		$this->form_validation->set_rules('e_competencia', _l('competencia'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('plan_sucess_lideranca/configuracoes?group=competencia');
        }
		else {
			$this->Psl_plan_sucess_lideranca_model->update_competencia($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('plan_sucess_lideranca/configuracoes?group=competencia');
		}
	}
	public function delete_competencia ($id) {
		$this->Psl_plan_sucess_lideranca_model->first_competencia($id);
		$this->Psl_plan_sucess_lideranca_model->delete_competencia($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('plan_sucess_lideranca/configuracoes?group=competencia');
	}
}