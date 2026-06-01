<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Politicas Empresa Controller
 */
class Politicas_empresa extends AdminController {
	public function __construct() { 
		parent::__construct();
		$this->load->model('Pe_politica_empresa_model');
		$this->load->model('Pe_politica_model');
		$this->load->model('Pe_tipo_politica_model');
		$this->load->model('Pe_categoria_model');
		$this->load->model('Pe_area_model');
		$this->load->model('Pe_status_model');
		$this->load->model('Pe_nivel_hierarquico_model');
		$this->load->model('Pe_impacto_model');
		$this->load->model('Pe_tipo_procedimento_model');
		$this->load->model('pe_conformidade_model');
		$this->load->model('pe_procedimento_model');
		$this->load->model('Pe_risco_model');

		$this->load->library(['form_validation', 'upload']);
	}
	private function http_method ($vfMethod) {
        if ($_SERVER['REQUEST_METHOD'] !== $vfMethod) {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['status' => false, 'message' => 'Metodo não permitido']);
            exit;
        }
    }
	// Painel
	public function index() {
		$data['title'] = _l('pe_painel');

		$data['TotalPoliticas'] = $this->Pe_politica_model->getTotalPoliticas();
		$data['TotalConformidades'] = $this->Pe_politica_model->getTotalConformidades();
		$data['TotalTipoProcedimentos'] = $this->Pe_politica_model->getTotalTipoProcedimentos();
		$data['TotalProcedimentos'] = $this->Pe_politica_model->getTotalProcedimentos();
		$data['TotalRiscos'] = $this->Pe_politica_model->getTotalRiscos();

		$data['listaTotalPoliticaPorTipo'] = $this->Pe_politica_model->getTotalPoliticaPorTipo();
		// $data['status_totals_with_percentages'] = $this->pe_conformidade_model->get_status_totals_with_percentages();

		$data['totalConfByStatusPedente']  = $this->pe_conformidade_model->getTotalConformidadeByStatus("pendente");
		$data['totalConfByStatusAprovado'] = $this->pe_conformidade_model->getTotalConformidadeByStatus("aprovado");
		$data['totalConfByStatusRejeitado']   = $this->pe_conformidade_model->getTotalConformidadeByStatus("rejeitado");

		//$data['totalProcByStatusPedente']  = $this->pe_procedimento_model->getTotalProcedimentoByStatus("pendente");
		//$data['totalProcByStatusAprovado'] = $this->pe_procedimento_model->getTotalProcedimentoByStatus("aprovado");
		//$data['totalProcByStatusRejeitado']   = $this->pe_procedimento_model->getTotalProcedimentoByStatus("rejeitado");
		// var_dump($data["status_totals_with_percentages"]);die;
		$this->load->view('dashboard/index', $data);
	}

	/**
	 * Carregar as Politicas de Empresa
	 */
	public function listagem () {
		$data['title'] = _l('pe_politica_empresa');
		$data['tipos_politica'] = $this->Pe_tipo_politica_model->get();
		$data['categorias'] = $this->Pe_categoria_model->get();
		// $data['areas'] = $this->Pe_area_model->get();
		// $data['niveis_hierarquico'] = $this->Pe_nivel_hierarquico_model->get();
		$data['status'] = $this->Pe_status_model->get();
		$data['politicas'] = $this->Pe_politica_model->get();

		$data['conselhos'] = $this->db->get(db_prefix() . 'hr_conselhos')->result_array();
		$data['pelorios'] = $this->db->get(db_prefix() . 'hr_pelorios')->result_array();
		$data['direcoes'] = $this->db->get(db_prefix() . 'hr_direcoes')->result_array();
		$data['departamentos'] = $this->db->get(db_prefix() . 'departments')->result_array();
		$data['seccoes'] = $this->db->get(db_prefix() . 'hr_seccoes')->result_array();

		$data['staff_list'] = $this->Pe_politica_empresa_model->staffs_admin();

		// echo "<pre>";
		// var_dump($data['politicas'][1]["conselho"]);
		// return;
		$this->load->view('politicas/index', $data);
	}

	public function politica ($id) {
		$vfPolitica = $this->Pe_politica_model->first($id);
		$data['title'] = $vfPolitica['titulo'];
		$data['politica'] = $vfPolitica;

		$this->load->view('politica', $data);
	}

	public function add_politica() {
		$this->http_method('POST');

		$this->form_validation->set_rules('tipo_politica', _l('tipo_politica'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('categoria', _l('categoria'), 'required', ['required' => 'Preencha o campo {field}']);

		$this->form_validation->set_rules('conselho', _l('conselho'), 'required', ['required' => 'Preencha o campo {field}']);

		$this->form_validation->set_rules('titulo', 'Titulo', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', 'Descrição', 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			return redirect('politicas_empresa/listagem');
        }
		else {
			$file_upload = false;
			if (!empty($_FILES['arquivo']['name'])) {
				$conf_u['upload_path'] = FCPATH. 'modules/politicas_empresa/uploads/';
				$conf_u['allowed_types'] = 'jpg|png|jpeg|pdf|docx|doc';
				$conf_u['encrypt_name'] = TRUE;

				$this->upload->initialize($conf_u);
				if (!$this->upload->do_upload('arquivo')) {
					$dataView['title'] = _l('pe_nova_politica');
					$dataView['error'] = $this->upload->display_errors();

					set_alert('danger',"Houve algum erro, ao carregar o arquivo. Selecione um formato valíddo");
					return redirect('politicas_empresa/listagem');
				}
				else {
					$file_upload = TRUE;
					$upload_data = $this->upload->data();
				}
			}

			$data = [
				'staff_id' => get_staff_user_id(), // ID do Usuario Logado
				'tipo_politica_id' => $this->input->post('tipo_politica') ?? '',
				'categoria_id' => $this->input->post('categoria') ?? '',
				'conselho_id' => $this->input->post('conselho') ?? '',
				'pelorio_id' => $this->input->post('pelorio') ?? '',
				'direcao_id' => $this->input->post('direcao') ?? '',
				'departamento_id' => $this->input->post('departamento') ?? '',
				'seccao_id' => $this->input->post('seccao') ?? '',
				'status' => 'pendente',
				'titulo' => $this->input->post('titulo') ?? '',
				'descricao' => $this->input->post('descricao') ?? '',
				'arquivo' => $file_upload ? $upload_data['file_name'] : null,
				'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
			];

			$insert = $this->Pe_politica_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/listagem');
		}
	}

	public function politica_editar ($id) {
		$vfPolitica = $this->Pe_politica_model->first($id);
		$data['title'] = 'Editar Politica';

		$data['tipos_politica'] = $this->Pe_tipo_politica_model->get();
		$data['categorias'] = $this->Pe_categoria_model->get();
		// $data['areas'] = $this->Pe_area_model->get();
		// $data['niveis_hierarquico'] = $this->Pe_nivel_hierarquico_model->get();
		// $data['status'] = $this->Pe_status_model->get();


		$data['conselhos'] = $this->db->get(db_prefix() . 'hr_conselhos')->result_array();
		$data['pelorios'] = $this->db->get(db_prefix() . 'hr_pelorios')->result_array();
		$data['direcoes'] = $this->db->get(db_prefix() . 'hr_direcoes')->result_array();
		$data['departamentos'] = $this->db->get(db_prefix() . 'departments')->result_array();
		$data['seccoes'] = $this->db->get(db_prefix() . 'hr_seccoes')->result_array();

		$data['politica'] = $vfPolitica;

		$data['staff_list'] = $this->Pe_politica_empresa_model->staffs_admin();

		$this->load->view('politica_editar', $data);
	}
	public function actualizar_politica($id) {
		$this->http_method('POST');
		$vfPolitica = $this->Pe_politica_model->first($id);

		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('tipo_politica', _l('tipo_politica'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('categoria', _l('categoria'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('conselho', _l('conselho'), 'required', ['required' => 'Preencha o campo {field}']);
		// $this->form_validation->set_rules('nivel_hierarquico', _l('nivel_hierarquico'), 'required', ['required' => 'Preencha o campo {field}']);
		// $this->form_validation->set_rules('status', _l('status'), 'required', ['required' => 'Preencha o campo {field}']);

		$this->form_validation->set_rules('titulo', 'Titulo', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', 'Descrição', 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			return redirect('politicas_empresa/politica_editar/'.$id);
        }
		else {
			$data = [
				'staff_id' => get_staff_user_id(), // ID do Usuario Logado
				'tipo_politica_id' => $this->input->post('tipo_politica') ?? '',
				'categoria_id' => $this->input->post('categoria') ?? '',

				'conselho_id' => $this->input->post('conselho') ?? '',
				'pelorio_id' => $this->input->post('pelorio') ?? '',
				'direcao_id' => $this->input->post('direcao') ?? '',
				'departamento_id' => $this->input->post('departamento') ?? '',
				'seccao_id' => $this->input->post('seccao') ?? '',

				// 'area_id' => $this->input->post('area') ?? '',
				// 'nivel_hierarquico_id' => $this->input->post('nivel_hierarquico') ?? '',
				// 'status_id' => $this->input->post('status') ?? '',
				'titulo' => $this->input->post('titulo') ?? '',
				'descricao' => $this->input->post('descricao') ?? '',
				'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
			];
			if (!empty($_FILES['arquivo']['name'])) {
				$conf_u['upload_path'] = FCPATH. 'modules/politicas_empresa/uploads/';
				$conf_u['allowed_types'] = 'jpg|png|jpeg|pdf|docx|doc';
				$conf_u['encrypt_name'] = TRUE;

				$this->upload->initialize($conf_u);
				if (!$this->upload->do_upload('arquivo')) {
					$dataView['title'] = _l('pe_nova_politica');
					$dataView['error'] = $this->upload->display_errors();

					set_alert('danger',"Houve algum erro, ao carregar o arquivo. Selecione um formato valíddo");
					return redirect('politicas_empresa/politica_editar/'.$id);
				}
				else {
					$upload_data = $this->upload->data();

					$data['arquivo'] = $upload_data['file_name'];
				}
			}

			$update = $this->Pe_politica_model->update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/politica_editar/'.$id);
		}
	}
	public function delete_politica ($id) {
		$this->Pe_politica_model->first($id);
		$this->Pe_politica_model->delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('politicas_empresa/listagem');
	}
	public function status_aprovar ($id) {
		$vf = $this->Pe_politica_model->first($id);
		if ($vf['status'] != 'pendente') {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('politicas_empresa/politica/'.$id);
		}
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('politicas_empresa/politica/'.$id);
		}
		$this->Pe_politica_model->aprovar(['status' => 'aprovado'], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('politicas_empresa/politica/'.$id);
	}
	public function status_rejeitar ($id) {
		$vf = $this->Pe_politica_model->first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('politicas_empresa/politica/'.$id);
		}
		if ($vf['status'] != 'pendente') {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('politicas_empresa/politica/'.$id);
		}
		$this->Pe_politica_model->rejeitar(['status' => 'rejeitado'], $id);
		set_alert('success',"Politica Rejeitada.");
		return redirect('politicas_empresa/politica/'.$id);
	}

	public function configuracoes()
	{
		$this->load->model('staff_model');
		$data['group'] = $this->input->get('group');
		$data['title'] = _l('pe_configuracoes');
		$data['tab'][] = 'tipo_politica';
		$data['tab'][] = 'categoria';
		// $data['tab'][] = 'area';
		// $data['tab'][] = 'estado';
		// $data['tab'][] = 'nivel_hierarquico';
		$data['tab'][] = 'tipo_procedimento';
		$data['tab'][] = 'probabilidade';
		$data['tab'][] = 'impacto';
		// $data['tab'][] = 'norma';
		// $data['tab'][] = 'conselhos';
		// $data['tab'][] = 'pelorios';
		// $data['tab'][] = 'direcoes';
		// $data['tab'][] = 'departamentos';
		// $data['tab'][] = 'seccoes';

		if ($data['group'] == '') {
			$data['title'] = _l('tipo_politica');
			$data['group'] = 'tipo_politica';
			$data['tipos_politica'] = $this->Pe_tipo_politica_model->get();
		} elseif ($data['group'] == 'tipo_politica') {
			$data['title'] = _l('tipo_politica');
			$data['tipos_politica'] = $this->Pe_tipo_politica_model->get();
		} elseif ($data['group'] == 'categoria') {
			$data['title'] = _l('categoria');
			$data['categorias'] = $this->Pe_categoria_model->get();
		}
		elseif ($data['group'] == 'probabilidade') {
			$data['title'] = _l('probabilidade');
			$data['probabilidades'] = $this->Pe_politica_empresa_model->probabilidade_get();
		}
		// elseif ($data['group'] == 'area') {
		// 	$data['title'] = _l('area');
		// 	$data['areas'] = $this->Pe_area_model->get();
		// } elseif ($data['group'] == 'estado') {
		// 	$data['title'] = _l('estado');
		// 	$data['status'] = $this->Pe_status_model->get();
		// } elseif ($data['group'] == 'nivel_hierarquico') {
		// 	$data['title'] = _l('nivel_hierarquico');
		// 	$data['niveis_hierarquico'] = $this->Pe_nivel_hierarquico_model->get();
		// }
		elseif ($data['group'] == 'tipo_procedimento') {
			$data['title'] = _l('tipo_procedimento');
			$data['tipos_procedimento'] = $this->Pe_tipo_procedimento_model->get();
		} elseif ($data['group'] == 'probabilidade') {
			$data['title'] = _l('probabilidade');
			$data['probabilidade'] = [];
		} elseif ($data['group'] == 'impacto') {
			$data['title'] = _l('impacto');
			$data['impactos'] = $this->Pe_impacto_model->get();
		} elseif ($data['group'] == 'norma') {
			$data['title'] = _l('norma');
			$data['norma'] = [];
		}
		// elseif ($data['group'] == 'conselhos') {
		// 	$data['title'] = _l('conselhos');
		// 	$data['conselhos'] = $this->db->get(db_prefix() . 'hr_conselhos')->result_array();
		// } elseif ($data['group'] == 'pelorios') {
		// 	$data['title'] = _l('pelorios');
		// 	$data['conselhos'] = $this->db->get(db_prefix() . 'hr_conselhos')->result_array();
		// 	$data['pelorios'] = $this->Pe_politica_empresa_model->pelorios_get();
		// } elseif ($data['group'] == 'direcoes') {
		// 	$data['title'] = _l('direcoes');
		// 	$data['pelorios'] = $this->Pe_politica_empresa_model->pelorios_get();
		// 	$data['direcoes'] = $this->Pe_politica_empresa_model->direcao_get();
		// } elseif ($data['group'] == 'departamentos') {
		// 	$data['title'] = _l('departamentos');
		// 	$data['direcoes'] = $this->Pe_politica_empresa_model->direcao_get();
		// 	$data['departamentos'] = $this->Pe_politica_empresa_model->departamento_get();
		// } elseif ($data['group'] == 'seccoes') {
		// 	$data['title'] = _l('seccoes');
		// 	$data['departamentos'] = $this->Pe_politica_empresa_model->departamento_get();
		// 	$data['seccoes'] = $this->Pe_politica_empresa_model->seccao_get();
		// }
		else {
			set_alert('danger',"Definições não encontrada");
			redirect('politicas_empresa/configuracoes?group=tipo_politica');
		}

		$data['tabs']['view'] = 'includes/' . $data['group'];
		$this->load->view('configuracoes', $data);
	}

	public function add_tipo_politica () {
		$this->http_method('POST');

		$data = [
            'staff_id' => get_staff_user_id(), // ID do Usuario Logado
            'tipo_politica' => $this->input->post('tipo_politica') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
        ];
		$this->form_validation->set_rules('tipo_politica', _l('tipo_politica'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=tipo_politica');
        }
		else {
			$insert = $this->Pe_tipo_politica_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/configuracoes?group=tipo_politica');
		}
	}
	public function editar_tipo_politica ($id) {
		$this->http_method('POST');
		$this->Pe_tipo_politica_model->first($id);

		$data = [
            'tipo_politica' => $this->input->post('e_tipo_politica') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
        ];
		$this->form_validation->set_rules('e_tipo_politica', _l('tipo_politica'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=tipo_politica');
        }
		else {
			$this->Pe_tipo_politica_model->update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/configuracoes?group=tipo_politica');
		}
	}
	public function delete_tipo_politica ($id) {
		$this->Pe_tipo_politica_model->first($id);
		$this->Pe_tipo_politica_model->delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('politicas_empresa/configuracoes?group=tipo_politica');
	}

	public function add_categoria () {
		$this->http_method('POST');

		$data = [
            'staff_id' => get_staff_user_id(), // ID do Usuario Logado
            'categoria' => $this->input->post('categoria') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
        ];
		$this->form_validation->set_rules('categoria', _l('categoria'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=categoria');
        }
		else {
			$insert = $this->Pe_categoria_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/configuracoes?group=categoria');
		}
	}
	public function editar_categoria ($id) {
		$this->http_method('POST');
		$this->Pe_categoria_model->first($id);

		$data = [
            'categoria' => $this->input->post('e_categoria') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
        ];
		$this->form_validation->set_rules('e_categoria', _l('categoria'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=categoria');
        }
		else {
			$this->Pe_categoria_model->update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/configuracoes?group=categoria');
		}
	}
	public function delete_categoria ($id) {
		$this->Pe_categoria_model->first($id);
		$this->Pe_categoria_model->delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('politicas_empresa/configuracoes?group=categoria');
	}

	public function add_conselho () {
		$this->http_method('POST');
		$data = [
            'nome' => $this->input->post('conselho') ?? '',
        ];
		$this->form_validation->set_rules('conselho', _l('conselho'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=conselhos');
        }
		else {
			$insert = $this->Pe_politica_empresa_model->conselho_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/configuracoes?group=conselhos');
		}
	}
	public function editar_conselho ($id) {
		$this->http_method('POST');
		$this->Pe_politica_empresa_model->conselho_first($id);

		$data = [
            'nome' => $this->input->post('e_conselho') ?? '',
        ];
		$this->form_validation->set_rules('e_conselho', _l('conselho'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=conselhos');
        }
		else {
			$this->Pe_politica_empresa_model->conselho_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/configuracoes?group=conselhos');
		}
	}
	public function delete_conselho ($id) {
		$this->Pe_politica_empresa_model->conselho_first($id);
		$this->Pe_politica_empresa_model->conselho_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('politicas_empresa/configuracoes?group=conselhos');
	}

	public function add_pelorio () {
		$this->http_method('POST');
		$data = [
            'conselho_id' => $this->input->post('conselho') ?? '',
            'nome' => $this->input->post('pelorio') ?? '',
        ];
		$this->form_validation->set_rules('conselho', _l('conselho'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('pelorio', _l('pelorio'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=pelorios');
        }
		else {
			$insert = $this->Pe_politica_empresa_model->pelorio_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/configuracoes?group=pelorios');
		}
	}
	public function editar_pelorio ($id) {
		$this->http_method('POST');
		$this->Pe_politica_empresa_model->conselho_first($id);

		$data = [
            'conselho_id' => $this->input->post('e_conselho') ?? '',
            'nome' => $this->input->post('e_pelorio') ?? '',
        ];
		$this->form_validation->set_rules('e_conselho', _l('conselho'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_pelorio', _l('e_pelorio'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=pelorios');
        }
		else {
			$this->Pe_politica_empresa_model->pelorio_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/configuracoes?group=pelorios');
		}
	}
	public function delete_pelorio ($id) {
		$this->Pe_politica_empresa_model->pelorio_first($id);
		$this->Pe_politica_empresa_model->pelorio_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('politicas_empresa/configuracoes?group=pelorios');
	}

	public function add_direcao () {
		$this->http_method('POST');
		$data = [
            'pelorios_id' => $this->input->post('pelorio') ?? '',
            'nome' => $this->input->post('direcao') ?? '',
        ];
		$this->form_validation->set_rules('pelorio', _l('pelorio'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('direcao', _l('direcao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=direcoes');
        }
		else {
			$insert = $this->Pe_politica_empresa_model->direcao_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/configuracoes?group=direcoes');
		}
	}
	public function editar_direcao ($id) {
		$this->http_method('POST');
		$this->Pe_politica_empresa_model->direcao_first($id);

		$data = [
            'pelorios_id' => $this->input->post('e_pelorio') ?? '',
            'nome' => $this->input->post('e_direcao') ?? '',
        ];
		$this->form_validation->set_rules('e_pelorio', _l('Pelorio'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_direcao', _l('e_direcao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=direcoes');
        }
		else {
			$this->Pe_politica_empresa_model->direcao_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/configuracoes?group=direcoes');
		}
	}
	public function delete_direcao ($id) {
		$this->Pe_politica_empresa_model->direcao_first($id);
		$this->Pe_politica_empresa_model->direcao_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('politicas_empresa/configuracoes?group=direcoes');
	}

	public function add_departamento () {
		$this->http_method('POST');
		$data = [
            'direcoes_id' => $this->input->post('direcao') ?? '',
            'name' => $this->input->post('departamento') ?? '',
        ];
		$this->form_validation->set_rules('direcao', _l('direcao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('departamento', _l('departamento'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=departamentos');
        }
		else {
			$insert = $this->Pe_politica_empresa_model->departamento_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/configuracoes?group=departamentos');
		}
	}
	public function editar_departamento ($id) {
		$this->http_method('POST');
		$this->Pe_politica_empresa_model->departamento_first($id);

		$data = [
            'direcoes_id' => $this->input->post('e_direcao') ?? '',
            'name' => $this->input->post('e_departamento') ?? '',
        ];
		$this->form_validation->set_rules('e_direcao', _l('Direção'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_departamento', _l('e_departamento'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=departamentos');
        }
		else {
			$this->Pe_politica_empresa_model->departamento_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/configuracoes?group=departamentos');
		}
	}
	public function delete_departamento ($id) {
		$this->Pe_politica_empresa_model->departamento_first($id);
		$this->Pe_politica_empresa_model->departamento_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('politicas_empresa/configuracoes?group=departamentos');
	}

	public function add_seccao () {
		$this->http_method('POST');
		$data = [
            'departments_id' => $this->input->post('departamento') ?? '',
            'nome' => $this->input->post('seccao') ?? '',
        ];
		$this->form_validation->set_rules('departamento', _l('departamento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('seccao', _l('seccao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=seccoes');
        }
		else {
			$insert = $this->Pe_politica_empresa_model->seccao_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/configuracoes?group=seccoes');
		}
	}
	public function editar_seccao ($id) {
		$this->http_method('POST');
		$this->Pe_politica_empresa_model->seccao_first($id);
		$data = [
            'departments_id' => $this->input->post('e_departamento') ?? '',
            'nome' => $this->input->post('e_seccao') ?? '',
        ];
		$this->form_validation->set_rules('e_seccao', _l('Secção'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_departamento', _l('e_departamento'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=seccoes');
        }
		else {
			$this->Pe_politica_empresa_model->seccao_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/configuracoes?group=seccoes');
		}
	}
	public function delete_seccao ($id) {
		$this->Pe_politica_empresa_model->seccao_first($id);
		$this->Pe_politica_empresa_model->seccao_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('politicas_empresa/configuracoes?group=seccoes');
	}

	public function add_area () {
		$this->http_method('POST');

		$data = [
            'staff_id' => get_staff_user_id(), // ID do Usuario Logado
            'area' => $this->input->post('area') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
        ];
		$this->form_validation->set_rules('area', _l('area'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=area');
        }
		else {
			$insert = $this->Pe_area_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/configuracoes?group=area');
		}
	}
	public function editar_area ($id) {
		$this->http_method('POST');
		$this->Pe_area_model->first($id);

		$data = [
            'area' => $this->input->post('e_area') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
        ];
		$this->form_validation->set_rules('e_area', _l('area'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=area');
        }
		else {
			$this->Pe_area_model->update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/configuracoes?group=area');
		}
	}
	public function delete_area ($id) {
		$this->Pe_area_model->first($id);
		$this->Pe_area_model->delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('politicas_empresa/configuracoes?group=area');
	}

	public function add_status () {
		$this->http_method('POST');

		$data = [
            'staff_id' => get_staff_user_id(), // ID do Usuario Logado
            'status' => $this->input->post('status') ?? '',
        ];
		$this->form_validation->set_rules('status', _l('estado'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=estado');
        }
		else {
			$insert = $this->Pe_status_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/configuracoes?group=estado');
		}
	}
	public function editar_status ($id) {
		$this->http_method('POST');
		$this->Pe_status_model->first($id);

		$data = [
            'status' => $this->input->post('e_status') ?? '',
        ];
		$this->form_validation->set_rules('e_status', _l('estado'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=estado');
        }
		else {
			$this->Pe_status_model->update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/configuracoes?group=estado');
		}
	}
	public function delete_status ($id) {
		$this->Pe_status_model->first($id);
		$this->Pe_status_model->delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('politicas_empresa/configuracoes?group=estado');
	}

	public function add_nivel_hierarquico () {
		$this->http_method('POST');

		$data = [
            'staff_id' => get_staff_user_id(), // ID do Usuario Logado
            'nivel_hierarquico' => $this->input->post('nivel_hierarquico') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
        ];
		$this->form_validation->set_rules('nivel_hierarquico', _l('nivel_hierarquico'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=nivel_hierarquico');
        }
		else {
			$insert = $this->Pe_nivel_hierarquico_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/configuracoes?group=nivel_hierarquico');
		}
	}
	public function editar_nivel_hierarquico ($id) {
		$this->http_method('POST');
		$this->Pe_nivel_hierarquico_model->first($id);

		$data = [
            'nivel_hierarquico' => $this->input->post('e_nivel_hierarquico') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
        ];
		$this->form_validation->set_rules('e_nivel_hierarquico', _l('nivel_hierarquico'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=nivel_hierarquico');
        }
		else {
			$this->Pe_nivel_hierarquico_model->update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/configuracoes?group=nivel_hierarquico');
		}
	}
	public function delete_nivel_hierarquico ($id) {
		$this->Pe_nivel_hierarquico_model->first($id);
		$this->Pe_nivel_hierarquico_model->delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('politicas_empresa/configuracoes?group=nivel_hierarquico');
	}

	public function add_impacto () {
		$this->http_method('POST');

		$data = [
            'staff_id' => get_staff_user_id(), // ID do Usuario Logado
            'impacto' => $this->input->post('impacto') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
        ];
		$this->form_validation->set_rules('impacto', _l('impacto'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=impacto');
        }
		else {
			$insert = $this->Pe_impacto_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/configuracoes?group=impacto');
		}
	}
	public function editar_impacto ($id) {
		$this->http_method('POST');
		$this->Pe_impacto_model->first($id);

		$data = [
            'impacto' => $this->input->post('e_impacto') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
        ];
		$this->form_validation->set_rules('e_impacto', _l('impacto'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=impacto');
        }
		else {
			$this->Pe_impacto_model->update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/configuracoes?group=impacto');
		}
	}
	public function delete_impacto ($id) {
		$this->Pe_impacto_model->first($id);
		$this->Pe_impacto_model->delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('politicas_empresa/configuracoes?group=impacto');
	}

	public function add_tipo_procedimento () {
		$this->http_method('POST');

		$data = [
            'staff_id' => get_staff_user_id(), // ID do Usuario Logado
            'tipo_procedimento' => $this->input->post('tipo_procedimento') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
        ];
		$this->form_validation->set_rules('tipo_procedimento', _l('tipo_procedimento'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=tipo_procedimento');
        }
		else {
			$insert = $this->Pe_tipo_procedimento_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/configuracoes?group=tipo_procedimento');
		}
	}
	public function editar_tipo_procedimento ($id) {
		$this->http_method('POST');
		$this->Pe_tipo_procedimento_model->first($id);

		$data = [
            'tipo_procedimento' => $this->input->post('e_tipo_procedimento') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
        ];
		$this->form_validation->set_rules('e_tipo_procedimento', _l('tipo_procedimento'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=tipo_procedimento');
        }
		else {
			$this->Pe_tipo_procedimento_model->update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/configuracoes?group=tipo_procedimento');
		}
	}
	public function delete_tipo_procedimento ($id) {
		$this->Pe_tipo_procedimento_model->first($id);
		$this->Pe_tipo_procedimento_model->delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('politicas_empresa/configuracoes?group=tipo_procedimento');
	}

	public function add_probabilidade () {
		$this->http_method('POST');
		$data = [
            'valor_probabilidade' => $this->input->post('probabilidade') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
        ];
		$this->form_validation->set_rules('descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('probabilidade', _l('valor_probabilidade'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=probabilidade');
        }
		else {
			$insert = $this->Pe_politica_empresa_model->probabilidade_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/configuracoes?group=probabilidade');
		}
	}
	public function editar_probabilidade ($id) {
		$this->http_method('POST');
		$this->Pe_risco_model->nivel_first($id);

		$data = [
            'nivel_risco' => $this->input->post('e_nivel_risco') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
        ];
		$this->form_validation->set_rules('e_nivel_risco', _l('nivel_risco'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('politicas_empresa/configuracoes?group=nivel_risco');
        }
		else {
			$this->Pe_risco_model->nivel_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/configuracoes?group=nivel_risco');
		}
	}
	public function delete_probabilidade ($id) {
		$this->Pe_risco_model->nivel_first($id);
		$this->Pe_risco_model->nivel_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('politicas_empresa/configuracoes?group=nivel_risco');
	}
}