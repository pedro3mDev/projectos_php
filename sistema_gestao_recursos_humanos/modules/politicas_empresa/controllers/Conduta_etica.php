<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Politicas Empresa Controller
 */
class Conduta_etica extends AdminController {
	public function __construct() {
		parent::__construct();
		$this->load->model('Pe_politica_model');
		$this->load->model('Pe_conduta_model');
		$this->load->model('Pe_treinamento_model');
		$this->load->model('Pe_treinamento_staff_model');
		$this->load->model('Pe_conduta_adesao_model');
		$this->load->model('Pe_conduta_violacao_model');

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
		$data['title'] = _l('pe_codigo_conduta_entica');
		$data['condutas'] = $this->Pe_conduta_model->get();
		$data['total_condutas'] = $this->Pe_conduta_model->total();

		$data['treinamentos'] = $this->Pe_treinamento_model->get();
		$data['total_treinamentos'] = $this->Pe_treinamento_model->total();

		$data['adessoes'] = $this->Pe_conduta_adesao_model->get();
		$data['total_adessoes'] = $this->Pe_conduta_adesao_model->total();

		$data['violacoes'] = $this->Pe_conduta_violacao_model->get();
		$data['total_violacoes'] = $this->Pe_conduta_violacao_model->total();

		$this->load->view('conduta_etica/index', $data);
	}

	public function nova_conduta() {
		$data['title'] = _l('pe_nova_conduta');
		$this->load->view('conduta_etica/add_conduta_etica', $data);
	}
	public function adicionar_conduta() {
		$this->http_method('POST');

		$data = [
            'staff_id' => get_staff_user_id(), // ID do Usuario Logado
            'nome' => $this->input->post('titulo') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
        ];
		$this->form_validation->set_rules('titulo', 'Titulo', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', 'Descrição', 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			$dataView['title'] = _l('pe_nova_conduta');
			$this->load->view('conduta_etica/add_conduta_etica', $dataView);
        }
		else {
			$insert = $this->Pe_conduta_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/conduta_etica/nova_conduta');
		}
	}
	public function conduta_eliminar($id) {
		$vfConduta = $this->Pe_conduta_model->first($id);
		$this->Pe_conduta_model->delete($id);

		set_alert('success',"Conduta eliminada com sucesso");
		redirect('politicas_empresa/conduta_etica');
	}

	public function conduta_editar($id) {
		$vfConduta = $this->Pe_conduta_model->first($id);

		$data['title'] = _l('pe_editar_conduta');
		$data['conduta'] = $vfConduta;
		$this->load->view('conduta_etica/editar_conduta_etica', $data);
	}
	public function actualizar_conduta($id) {
		$this->http_method('POST');
		$vfConduta = $this->Pe_conduta_model->first($id);

		$data = [
            'staff_id' => get_staff_user_id(), // ID do Usuario Logado
            'nome' => $this->input->post('titulo') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
        ];
		$this->form_validation->set_rules('titulo', 'Titulo', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', 'Descrição', 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			$dataView['title'] = _l('pe_editar_conduta');
			$dataView['conduta'] = $vfConduta;
			$this->load->view('conduta_etica/editar_conduta_etica', $dataView);
        }
		else {
			$insert = $this->Pe_conduta_model->update($data, $id);
			set_alert('success',"Atualilzado com sucesso");
			redirect('politicas_empresa/conduta_etica/conduta_editar/'.$id);
		}
	}

	public function novo_treinamnto() {
		$data['title'] = _l('pe_novo_treinamento');
		$data['condutas'] = $this->Pe_conduta_model->get();

		$this->load->view('conduta_etica/add_treinamento', $data);
	}
	public function adicionar_treinamento() {
		$this->http_method('POST');

		$data = [
            'staff_id' => get_staff_user_id(), // ID do Usuario Logado
            'conduta_id' => $this->input->post('conduta') ?? '',
            'data_treinamento' => $this->input->post('data') ?? '',
            'status' => $this->input->post('estado') ?? '',
        ];
		$this->form_validation->set_rules('conduta', 'Conduta', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data', 'Data', 'required', ['required' => 'Preencha o campo {field}']);
		$enum_valido = ['pendente', 'activo'];
		$this->form_validation->set_rules('estado', 'Estado', ['required', [
            'enum', function ($value) use ($enum_valido) {
                return in_array($value, $enum_valido);
            }
        ]], ['required' => 'Selecione um {field}', 'enum' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido)]);
		if (!$this->form_validation->run()) {

			$dataView['title'] = _l('pe_novo_treinamento');
			$dataView['condutas'] = $this->Pe_conduta_model->get();

			$this->load->view('conduta_etica/add_treinamento', $dataView);
        }
		else {
			$insert = $this->Pe_treinamento_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/conduta_etica/novo_treinamnto');
		}
	}
	public function treinamentos_eliminar ($id) {
		$this->Pe_treinamento_model->first($id);
		$this->Pe_treinamento_model->delete($id);

		set_alert('success',"Treinamneto eliminada com sucesso");
		redirect('politicas_empresa/conduta_etica');
	}
	public function treinamentos_editar($id)  {
		$vTreinamento = $this->Pe_treinamento_model->first($id);

		$data['title'] = _l('pe_editar_treinamento');
		$data['condutas'] = $this->Pe_conduta_model->get();
		$data['treinamento'] = $vTreinamento;

		$this->load->view('conduta_etica/editar_treinamento', $data);
	}
	public function actualizar_treinamento($id) {
		$vTreinamento = $this->Pe_treinamento_model->first($id);
		$this->http_method('POST');

		$data = [
            'conduta_id' => $this->input->post('conduta') ?? '',
            'data_treinamento' => $this->input->post('data') ?? '',
            'status' => $this->input->post('estado') ?? '',
        ];
		$this->form_validation->set_rules('conduta', 'Conduta', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data', 'Data', 'required', ['required' => 'Preencha o campo {field}']);
		$enum_valido = ['pendente', 'activo', 'finalizado'];
		$this->form_validation->set_rules('estado', 'Estado', ['required', [
            'enum', function ($value) use ($enum_valido) {
                return in_array($value, $enum_valido);
            }
        ]], ['required' => 'Selecione um {field}', 'enum' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido)]);
		if (!$this->form_validation->run()) {
			$dataView['title'] = _l('pe_editar_treinamento');
			$dataView['condutas'] = $this->Pe_conduta_model->get();
			$dataView['treinamento'] = $vTreinamento;

			$this->load->view('conduta_etica/editar_treinamento', $dataView);
        }
		else {
			$this->Pe_treinamento_model->update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/conduta_etica/treinamentos_editar/'.$id);
		}
	}
	public function treinamento($id)  {
		$vTreinamento = $this->Pe_treinamento_model->first($id);

		$data['title'] = _l('pe_treinamento');
		$data['condutas'] = $this->Pe_conduta_model->get();
		$data['treinamento'] = $vTreinamento;
		$data['participantes'] = $this->Pe_treinamento_staff_model->get($id);

		$this->load->view('conduta_etica/treinamento', $data);
	}
	public function add_participante($id) {
		$vTreinamento = $this->Pe_treinamento_model->first($id);
		$data['title'] = _l('pe_treinamento_add_participante');
		$data['treinamento'] = $vTreinamento;
		$data['staffs'] = $this->Pe_treinamento_staff_model->participantes($id);

		$this->load->view('conduta_etica/treinamento_add_participante', $data);
	}
	public function adicionar_participante_treinamento ($id) {
		$vTreinamento = $this->Pe_treinamento_model->first($id);
		$this->http_method('POST');

		$data = [
            'conduta_treinamento_id' => $vTreinamento['id'],
            'staff_id' => $this->input->post('staff') ?? '',
            'resultado' => $this->input->post('resultado') ?? '',
        ];
		$this->form_validation->set_rules('staff', 'Participante', 'required', ['required' => 'Preencha o campo {field}']);
		$enum_valido = ['pendente', 'aprovado', 'reprovado'];
		$this->form_validation->set_rules('resultado', 'Resultado', ['required', [
            'enum', function ($value) use ($enum_valido) {
                return in_array($value, $enum_valido);
            }
        ]], ['required' => 'Selecione um {field}', 'enum' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido)]);
		if (!$this->form_validation->run()) {
			$dataView['title'] = _l('pe_treinamento_add_participante');
			$dataView['treinamento'] = $vTreinamento;
			$dataView['staffs'] = $this->Pe_treinamento_staff_model->participantes($id);

			$this->load->view('conduta_etica/treinamento_add_participante', $dataView);
        }
		else {
			$insert = $this->Pe_treinamento_staff_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/conduta_etica/treinamento/'.$id);
		}
	}
	public function treinamento_participante_eliminar ($id) {
		$vfParticipante = $this->Pe_treinamento_staff_model->first($id);
		$this->Pe_treinamento_staff_model->delete($id);

		set_alert('success',"Participante Elimindao com sucesso");
		redirect('politicas_empresa/conduta_etica/treinamento/'.$vfParticipante['conduta_treinamento_id']);
	}
	public function editar_participante_treinamento ($id) {
		$vfParticipante = $this->Pe_treinamento_staff_model->first($id);
		$this->http_method('POST');

		$data = [
            'resultado' => $this->input->post('resultado') ?? '',
        ];
		$enum_valido = ['pendente', 'aprovado', 'reprovado'];
		$this->form_validation->set_rules('resultado', 'Resultado', ['required', [
            'enum', function ($value) use ($enum_valido) {
                return in_array($value, $enum_valido);
            }
        ]], ['required' => 'Selecione um {field}', 'enum' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido)]);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Houve algum erro, tente novamente.");
			redirect('politicas_empresa/conduta_etica/treinamento/'.$vfParticipante['conduta_treinamento_id']);
        }
		else {
			$insert = $this->Pe_treinamento_staff_model->update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/conduta_etica/treinamento/'.$vfParticipante['conduta_treinamento_id']);
		}
	}

	public function nova_adesao() {
		$data['title'] = _l('pe_nova_adesao');
		$data['condutas'] = $this->Pe_conduta_model->get();
		$data['staffs'] = $this->db->get('staff')->result_array();
		$this->load->view('conduta_etica/add_adesao', $data);
	}
	public function adicionar_adesao() {
		$this->http_method('POST');

		$this->form_validation->set_rules('conduta', 'Conduta', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('staff', 'Usuário', 'required', ['required' => 'Preencha o campo {field}']);
		$enum_valido = ['assinatura_digital', 'assinatura_fisica'];
		$this->form_validation->set_rules('metodo_adesao', 'Metodo Adesao', ['required', [
            'enum', function ($value) use ($enum_valido) {
                return in_array($value, $enum_valido);
            }
        ]], ['required' => 'Selecione um {field}', 'enum' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido)]);
		if (!$this->form_validation->run()) {
			$dataView['title'] = _l('pe_nova_adesao');
			$dataView['condutas'] = $this->Pe_conduta_model->get();
			$dataView['staffs'] = $this->db->get('staff')->result_array();
			$this->load->view('conduta_etica/add_adesao', $dataView);
        }
		else {
			$file_upload = false;
			if (!empty($_FILES['arquivo']['name'])) {
				$conf_u['upload_path'] = FCPATH. 'modules/politicas_empresa/uploads/';
				$conf_u['allowed_types'] = 'jpg|png|jpeg|pdf|docx|doc';
				$conf_u['encrypt_name'] = TRUE;

				$this->upload->initialize($conf_u);
				if (!$this->upload->do_upload('arquivo')) {
					$dataView['title'] = _l('pe_nova_adesao');
					$dataView['condutas'] = $this->Pe_conduta_model->get();
					$dataView['staffs'] = $this->db->get('staff')->result_array();
					$this->load->view('conduta_etica/add_adesao', $dataView);
					return;
				}
				else {
					$file_upload = TRUE;
					$upload_data = $this->upload->data();
				}
			}

			$data = [
				// 'staff_id' => get_staff_user_id(), // ID do Usuario Logado
				'conduta_id' => $this->input->post('conduta') ?? '',
				'staff_id' => $this->input->post('staff') ?? '',
				'metodo_aceite' => $this->input->post('metodo_adesao') ?? '',
				'arquivo' => $file_upload ? $upload_data['file_name'] : null,
			];

			$insert = $this->Pe_conduta_adesao_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/conduta_etica/nova_adesao');
		}
	}
	public function adesao_eliminar($id) {
		$vfAdesao = $this->Pe_conduta_adesao_model->first($id);
		$this->Pe_conduta_adesao_model->delete($id);

		set_alert('success',"Adesão Eliminada com sucesso");
		redirect('politicas_empresa/conduta_etica');
	}
	public function adesao_editar($id) {
		$vfAdesao = $this->Pe_conduta_adesao_model->first($id);

		$data['title'] = _l('pe_editar_adesao');
		$data['condutas'] = $this->Pe_conduta_model->get();
		$data['adesao'] = $vfAdesao;

		$data['staffs'] = $this->db->get('staff')->result_array();
		$this->load->view('conduta_etica/editar_adesao', $data);
	}
	public function actualizar_adesao($id) {
		$vfAdesao = $this->Pe_conduta_adesao_model->first($id);
		$this->http_method('POST');

		$this->form_validation->set_rules('conduta', 'Conduta', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('staff', 'Usuário', 'required', ['required' => 'Preencha o campo {field}']);
		$enum_valido = ['assinatura_digital', 'assinatura_fisica'];
		$this->form_validation->set_rules('metodo_adesao', 'Metodo Adesao', ['required', [
            'enum', function ($value) use ($enum_valido) {
                return in_array($value, $enum_valido);
            }
        ]], ['required' => 'Selecione um {field}', 'enum' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido)]);
		if (!$this->form_validation->run()) {
			$data['title'] = _l('pe_editar_adesao');
			$data['condutas'] = $this->Pe_conduta_model->get();
			$data['adesao'] = $vfAdesao;

			$data['staffs'] = $this->db->get('staff')->result_array();
			$this->load->view('conduta_etica/editar_adesao', $data);
        }
		else {
			$file_upload = false;
			if (!empty($_FILES['arquivo']['name'])) {
				$conf_u['upload_path'] = FCPATH. 'modules/politicas_empresa/uploads/';
				$conf_u['allowed_types'] = 'jpg|png|jpeg|pdf|docx|doc';
				$conf_u['encrypt_name'] = TRUE;

				$this->upload->initialize($conf_u);
				if (!$this->upload->do_upload('arquivo')) {
					$data['title'] = _l('pe_editar_adesao');
					$data['condutas'] = $this->Pe_conduta_model->get();
					$data['adesao'] = $vfAdesao;
					$data['error'] = $this->upload->display_errors();

					$data['staffs'] = $this->db->get('staff')->result_array();
					$this->load->view('conduta_etica/editar_adesao', $data);
					return;
				}
				else {
					$file_upload = TRUE;
					$upload_data = $this->upload->data();
				}
			}

			$data = [
				// 'staff_id' => get_staff_user_id(), // ID do Usuario Logado
				'conduta_id' => $this->input->post('conduta') ?? '',
				'staff_id' => $this->input->post('staff') ?? '',
				'metodo_aceite' => $this->input->post('metodo_adesao') ?? '',
				'arquivo' => $file_upload ? $upload_data['file_name'] : null,
			];

			$insert = $this->Pe_conduta_adesao_model->update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/conduta_etica/adesao_editar/'.$id);
		}
	}

	public function nova_vialocao() {
		$data['title'] = _l('pe_reportar_violacao');
		$data['condutas'] = $this->Pe_conduta_model->get();
		$data['staffs'] = $this->db->get('staff')->result_array();
		$this->load->view('conduta_etica/add_violacao', $data);
	}
	public function adicionar_violacao() {
		$this->http_method('POST');

		$data = [
            'staff_id' => $this->input->post('staff') ?? '',
            'conduta_id' => $this->input->post('conduta') ?? '',
            'acao_tomada' => $this->input->post('acao_tomada') ?? '',
            'data_ocorrencia' => $this->input->post('data_ocorrencia') ?? '',
            'status' => $this->input->post('estado') ?? '',
        ];
		$this->form_validation->set_rules('conduta', 'Conduta', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('staff', 'Usuário', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('acao_tomada', 'Ação Tomada', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_ocorrencia', 'Data Ocorrência', 'required', ['required' => 'Preencha o campo {field}']);
		$enum_valido = ['resolvido', 'ativo'];
		$this->form_validation->set_rules('estado', 'Estado', ['required', [
            'enum', function ($value) use ($enum_valido) {
                return in_array($value, $enum_valido);
            }
        ]], ['required' => 'Selecione um {field}', 'enum' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido)]);
		if (!$this->form_validation->run()) {
			$dataView['title'] = _l('pe_reportar_violacao');
			$dataView['condutas'] = $this->Pe_conduta_model->get();
			$dataView['staffs'] = $this->db->get('staff')->result_array();
			$this->load->view('conduta_etica/add_violacao', $dataView);
        }
		else {
			$insert = $this->Pe_conduta_violacao_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/conduta_etica/nova_vialocao');
		}
	}
	public function violacao_eliminar($id) {
		$this->Pe_conduta_violacao_model->first($id);
		$this->Pe_conduta_violacao_model->delete($id);

		set_alert('success',"Violacão Eliminada com sucesso");
		redirect('politicas_empresa/conduta_etica');
	}
	public function violacao_editar($id) {
		$vfViolacao = $this->Pe_conduta_violacao_model->first($id);
		$data['title'] = _l('pe_editar_violacao');
		$data['condutas'] = $this->Pe_conduta_model->get();
		$data['staffs'] = $this->db->get('staff')->result_array();

		$data['violacao'] = $vfViolacao;
		$this->load->view('conduta_etica/editar_violacao', $data);
	}
	public function actualizar_violacao($id) {
		$vfViolacao = $this->Pe_conduta_violacao_model->first($id);
		$this->http_method('POST');

		$data = [
            'staff_id' => $this->input->post('staff') ?? '',
            'conduta_id' => $this->input->post('conduta') ?? '',
            'acao_tomada' => $this->input->post('acao_tomada') ?? '',
            'data_ocorrencia' => $this->input->post('data_ocorrencia') ?? '',
            'status' => $this->input->post('estado') ?? '',
        ];
		$this->form_validation->set_rules('conduta', 'Conduta', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('staff', 'Usuário', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('acao_tomada', 'Ação Tomada', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_ocorrencia', 'Data Ocorrência', 'required', ['required' => 'Preencha o campo {field}']);
		$enum_valido = ['resolvido', 'ativo'];
		$this->form_validation->set_rules('estado', 'Estado', ['required', [
            'enum', function ($value) use ($enum_valido) {
                return in_array($value, $enum_valido);
            }
        ]], ['required' => 'Selecione um {field}', 'enum' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido)]);
		if (!$this->form_validation->run()) {
			$dataView['title'] = _l('pe_editar_violacao');
			$dataView['condutas'] = $this->Pe_conduta_model->get();
			$dataView['staffs'] = $this->db->get('staff')->result_array();

			$dataView['violacao'] = $vfViolacao;
			$this->load->view('conduta_etica/editar_violacao', $dataView);
        }
		else {
			$insert = $this->Pe_conduta_violacao_model->update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/conduta_etica/violacao_editar/'.$id);
		}
	}
}