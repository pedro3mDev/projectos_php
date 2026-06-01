<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Processo Controller
 */
class Processos extends AdminController {
	public function __construct() {
		parent::__construct();
		$this->load->model('Pe_politica_empresa_model');
		$this->load->model('Pe_politica_model');
		$this->load->model('Pe_processo_model');

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
		$data['title'] = _l('pe_processos');

		$data['politicas'] = $this->Pe_politica_model->get();
		$data['staffs'] = $this->Pe_politica_empresa_model->staffs();
		$data['staff_list'] = $this->Pe_politica_empresa_model->staffs_admin();

		$data['processos'] = $this->Pe_processo_model->get();
		$this->load->view('processos/index', $data);
	}

	public function add_processo() {
		$this->http_method('POST');

		$this->form_validation->set_rules('staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('politica', _l('pe_politica'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('titulo', 'Titulo', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', 'Descrição', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_verificacao', 'Data Verificação', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			return redirect('politicas_empresa/processos');
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
					return redirect('politicas_empresa/processos');
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
				'titulo' => $this->input->post('titulo') ?? '',
				'descricao' => $this->input->post('descricao') ?? '',
				'arquivo' => $file_upload ? $upload_data['file_name'] : null,
				'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
			];

			$insert = $this->Pe_processo_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/processos');
		}
	}

	public function processo ($id) {
		$vfprocesso = $this->Pe_processo_model->first($id);
		$data['title'] = $vfprocesso['titulo'];
		$data['processo'] = $vfprocesso;

		$this->load->view('processos/processo', $data);
	}
	public function processo_editar ($id) {
		$vfprocesso = $this->Pe_processo_model->first($id);
		$data['title'] = _l('pe_editar');
		$data['processo'] = $vfprocesso;

		$data['politicas'] = $this->Pe_politica_model->get();
		$data['staffs'] = $this->Pe_politica_empresa_model->staffs();
		$data['staff_list'] = $this->Pe_politica_empresa_model->staffs_admin();

		$this->load->view('processos/processo_editar', $data);
	}
	public function actualizar_processo($id) {
		$this->http_method('POST');
		$vfprocesso = $this->Pe_processo_model->first($id);

		$this->form_validation->set_rules('staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('politica', _l('pe_politica'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('titulo', 'Titulo', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', 'Descrição', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_verificacao', 'Data Verificação', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			return redirect('politicas_empresa/processos/processo_editar/'.$vfprocesso['id']);
        }
		else {
			$data = [
				'colaborador_id' => $this->input->post('staff') ?? '',
				'politica_id' => $this->input->post('politica') ?? '',
				'data_verificacao' => $this->input->post('data_verificacao') ?? '',
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
					return redirect('politicas_empresa/processos/processo_editar/'.$vfprocesso['id']);
				}
				else {
					$upload_data = $this->upload->data();
					$data['arquivo'] = $upload_data['file_name'];
				}
			}

			$insert = $this->Pe_processo_model->update($data, $id);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/processos/processo_editar/'.$vfprocesso['id']);
		}
	}
	public function delete_processo ($id) {
		$this->Pe_processo_model->first($id);
		$this->Pe_processo_model->delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('politicas_empresa/processos');
	}
	public function status_aprovar ($id) {
		$vf = $this->Pe_processo_model->first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('politicas_empresa/processos/processo/'.$id);
		}
		if ($vf['status'] != 'pendente') {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('politicas_empresa/processos/processo/'.$id);
		}
		$this->Pe_processo_model->aprovar(['status' => 'aprovado'], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('politicas_empresa/processos/processo/'.$id);
	}
	public function status_rejeitar ($id) {
		$vf = $this->Pe_processo_model->first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('politicas_empresa/processos/processo/'.$id);
		}
		if ($vf['status'] != 'pendente') {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('politicas_empresa/processos/processo/'.$id);
		}
		$this->Pe_processo_model->rejeitar(['status' => 'rejeitado'], $id);
		set_alert('success',"Comunicação Rejeitada.");
		return redirect('politicas_empresa/processos/processo/'.$id);
	}
}