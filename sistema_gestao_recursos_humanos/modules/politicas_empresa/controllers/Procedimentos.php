<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Procedimentos Controller
 */
class Procedimentos extends AdminController {
	public function __construct() {
		parent::__construct();
		$this->load->model('Pe_politica_empresa_model');
		$this->load->model('Pe_politica_model');
		$this->load->model('Pe_procedimento_model');
		$this->load->model('Pe_processo_model');
		$this->load->model('Pe_tipo_procedimento_model');

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
		$data['title'] = _l('pe_procedimentos');

		$data['tipos_procedimento'] = $this->Pe_tipo_procedimento_model->get();
		$data['politicas'] = $this->Pe_politica_model->get();
		$data['processos'] = $this->Pe_processo_model->get('aprovado');
		$data['staffs'] = $this->Pe_politica_empresa_model->staffs();

		$data['procedimentos'] = $this->Pe_procedimento_model->get();

		$data['staff_list'] = $this->Pe_politica_empresa_model->staffs_admin();

		$this->load->view('procedimentos/index', $data);
	}

	public function add_procedimento() {
		$this->http_method('POST');
		$this->form_validation->set_rules('staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('politica', _l('pe_politica'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('tipo_procedimento', _l('tipo_procedimento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('processo', _l('processo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);

		$this->form_validation->set_rules('procedimento', _l('description'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', _l('description'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			return redirect('politicas_empresa/procedimentos');
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
					return redirect('politicas_empresa/procedimentos');
				}
				else {
					$file_upload = TRUE;
					$upload_data = $this->upload->data();
				}
			}

			$data = [
				'staff_id' => get_staff_user_id(), // ID do Usuario Logado
				'staff_procedimento_id' => $this->input->post('staff') ?? '',
				'politica_id' => $this->input->post('politica') ?? '',
				'tipo_procedimento_id' => $this->input->post('tipo_procedimento') ?? '',
				'processo_id' => $this->input->post('processo') ?? '',
				'procedimento' => $this->input->post('procedimento') ?? '',
				'descricao' => $this->input->post('descricao') ?? '',
				'arquivo' => $file_upload ? $upload_data['file_name'] : null,
				'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
			];

			$insert = $this->Pe_procedimento_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/procedimentos');
		}
	}
	public function delete_procedimento ($id) {
		$this->Pe_procedimento_model->first($id);
		$this->Pe_procedimento_model->delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('politicas_empresa/procedimentos');
	}

	public function procedimento ($id) {
		$vfprocedimento = $this->Pe_procedimento_model->first($id);
		$data['title'] = $vfprocedimento['procedimento'];
		$data['procedimento'] = $vfprocedimento;

		$this->load->view('procedimentos/procedimento', $data);
	}
	public function procedimento_editar ($id) {
		$vfprocedimento = $this->Pe_procedimento_model->first($id);
		$data['title'] = $vfprocedimento['procedimento'];
		$data['procedimento'] = $vfprocedimento;

		$data['tipos_procedimento'] = $this->Pe_tipo_procedimento_model->get();
		$data['politicas'] = $this->Pe_politica_model->get();
		$data['staffs'] = $this->Pe_politica_empresa_model->staffs();
		$data['processos'] = $this->Pe_processo_model->get('aprovado');


		$data['staff_list'] = $this->Pe_politica_empresa_model->staffs_admin();

		$this->load->view('procedimentos/procedimento_editar', $data);
	}
	public function actualizar_procedimento($id) {
		$this->http_method('POST');
		$this->Pe_procedimento_model->first($id);

		$this->form_validation->set_rules('staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('politica', _l('pe_politica'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('tipo_procedimento', _l('tipo_procedimento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('processo', _l('processo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);

		$this->form_validation->set_rules('procedimento', _l('description'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', _l('description'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			return redirect('politicas_empresa/procedimentos/procedimento/'. $id);
        }
		else {
			$data = [
				'staff_procedimento_id' => $this->input->post('staff') ?? '',
				'politica_id' => $this->input->post('politica') ?? '',
				'tipo_procedimento_id' => $this->input->post('tipo_procedimento') ?? '',
				'processo_id' => $this->input->post('processo') ?? '',
				'procedimento' => $this->input->post('procedimento') ?? '',
				'descricao' => $this->input->post('descricao') ?? '',
				'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
			];
			if (!empty($_FILES['arquivo']['name'])) {
				$conf_u['upload_path'] = FCPATH. 'modules/politicas_empresa/uploads/';
				$conf_u['allowed_types'] = 'jpg|png|jpeg|pdf|docx|doc';
				$conf_u['encrypt_name'] = TRUE;

				$this->upload->initialize($conf_u);
				if (!$this->upload->do_upload('arquivo')) {
					set_alert('danger',"Houve algum erro, ao carregar o arquivo. Selecione um formato valíddo");
					return redirect('politicas_empresa/procedimentos/procedimento/'. $id);
				}
				else {
					$upload_data = $this->upload->data();
					$data['arquivo'] = $upload_data['file_name'];
				}
			}

			$insert = $this->Pe_procedimento_model->update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/procedimentos/procedimento/'. $id);
		}
	}
	public function status_aprovar ($id) {
		$vf = $this->Pe_procedimento_model->first($id);
		if ($vf['status'] != 'pendente') {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('politicas_empresa/procedimentos/procedimento/'.$id);
		}
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('politicas_empresa/procedimentos/procedimento/'.$id);
		}
		$this->Pe_procedimento_model->aprovar(['status' => 'aprovado'], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('politicas_empresa/procedimentos/procedimento/'.$id);
	}
	public function status_rejeitar ($id) {
		$vf = $this->Pe_procedimento_model->first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('politicas_empresa/procedimentos/procedimento/'.$id);
		}
		if ($vf['status'] != 'pendente') {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('politicas_empresa/procedimentos/procedimento/'.$id);
		}
		$this->Pe_procedimento_model->rejeitar(['status' => 'rejeitado'], $id);
		set_alert('success',"Politica Rejeitada.");
		return redirect('politicas_empresa/procedimentos/procedimento/'.$id);
	}
}