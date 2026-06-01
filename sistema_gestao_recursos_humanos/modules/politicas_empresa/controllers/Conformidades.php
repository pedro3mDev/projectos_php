<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Conforimidades Controller
 */
class Conformidades extends AdminController {
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
		$data['title'] = _l('Conformidades');

		$data['conformidades'] = $this->Pe_conformidade_model->get();
		$data['politicas'] = $this->Pe_politica_model->get();
		$data['staffs'] = $this->Pe_politica_empresa_model->staffs();

		$data['staff_list'] = $this->Pe_politica_empresa_model->staffs_admin();

		$this->load->view('conformidades/index', $data);
	}

	public function add_conformidade() {
		$this->http_method('POST');

		$this->form_validation->set_rules('staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('politica', _l('pe_politica'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_verificacao', 'Data Verificação', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('observacao', 'Observação', 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			return redirect('politicas_empresa/conformidades');
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
					return redirect('politicas_empresa/conformidades');
				}
				else {
					$file_upload = TRUE;
					$upload_data = $this->upload->data();
				}
			}

			$data = [
				'staff_id' => get_staff_user_id(), // ID do Usuario Logado
				'staff_conformidade_id' => $this->input->post('staff') ?? '',
				'politica_id' => $this->input->post('politica') ?? '',
				'observacao' => $this->input->post('observacao') ?? '',
				'data_verificacao' => $this->input->post('data_verificacao') ?? '',
				'status' => 'pendente',
				'arquivo' => $file_upload ? $upload_data['file_name'] : null,
				'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
			];

			$insert = $this->Pe_conformidade_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/conformidades');
		}
	}

	public function conformidade ($id) {
		$vfConformidade = $this->Pe_conformidade_model->first($id);
		$data['title'] = $vfConformidade['titulo'];
		$data['conformidade'] = $vfConformidade;

		$this->load->view('conformidades/conformidade', $data);
	}
	public function conformidade_editar ($id) {
		$vfConformidade = $this->Pe_conformidade_model->first($id);
		$data['title'] = _l('pe_editar');
		$data['conformidade'] = $vfConformidade;

		$data['politicas'] = $this->Pe_politica_model->get();
		$data['conformidades'] = $this->Pe_conformidade_model->get();
		$data['staffs'] = $this->Pe_politica_empresa_model->staffs();

		$data['staff_list'] = $this->Pe_politica_empresa_model->staffs_admin();

		$this->load->view('conformidades/conformidade_editar', $data);
	}
	public function actualizar_conformidade($id) {
		$this->http_method('POST');
		$vfConformidade = $this->Pe_conformidade_model->first($id);

		$this->form_validation->set_rules('staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('politica', _l('pe_politica'), 'required', ['required' => 'Preencha o campo {field}']);

		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_verificacao', 'Data Verificação', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('observacao', 'Observação', 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			return redirect('politicas_empresa/conformidades/conformidade_editar/'.$vfConformidade['id']);
        }
		else {
			$data = [
				'staff_conformidade_id' => $this->input->post('staff') ?? '',
				'politica_id' => $this->input->post('politica') ?? '',
				'observacao' => $this->input->post('observacao') ?? '',
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
					return redirect('politicas_empresa/conformidades/conformidade_editar/'.$vfConformidade['id']);
				}
				else {
					$upload_data = $this->upload->data();
					$data['arquivo'] = $upload_data['file_name'];
				}
			}

			$insert = $this->Pe_conformidade_model->update($data, $id);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/conformidades/conformidade_editar/'.$vfConformidade['id']);
		}
	}
	public function delete_conformidade ($id) {
		$this->Pe_conformidade_model->first($id);
		$this->Pe_conformidade_model->delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('politicas_empresa/conformidades');
	}
	public function status_aprovar ($id) {
		$vf = $this->Pe_conformidade_model->first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('politicas_empresa/conformidades/conformidade/'.$id);
		}
		if ($vf['status'] != 'pendente') {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('politicas_empresa/conformidades/conformidade/'.$id);
		}
		$this->Pe_conformidade_model->aprovar(['status' => 'aprovado'], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('politicas_empresa/conformidades/conformidade/'.$id);
	}
	public function status_rejeitar ($id) {
		$vf = $this->Pe_conformidade_model->first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('politicas_empresa/conformidades/conformidade/'.$id);
		}
		if ($vf['status'] != 'pendente') {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('politicas_empresa/conformidades/conformidade/'.$id);
		}
		$this->Pe_conformidade_model->rejeitar(['status' => 'rejeitado'], $id);
		set_alert('success',"Conformidade Rejeitada.");
		return redirect('politicas_empresa/conformidades/conformidade/'.$id);
	}
}