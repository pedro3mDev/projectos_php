<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Revisoes Controller
 */
class Revisoes extends AdminController {
	public function __construct() {
		parent::__construct();
		$this->load->model('Pe_politica_empresa_model');
		$this->load->model('Pe_politica_model');
		$this->load->model('Pe_procedimento_model');
		$this->load->model('Pe_tipo_procedimento_model');
		$this->load->model('Pe_revisao_model');

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
		$data['title'] = _l('pe_revisoes');

		$data['politicas'] = $this->Pe_politica_model->get();
		$data['staffs'] = $this->Pe_politica_empresa_model->staffs();

		$data['revisoes'] = $this->Pe_revisao_model->get();

		$data['staff_list'] = $this->Pe_politica_empresa_model->staffs_admin();

		$this->load->view('revisoes/index', $data);
	}

	public function add_revisao() {
		$this->http_method('POST');
		$this->form_validation->set_rules('politica', _l('pe_politica'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', _l('description'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('alteracao', _l('alteracao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			return redirect('politicas_empresa/revisoes');
        }
		else {
			$data = [
				'staff_id' => get_staff_user_id(), // ID do Usuario Logado
				'politica_id' => $this->input->post('politica') ?? '',
				'alteracao' => $this->input->post('alteracao') ?? '',
				'descricao' => $this->input->post('descricao') ?? '',
				'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
			];

			$insert = $this->Pe_revisao_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/revisoes');
		}
	}
	public function delete_revisao ($id) {
		$this->Pe_revisao_model->first($id);
		$this->Pe_revisao_model->delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('politicas_empresa/procedimentos');
	}

	public function revisao ($id) {
		$vfrevisao = $this->Pe_revisao_model->first($id);
		$data['title'] = limitarPalavra($vfrevisao['descricao'], 10);
		$data['revisao'] = $vfrevisao;

		$this->load->view('revisoes/revisao', $data);
	}
	public function revisao_editar ($id) {
		$vfrevisao = $this->Pe_revisao_model->first($id);
		$data['title'] = limitarPalavra($vfrevisao['descricao'], 10);
		$data['revisao'] = $vfrevisao;

		$data['politicas'] = $this->Pe_politica_model->get();
		$data['staff_list'] = $this->Pe_politica_empresa_model->staffs_admin();

		$this->load->view('revisoes/revisao_editar', $data);
	}
	public function actualizar_revisao($id) {
		$this->http_method('POST');
		$this->Pe_revisao_model->first($id);

		$this->form_validation->set_rules('politica', _l('pe_politica'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', _l('description'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('alteracao', _l('alteracao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			return redirect('politicas_empresa/revisoes/revisao_editar/'. $id);
        }
		else {
			$data = [
				'politica_id' => $this->input->post('politica') ?? '',
				'alteracao' => $this->input->post('alteracao') ?? '',
				'descricao' => $this->input->post('descricao') ?? '',
				'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
			];
			$insert = $this->Pe_revisao_model->update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/revisoes/revisao_editar/'. $id);
		}
	}
	public function status_aprovar ($id) {
		$vf = $this->Pe_revisao_model->first($id);
		if ($vf['status'] != 'pendente') {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('politicas_empresa/revisoes/revisao/'.$id);
		}
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('politicas_empresa/revisoes/revisao/'.$id);
		}
		$this->Pe_revisao_model->aprovar(['status' => 'aprovado'], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('politicas_empresa/revisoes/revisao/'.$id);
	}
	public function status_rejeitar ($id) {
		$vf = $this->Pe_revisao_model->first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('politicas_empresa/revisoes/revisao/'.$id);
		}
		if ($vf['status'] != 'pendente') {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('politicas_empresa/revisoes/revisao/'.$id);
		}
		$this->Pe_revisao_model->rejeitar(['status' => 'rejeitado'], $id);
		set_alert('success',"Politica Rejeitada.");
		return redirect('politicas_empresa/revisoes/revisao/'.$id);
	}
}