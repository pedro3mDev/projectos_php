<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Riscos Controller
 */
class Riscos extends AdminController {
	public function __construct() {
		parent::__construct();
		$this->load->model('Pe_politica_empresa_model');
		$this->load->model('Pe_politica_model');
		$this->load->model('Pe_tipo_politica_model');
		$this->load->model('Pe_categoria_model');
		$this->load->model('Pe_area_model');
		$this->load->model('Pe_status_model');
		$this->load->model('Pe_nivel_hierarquico_model');
		$this->load->model('Pe_conformidade_model');
		$this->load->model('Pe_impacto_model');
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
		$data['title'] = _l('pe_riscos');

		$data['impactos'] = $this->Pe_impacto_model->get();
		$data['politicas'] = $this->Pe_politica_model->get();
		$data['probabilidades'] = $this->Pe_politica_empresa_model->probabilidade_get();
		$data['staffs'] = $this->Pe_politica_empresa_model->staffs();

		$data['riscos'] = $this->Pe_risco_model->get();

		$data['staff_list'] = $this->Pe_politica_empresa_model->staffs_admin();

		$this->load->view('riscos/index', $data);
	}

	// Matriz de Risco
	public function matriz() {
		$data['impactos'] = $this->Pe_impacto_model->get();
		$data['politicas'] = $this->Pe_politica_model->get();
		$data['staffs'] = $this->Pe_politica_empresa_model->staffs();
		$data['probabilidades'] = $this->Pe_politica_empresa_model->probabilidade_get();

		$data['riscos'] = $this->Pe_risco_model->get_matriz_vertical();

		// var_dump($data['probabilidades']);
		// return;
		$this->load->view('riscos/matriz', $data);
	}

	public function add_risco() {
		$this->http_method('POST');
		// $this->form_validation->set_rules('staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('politica', _l('pe_politica'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('probabilidade', _l('probabilidade'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('impacto', _l('impacto'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', _l('description'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('medidas_metigacao', _l('medidas_metigacao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			echo validation_errors();
			return;
			set_alert('danger',"Preenchas os campos correctamente");
			return redirect('politicas_empresa/riscos');
        }
		else {
			$file_upload = false;
			if (!empty($_FILES['arquivo']['name'])) {
				$conf_u['upload_path'] = FCPATH. 'modules/politicas_empresa/uploads/';
				$conf_u['allowed_types'] = 'jpg|png|jpeg|pdf|docx|doc';
				$conf_u['encrypt_name'] = TRUE;

				$this->upload->initialize($conf_u);
				if (!$this->upload->do_upload('arquivo')) {
					// $dataView['title'] = _l('pe_nova_politica');
					// $dataView['error'] = $this->upload->display_errors();
					set_alert('danger',"Houve algum erro, ao carregar o arquivo. Selecione um formato valíddo");
					return redirect('politicas_empresa/riscos');
				}
				else {
					$file_upload = TRUE;
					$upload_data = $this->upload->data();
				}
			}

			$data = [
				'staff_id' => get_staff_user_id(), // ID do Usuario Logado
				// 'staff_risco_id' => $this->input->post('staff') ?? '',
				'politica_id' => $this->input->post('politica') ?? '',
				'impacto_id' => $this->input->post('impacto') ?? '',
				'probabilidade_id' => $this->input->post('probabilidade') ?? '',
				'descricao' => $this->input->post('descricao') ?? '',
				'medidas_metigacao' => $this->input->post('medidas_metigacao') ?? '',
				'arquivo' => $file_upload ? $upload_data['file_name'] : null,
				'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
			];

			$insert = $this->Pe_risco_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/riscos');
		}
	}
	public function delete_risco ($id) {
		$this->Pe_risco_model->first($id);
		$this->Pe_risco_model->delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('politicas_empresa/riscos');
	}

	public function risco ($id) {
		$vfrisco = $this->Pe_risco_model->first($id);
		$data['title'] = $vfrisco['titulo'];
		$data['risco'] = $vfrisco;

		$this->load->view('riscos/risco', $data);
	}
	public function risco_editar ($id) {
		$vfrisco = $this->Pe_risco_model->first($id);
		$data['title'] = _l('pe_editar');
		$data['risco'] = $vfrisco;

		$data['impactos'] = $this->Pe_impacto_model->get();
		$data['politicas'] = $this->Pe_politica_model->get();
		$data['staffs'] = $this->Pe_politica_empresa_model->staffs();
		$data['probabilidades'] = $this->Pe_politica_empresa_model->probabilidade_get();

		$data['staff_list'] = $this->Pe_politica_empresa_model->staffs_admin();

		$this->load->view('riscos/risco_editar', $data);
	}
	public function actualizar_risco($id) {
		$this->http_method('POST');
		$this->Pe_risco_model->first($id);

		// $this->form_validation->set_rules('staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('politica', _l('pe_politica'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('impacto', _l('impacto'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('probabilidade', _l('probabilidade'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', _l('description'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('medidas_metigacao', _l('medidas_metigacao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			return redirect('politicas_empresa/riscos/risco_editar/'.$id);
        }
		else {
			$data = [
				// 'staff_risco_id' => $this->input->post('staff') ?? '',
				'politica_id' => $this->input->post('politica') ?? '',
				'impacto_id' => $this->input->post('impacto') ?? '',
				'probabilidade_id' => $this->input->post('probabilidade') ?? '',
				'descricao' => $this->input->post('descricao') ?? '',
				'medidas_metigacao' => $this->input->post('medidas_metigacao') ?? '',
				'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
			];
			if (!empty($_FILES['arquivo']['name'])) {
				$conf_u['upload_path'] = FCPATH. 'modules/politicas_empresa/uploads/';
				$conf_u['allowed_types'] = 'jpg|png|jpeg|pdf|docx|doc';
				$conf_u['encrypt_name'] = TRUE;

				$this->upload->initialize($conf_u);
				if (!$this->upload->do_upload('arquivo')) {
					// $dataView['title'] = _l('pe_nova_politica');
					// $dataView['error'] = $this->upload->display_errors();
					set_alert('danger',"Houve algum erro, ao carregar o arquivo. Selecione um formato valíddo");
					return redirect('politicas_empresa/riscos/risco_editar/'.$id);
				}
				else {
					$file_upload = TRUE;
					$upload_data = $this->upload->data();
					$data['arquivo'] = $upload_data['file_name'];
				}
			}

			$insert = $this->Pe_risco_model->update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/riscos/risco_editar/'.$id);
		}
	}
	public function status_aprovar ($id) {
		$vf = $this->Pe_risco_model->first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('politicas_empresa/riscos/risco/'.$id);
		}
		if ($vf['status'] != 'pendente') {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('politicas_empresa/riscos/risco/'.$id);
		}
		$this->Pe_risco_model->aprovar(['status' => 'aprovado'], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('politicas_empresa/riscos/risco/'.$id);
	}
	public function status_rejeitar ($id) {
		$vf = $this->Pe_risco_model->first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('politicas_empresa/riscos/risco/'.$id);
		}
		if ($vf['status'] != 'pendente') {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('politicas_empresa/riscos/risco/'.$id);
		}
		$this->Pe_risco_model->rejeitar(['status' => 'rejeitado'], $id);
		set_alert('success',"Risco Rejeitado.");
		return redirect('politicas_empresa/riscos/risco/'.$id);
	}
}