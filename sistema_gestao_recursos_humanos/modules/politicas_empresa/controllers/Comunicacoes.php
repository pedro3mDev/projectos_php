<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Conforimidades Controller
 */
class Comunicacoes extends AdminController {
	public function __construct() {
		parent::__construct();
		$this->load->model('Pe_politica_empresa_model');
		$this->load->model('Pe_politica_model');
		$this->load->model('Pe_tipo_politica_model');
		$this->load->model('Pe_categoria_model');
		$this->load->model('Pe_area_model');
		$this->load->model('Pe_status_model');
		$this->load->model('Pe_nivel_hierarquico_model');
		$this->load->model('Pe_comunicacao_model');

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
		$data['title'] = _l('pe_comunicacoes');

		$data['politicas'] = $this->Pe_politica_model->get();
		$data['staffs'] = $this->Pe_politica_empresa_model->staffs();
		$data['staff_list'] = $this->Pe_politica_empresa_model->staffs_admin();

		$data['comunicacoes'] = $this->Pe_comunicacao_model->get();
		$this->load->view('comunicacoes/index', $data);
	}

	public function add_comunicacao() {
		$this->http_method('POST');

		$this->form_validation->set_rules('staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('politica', _l('pe_politica'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_verificacao', 'Data Verificação', 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			return redirect('politicas_empresa/comunicacoes');
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
					return redirect('politicas_empresa/comunicacoes');
				}
				else {
					$file_upload = TRUE;
					$upload_data = $this->upload->data();
				}
			}

			$data = [
				'staff_id' => get_staff_user_id(), // ID do Usuario Logado
				'colaborador_id' => $this->input->post('staff') ?? '',
				'politica_id' => $this->input->post('politica') ?? '',
				'data_verificacao' => $this->input->post('data_verificacao') ?? '',
				'status' => 'pendente',
				'arquivo' => $file_upload ? $upload_data['file_name'] : null,
				'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
			];

			$insert = $this->Pe_comunicacao_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/comunicacoes');
		}
	}

	public function comunicacao ($id) {
		$vfcomunicacao = $this->Pe_comunicacao_model->first($id);
		$data['title'] = $vfcomunicacao['titulo'];
		$data['comunicacao'] = $vfcomunicacao;

		$this->load->view('comunicacoes/comunicacao', $data);
	}
	public function comunicacao_editar ($id) {
		$vfcomunicacao = $this->Pe_comunicacao_model->first($id);
		$data['title'] = _l('pe_editar');
		$data['comunicacao'] = $vfcomunicacao;

		$data['politicas'] = $this->Pe_politica_model->get();
		$data['staffs'] = $this->Pe_politica_empresa_model->staffs();
		$data['staff_list'] = $this->Pe_politica_empresa_model->staffs_admin();

		$data['staff_list'] = $this->Pe_politica_empresa_model->staffs_admin();

		$this->load->view('comunicacoes/comunicacao_editar', $data);
	}
	public function actualizar_comunicacao($id) {
		$this->http_method('POST');
		$vfcomunicacao = $this->Pe_comunicacao_model->first($id);

		$this->form_validation->set_rules('staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('politica', _l('pe_politica'), 'required', ['required' => 'Preencha o campo {field}']);

		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_verificacao', 'Data Verificação', 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			return redirect('politicas_empresa/comunicacoes/comunicacao_editar/'.$vfcomunicacao['id']);
        }
		else {
			$data = [
				'colaborador_id' => $this->input->post('staff') ?? '',
				'politica_id' => $this->input->post('politica') ?? '',
				'data_verificacao' => $this->input->post('data_verificacao') ?? '',
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
					return redirect('politicas_empresa/comunicacoes/comunicacao_editar/'.$vfcomunicacao['id']);
				}
				else {
					$upload_data = $this->upload->data();
					$data['arquivo'] = $upload_data['file_name'];
				}
			}

			$insert = $this->Pe_comunicacao_model->update($data, $id);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/comunicacoes/comunicacao_editar/'.$vfcomunicacao['id']);
		}
	}
	public function delete_comunicacao ($id) {
		$this->Pe_comunicacao_model->first($id);
		$this->Pe_comunicacao_model->delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('politicas_empresa/comunicacoes');
	}
	public function status_aprovar ($id) {
		$vf = $this->Pe_comunicacao_model->first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('politicas_empresa/comunicacoes/comunicacao/'.$id);
		}
		if ($vf['status'] != 'pendente') {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('politicas_empresa/comunicacoes/comunicacao/'.$id);
		}
		$this->Pe_comunicacao_model->aprovar(['status' => 'aprovado'], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('politicas_empresa/comunicacoes/comunicacao/'.$id);
	}
	public function status_rejeitar ($id) {
		$vf = $this->Pe_comunicacao_model->first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('politicas_empresa/comunicacoes/comunicacao/'.$id);
		}
		if ($vf['status'] != 'pendente') {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('politicas_empresa/comunicacoes/comunicacao/'.$id);
		}
		$this->Pe_comunicacao_model->rejeitar(['status' => 'rejeitado'], $id);
		set_alert('success',"Comunicação Rejeitada.");
		return redirect('politicas_empresa/comunicacoes/comunicacao/'.$id);
	}
}