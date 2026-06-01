<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Recruitment Controller
 */
class Gestao_formacao extends AdminController {
	public function __construct() {
		parent::__construct();
		$this->load->model('Gestao_formacao_model');
		$this->load->library(['form_validation', 'upload']);
	}
	private function http_method ($vfMethod) {
        if ($_SERVER['REQUEST_METHOD'] !== $vfMethod) {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['status' => false, 'message' => 'Metodo não permitido']);
            exit;
        }
    }
	/**
	 * Tela de Dashboard
	 */
	public function dashboard() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Dashboard');
		$data['total_categoria'] = $this->Gestao_formacao_model->total_categoria();
		$data['inscritos_total'] = $this->Gestao_formacao_model->inscritos_total();
		$data['total_risco'] = $this->Gestao_formacao_model->total_risco();

		// Cursos
		$data['total_curso'] = $this->Gestao_formacao_model->total_curso();
		$data['total_curso_p'] = $this->Gestao_formacao_model->total_curso(1);
		$data['total_curso_a'] = $this->Gestao_formacao_model->total_curso(2);
		$data['total_curso_r'] = $this->Gestao_formacao_model->total_curso(3);

		// Recrutamento
		$data['total_recrutamento_p'] = $this->Gestao_formacao_model->total_recrutamento(1);
		$data['total_recrutamento_a'] = $this->Gestao_formacao_model->total_recrutamento(2);
		$data['total_recrutamento_r'] = $this->Gestao_formacao_model->total_recrutamento(3);

		$data['dashboard_curso'] = $this->Gestao_formacao_model->dashboard_curso();
		$data['dashboard_vaga'] = $this->Gestao_formacao_model->dashboard_vaga();

		$data['total_plataforma_ead'] = $this->Gestao_formacao_model->total_plataforma_ead();
		$data['total_plataforma_ead_p'] = $this->Gestao_formacao_model->total_plataforma_ead(1);
		$data['total_plataforma_ead_a'] = $this->Gestao_formacao_model->total_plataforma_ead(2);
		$data['total_plataforma_ead_r'] = $this->Gestao_formacao_model->total_plataforma_ead(3);

		$data['total_acessibilidade'] = $this->Gestao_formacao_model->total_acessibilidade();
		$data['total_acessibilidade_p'] = $this->Gestao_formacao_model->total_acessibilidade(1);
		$data['total_acessibilidade_a'] = $this->Gestao_formacao_model->total_acessibilidade(2);
		$data['total_acessibilidade_r'] = $this->Gestao_formacao_model->total_acessibilidade(3);

		$this->load->view('dashboard/index', $data);
	}

	/************************************************************
	 * 						Tela de Cursos
	 ************************************************************/
	public function cursos() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Dashboard');
		$data['categorias'] = $this->Gestao_formacao_model->get_categoria();
		$data['status'] = $this->Gestao_formacao_model->get_status();
		$data['staff_list'] = $this->Gestao_formacao_model->staffs_admin();
        $data['staffs'] = $this->Gestao_formacao_model->staffs();

		$data['cursos'] = $this->Gestao_formacao_model->get_curso();
		$data['total_curso'] = $this->Gestao_formacao_model->total_curso();
		$data['total_curso_p'] = $this->Gestao_formacao_model->total_curso(1);
		$data['total_curso_a'] = $this->Gestao_formacao_model->total_curso(2);
		$data['total_curso_r'] = $this->Gestao_formacao_model->total_curso(3);

		$this->load->view('cursos/index_cursos', $data);
	}
	public function add_curso () {
		$this->http_method('POST');

		$data = [
            'status_id' => 1,
            'categoria_id' => $this->input->post('categoria') ?? '',
            'nome' => $this->input->post('nome') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
            'carga_horaria' => $this->input->post('carga_horaria') ?? '',
            'publico_alvo' => $this->input->post('publico_alvo') ?? '',
            'requisitos' => $this->input->post('requisitos') ?? '',
            'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];
		$this->form_validation->set_rules('categoria', _l('categoria'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('nome', _l('nome'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('carga_horaria', _l('carga_horaria'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('publico_alvo', _l('publico_alvo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('requisitos', _l('requisitos'), 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/cursos');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_curso($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/cursos');
		}
	}
	public function editar_curso ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_curso($id);

		$data = [
            'categoria_id' => $this->input->post('e_categoria') ?? '',
            'nome' => $this->input->post('e_nome') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
            'carga_horaria' => $this->input->post('e_carga_horaria') ?? '',
            'publico_alvo' => $this->input->post('e_publico_alvo') ?? '',
            'requisitos' => $this->input->post('e_requisitos') ?? '',
            'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];
		$this->form_validation->set_rules('e_categoria', _l('categoria'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_nome', _l('nome'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_carga_horaria', _l('carga_horaria'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_publico_alvo', _l('publico_alvo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_requisitos', _l('requisitos'), 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/cursos');
        }
		else {
			$insert = $this->Gestao_formacao_model->update_curso($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_formacao/cursos');
		}
	}
	public function curso_aprovar($id) {
        $vf = $this->Gestao_formacao_model->first_curso($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_formacao/cursos');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_formacao/cursos');
		}
		$this->Gestao_formacao_model->update_curso(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('gestao_formacao/cursos');
    }
    public function curso_rejeitar($id) {
        $vf = $this->Gestao_formacao_model->first_curso($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_formacao/cursos');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_formacao/cursos');
		}
		$this->Gestao_formacao_model->update_curso(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('gestao_formacao/cursos');
    }
	public function delete_curso ($id) {
		$this->Gestao_formacao_model->first_curso($id);
		$this->Gestao_formacao_model->delete_curso($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/cursos');
	}

	public function cursos_categoria() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Categoria');
		$data['categorias'] = $this->Gestao_formacao_model->get_categoria();

		$this->load->view('cursos/categoria', $data);
	}
	public function add_categoria () {
		$this->http_method('POST');

		$data = [
            'nome' => $this->input->post('nome') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
        ];
		$this->form_validation->set_rules('nome', _l('nome'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/cursos_categoria');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_categoria($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/cursos_categoria');
		}
	}
	public function editar_categoria ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_categoria($id);

		$data = [
            'nome' => $this->input->post('e_nome') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
        ];
		$this->form_validation->set_rules('e_nome', _l('nome'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/cursos_categoria');
        }
		else {
			$this->Gestao_formacao_model->update_categoria($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_formacao/cursos_categoria');
		}
	}
	public function delete_categoria ($id) {
		$this->Gestao_formacao_model->first_categoria($id);
		$this->Gestao_formacao_model->delete_categoria($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/cursos_categoria');
	}

	public function cursos_vagas() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Vagas');
		$data['cursos'] = $this->Gestao_formacao_model->get_curso(2);

		$data['vagas'] = $this->Gestao_formacao_model->get_vaga();
		$this->load->view('cursos/vagas', $data);
	}
	public function add_vaga () {
		$this->http_method('POST');

		$data = [
            'curso_id' => $this->input->post('curso') ?? '',
            'total_vagas' => $this->input->post('total_vagas') ?? '',
            'data_inicio' => $this->input->post('data_inicio') ?? '',
            'data_fim' => $this->input->post('data_fim') ?? '',
        ];
		$this->form_validation->set_rules('curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('total_vagas', _l('total_vagas'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_inicio', _l('data_inicio'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_fim', _l('data_fim'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/cursos_vagas');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_vaga($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/cursos_vagas');
		}
	}
	public function editar_vaga ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_vaga($id);

		$data = [
            'curso_id' => $this->input->post('e_curso') ?? '',
            'total_vagas' => $this->input->post('e_total_vagas') ?? '',
            'data_inicio' => $this->input->post('e_data_inicio') ?? '',
            'data_fim' => $this->input->post('e_data_fim') ?? '',
        ];
		$this->form_validation->set_rules('e_curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_total_vagas', _l('total_vagas'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_data_inicio', _l('data_inicio'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_data_fim', _l('data_fim'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/cursos_vagas');
        }
		else {
			$insert = $this->Gestao_formacao_model->update_vaga($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_formacao/cursos_vagas');
		}
	}
	public function delete_vaga ($id) {
		$this->Gestao_formacao_model->first_vaga($id);
		$this->Gestao_formacao_model->delete_vaga($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/cursos_vagas');
	}

	public function cursos_Inscricoes() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Inscricoes');
		$data['status'] = $this->Gestao_formacao_model->get_status();
		$data['staff_list'] = $this->Gestao_formacao_model->staffs_admin();
        $data['staffs'] = $this->Gestao_formacao_model->staffs();
		$data['cursos'] = $this->Gestao_formacao_model->get_curso(2);
		$data['vagas'] = $this->Gestao_formacao_model->get_vaga();

		$data['inscricoes'] = $this->Gestao_formacao_model->get_inscricao();
		$this->load->view('cursos/Inscricoes', $data);
	}
	public function add_inscricao () {
		$this->http_method('POST');

		$data = [
            'status_id' => 1,
            'vaga_id' => $this->input->post('vaga') ?? '',
            'staff_id' => $this->input->post('staff') ?? '',
            'data_inscricao' => $this->input->post('data_inscricao') ?? '',
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];
		$this->form_validation->set_rules('staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('vaga', _l('vaga'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_inscricao', _l('data_inscricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/cursos_Inscricoes');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_inscricao($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/cursos_Inscricoes');
		}
	}
	public function editar_inscricao ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_inscricao($id);

		$data = [
            'vaga_id' => $this->input->post('e_vaga') ?? '',
            'staff_id' => $this->input->post('e_staff') ?? '',
            'data_inscricao' => $this->input->post('e_data_inscricao') ?? '',
			'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];
		$this->form_validation->set_rules('e_staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_vaga', _l('vaga'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_data_inscricao', _l('data_inscricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/cursos_Inscricoes');
        }
		else {
			$insert = $this->Gestao_formacao_model->update_inscricao($data, $id);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/cursos_Inscricoes');
		}
	}
	public function inscricao_aprovar($id) {
        $vf = $this->Gestao_formacao_model->first_inscricao($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_formacao/cursos_Inscricoes');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_formacao/cursos_Inscricoes');
		}
		// Verificar o Numero de Vagas
		$total_inscrito = $this->Gestao_formacao_model->inscritos_total(2, $vf['vaga_id']);
		if ($total_inscrito >= $vf['total_vagas']) {
			set_alert('danger',"Erro, não ha vaga disponível.");
			return redirect('gestao_formacao/cursos_Inscricoes');
		}

		$this->Gestao_formacao_model->update_inscricao(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('gestao_formacao/cursos_Inscricoes');
    }
    public function inscricao_rejeitar($id) {
        $vf = $this->Gestao_formacao_model->first_inscricao($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_formacao/cursos_Inscricoes');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_formacao/cursos_Inscricoes');
		}
		$this->Gestao_formacao_model->update_inscricao(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('gestao_formacao/cursos_Inscricoes');
    }
	public function delete_inscricao ($id) {
		$this->Gestao_formacao_model->first_inscricao($id);
		$this->Gestao_formacao_model->delete_inscricao($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/cursos_Inscricoes');
	}

	public function cursos_visualizar_curso() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Visualizar');
		$this->load->view('cursos/visualizar_curso', $data);
	}

	public function cursos_visualizar_categoria() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Visualizar');
		$this->load->view('cursos/visualizar_categoria', $data);
	}

	public function cursos_visualizar_vaga() { 
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Visualizar'); 
		$this->load->view('cursos/visualizar_vaga', $data);
	}

	public function cursos_visualizar_inscricoes() { 
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Visualizar'); 
		$this->load->view('cursos/visualizar_inscricoes', $data);
	}


	 /************************************************************
	 * 						Tela de formacao
	 ************************************************************/
	public function formacao() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('formacao');
		$data['status'] = $this->Gestao_formacao_model->get_status();
		$data['staff_list'] = $this->Gestao_formacao_model->staffs_admin();
        $data['staffs'] = $this->Gestao_formacao_model->staffs();
		$data['cursos'] = $this->Gestao_formacao_model->get_curso(2);

		$data['historico_formacao'] = $this->Gestao_formacao_model->get_historico_formacao();

		$data['total_historico_formacao'] = $this->Gestao_formacao_model->total_historico_formacao();
		$data['total_historico_formacao_p'] = $this->Gestao_formacao_model->total_historico_formacao(1);
		$data['total_historico_formacao_a'] = $this->Gestao_formacao_model->total_historico_formacao(2);
		$data['total_historico_formacao_r'] = $this->Gestao_formacao_model->total_historico_formacao(3);

		$this->load->view('formacao/index_formacao', $data);
	}
	public function add_historico_formacao () {
		$this->http_method('POST');

		$data = [
            'status_id' => 1,
            'curso_id' => $this->input->post('curso') ?? '',
            'staff_id' => $this->input->post('staff') ?? '',
            'data_inscricao' => $this->input->post('data_inscricao') ?? '',
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

		$this->form_validation->set_rules('curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_inscricao', _l('data_inscricao'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/formacao');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_historico_formacao($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/formacao');
		}
	}
	public function editar_historico_formacao ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_historico_formacao($id);

		$data = [
            'curso_id' => $this->input->post('e_curso') ?? '',
            'staff_id' => $this->input->post('e_staff') ?? '',
            'data_inscricao' => $this->input->post('e_data_inscricao') ?? '',
			'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

		$this->form_validation->set_rules('e_curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_data_inscricao', _l('data_inscricao'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/formacao');
        }
		else {
			$update = $this->Gestao_formacao_model->update_historico_formacao($data, $id);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/formacao');
		}
	}
	public function delete_historico_formacao ($id) {
		$this->Gestao_formacao_model->first_historico_formacao($id);
		$this->Gestao_formacao_model->delete_historico_formacao($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/formacao');
	}
	public function historico_formacao_aprovar($id) {
        $vf = $this->Gestao_formacao_model->first_historico_formacao($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_formacao/formacao');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_formacao/formacao');
		}

		$this->Gestao_formacao_model->update_historico_formacao(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('gestao_formacao/formacao');
    }
    public function historico_formacao_rejeitar($id) {
        $vf = $this->Gestao_formacao_model->first_historico_formacao($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_formacao/formacao');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_formacao/formacao');
		}
		$this->Gestao_formacao_model->update_historico_formacao(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('gestao_formacao/formacao');
    }

	public function formacao_visualizar_formacao() { 
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Visualizar'); 
		$this->load->view('formacao/visualizar_formacao', $data);
	}

	 /************************************************************
	 * 						Tela de impacto
	 ************************************************************/
	public function impacto() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('impacto');
		$data['vagas'] = $this->Gestao_formacao_model->get_vaga();
		$data['inscricoes'] = $this->Gestao_formacao_model->get_inscricao();

		$data['cursos'] = $this->Gestao_formacao_model->get_curso(2);

		$data['avaliacao'] = $this->Gestao_formacao_model->get_avaliacao();

		$data['total_relatorio_impacto'] = $this->Gestao_formacao_model->total_relatorio_impacto();
		$data['total_avaliacao'] = $this->Gestao_formacao_model->total_avaliacao();

		$this->load->view('impacto/index_impacto', $data);
	}
	public function listar_inscritos($vaga_id)
	{
		if (!$vaga_id) {
			// Retorna um erro se o ID não foi fornecido
			echo json_encode([
				'status' => false,
				'message' => 'ID do direcoes não fornecido.'
			]);
			return;
		}
		$inscritos = $this->Gestao_formacao_model->get_inscricao(2, $vaga_id);

		// Retorna os dados como JSON
		echo json_encode([
			'status' => true,
			'data' => $inscritos
		]);
	}

	public function add_avaliacao () {
		$this->http_method('POST');

		$data = [
            'vaga_id' => $this->input->post('vaga') ?? '',
            'inscricao_id' => $this->input->post('staff') ?? '',
            'nota' => $this->input->post('nota') ?? '',
            'comentario' => $this->input->post('comentario') ?? '',
            'data_avaliacao' => $this->input->post('data_avaliacao') ?? '',
        ];
		$this->form_validation->set_rules('staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('vaga', _l('vaga'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('nota', _l('nota'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('comentario', _l('comentario'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_avaliacao', _l('data_avaliacao'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/impacto');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_avaliacao($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/impacto');
		}
	}
	public function editar_avaliacao ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_avaliacao($id);

		$data = [
            'vaga_id' => $this->input->post('e_vaga') ?? '',
            'inscricao_id' => $this->input->post('e_staff') ?? '',
            'nota' => $this->input->post('e_nota') ?? '',
            'comentario' => $this->input->post('e_comentario') ?? '',
            'data_avaliacao' => $this->input->post('e_data_avaliacao') ?? '',
        ];
		$this->form_validation->set_rules('e_staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_vaga', _l('vaga'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_nota', _l('nota'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_comentario', _l('comentario'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_data_avaliacao', _l('data_avaliacao'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/impacto');
        }
		else {
			$insert = $this->Gestao_formacao_model->update_avaliacao($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_formacao/impacto');
		}
	}
	public function delete_avaliacao ($id) {
		$this->Gestao_formacao_model->first_avaliacao($id);
		$this->Gestao_formacao_model->delete_avaliacao($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/impacto');
	}

	public function impacto_relatorio() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Relatorio');
		$data['cursos'] = $this->Gestao_formacao_model->get_curso(2);
		$data['impacto_qualitativo'] = $this->Gestao_formacao_model->get_impacto_qualitativo();
		$data['impacto_quantitativo'] = $this->Gestao_formacao_model->get_impacto_quantitativo();

		$data['relatorio_impacto'] = $this->Gestao_formacao_model->get_relatorio_impacto();

		$this->load->view('impacto/relatorio', $data);
	}
	public function add_relatorio_impacto () {
		$this->http_method('POST');

		$data = [
            'curso_id' => $this->input->post('curso') ?? '',
            'impacto_qualitativo_id' => $this->input->post('impacto_qualitativo') ?? '',
            'impacto_quantitativo_id' => $this->input->post('impacto_quantitativo') ?? '',
            'data_relatorio' => $this->input->post('data_relatorio') ?? '',
        ];
		$this->form_validation->set_rules('curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('impacto_quantitativo', _l('impacto_quantitativo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('impacto_quantitativo', _l('impacto_quantitativo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_relatorio', _l('data_relatorio'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/impacto_relatorio');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_relatorio_impacto($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/impacto_relatorio');
		}
	}
	public function editar_relatorio_impacto ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_relatorio_impacto($id);

		$data = [
            'curso_id' => $this->input->post('e_curso') ?? '',
            'impacto_qualitativo_id' => $this->input->post('e_impacto_qualitativo') ?? '',
            'impacto_quantitativo_id' => $this->input->post('e_impacto_quantitativo') ?? '',
            'data_relatorio' => $this->input->post('e_data_relatorio') ?? '',
        ];
		$this->form_validation->set_rules('e_curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_impacto_quantitativo', _l('impacto_quantitativo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_impacto_quantitativo', _l('impacto_quantitativo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_data_relatorio', _l('data_relatorio'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/impacto_relatorio');
        }
		else {
			$insert = $this->Gestao_formacao_model->update_relatorio_impacto($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_formacao/impacto_relatorio');
		}
	}
	public function delete_relatorio_impacto ($id) {
		$this->Gestao_formacao_model->first_relatorio_impacto($id);
		$this->Gestao_formacao_model->delete_relatorio_impacto($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/impacto_relatorio');
	}

	public function impacto_visualizar_avaliacao() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Visualizar');
		$this->load->view('impacto/visualizar_avaliacao', $data);
	}

	public function impacto_visualizar_relatorio() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Visualizar');
		$this->load->view('impacto/visualizar_relatorio', $data);
	}
	 /************************************************************
	 * 						Tela de orcamento
	 ************************************************************/
	public function orcamento() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('orcamento');
		$data['cursos'] = $this->Gestao_formacao_model->get_curso(2);
		$data['planeamento'] = $this->Gestao_formacao_model->get_planeamento();

		$data['total_planeamento'] = $this->Gestao_formacao_model->total_planeamento();
		$data['total_roi'] = $this->Gestao_formacao_model->total_roi();

		$this->load->view('orcamento/index_orcamento', $data);
	}
	public function add_planeamento () {
		$this->http_method('POST');

		$data = [
            'curso_id' => $this->input->post('curso') ?? '',
            'orcamento_previsto' => $this->input->post('orcamento_previsto') ?? '',
            'orcamento_realizado' => $this->input->post('orcamento_realizado') ?? '',
            'data_planeamento' => $this->input->post('data_planeamento') ?? '',
        ];
		$this->form_validation->set_rules('curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('orcamento_previsto', _l('orcamento_previsto'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('orcamento_realizado', _l('orcamento_realizado'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_planeamento', _l('data_planeamento'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/orcamento');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_planeamento($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/orcamento');
		}
	}
	public function editar_planeamento ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_planeamento($id);

		$data = [
            'curso_id' => $this->input->post('e_curso') ?? '',
            'orcamento_previsto' => $this->input->post('e_orcamento_previsto') ?? '',
            'orcamento_realizado' => $this->input->post('e_orcamento_realizado') ?? '',
            'data_planeamento' => $this->input->post('e_data_planeamento') ?? '',
        ];
		$this->form_validation->set_rules('e_curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_orcamento_previsto', _l('orcamento_previsto'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_orcamento_realizado', _l('orcamento_realizado'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_data_planeamento', _l('data_planeamento'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/orcamento');
        }
		else {
			$insert = $this->Gestao_formacao_model->update_planeamento($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_formacao/orcamento');
		}
	}
	public function delete_planeamento ($id) {
		$this->Gestao_formacao_model->first_planeamento($id);
		$this->Gestao_formacao_model->delete_planeamento($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/orcamento');
	}

	public function orcamento_roi() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Roi');
		$data['cursos'] = $this->Gestao_formacao_model->get_curso(2);
		$data['roi'] = $this->Gestao_formacao_model->get_roi();

		$this->load->view('orcamento/roi', $data);
	}
	public function add_roi () {
		$this->http_method('POST');

		$data = [
            'curso_id' => $this->input->post('curso') ?? '',
            'custo' => $this->input->post('custo') ?? '',
            'beneficio' => $this->input->post('beneficio') ?? '',
            'retorno' => $this->input->post('retorno') ?? '',
        ];
		$this->form_validation->set_rules('curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('custo', _l('custo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('beneficio', _l('beneficio'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('retorno', _l('retorno'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/orcamento_roi');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_roi($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/orcamento_roi');
		}
	}
	public function editar_roi ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_roi($id);

		$data = [
            'curso_id' => $this->input->post('e_curso') ?? '',
            'custo' => $this->input->post('e_custo') ?? '',
            'beneficio' => $this->input->post('e_beneficio') ?? '',
            'retorno' => $this->input->post('e_retorno') ?? '',
        ];
		$this->form_validation->set_rules('e_curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_custo', _l('custo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_beneficio', _l('beneficio'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_retorno', _l('retorno'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/orcamento_roi');
        }
		else {
			$update = $this->Gestao_formacao_model->update_roi($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_formacao/orcamento_roi');
		}
	}
	public function delete_roi ($id) {
		$this->Gestao_formacao_model->first_roi($id);
		$this->Gestao_formacao_model->delete_roi($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/orcamento_roi');
	}

	public function orcamento_visualizar_planeamento() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Visualizar');
		$this->load->view('orcamento/visualizar_planeamento', $data);
	}

	public function orcamento_visualizar_roi() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Visualizar');
		$this->load->view('orcamento/visualizar_roi', $data);
	}

	 /************************************************************
	 * 						Tela de riscos
	 ************************************************************/
	public function riscos() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('riscos');
		$data['status'] = $this->Gestao_formacao_model->get_status();
		$data['nivel_risco'] = $this->Gestao_formacao_model->get_nivel_risco();
		$data['cursos'] = $this->Gestao_formacao_model->get_curso(2);
		$data['staff_list'] = $this->Gestao_formacao_model->staffs_admin();

		$data['total_risco'] = $this->Gestao_formacao_model->total_risco();
		$data['total_risco_p'] = $this->Gestao_formacao_model->total_risco(1);
		$data['total_risco_a'] = $this->Gestao_formacao_model->total_risco(2);
		$data['total_risco_r'] = $this->Gestao_formacao_model->total_risco(3);

		$data['risco'] = $this->Gestao_formacao_model->get_risco();
		$this->load->view('riscos/index_riscos', $data);
	}
	public function add_risco () {
		$this->http_method('POST');

		$data = [
            'status_id' => 1,
            'curso_id' => $this->input->post('curso') ?? '',
            'nivel_risco_id' => $this->input->post('nivel_risco') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
            'data_identificacao' => $this->input->post('data_identificacao') ?? '',
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

		$this->form_validation->set_rules('curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('nivel_risco', _l('nivel_risco'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_identificacao', _l('data_identificacao'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/riscos');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_risco($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/riscos');
		}
	}
	public function editar_risco ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_risco($id);

		$data = [
            'curso_id' => $this->input->post('e_curso') ?? '',
            'nivel_risco_id' => $this->input->post('e_nivel_risco') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
            'data_identificacao' => $this->input->post('e_data_identificacao') ?? '',
			'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

		$this->form_validation->set_rules('e_curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_nivel_risco', _l('nivel_risco'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_data_identificacao', _l('data_identificacao'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/riscos');
        }
		else {
			$update = $this->Gestao_formacao_model->update_risco($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_formacao/riscos');
		}
	}
	public function delete_risco ($id) {
		$this->Gestao_formacao_model->first_risco($id);
		$this->Gestao_formacao_model->delete_risco($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/riscos');
	}
	public function risco_aprovar($id) {
        $vf = $this->Gestao_formacao_model->first_risco($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_formacao/riscos');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_formacao/riscos');
		}

		$this->Gestao_formacao_model->update_risco(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('gestao_formacao/riscos');
    }
    public function risco_rejeitar($id) {
        $vf = $this->Gestao_formacao_model->first_risco($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_formacao/riscos');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_formacao/riscos');
		}
		$this->Gestao_formacao_model->update_risco(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('gestao_formacao/riscos');
    }

	public function riscos_conformidade() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Conformidade');
		$data['status'] = $this->Gestao_formacao_model->get_status();
		$data['cursos'] = $this->Gestao_formacao_model->get_curso(2);
		$data['staff_list'] = $this->Gestao_formacao_model->staffs_admin();

		$data['conformidade'] = $this->Gestao_formacao_model->get_conformidade();
		$this->load->view('riscos/conformidade', $data);
	}
	public function add_conformidade () {
		$this->http_method('POST');

		$data = [
            'status_id' => 1,
            'curso_id' => $this->input->post('curso') ?? '',
            'requisitos_regulatorios' => $this->input->post('requisitos_regulatorios') ?? '',
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('requisitos_regulatorios', _l('requisitos_regulatorios'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/riscos_conformidade');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_conformidade($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/riscos_conformidade');
		}
	}
	public function editar_conformidade ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_conformidade($id);

		$data = [
            'curso_id' => $this->input->post('e_curso') ?? '',
            'requisitos_regulatorios' => $this->input->post('e_requisitos_regulatorios') ?? '',
			'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_requisitos_regulatorios', _l('requisitos_regulatorios'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/riscos_conformidade');
        }
		else {
			$insert = $this->Gestao_formacao_model->update_conformidade($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_formacao/riscos_conformidade');
		}
	}
	public function delete_conformidade ($id) {
		$this->Gestao_formacao_model->first_conformidade($id);
		$this->Gestao_formacao_model->delete_conformidade($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/riscos_conformidade');
	}
	public function conformidade_aprovar($id) {
        $vf = $this->Gestao_formacao_model->first_conformidade($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_formacao/riscos_conformidade');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_formacao/riscos_conformidade');
		}

		$this->Gestao_formacao_model->update_conformidade(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('gestao_formacao/riscos_conformidade');
    }
    public function conformidade_rejeitar($id) {
        $vf = $this->Gestao_formacao_model->first_conformidade($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_formacao/riscos_conformidade');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_formacao/riscos_conformidade');
		}
		$this->Gestao_formacao_model->update_conformidade(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('gestao_formacao/riscos_conformidade');
    }

	public function riscos_visualizar_risco() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Visualizar');
		$this->load->view('riscos/visualizar_risco', $data);
	}

	public function riscos_visualizar_conformidade() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Visualizar');
		$this->load->view('riscos/visualizar_conformidade', $data);
	}

	 /************************************************************
	 * 						Tela de personalizacao
	 ************************************************************/
	public function personalizacao() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('personalizacao');
		$data['status'] = $this->Gestao_formacao_model->get_status();
		$data['staff_list'] = $this->Gestao_formacao_model->staffs_admin();
        $data['staffs'] = $this->Gestao_formacao_model->staffs();
		$data['cursos'] = $this->Gestao_formacao_model->get_curso(2);

		$data['curso_personalizado'] = $this->Gestao_formacao_model->get_curso_personalizado();

		$data['total_curso_personalizado'] = $this->Gestao_formacao_model->total_curso_personalizado();
		$data['total_curso_personalizado_p'] = $this->Gestao_formacao_model->total_curso_personalizado(1);
		$data['total_curso_personalizado_a'] = $this->Gestao_formacao_model->total_curso_personalizado(2);
		$data['total_curso_personalizado_r'] = $this->Gestao_formacao_model->total_curso_personalizado(3);

		$this->load->view('personalizacao/index_personalizacao', $data);
	}
	public function add_curso_personalizado () {
		$this->http_method('POST');

		$data = [
            'status_id' => 1,
            'curso_id' => $this->input->post('curso') ?? '',
            'staff_id' => $this->input->post('staff') ?? '',
            'adaptacoes' => $this->input->post('adaptacoes') ?? '',
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

		$this->form_validation->set_rules('curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('adaptacoes', _l('adaptacoes'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/personalizacao');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_curso_personalizado($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/personalizacao');
		}
	}
	public function editar_curso_personalizado ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_curso_personalizado($id);

		$data = [
            'curso_id' => $this->input->post('e_curso') ?? '',
            'staff_id' => $this->input->post('e_staff') ?? '',
            'adaptacoes' => $this->input->post('e_adaptacoes') ?? '',
			'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

		$this->form_validation->set_rules('e_curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_adaptacoes', _l('adaptacoes'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/personalizacao');
        }
		else {
			$update = $this->Gestao_formacao_model->update_curso_personalizado($data, $id);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/personalizacao');
		}
	}
	public function delete_curso_personalizado ($id) {
		$this->Gestao_formacao_model->first_curso_personalizado($id);
		$this->Gestao_formacao_model->delete_curso_personalizado($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/personalizacao');
	}
	public function curso_personalizado_aprovar($id) {
        $vf = $this->Gestao_formacao_model->first_curso_personalizado($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_formacao/personalizacao');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_formacao/personalizacao');
		}

		$this->Gestao_formacao_model->update_curso_personalizado(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('gestao_formacao/personalizacao');
    }
    public function curso_personalizado_rejeitar($id) {
        $vf = $this->Gestao_formacao_model->first_curso_personalizado($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_formacao/personalizacao');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_formacao/personalizacao');
		}
		$this->Gestao_formacao_model->update_curso_personalizado(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('gestao_formacao/personalizacao');
    }

	public function personalizacao_visualizar_personalizacao() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Visualizar');
		$this->load->view('personalizacao/visualizar_personalizacao', $data);
	}

	 /************************************************************
	 * 						Tela de competencias
	 ************************************************************/
	public function competencias() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('competencias');
		$data['cursos'] = $this->Gestao_formacao_model->get_curso(2);
		$data['competencia'] = $this->Gestao_formacao_model->get_competencia();

		$data['total_compotencia_curso'] = $this->Gestao_formacao_model->total_compotencia_curso();
		$data['total_competencia_usuario'] = $this->Gestao_formacao_model->total_competencia_usuario();

		$data['compotencia_curso'] = $this->Gestao_formacao_model->get_compotencia_curso();

		$this->load->view('competencias/index_competencias', $data);
	}
	public function add_compotencia_curso () {
		$this->http_method('POST');

		$data = [
            'curso_id' => $this->input->post('curso') ?? '',
            'competencia_id' => $this->input->post('competencia') ?? '',
        ];

		$this->form_validation->set_rules('curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('competencia', _l('competencia'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/competencias');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_compotencia_curso($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/competencias');
		}
	}
	public function editar_compotencia_curso ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_compotencia_curso($id);

		$data = [
            'curso_id' => $this->input->post('e_curso') ?? '',
            'competencia_id' => $this->input->post('e_competencia') ?? '',
        ];

		$this->form_validation->set_rules('e_curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_competencia', _l('competencia'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/competencias');
        }
		else {
			$update = $this->Gestao_formacao_model->update_compotencia_curso($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_formacao/competencias');
		}
	}
	public function delete_compotencia_curso ($id) {
		$this->Gestao_formacao_model->first_compotencia_curso($id);
		$this->Gestao_formacao_model->delete_compotencia_curso($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/competencias');
	}

	public function competencias_competencias_usuario() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Competencias do Usuario');
		$data['competencia'] = $this->Gestao_formacao_model->get_competencia();
        $data['staffs'] = $this->Gestao_formacao_model->staffs();

		$data['competencia_usuario'] = $this->Gestao_formacao_model->get_competencia_usuario();

		$this->load->view('competencias/competencias_usuario', $data);
	}
	public function add_competencia_usuario () {
		$this->http_method('POST');

		$data = [
            'staff_id' => $this->input->post('staff') ?? '',
            'competencia_id' => $this->input->post('competencia') ?? '',
            'nivel' => $this->input->post('nivel') ?? '',
        ];

		$this->form_validation->set_rules('staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('competencia', _l('competencia'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('nivel', _l('nivel'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/competencias_competencias_usuario');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_competencia_usuario($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/competencias_competencias_usuario');
		}
	}
	public function editar_competencia_usuario ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_competencia_usuario($id);

		$data = [
            'staff_id' => $this->input->post('e_staff') ?? '',
            'competencia_id' => $this->input->post('e_competencia') ?? '',
            'nivel' => $this->input->post('e_nivel') ?? '',
        ];

		$this->form_validation->set_rules('e_staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_competencia', _l('competencia'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_nivel', _l('nivel'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/competencias_competencias_usuario');
        }
		else {
			$insert = $this->Gestao_formacao_model->update_competencia_usuario($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_formacao/competencias_competencias_usuario');
		}
	}
	public function delete_competencia_usuario ($id) {
		$this->Gestao_formacao_model->first_competencia_usuario($id);
		$this->Gestao_formacao_model->delete_competencia_usuario($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/competencias_competencias_usuario');
	}

	public function competencias_visualizar_competencias() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Visualizar');
		$this->load->view('competencias/visualizar_competencias', $data);
	}

	public function competencias_visualizar_competencias_usuario() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Visualizar');
		$this->load->view('competencias/visualizar_competencias_usuario', $data);
	}

	 /************************************************************
	 * 						Tela de integracao
	 ************************************************************/
	public function integracao() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('integracao');
		$data['status'] = $this->Gestao_formacao_model->get_status();
		$data['staff_list'] = $this->Gestao_formacao_model->staffs_admin();
        $data['staffs'] = $this->Gestao_formacao_model->staffs();
		$data['cursos'] = $this->Gestao_formacao_model->get_curso(2);
		$data['vagas'] = $this->Gestao_formacao_model->get_vaga();

		$data['total_recrutamento'] = $this->Gestao_formacao_model->total_recrutamento();
		$data['total_recrutamento_p'] = $this->Gestao_formacao_model->total_recrutamento(1);
		$data['total_recrutamento_a'] = $this->Gestao_formacao_model->total_recrutamento(2);
		$data['total_recrutamento_r'] = $this->Gestao_formacao_model->total_recrutamento(3);

		$data['recrutamento'] = $this->Gestao_formacao_model->get_recrutamento();

		$this->load->view('integracao/index_integracao', $data);
	}
	public function add_recrutamento () {
		$this->http_method('POST');

		$data = [
            'status_id' => 1,
            'staff_id' => $this->input->post('staff') ?? '',
            'vaga_id' => $this->input->post('vaga') ?? '',
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

		$this->form_validation->set_rules('staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('vaga', _l('vaga'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/integracao');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_recrutamento($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/integracao');
		}
	}
	public function editar_recrutamento ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_recrutamento($id);

		$data = [
            'staff_id' => $this->input->post('e_staff') ?? '',
            'vaga_id' => $this->input->post('e_vaga') ?? '',
			'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

		$this->form_validation->set_rules('e_staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_vaga', _l('vaga'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/integracao');
        }
		else {
			$update = $this->Gestao_formacao_model->update_recrutamento($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_formacao/integracao');
		}
	}
	public function delete_recrutamento ($id) {
		$this->Gestao_formacao_model->first_recrutamento($id);
		$this->Gestao_formacao_model->delete_recrutamento($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/integracao');
	}
	public function recrutamento_aprovar($id) {
        $vf = $this->Gestao_formacao_model->first_recrutamento($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_formacao/integracao');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_formacao/integracao');
		}

		$this->Gestao_formacao_model->update_recrutamento(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('gestao_formacao/integracao');
    }
    public function recrutamento_rejeitar($id) {
        $vf = $this->Gestao_formacao_model->first_recrutamento($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_formacao/integracao');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_formacao/integracao');
		}
		$this->Gestao_formacao_model->update_recrutamento(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('gestao_formacao/integracao');
    }

	public function integracao_Avaliacao_desempenho() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Avaliacao de Desempenho');
		$data['recrutamento'] = $this->Gestao_formacao_model->get_recrutamento(2);
		$data['competencia'] = $this->Gestao_formacao_model->get_competencia();
		$data['aval_desempenho'] = $this->Gestao_formacao_model->get_aval_desempenho();

		$this->load->view('integracao/Avaliacao_desempenho', $data);
	}
	public function add_aval_desempenho () {
		$this->http_method('POST');

		$data = [
            'recrutamento_id' => $this->input->post('recrutamento') ?? '',
            'competencia_id' => $this->input->post('competencia') ?? '',
            'nota' => $this->input->post('nota') ?? '',
        ];


		$this->form_validation->set_rules('recrutamento', _l('recrutamento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('competencia', _l('competencia'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('nota', _l('nota'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/integracao_Avaliacao_desempenho');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_aval_desempenho($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/integracao_Avaliacao_desempenho');
		}
	}
	public function editar_aval_desempenho ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_aval_desempenho($id);

		$data = [
            'recrutamento_id' => $this->input->post('e_recrutamento') ?? '',
            'competencia_id' => $this->input->post('e_competencia') ?? '',
            'nota' => $this->input->post('e_nota') ?? '',
        ];

		$this->form_validation->set_rules('e_recrutamento', _l('recrutamento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_competencia', _l('competencia'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_nota', _l('nota'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/integracao_Avaliacao_desempenho');
        }
		else {
			$insert = $this->Gestao_formacao_model->update_aval_desempenho($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_formacao/integracao_Avaliacao_desempenho');
		}
	}
	public function delete_aval_desempenho ($id) {
		$this->Gestao_formacao_model->first_aval_desempenho($id);
		$this->Gestao_formacao_model->delete_aval_desempenho($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/integracao_Avaliacao_desempenho');
	}

	public function integracao_visualizar_recrutameto() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Visualizar');
		$this->load->view('integracao/visualizar_recrutameto', $data);
	}

	public function integracao_visualizar_avaliacao() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Visualizar');
		$this->load->view('integracao/visualizar_avaliacao', $data);
	}

	 /************************************************************
	 * 						Tela de compliance
	 ************************************************************/
	public function compliance() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('compliance');
		$data['cursos'] = $this->Gestao_formacao_model->get_curso(2);
		$data['status'] = $this->Gestao_formacao_model->get_status();
		$data['staff_list'] = $this->Gestao_formacao_model->staffs_admin();

		$data['total_conformidade_regulatoria'] = $this->Gestao_formacao_model->total_conformidade_regulatoria();
		$data['total_conformidade_regulatoria_p'] = $this->Gestao_formacao_model->total_conformidade_regulatoria(1);
		$data['total_conformidade_regulatoria_a'] = $this->Gestao_formacao_model->total_conformidade_regulatoria(2);
		$data['total_conformidade_regulatoria_r'] = $this->Gestao_formacao_model->total_conformidade_regulatoria(3);

		$data['conformidade_regulatoria'] = $this->Gestao_formacao_model->get_conformidade_regulatoria();

		$this->load->view('compliance/index_compliance', $data);
	}
	public function add_conformidade_regulatoria () {
		$this->http_method('POST');

		$data = [
            'status_id' => 1,
            'curso_id' => $this->input->post('curso') ?? '',
            'normas' => $this->input->post('normas') ?? '',
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

		$this->form_validation->set_rules('curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('normas', _l('normas'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/compliance');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_conformidade_regulatoria($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/compliance');
		}
	}
	public function editar_conformidade_regulatoria ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_conformidade_regulatoria($id);

		$data = [
            'curso_id' => $this->input->post('e_curso') ?? '',
            'normas' => $this->input->post('e_normas') ?? '',
			'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

		$this->form_validation->set_rules('e_curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_normas', _l('normas'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/compliance');
        }
		else {
			$insert = $this->Gestao_formacao_model->update_conformidade_regulatoria($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_formacao/compliance');
		}
	}
	public function delete_conformidade_regulatoria ($id) {
		$this->Gestao_formacao_model->first_conformidade_regulatoria($id);
		$this->Gestao_formacao_model->delete_conformidade_regulatoria($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/compliance');
	}
	public function conformidade_regulatoria_aprovar($id) {
        $vf = $this->Gestao_formacao_model->first_conformidade_regulatoria($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_formacao/compliance');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_formacao/compliance');
		}

		$this->Gestao_formacao_model->update_conformidade_regulatoria(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('gestao_formacao/compliance');
    }
    public function conformidade_regulatoria_rejeitar($id) {
        $vf = $this->Gestao_formacao_model->first_conformidade_regulatoria($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_formacao/compliance');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_formacao/compliance');
		}
		$this->Gestao_formacao_model->update_conformidade_regulatoria(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('gestao_formacao/compliance');
    }

	public function compliance_avaliacao() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Avaliacao');
		$data['cursos'] = $this->Gestao_formacao_model->get_curso(2);

		$data['certificado_acreditacao'] = $this->Gestao_formacao_model->get_certificado_acreditacao();

		$this->load->view('compliance/avaliacao', $data);
	}
	public function add_certificado_acreditacao () {
		$this->http_method('POST');

		$data = [
            'curso_id' => $this->input->post('curso') ?? '',
            'entidade_acreditadora' => $this->input->post('entidade_acreditadora') ?? '',
            'validade' => $this->input->post('validade') ?? '',
        ];

		$this->form_validation->set_rules('curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('entidade_acreditadora', _l('entidade_acreditadora'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('validade', _l('validade'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/compliance_avaliacao');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_certificado_acreditacao($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/compliance_avaliacao');
		}
	}
	public function editar_certificado_acreditacao ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_certificado_acreditacao($id);

		$data = [
            'curso_id' => $this->input->post('e_curso') ?? '',
            'entidade_acreditadora' => $this->input->post('e_entidade_acreditadora') ?? '',
            'validade' => $this->input->post('e_validade') ?? '',
        ];

		$this->form_validation->set_rules('e_curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_entidade_acreditadora', _l('entidade_acreditadora'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_validade', _l('validade'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/compliance_avaliacao');
        }
		else {
			$insert = $this->Gestao_formacao_model->update_certificado_acreditacao($data, $id);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/compliance_avaliacao');
		}
	}
	public function delete_certificado_acreditacao ($id) {
		$this->Gestao_formacao_model->first_certificado_acreditacao($id);
		$this->Gestao_formacao_model->delete_certificado_acreditacao($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/compliance_avaliacao');
	}

	public function compliance_visualizar_recrutamento() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Visualizar');
		$this->load->view('compliance/visualizar_recrutamento', $data);
	}

	public function compliance_visualizar_avaliacao() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Visualizar');
		$this->load->view('compliance/visualizar_avaliacao', $data);
	}

	 /************************************************************
	 * 						Tela de tec_acesso
	 ************************************************************/
	public function tec_acesso() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('tec_acesso');
		$data['plataforma_ead'] = $this->Gestao_formacao_model->get_plataforma_ead();
		$data['status'] = $this->Gestao_formacao_model->get_status();
		$data['staff_list'] = $this->Gestao_formacao_model->staffs_admin();

		$data['total_plataforma_ead'] = $this->Gestao_formacao_model->total_plataforma_ead();
		$data['total_plataforma_ead_p'] = $this->Gestao_formacao_model->total_plataforma_ead(1);
		$data['total_plataforma_ead_a'] = $this->Gestao_formacao_model->total_plataforma_ead(2);
		$data['total_plataforma_ead_r'] = $this->Gestao_formacao_model->total_plataforma_ead(3);

		$this->load->view('tec_acesso/index_tec_acesso', $data);
	}
	public function add_plataforma_ead () {
		$this->http_method('POST');

		$data = [
            'status_id' => 1,
            'nome' => $this->input->post('nome') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
            'url' => $this->input->post('url') ?? '',
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

		$this->form_validation->set_rules('nome', _l('nome'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('url', _l('url'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/tec_acesso');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_plataforma_ead($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/tec_acesso');
		}
	}
	public function editar_plataforma_ead ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_plataforma_ead($id);

		$data = [
            'nome' => $this->input->post('e_nome') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
            'url' => $this->input->post('e_url') ?? '',
			'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

		$this->form_validation->set_rules('e_nome', _l('nome'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_url', _l('url'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/tec_acesso');
        }
		else {
			$insert = $this->Gestao_formacao_model->update_plataforma_ead($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_formacao/tec_acesso');
		}
	}
	public function delete_plataforma_ead ($id) {
		$this->Gestao_formacao_model->first_plataforma_ead($id);
		$this->Gestao_formacao_model->delete_plataforma_ead($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/tec_acesso');
	}
	public function plataforma_ead_aprovar($id) {
        $vf = $this->Gestao_formacao_model->first_plataforma_ead($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_formacao/tec_acesso');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_formacao/tec_acesso');
		}

		$this->Gestao_formacao_model->update_plataforma_ead(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('gestao_formacao/tec_acesso');
    }
    public function plataforma_ead_rejeitar($id) {
        $vf = $this->Gestao_formacao_model->first_plataforma_ead($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_formacao/tec_acesso');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_formacao/tec_acesso');
		}
		$this->Gestao_formacao_model->update_plataforma_ead(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('gestao_formacao/tec_acesso');
    }

    public function tec_acesso_avaliacao() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Avaliacao');
		$data['cursos'] = $this->Gestao_formacao_model->get_curso(2);
		$data['status'] = $this->Gestao_formacao_model->get_status();
		$data['staff_list'] = $this->Gestao_formacao_model->staffs_admin();

		$data['acessibilidade'] = $this->Gestao_formacao_model->get_acessibilidade();

		$this->load->view('tec_acesso/avaliacao', $data);
	}
	public function add_acessibilidade () {
		$this->http_method('POST');

		$data = [
            'status_id' => 1,
            'curso_id' => $this->input->post('curso') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/tec_acesso_avaliacao');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_acessibilidade($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/tec_acesso_avaliacao');
		}
	}
	public function editar_acessibilidade ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_acessibilidade($id);
		$data = [
            'curso_id' => $this->input->post('e_curso') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
			'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/tec_acesso_avaliacao');
        }
		else {
			$update = $this->Gestao_formacao_model->update_acessibilidade($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_formacao/tec_acesso_avaliacao');
		}
	}
	public function delete_acessibilidade ($id) {
		$this->Gestao_formacao_model->first_acessibilidade($id);
		$this->Gestao_formacao_model->delete_acessibilidade($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/tec_acesso_avaliacao');
	}
	public function acessibilidade_aprovar($id) {
        $vf = $this->Gestao_formacao_model->first_acessibilidade($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_formacao/tec_acesso_avaliacao');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_formacao/tec_acesso_avaliacao');
		}

		$this->Gestao_formacao_model->update_acessibilidade(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('gestao_formacao/tec_acesso_avaliacao');
    }
    public function acessibilidade_rejeitar($id) {
        $vf = $this->Gestao_formacao_model->first_acessibilidade($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_formacao/tec_acesso_avaliacao');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_formacao/tec_acesso_avaliacao');
		}
		$this->Gestao_formacao_model->update_acessibilidade(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('gestao_formacao/tec_acesso_avaliacao');
    }

	public function tec_acesso_visualizar_recrutamento() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Visualizar');
		$this->load->view('tec_acesso/visualizar_recrutamento', $data);
	}

	public function tec_acesso_visualizar_avaliacao() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Visualizar');
		$this->load->view('tec_acesso/visualizar_avaliacao', $data);
	}

	 /************************************************************
	 * 						Tela de suporte
	 ************************************************************/
	public function suporte() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('suporte');$data['status'] = $this->Gestao_formacao_model->get_status();
		$data['staff_list'] = $this->Gestao_formacao_model->staffs_admin();
        $data['staffs'] = $this->Gestao_formacao_model->staffs();

		$data['suporte'] = $this->Gestao_formacao_model->get_suporte();

		$data['total_suporte'] = $this->Gestao_formacao_model->total_suporte();
		$data['total_suporte_p'] = $this->Gestao_formacao_model->total_suporte(1);
		$data['total_suporte_a'] = $this->Gestao_formacao_model->total_suporte(2);
		$data['total_suporte_r'] = $this->Gestao_formacao_model->total_suporte(3);

		$this->load->view('suporte/index_suporte', $data);
	}
	public function add_suporte () {
		$this->http_method('POST');

		$data = [
            'status_id' => 1,
            'staff_id' => $this->input->post('staff') ?? '',
            'tipo_suporte' => $this->input->post('tipo_suporte') ?? '',
            'data_registro' => $this->input->post('data_registro') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('tipo_suporte', _l('tipo_suporte'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_registro', _l('data_registro'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/suporte');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_suporte($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/suporte');
		}
	}
	public function editar_suporte ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_suporte($id);

		$data = [
            'staff_id' => $this->input->post('e_staff') ?? '',
            'tipo_suporte' => $this->input->post('e_tipo_suporte') ?? '',
            'data_registro' => $this->input->post('e_data_registro') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
			'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_staff', _l('staff'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_tipo_suporte', _l('tipo_suporte'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_data_registro', _l('data_registro'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/suporte');
        }
		else {
			$insert = $this->Gestao_formacao_model->update_suporte($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_formacao/suporte');
		}
	}
	public function delete_suporte ($id) {
		$this->Gestao_formacao_model->first_suporte($id);
		$this->Gestao_formacao_model->delete_suporte($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/suporte');
	}
	public function suporte_aprovar($id) {
        $vf = $this->Gestao_formacao_model->first_suporte($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_formacao/suporte');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_formacao/suporte');
		}

		$this->Gestao_formacao_model->update_suporte(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('gestao_formacao/suporte');
    }
    public function suporte_rejeitar($id) {
        $vf = $this->Gestao_formacao_model->first_suporte($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_formacao/suporte');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_formacao/suporte');
		}
		$this->Gestao_formacao_model->update_suporte(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('gestao_formacao/suporte');
    }


	public function suporte_recurso() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Recurso');
		$data['cursos'] = $this->Gestao_formacao_model->get_curso(2);

		$data['recurso'] = $this->Gestao_formacao_model->get_recurso();

		$this->load->view('suporte/recurso', $data);
	}
	public function add_recurso () {
		$this->http_method('POST');

		$data = [
            'curso_id' => $this->input->post('curso') ?? '',
            'tipo_recurso' => $this->input->post('tipo_recurso') ?? '',
            'url' => $this->input->post('url') ?? '',
        ];

		$this->form_validation->set_rules('curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('tipo_recurso', _l('tipo_recurso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('url', _l('url'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/suporte_recurso');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_recurso($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/suporte_recurso');
		}
	}
	public function editar_recurso ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_recurso($id);

		$data = [
            'curso_id' => $this->input->post('e_curso') ?? '',
            'tipo_recurso' => $this->input->post('e_tipo_recurso') ?? '',
            'url' => $this->input->post('e_url') ?? '',
        ];

		$this->form_validation->set_rules('e_curso', _l('curso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_tipo_recurso', _l('tipo_recurso'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_url', _l('url'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/suporte_recurso');
        }
		else {
			$insert = $this->Gestao_formacao_model->update_recurso($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_formacao/suporte_recurso');
		}
	}
	public function delete_recurso ($id) {
		$this->Gestao_formacao_model->first_recurso($id);
		$this->Gestao_formacao_model->delete_recurso($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/suporte_recurso');
	}

	public function suporte_visualizar_suporte() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Visualizar');
		$this->load->view('suporte/visualizar_suporte', $data);
	}

	public function suporte_visualizar_recurso() {
		if (!has_permission('gestao_formacao', '', 'edit') && !is_admin()) {
			access_denied('gestao_formacao');
		}
		$data['title'] = _l('Visualizar');
		$this->load->view('suporte/visualizar_recurso', $data);
	}

	public function configuracoes () {
		$data['title'] = _l('configuracoes');

		$data['group'] = $this->input->get('group');
		$data['tab'][] = 'impacto_qualitativo';
		$data['tab'][] = 'impacto_quantitativo';
		$data['tab'][] = 'status';
		$data['tab'][] = 'nivel_risco';
		$data['tab'][] = 'competencias';

		if ($data['group'] == '' || $data['group'] == 'impacto_qualitativo') {
			$data['title'] = _l('impacto_qualitativo');
			$data['group'] = 'impacto_qualitativo';
			$data['impacto_qualitativo'] = $this->Gestao_formacao_model->get_impacto_qualitativo();
		} elseif ($data['group'] == 'impacto_quantitativo') {
			$data['title'] = _l('impacto_quantitativo');
			$data['impacto_quantitativo'] = $this->Gestao_formacao_model->get_impacto_quantitativo();
		} elseif ($data['group'] == 'status') {
			$data['title'] = _l('status');
			$data['status'] = $this->Gestao_formacao_model->get_status();
		} elseif ($data['group'] == 'nivel_risco') {
			$data['title'] = _l('nivel_risco');
			$data['nivel_risco'] = $this->Gestao_formacao_model->get_nivel_risco();
		} elseif ($data['group'] == 'competencias') {
			$data['title'] = _l('competencia');
			$data['competencia'] = $this->Gestao_formacao_model->get_competencia();
		}
		else {
			set_alert('danger',"Configuração não encontrada");
			redirect('gestao_formacao/configuracoes');
		}

		$data['tabs']['view'] = 'configuracoes/' . $data['group'];
		$this->load->view('configuracoes/index', $data);
	}

	public function add_impacto_qualitativo () {
		$this->http_method('POST');

		$data = [
            'nome' => $this->input->post('nome') ?? '',
            'valor' => $this->input->post('valor') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
        ];
		$this->form_validation->set_rules('nome', _l('nome'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('valor', _l('valor'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/configuracoes?group=impacto_qualitativo');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_impacto_qualitativo($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/configuracoes?group=impacto_qualitativo');
		}
	}
	public function editar_impacto_qualitativo ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_impacto_qualitativo($id);

		$data = [
            'nome' => $this->input->post('e_nome') ?? '',
            'valor' => $this->input->post('e_valor') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
        ];
		$this->form_validation->set_rules('e_nome', _l('nome'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_valor', _l('valor'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/configuracoes?group=impacto_qualitativo');
        }
		else {
			$insert = $this->Gestao_formacao_model->update_impacto_qualitativo($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_formacao/configuracoes?group=impacto_qualitativo');
		}
	}
	public function delete_impacto_qualitativo ($id) {
		$this->Gestao_formacao_model->first_impacto_qualitativo($id);
		$this->Gestao_formacao_model->delete_impacto_qualitativo($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/configuracoes?group=impacto_qualitativo');
	}

	public function add_impacto_quantitativo () {
		$this->http_method('POST');

		$data = [
            'nome' => $this->input->post('nome') ?? '',
            'valor' => $this->input->post('valor') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
        ];
		$this->form_validation->set_rules('nome', _l('nome'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('valor', _l('valor'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/configuracoes?group=impacto_quantitativo');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_impacto_quantitativo($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/configuracoes?group=impacto_quantitativo');
		}
	}
	public function editar_impacto_quantitativo ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_impacto_quantitativo($id);

		$data = [
            'nome' => $this->input->post('e_nome') ?? '',
            'valor' => $this->input->post('e_valor') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
        ];
		$this->form_validation->set_rules('e_nome', _l('nome'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_valor', _l('valor'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/configuracoes?group=impacto_quantitativo');
        }
		else {
			$insert = $this->Gestao_formacao_model->update_impacto_quantitativo($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_formacao/configuracoes?group=impacto_quantitativo');
		}
	}
	public function delete_impacto_quantitativo ($id) {
		$this->Gestao_formacao_model->first_impacto_quantitativo($id);
		$this->Gestao_formacao_model->delete_impacto_quantitativo($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/configuracoes?group=impacto_quantitativo');
	}

	public function add_competencia () {
		$this->http_method('POST');

		$data = [
            'nome' => $this->input->post('competencia') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
        ];
		$this->form_validation->set_rules('competencia', _l('competencia'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/configuracoes?group=competencias');
        }
		else {
			$insert = $this->Gestao_formacao_model->create_competencia($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_formacao/configuracoes?group=competencias');
		}
	}
	public function editar_competencia ($id) {
		$this->http_method('POST');
		$this->Gestao_formacao_model->first_competencia($id);

		$data = [
            'nome' => $this->input->post('e_competencia') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
        ];
		$this->form_validation->set_rules('e_competencia', _l('competencia'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_formacao/configuracoes?group=competencias');
        }
		else {
			$this->Gestao_formacao_model->update_competencia($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_formacao/configuracoes?group=competencias');
		}
	}
	public function delete_competencia ($id) {
		$this->Gestao_formacao_model->first_competencia($id);
		$this->Gestao_formacao_model->delete_competencia($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_formacao/configuracoes?group=competencias');
	}
}