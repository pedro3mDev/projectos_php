<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Politicas Empresa Controller
 */
class Seguranca_escritorio extends AdminController {
	public function __construct() {
		parent::__construct();
		$this->load->model('Pe_politica_model');
		$this->load->model('Pe_categoria_model');
		$this->load->model('Pe_politica_categoria_model');
		$this->load->model('Pe_acesso_model');
		$this->load->model('Pe_termo_model');

		$this->load->library(['form_validation', 'upload']);
	}
	private function http_method ($vfMethod) {
        if ($_SERVER['REQUEST_METHOD'] !== $vfMethod) {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['status' => false, 'message' => 'Metodo não permitido']);
            exit;
        }
    }
	private function acesso ($id, $acao) {
        $dados = [
            'staff_id' => get_staff_user_id(),
            'politica_id' => $id,
			'acao' => $acao
        ];
		$this->Pe_acesso_model->create($dados);
    }

	public function index() {
		$data['title'] = _l('pe_seguranca_escritorio');
		$data['categorias'] = $this->Pe_categoria_model->get();
		$data['total_categoria'] = $this->Pe_categoria_model->total();

		$data['politicas'] = $this->Pe_politica_model->get();
		$data['total_politicas'] = $this->Pe_politica_model->total();

		$data['conformidades'] = $this->Pe_termo_model->get('conformidades');

		$this->load->view('seguranca_escritorio/index', $data);
	}

	public function nova_categoria() {
		$data['title'] = _l('pe_nova_categoria');
		$this->load->view('seguranca_escritorio/nova_categoria', $data);
	}
	public function adicionar_categoria() {
		$this->http_method('POST');

		$data = [
            'staff_id' => get_staff_user_id(), // ID do Usuario Logado
            'categoria' => $this->input->post('categoria') ?? '',
        ];
		$this->form_validation->set_rules('categoria', 'Categoria', 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			$dataView['title'] = _l('pe_nova_categoria');
			$this->load->view('seguranca_escritorio/nova_categoria', $dataView);
        }
		else {
			$insert = $this->Pe_categoria_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/seguranca_escritorio/nova_categoria');
		}
	}
	public function categoria($id) {
		$vfCategoria = $this->Pe_categoria_model->first($id);
		$data['title'] = _l('pe_categoria');
		$data['categoria'] = $vfCategoria;

		$this->load->view('seguranca_escritorio/categoria', $data);
	}
	public function editar_categoria($id) {
		$this->http_method('POST');
		$vfCategoria = $this->Pe_categoria_model->first($id);

		$data = [
            'categoria' => $this->input->post('categoria') ?? '',
        ];

		if ($data['categoria'] == $vfCategoria['categoria']) {
			set_alert('warning',"Não houve nenhuma informação actualizada");
			redirect('politicas_empresa/seguranca_escritorio/categoria/'.$vfCategoria['id']);
		}
		else {
			$this->form_validation->set_rules('categoria', 'Categoria', 'required', ['required' => 'Preencha o campo {field}']);
			if (!$this->form_validation->run()) {
				$dataView['title'] = _l('pe_categoria');
				$dataView['categoria'] = $vfCategoria;

				$this->load->view('seguranca_escritorio/categoria', $dataView);
			}
			else {
				$insert = $this->Pe_categoria_model->update($data, $id);
				set_alert('success',"Actualizado com sucesso");
				redirect('politicas_empresa/seguranca_escritorio/categoria/'.$id);
			}
		}
	}
	public function categoria_eliminar($id) {
		$vfCategoria = $this->Pe_categoria_model->first($id);
		$this->Pe_categoria_model->delete($id);

		set_alert('success',"Categoria eliminada com sucesso");
		redirect('politicas_empresa/seguranca_escritorio');
	}

	public function nova_politica() {
		$data['title'] = _l('pe_nova_politica');
		$this->load->view('seguranca_escritorio/nova_politica', $data);
	}
	public function adicionar_politica() {
		$this->http_method('POST');

		$this->form_validation->set_rules('titulo', 'Titulo', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', 'Descrição', 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			$dataView['title'] = _l('pe_nova_politica');
			$this->load->view('seguranca_escritorio/nova_politica', $dataView);
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

					$this->load->view('seguranca_escritorio/nova_politica', $dataView);
					return;
				}
				else {
					$file_upload = TRUE;
					$upload_data = $this->upload->data();
				}
			}

			$data = [
				'staff_id' => get_staff_user_id(), // ID do Usuario Logado
				'titulo' => $this->input->post('titulo') ?? '',
				'descricao' => $this->input->post('descricao') ?? '',
				'arquivo' => $file_upload ? $upload_data['file_name'] : null,
			];

			$insert = $this->Pe_politica_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/seguranca_escritorio/nova_politica');
		}
	}
	public function politica($id) {
		$vfPolitica = $this->Pe_politica_model->first($id);
		$this->acesso($id, 'acessou');
		$data['politica'] = $vfPolitica;
		$data['title'] = _l('pe_nova_politica');
		$data['categorias'] = $this->Pe_politica_categoria_model->get_categorias($id);
		$data['categorias_politica'] = $this->Pe_politica_categoria_model->get($id);

		$data['acessos'] = $this->Pe_acesso_model->get($id);

		$this->load->view('seguranca_escritorio/politica', $data);
	}
	public function politica_editar($id) {
		$vfPolitica = $this->Pe_politica_model->first($id);
		$data['politica'] = $vfPolitica;
		$data['title'] = _l('pe_editar_politica');
		$this->load->view('seguranca_escritorio/editar_politica', $data);
	}
	public function actualizar_politica ($id) {
		$this->http_method('POST');
		$vfPolitica = $this->Pe_politica_model->first($id);

		$this->form_validation->set_rules('titulo', 'Titulo', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', 'Descrição', 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			$dataView['politica'] = $vfPolitica;
			$dataView['title'] = _l('pe_editar_politica');
			$this->load->view('seguranca_escritorio/editar_politica', $dataView);
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

					$dataView['politica'] = $vfPolitica;
					$dataView['title'] = _l('pe_editar_politica');
					$this->load->view('seguranca_escritorio/editar_politica', $dataView);
					return;
				}
				else {
					$file_upload = TRUE;
					$upload_data = $this->upload->data();
				}
			}

			if ($file_upload) {
				$data = [
					'titulo' => $this->input->post('titulo') ?? '',
					'descricao' => $this->input->post('descricao') ?? '',
					'arquivo' => $file_upload ? $upload_data['file_name'] : null,
				];
			}
			else {
				$data = [
					'titulo' => $this->input->post('titulo') ?? '',
					'descricao' => $this->input->post('descricao') ?? '',
				];
			}

			$insert = $this->Pe_politica_model->update($data, $id);
			$this->acesso($id, 'alterou');
			set_alert('success',"Atualizado com sucesso");
			redirect('politicas_empresa/seguranca_escritorio/politica_editar/'.$id);
		}
	}
	public function politica_eliminar ($id) {
		$vfPolitica = $this->Pe_politica_model->first($id);
		$this->Pe_politica_model->delete($id);

		set_alert('success',"Politica eliminada com sucesso");
		redirect('politicas_empresa/seguranca_escritorio');
	}

	public function add_politica_categoria($id) {
		$this->http_method('POST');
		$vfPolitica = $this->Pe_politica_model->first($id);

		$data = [
            'categoria_id' => $this->input->post('categoria') ?? '',
            'politica_id' => $vfPolitica['id'],
        ];
		$this->form_validation->set_rules('categoria', 'Categoria', 'required', ['required' => 'Selecione o campo {field}']);
		if (!$this->form_validation->run()) {
			$dataView['politica'] = $vfPolitica;
			$dataView['title'] = _l('pe_nova_politica');
			$dataView['categorias'] = $this->Pe_politica_categoria_model->get_categorias($id);
			$dataView['categorias_politica'] = $this->Pe_politica_categoria_model->get($id);

			$this->load->view('seguranca_escritorio/politica', $dataView);
        }
		else {
			$insert = $this->Pe_politica_categoria_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/seguranca_escritorio/politica/'.$id);
		}
	}
	public function remover_politica_categoria($id, $id_plca) {
		$vfPolitica = $this->Pe_politica_categoria_model->first($id, $id_plca);
		$this->Pe_politica_categoria_model->delete($id, $id_plca);

		set_alert('success',"Categoria eliminada com sucesso");
		redirect('politicas_empresa/seguranca_escritorio/politica/'.$id);
	}

	public function nova_termo_conformidade() {
		$data['title'] = _l('pe_nova_termo_conformidade');
		$data['colaboradores'] = $this->db->get('staff')->result_array();
		$data['politicas'] = $this->Pe_politica_model->get();
		$this->load->view('seguranca_escritorio/nova_termo_conformidade', $data);
	}
	public function adicionar_termo_conformidade () {
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
			$dataView['title'] = _l('pe_nova_termo_conformidade');
			$dataView['colaboradores'] = $this->db->get('staff')->result_array();
			$dataView['politicas'] = $this->Pe_politica_model->get();
			$this->load->view('seguranca_escritorio/nova_termo_conformidade', $dataView);
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

					$dataView['title'] = _l('pe_nova_termo_conformidade');
					$dataView['colaboradores'] = $this->db->get('staff')->result_array();
					$dataView['politicas'] = $this->Pe_politica_model->get();
					$this->load->view('seguranca_escritorio/nova_termo_conformidade', $dataView);
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
				'tipo_termo' => 'conformidade',
			];

			$insert = $this->Pe_termo_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/seguranca_escritorio/nova_termo_conformidade');
		}
	}

	public function conformidade_eliminar ($id) {
		$vfTermo = $this->Pe_termo_model->first($id);
		$this->Pe_termo_model->delete($id);

		set_alert('success',"Registro de Conformidade eliminada com sucesso");
		redirect('politicas_empresa/seguranca_escritorio');
	}
	public function conformidade_editar($id) {
		$vfTermo = $this->Pe_termo_model->first($id);

		$data['title'] = _l('pe_editar_termo_conformidade');
		$data['colaboradores'] = $this->db->get('staff')->result_array();
		$data['politicas'] = $this->Pe_politica_model->get();
		$data['conformidade'] = $vfTermo;
		$this->load->view('seguranca_escritorio/editar_termo_conformidade', $data);
	}
	public function actualizar_termo_conformidade ($id) {
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
			$dataView['title'] = _l('pe_editar_termo_conformidade');
			$dataView['colaboradores'] = $this->db->get('staff')->result_array();
			$dataView['politicas'] = $this->Pe_politica_model->get();
			$dataView['conformidade'] = $vfTermo;
			$this->load->view('seguranca_escritorio/editar_termo_conformidade', $dataView);
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

					$dataView['title'] = _l('pe_editar_termo_conformidade');
					$dataView['colaboradores'] = $this->db->get('staff')->result_array();
					$dataView['conformidade'] = $vfTermo;
					$this->load->view('seguranca_escritorio/editar_termo_conformidade', $dataView);
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
				'tipo_termo' => 'conformidade',
			];

			$insert = $this->Pe_termo_model->update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/seguranca_escritorio/conformidade_editar/'.$id);
		}
	}
}