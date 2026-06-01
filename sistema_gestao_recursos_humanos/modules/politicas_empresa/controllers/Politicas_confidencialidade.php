<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Politicas Empresa Controller
 */
class Politicas_confidencialidade extends AdminController {
	public function __construct() {
		parent::__construct();
		$this->load->model('Pe_politica_model');
		$this->load->model('Pe_termo_model');
		$this->load->model('Pe_acesso_model');

		$this->load->library(['form_validation', 'upload']);
	}
	private function http_method ($vfMethod) {
        if ($_SERVER['REQUEST_METHOD'] !== $vfMethod) {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['status' => false, 'message' => 'Metodo não permitido']);
            exit;
        }
    }

	public function index() {
		$data['title'] = _l('pe_politicas_confidencialidade');
		$data['confidencialidades'] = $this->Pe_termo_model->get('confidencialidade');
		$data['acessos'] = $this->Pe_acesso_model->get_all();

		$this->load->view('politicas_confidencialidade/index', $data);
	}

	public function novo_termo() {
		$data['title'] = _l('pe_nova_termo_confidencialidade');
		$data['colaboradores'] = $this->db->get('staff')->result_array();
		$data['politicas'] = $this->Pe_politica_model->get();
		$this->load->view('politicas_confidencialidade/nova_termo_confidencialidade', $data);
	}
	public function adicionar_termo () {
		$this->http_method('POST');

		$this->form_validation->set_rules('colaborador', 'Colaborador', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('politica', 'Política', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_assinatura', 'Data Assinatura', 'required', ['required' => 'Preencha o campo {field}']);

        $enum_valido = ['digital', 'fisico'];
		$this->form_validation->set_rules('tipo_assinatura', 'Tipo de Assinatura', ['required', [
            'enum', function ($value) use ($enum_valido) {
                return in_array($value, $enum_valido);
            }
        ]], ['required' => 'Selecione um {field}', 'enum' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido)]);
		if (!$this->form_validation->run()) {
			$dataView['title'] = _l('pe_nova_termo_confidencialidade');
			$dataView['colaboradores'] = $this->db->get('staff')->result_array();
			$dataView['politicas'] = $this->Pe_politica_model->get();
			$this->load->view('politicas_confidencialidade/nova_termo_confidencialidade', $dataView);
			return;
        }
		else {
			$file_upload = false;
			if (!empty($_FILES['arquivo']['name'])) {
				$conf_u['upload_path'] = FCPATH. 'modules/politicas_empresa/uploads/';
				$conf_u['allowed_types'] = 'jpg|png|jpeg|pdf|docx|doc';
				$conf_u['encrypt_name'] = TRUE;

				$this->upload->initialize($conf_u);
				if (!$this->upload->do_upload('arquivo')) {
					$dataView['error'] = $this->upload->display_errors();

					$dataView['title'] = _l('pe_nova_termo_confidencialidade');
					$dataView['colaboradores'] = $this->db->get('staff')->result_array();
					$dataView['politicas'] = $this->Pe_politica_model->get();
					$this->load->view('politicas_confidencialidade/nova_termo_confidencialidade', $dataView);
					return;
				}
				else {
					$file_upload = TRUE;
					$upload_data = $this->upload->data();
				}
			}

			$data = [
				// 'staff_id' => get_staff_user_id(), // ID do Usuario Logado
				'staff_id' => $this->input->post('colaborador') ?? '',
				'politica_id' => $this->input->post('politica') ?? '',
				'data_assinatura' => $this->input->post('data_assinatura') ?? '',
				'tipo_assinatura' => $this->input->post('tipo_assinatura') ?? '',
				'arquivo' => $file_upload ? $upload_data['file_name'] : null,
				'tipo_termo' => 'confidencialidade',
			];

			$insert = $this->Pe_termo_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/politicas_confidencialidade/novo_termo');
		}
	}

	public function confidencialidade_eliminar ($id) {
		$vfTermo = $this->Pe_termo_model->first($id);
		$this->Pe_termo_model->delete($id);

		set_alert('success',"Registro de Confidencialidade eliminada com sucesso");
		redirect('politicas_empresa/politicas_confidencialidade');
	}
	public function confidencialidade_editar($id) {
		$vfTermo = $this->Pe_termo_model->first($id);

		$data['title'] = _l('pe_editar_termo_confidencialidade');
		$data['colaboradores'] = $this->db->get('staff')->result_array();
		$data['politicas'] = $this->Pe_politica_model->get();
		$data['confidencialidade'] = $vfTermo;
		$this->load->view('politicas_confidencialidade/editar_termo', $data);
	}
	public function actualizar_termo ($id) {
		$this->http_method('POST');
		$vfTermo = $this->Pe_termo_model->first($id);

		$this->form_validation->set_rules('colaborador', 'Colaborador', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('politica', 'Política', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_assinatura', 'Data Assinatura', 'required', ['required' => 'Preencha o campo {field}']);

        $enum_valido = ['digital', 'fisico'];
		$this->form_validation->set_rules('tipo_assinatura', 'Tipo de Assinatura', ['required', [
            'enum', function ($value) use ($enum_valido) {
                return in_array($value, $enum_valido);
            }
        ]], ['required' => 'Selecione um {field}', 'enum' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido)]);
		if (!$this->form_validation->run()) {
			$data['title'] = _l('pe_editar_termo_confidencialidade');
			$data['colaboradores'] = $this->db->get('staff')->result_array();
			$data['politicas'] = $this->Pe_politica_model->get();
			$data['confidencialidade'] = $vfTermo;
			$this->load->view('politicas_confidencialidade/editar_termo', $data);
			return;
        }
		else {
			$file_upload = false;
			if (!empty($_FILES['arquivo']['name'])) {
				$conf_u['upload_path'] = FCPATH. 'modules/politicas_empresa/uploads/';
				$conf_u['allowed_types'] = 'jpg|png|jpeg|pdf|docx|doc';
				$conf_u['encrypt_name'] = TRUE;

				$this->upload->initialize($conf_u);
				if (!$this->upload->do_upload('arquivo')) {
					$data['error'] = $this->upload->display_errors();

					$data['title'] = _l('pe_editar_termo_confidencialidade');
					$data['colaboradores'] = $this->db->get('staff')->result_array();
					$data['politicas'] = $this->Pe_politica_model->get();
					$data['confidencialidade'] = $vfTermo;
					$this->load->view('politicas_confidencialidade/editar_termo', $data);
					return;
				}
				else {
					$file_upload = TRUE;
					$upload_data = $this->upload->data();
				}
			}

			$data = [
				// 'staff_id' => get_staff_user_id(), // ID do Usuario Logado
				'staff_id' => $this->input->post('colaborador') ?? '',
				'politica_id' => $this->input->post('politica') ?? '',
				'data_assinatura' => $this->input->post('data_assinatura') ?? '',
				'tipo_assinatura' => $this->input->post('tipo_assinatura') ?? '',
				'arquivo' => $file_upload ? $upload_data['file_name'] : null,
				'tipo_termo' => 'confidencialidade',
			];

			$insert = $this->Pe_termo_model->update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/politicas_confidencialidade/confidencialidade_editar/'.$id);
		}
	}
}