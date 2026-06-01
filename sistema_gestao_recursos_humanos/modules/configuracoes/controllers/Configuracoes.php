<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Politicas Empresa Controller
 */
class Configuracoes extends AdminController {
	public function __construct() { 
		parent::__construct();
		$this->load->model('Configuracoes_model');

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
		$data['title'] = _l('Configurações');

		$data['total_modulos'] = $this->Configuracoes_model->total_modulos();
		$data['total_permissoes'] = $this->Configuracoes_model->total_permissoes();
		$data['total_conselhos'] = $this->Configuracoes_model->total_conselhos();
		$data['total_pelorios'] = $this->Configuracoes_model->total_pelorios();
		$data['total_direccoes'] = $this->Configuracoes_model->total_direccoes();
		$data['total_departamentos'] = $this->Configuracoes_model->total_departamentos();
		$data['total_seccoes'] = $this->Configuracoes_model->total_seccoes();
		$data['total_cargos'] = $this->Configuracoes_model->total_cargos();

		$data['logs_sistema'] = $this->Configuracoes_model->logs_get();
		$data['marcacoes'] = $this->Configuracoes_model->marcacoes_get();

		$this->load->view('index', $data);
	}
	// geral
	public function geral() {
		$data['title'] = _l('Configurações Geral');
		$this->load->view('geral', $data);
	}
	// sistema
	public function sistema() {
		$data['title'] = _l('Configurações Sistema');
		$data['group'] = $this->input->get('group');
		$data['tab'][] = 'permissoes';
		$data['tab'][] = 'redifinir_dados';
		$data['tab'][] = 'conselhos';
		$data['tab'][] = 'pelorios';
		$data['tab'][] = 'direcoes';
		$data['tab'][] = 'departamentos';
		$data['tab'][] = 'seccoes';

		$data['staffs'] = $this->Configuracoes_model->staffs();

		if ($data['group'] == '') {
			$data['title'] = _l('permissoes');
			$data['group'] = 'permissoes';
		} elseif ($data['group'] == 'permissoes') {
			$data['title'] = _l('permissoes');
			$data['group'] = 'permissoes';
		} elseif ($data['group'] == 'redifinir_dados') {
			$data['title'] = _l('redifinir_dados');
			$data['group'] = 'redifinir_dados';
		} elseif ($data['group'] == 'conselhos') {
			$data['title'] = _l('conselhos');
			// $data['conselhos'] = $this->db->get(db_prefix() . 'hr_conselhos')->result_array();
			$data['conselhos'] = $this->Configuracoes_model->conselhos_get();
		} elseif ($data['group'] == 'pelorios') {
			$data['title'] = _l('pelorios');
			$data['conselhos'] = $this->db->get(db_prefix() . 'hr_conselhos')->result_array();
			$data['pelorios'] = $this->Configuracoes_model->pelorios_get();
		} elseif ($data['group'] == 'direcoes') {
			$data['title'] = _l('direcoes');
			$data['pelorios'] = $this->Configuracoes_model->pelorios_get();
			$data['direcoes'] = $this->Configuracoes_model->direcao_get();
		} elseif ($data['group'] == 'departamentos') {
			$data['title'] = _l('departamentos');
			$data['direcoes'] = $this->Configuracoes_model->direcao_get();
			$data['departamentos'] = $this->Configuracoes_model->departamento_get();
		} elseif ($data['group'] == 'seccoes') {
			$data['title'] = _l('seccoes');
			$data['departamentos'] = $this->Configuracoes_model->departamento_get();
			$data['seccoes'] = $this->Configuracoes_model->seccao_get();
		} else {
			set_alert('danger',"Definições não encontrada");
			redirect('configuracoes/sistema?group=permissoes');
		}

		$data['tabs']['view'] = 'includes/' . $data['group'];

		$this->load->view('sistema', $data);
	}
	// permissoes
	public function permissoes() {
		$data['title'] = _l('Permissões');
		$this->load->view('permissoes', $data);
	}
	// redifinir_dados
	public function redifinir_dados() {
		$data['title'] = _l('Configurações');
		$this->load->view('redifinir_dados', $data);
	}

	public function add_conselho () {
		$this->http_method('POST');
		$data = [
            'nome' => $this->input->post('conselho') ?? '',
            'gerente_id' => $this->input->post('staff') ?? '',
        ];
		$this->form_validation->set_rules('conselho', _l('conselho'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('configuracoes/sistema?group=conselhos');
        }
		else {
			$insert = $this->Configuracoes_model->conselho_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('configuracoes/sistema?group=conselhos');
		}
	}
	public function editar_conselho ($id) {
		$this->http_method('POST');
		$this->Configuracoes_model->conselho_first($id);

		$data = [
            'nome' => $this->input->post('e_conselho') ?? '',
			'gerente_id' => $this->input->post('e_staff') ?? '',
        ];
		$this->form_validation->set_rules('e_conselho', _l('conselho'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('configuracoes/sistema?group=conselhos');
        }
		else {
			$this->Configuracoes_model->conselho_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('configuracoes/sistema?group=conselhos');
		}
	}
	public function delete_conselho ($id) {
		$this->Configuracoes_model->conselho_first($id);
		$this->Configuracoes_model->conselho_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('configuracoes/sistema?group=conselhos');
	}

	public function add_pelorio () {
		$this->http_method('POST');
		$data = [
            'conselho_id' => $this->input->post('conselho') ?? '',
			'gerente_id' => $this->input->post('staff') ?? '',
            'nome' => $this->input->post('pelorio') ?? '',
        ];
		$this->form_validation->set_rules('staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('conselho', _l('conselho'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('pelorio', _l('pelorio'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('configuracoes/sistema?group=pelorios');
        }
		else {
			$insert = $this->Configuracoes_model->pelorio_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('configuracoes/sistema?group=pelorios');
		}
	}
	public function editar_pelorio ($id) {
		$this->http_method('POST');
		$this->Configuracoes_model->conselho_first($id);

		$data = [
            'conselho_id' => $this->input->post('e_conselho') ?? '',
			'gerente_id' => $this->input->post('e_staff') ?? '',
            'nome' => $this->input->post('e_pelorio') ?? '',
        ];
		$this->form_validation->set_rules('e_staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_conselho', _l('conselho'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_pelorio', _l('e_pelorio'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('configuracoes/sistema?group=pelorios');
        }
		else {
			$this->Configuracoes_model->pelorio_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('configuracoes/sistema?group=pelorios');
		}
	}
	public function delete_pelorio ($id) {
		$this->Configuracoes_model->pelorio_first($id);
		$this->Configuracoes_model->pelorio_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('configuracoes/sistema?group=pelorios');
	}

	public function add_direcao () {
		$this->http_method('POST');
		$data = [
            'pelorios_id' => $this->input->post('pelorio') ?? '',
			'gerente_id' => $this->input->post('staff') ?? '',
            'nome' => $this->input->post('direcao') ?? '',
        ];
		$this->form_validation->set_rules('staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('pelorio', _l('pelorio'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('direcao', _l('direcao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('configuracoes/sistema?group=direcoes');
        }
		else {
			$insert = $this->Configuracoes_model->direcao_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('configuracoes/sistema?group=direcoes');
		}
	}
	public function editar_direcao ($id) {
		$this->http_method('POST');
		$this->Configuracoes_model->direcao_first($id);

		$data = [
            'pelorios_id' => $this->input->post('e_pelorio') ?? '',
			'gerente_id' => $this->input->post('e_staff') ?? '',
            'nome' => $this->input->post('e_direcao') ?? '',
        ];
		$this->form_validation->set_rules('e_staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_pelorio', _l('Pelorio'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_direcao', _l('e_direcao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('configuracoes/sistema?group=direcoes');
        }
		else {
			$this->Configuracoes_model->direcao_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('configuracoes/sistema?group=direcoes');
		}
	}
	public function delete_direcao ($id) {
		$this->Configuracoes_model->direcao_first($id);
		$this->Configuracoes_model->direcao_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('configuracoes/sistema?group=direcoes');
	}

	public function add_departamento () {
		$this->http_method('POST');
		$data = [
            'direcoes_id' => $this->input->post('direcao') ?? '',
			'gerente_id' => $this->input->post('staff') ?? '',
            'name' => $this->input->post('departamento') ?? '',
        ];
		$this->form_validation->set_rules('staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('direcao', _l('direcao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('departamento', _l('departamento'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('configuracoes/sistema?group=departamentos');
        }
		else {
			$insert = $this->Configuracoes_model->departamento_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('configuracoes/sistema?group=departamentos');
		}
	}
	public function editar_departamento ($id) {
		$this->http_method('POST');
		$this->Configuracoes_model->departamento_first($id);

		$data = [
            'direcoes_id' => $this->input->post('e_direcao') ?? '',
			'gerente_id' => $this->input->post('e_staff') ?? '',
            'name' => $this->input->post('e_departamento') ?? '',
        ];
		$this->form_validation->set_rules('e_staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_direcao', _l('Direção'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_departamento', _l('e_departamento'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('configuracoes/sistema?group=departamentos');
        }
		else {
			$this->Configuracoes_model->departamento_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('configuracoes/sistema?group=departamentos');
		}
	}
	public function delete_departamento ($id) {
		$this->Configuracoes_model->departamento_first($id);
		$this->Configuracoes_model->departamento_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('configuracoes/sistema?group=departamentos');
	}

	public function add_seccao () {
		$this->http_method('POST');
		$data = [
            'departments_id' => $this->input->post('departamento') ?? '',
			'gerente_id' => $this->input->post('staff') ?? '',
            'nome' => $this->input->post('seccao') ?? '',
        ];
		$this->form_validation->set_rules('staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('departamento', _l('departamento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('seccao', _l('seccao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('configuracoes/sistema?group=seccoes');
        }
		else {
			$insert = $this->Configuracoes_model->seccao_create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('configuracoes/sistema?group=seccoes');
		}
	}
	public function editar_seccao ($id) {
		$this->http_method('POST');
		$this->Configuracoes_model->seccao_first($id);
		$data = [
            'departments_id' => $this->input->post('e_departamento') ?? '',
			'gerente_id' => $this->input->post('e_staff') ?? '',
            'nome' => $this->input->post('e_seccao') ?? '',
        ];
		$this->form_validation->set_rules('e_staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_seccao', _l('Secção'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_departamento', _l('e_departamento'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('configuracoes/sistema?group=seccoes');
        }
		else {
			$this->Configuracoes_model->seccao_update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('configuracoes/sistema?group=seccoes');
		}
	}
	public function delete_seccao ($id) {
		$this->Configuracoes_model->seccao_first($id);
		$this->Configuracoes_model->seccao_delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('configuracoes/sistema?group=seccoes');
	}
}