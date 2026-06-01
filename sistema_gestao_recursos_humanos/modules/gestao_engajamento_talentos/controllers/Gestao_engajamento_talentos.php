<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Engajamento de Talentos Controller
 */
class Gestao_engajamento_talentos extends AdminController {
	public function __construct() {
		parent::__construct();
		$this->load->model('Gestao_engajamento_talento_model');
		$this->load->library(['form_validation', 'upload']);
	}
	private function http_method ($vfMethod) {
        if ($_SERVER['REQUEST_METHOD'] !== $vfMethod) {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['status' => false, 'message' => 'Metodo não permitido']);
            exit;
        }
    }
	/********************************************************************************
	 * Tela de Dashboard
	 *******************************************************************************/
	public function dashboard() {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Dashboard');
		$data['pesquisa_engajamento_total'] = $this->Gestao_engajamento_talento_model->pesquisa_engajamento_total();
		$data['total_pergunta_engajamento'] = $this->Gestao_engajamento_talento_model->total_pergunta_engajamento();
		$data['total_resposta_engajamento'] = $this->Gestao_engajamento_talento_model->total_resposta_engajamento();
		$data['total_premio'] = $this->Gestao_engajamento_talento_model->total_premio();

		$data['conflito_dashboard'] = $this->Gestao_engajamento_talento_model->get_conflito_dashboard();

		$data['total_resposta_engajamento_pessimo'] = $this->Gestao_engajamento_talento_model->total_resposta_engajamento(null, 1);
		$data['total_resposta_engajamento_mau'] = $this->Gestao_engajamento_talento_model->total_resposta_engajamento(null, 2);
		$data['total_resposta_engajamento_bom'] = $this->Gestao_engajamento_talento_model->total_resposta_engajamento(null, 3);
		$data['total_resposta_engajamento_muito_bom'] = $this->Gestao_engajamento_talento_model->total_resposta_engajamento(null, 4);
		$data['total_resposta_engajamento_excelente'] = $this->Gestao_engajamento_talento_model->total_resposta_engajamento(null, 5);

		$this->load->view('dashboard/index', $data);
	}


	/********************************************************************************
	 * Tela de Pesquisas
	 *******************************************************************************/
	public function pesquisas() {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('pesquisas');
		$data['status'] = $this->Gestao_engajamento_talento_model->get_status();
		$data['pesquisa_engajamento'] = $this->Gestao_engajamento_talento_model->get_pesquisa_engajamento();
		$data['staff_list'] = $this->Gestao_engajamento_talento_model->staffs_admin();

		$data['pesquisa_engajamento_total'] = $this->Gestao_engajamento_talento_model->pesquisa_engajamento_total();
		$data['total_pergunta_engajamento'] = $this->Gestao_engajamento_talento_model->total_pergunta_engajamento();
		$data['total_resposta_engajamento'] = $this->Gestao_engajamento_talento_model->total_resposta_engajamento();
		$data['pesquisa_engajamento_total_pendente'] = $this->Gestao_engajamento_talento_model->pesquisa_engajamento_total(1);

		$this->load->view('pesquisas/index_pesquisas', $data);
	}

	public function analise_grafica() {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Analise Grafica');
		$data['pergunta_engajamento'] = $this->Gestao_engajamento_talento_model->get_pergunta_engajamento();
		$data['filtro'] = $this->input->get('filtro');

		if ($data['filtro']) {
			$total_resposta = $this->Gestao_engajamento_talento_model->total_resposta_engajamento($data['filtro']);
			$soma_resposta = $this->Gestao_engajamento_talento_model->somar_resposta_engajamento($data['filtro']);
			$data['total_resposta_engajamento'] = $total_resposta;
			$data['dashboard_resposta_engajamento'] = $this->Gestao_engajamento_talento_model->dashboard_resposta_engajamento($data['filtro']);

			$data['media_resposta_engajamento'] = $soma_resposta / $total_resposta;

			$data['somar_resposta_engajamento_pessimo'] = $this->Gestao_engajamento_talento_model->total_resposta_engajamento($data['filtro'], 1);
			$data['somar_resposta_engajamento_mau'] = $this->Gestao_engajamento_talento_model->total_resposta_engajamento($data['filtro'], 2);
			$data['somar_resposta_engajamento_bom'] = $this->Gestao_engajamento_talento_model->total_resposta_engajamento($data['filtro'], 3);
			$data['somar_resposta_engajamento_muito_bom'] = $this->Gestao_engajamento_talento_model->total_resposta_engajamento($data['filtro'], 4);
			$data['somar_resposta_engajamento_excelente'] = $this->Gestao_engajamento_talento_model->total_resposta_engajamento($data['filtro'], 5);

		}

		$this->load->view('pesquisas/analise_grafica', $data);
	}

	public function algoritmo() {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$loginID = $usuario_id ?? get_staff_user_id();
		$data['title'] = _l('Recomendação');
		$data['status'] = $this->Gestao_engajamento_talento_model->get_status();
        $data['sugerir_pesquisas'] = $this->Gestao_engajamento_talento_model->sugerir_pesquisas($loginID);
		$this->load->view('pesquisas/algoritmo', $data);
	}

	public function add_pesquisa_engajamento () {
		$this->http_method('POST');

		$data = [
            'status_id' => 1,
            'titulo' => $this->input->post('titulo') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
            'data_criacao' => $this->input->post('data_criacao') ?? '',
            'data_fim' => $this->input->post('data_fim') ?? '',
            'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];
		$this->form_validation->set_rules('titulo', _l('titulo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_criacao', _l('data_criacao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_fim', _l('data_fim'), 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/pesquisas');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->create_pesquisa_engajamento($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_engajamento_talentos/pesquisas');
		}
	}
	public function editar_pesquisa_engajamento ($id) {
		$this->http_method('POST');
		$this->Gestao_engajamento_talento_model->first_pesquisa_engajamento($id);

		$data = [
            'titulo' => $this->input->post('e_titulo') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
            'data_criacao' => $this->input->post('e_data_criacao') ?? '',
            'data_fim' => $this->input->post('e_data_fim') ?? '',
            'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];
		$this->form_validation->set_rules('e_titulo', _l('titulo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_data_criacao', _l('data_criacao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_data_fim', _l('data_fim'), 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/pesquisas');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->update_pesquisa_engajamento($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_engajamento_talentos/pesquisas');
		}
	}
	public function pesquisa_engajamento_aprovar($id) {
        $vf = $this->Gestao_engajamento_talento_model->first_pesquisa_engajamento($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_engajamento_talentos/pesquisas');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_engajamento_talentos/pesquisas');
		}
		$this->Gestao_engajamento_talento_model->update_pesquisa_engajamento(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('gestao_engajamento_talentos/pesquisas');
    }
    public function pesquisa_engajamento_rejeitar($id) {
        $vf = $this->Gestao_engajamento_talento_model->first_pesquisa_engajamento($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_engajamento_talentos/pesquisas');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_engajamento_talentos/pesquisas');
		}
		$this->Gestao_engajamento_talento_model->update_pesquisa_engajamento(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('gestao_engajamento_talentos/pesquisas');
    }
	public function delete_pesquisa_engajamento ($id) {
		$this->Gestao_engajamento_talento_model->first_pesquisa_engajamento($id);
		$this->Gestao_engajamento_talento_model->delete_pesquisa_engajamento($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_engajamento_talentos/pesquisas');
	}

	public function pesquisas_pergunta_engajamento() {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Pergunta de Engajamento');
		$data['pesquisa_engajamento'] = $this->Gestao_engajamento_talento_model->get_pesquisa_engajamento(2);
		$data['pergunta_engajamento'] = $this->Gestao_engajamento_talento_model->get_pergunta_engajamento();

		$this->load->view('pesquisas/pergunta_engajamento', $data);
	}
	public function add_pergunta_engajamento () {
		$this->http_method('POST');

		$data = [
            'pesquisa_engajamento_id' => $this->input->post('pesquisa') ?? '',
            'texto' => $this->input->post('texto') ?? '',
            'tipo_resposta' => $this->input->post('tipo_resposta') ?? '',
        ];
		$this->form_validation->set_rules('pesquisa', _l('pesquisa'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('texto', _l('texto'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('tipo_resposta', _l('tipo_resposta'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/pesquisas_pergunta_engajamento');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->create_pergunta_engajamento($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_engajamento_talentos/pesquisas_pergunta_engajamento');
		}
	}
	public function editar_pergunta_engajamento ($id) {
		$this->http_method('POST');
		$this->Gestao_engajamento_talento_model->first_pergunta_engajamento($id);

		$data = [
            'pesquisa_engajamento_id' => $this->input->post('e_pesquisa') ?? '',
            'texto' => $this->input->post('e_texto') ?? '',
            'tipo_resposta' => $this->input->post('e_tipo_resposta') ?? '',
        ];
		$this->form_validation->set_rules('e_pesquisa', _l('pesquisa'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_texto', _l('texto'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_tipo_resposta', _l('tipo_resposta'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/pesquisas_pergunta_engajamento');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->update_pergunta_engajamento($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_engajamento_talentos/pesquisas_pergunta_engajamento');
		}
	}
	public function delete_pergunta_engajamento ($id) {
		$this->Gestao_engajamento_talento_model->first_pergunta_engajamento($id);
		$this->Gestao_engajamento_talento_model->delete_pergunta_engajamento($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_engajamento_talentos/pesquisas_pergunta_engajamento');
	}

	public function pesquisas_resposta_engajamento() {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('pesquisas');
		$data['pesquisa_engajamento'] = $this->Gestao_engajamento_talento_model->get_pesquisa_engajamento(2);
		$data['pergunta_engajamento'] = $this->Gestao_engajamento_talento_model->get_pergunta_engajamento();
		// $data['colaboradores'] = $this->Gestao_engajamento_talento_model->colaboradores();

		$data['colaboradores'] = $this->Gestao_engajamento_talento_model->staffs();
		$data['resposta_engajamento'] = $this->Gestao_engajamento_talento_model->get_resposta_engajamento();

		$this->load->view('pesquisas/resposta_engajamento', $data);
	}

	public function add_resposta_engajamento () {
		$this->http_method('POST');

		$data = [
            'pergunta_engajamento_id' => $this->input->post('pergunta') ?? '',
            'staff_id' => $this->input->post('colaborador') ?? '',
            'resposta' => $this->input->post('resposta') ?? '',
        ];
		$this->form_validation->set_rules('pergunta', _l('pergunta'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('colaborador', _l('colaborador'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('resposta', _l('resposta'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/pesquisas_resposta_engajamento');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->create_resposta_engajamento($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_engajamento_talentos/pesquisas_resposta_engajamento');
		}
	}
	public function editar_resposta_engajamento ($id) {
		$this->http_method('POST');
		$this->Gestao_engajamento_talento_model->first_resposta_engajamento($id);

		$data = [
            'pergunta_engajamento_id' => $this->input->post('e_pergunta') ?? '',
            'staff_id' => $this->input->post('e_colaborador') ?? '',
            'resposta' => $this->input->post('e_resposta') ?? '',
        ];
		$this->form_validation->set_rules('e_pergunta', _l('pergunta'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_colaborador', _l('colaborador'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_resposta', _l('resposta'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/pesquisas_resposta_engajamento');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->update_resposta_engajamento($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_engajamento_talentos/pesquisas_resposta_engajamento');
		}
	}
	public function delete_resposta_engajamento ($id) {
		$this->Gestao_engajamento_talento_model->first_resposta_engajamento($id);
		$this->Gestao_engajamento_talento_model->delete_resposta_engajamento($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_engajamento_talentos/pesquisas_resposta_engajamento');
	}

	public function listar_perguntas($pesquisa_id)
	{
		if (!$pesquisa_id) {
			// Retorna um erro se o ID não foi fornecido
			echo json_encode([
				'status' => false,
				'message' => 'ID da Pesquisa não fornecido.'
			]);
			return;
		}
		$perguntas = $this->Gestao_engajamento_talento_model->get_pergunta_engajamento($pesquisa_id);

		// Retorna os dados como JSON
		echo json_encode([
			'status' => true,
			'data' => $perguntas
		]);
	}

	public function pesquisas_visualizar_pesquisa($id) {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Visualizar');
		$vf = $this->Gestao_engajamento_talento_model->first_pesquisa_engajamento($id);
		$data['pesquisa_engajamento'] = $vf;

		$this->load->view('pesquisas/visualizar_pesquisa', $data);
	}

	public function pesquisas_visualizar_pergunta($id) {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Visualizar');
		
		$vf = $this->Gestao_engajamento_talento_model->first_pergunta_engajamento($id);
		$data['pergunta_engajamento'] = $vf;
		$this->load->view('pesquisas/visualizar_pergunta', $data);
	}

	public function pesquisas_visualizar_resposta($id) {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Visualizar');
		$vf = $this->Gestao_engajamento_talento_model->first_resposta_engajamento($id);
		$data['resposta_engajamento'] = $vf;

		$this->load->view('pesquisas/visualizar_resposta', $data);
	}

	/********************************************************************************
	 * Tela de Programas
	 *******************************************************************************/
	public function programas() {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('programas');
		$data['colaboradores'] = $this->Gestao_engajamento_talento_model->staffs();
		$data['reconhecimento'] = $this->Gestao_engajamento_talento_model->get_reconhecimento();

		$data['total_reconhecimento'] = $this->Gestao_engajamento_talento_model->total_reconhecimento();
		$data['total_premio'] = $this->Gestao_engajamento_talento_model->total_premio();
		$data['total_resgate_premio'] = $this->Gestao_engajamento_talento_model->total_resgate_premio();

		$this->load->view('programas/index_programas', $data);
	}
	public function add_reconhecimento () {
		$this->http_method('POST');

		$data = [
            'staff_id' => $this->input->post('colaborador') ?? '',
            'tipo' => $this->input->post('tipo') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
            'data_reconhecimento' => $this->input->post('data_reconhecimento') ?? '',
            'pontos' => $this->input->post('pontos') ?? '',
        ];
		$this->form_validation->set_rules('colaborador', _l('colaborador'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('tipo', _l('tipo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_reconhecimento', _l('data_reconhecimento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('pontos', _l('pontos'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/programas');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->create_reconhecimento($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_engajamento_talentos/programas');
		}
	}
	public function editar_reconhecimento ($id) {
		$this->http_method('POST');
		$this->Gestao_engajamento_talento_model->first_reconhecimento($id);

		$data = [
            'staff_id' => $this->input->post('e_colaborador') ?? '',
            'tipo' => $this->input->post('e_tipo') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
            'data_reconhecimento' => $this->input->post('e_data_reconhecimento') ?? '',
            'pontos' => $this->input->post('e_pontos') ?? '',
        ];
		$this->form_validation->set_rules('e_colaborador', _l('colaborador'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_tipo', _l('tipo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_data_reconhecimento', _l('data_reconhecimento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_pontos', _l('pontos'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/pesquisas_resposta_engajamento');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->update_reconhecimento($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_engajamento_talentos/programas');
		}
	}
	public function delete_reconhecimento ($id) {
		$this->Gestao_engajamento_talento_model->first_reconhecimento($id);
		$this->Gestao_engajamento_talento_model->delete_reconhecimento($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_engajamento_talentos/programas');
	}

	public function programas_premio() {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Prêmio');
		$data['premio'] = $this->Gestao_engajamento_talento_model->get_premio();

		$this->load->view('programas/premio', $data);
	}
	public function add_premio () {
		$this->http_method('POST');

		$data = [
            'nome' => $this->input->post('nome') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
            'pontos_necessario' => $this->input->post('pontos_necessario') ?? '',
        ];
		$this->form_validation->set_rules('nome', _l('nome'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('pontos_necessario', _l('pontos_necessario'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/programas_premio');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->create_premio($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_engajamento_talentos/programas_premio');
		}
	}
	public function editar_premio ($id) {
		$this->http_method('POST');
		$this->Gestao_engajamento_talento_model->first_premio($id);

		$data = [
            'nome' => $this->input->post('e_nome') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
            'pontos_necessario' => $this->input->post('e_pontos_necessario') ?? '',
        ];
		$this->form_validation->set_rules('e_nome', _l('nome'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_pontos_necessario', _l('pontos_necessario'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/programas_premio');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->update_premio($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_engajamento_talentos/programas_premio');
		}
	}
	public function delete_premio ($id) {
		$this->Gestao_engajamento_talento_model->first_premio($id);
		$this->Gestao_engajamento_talento_model->delete_premio($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_engajamento_talentos/programas_premio');
	}

	public function programas_resgate() {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Resgate de Prêmio');
		$data['premio'] = $this->Gestao_engajamento_talento_model->get_premio();
		$data['colaboradores'] = $this->Gestao_engajamento_talento_model->staffs();

		$data['resgate_premio'] = $this->Gestao_engajamento_talento_model->get_resgate_premio();
		$this->load->view('programas/resgate', $data);
	}
	public function add_resgate_premio () {
		$this->http_method('POST');

		$data = [
            'staff_id' => $this->input->post('colaborador') ?? '',
            'premio_id' => $this->input->post('premio') ?? '',
            'data_resgate' => $this->input->post('data_resgate') ?? '',
        ];
		$this->form_validation->set_rules('colaborador', _l('colaborador'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('premio', _l('premio'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_resgate', _l('data_resgate'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/programas_resgate');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->create_resgate_premio($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_engajamento_talentos/programas_resgate');
		}
	}
	public function editar_resgate_premio ($id) {
		$this->http_method('POST');
		$this->Gestao_engajamento_talento_model->first_resgate_premio($id);

		$data = [
            'staff_id' => $this->input->post('e_colaborador') ?? '',
            'premio_id' => $this->input->post('e_premio') ?? '',
            'data_resgate' => $this->input->post('e_data_resgate') ?? '',
        ];
		$this->form_validation->set_rules('e_colaborador', _l('colaborador'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_premio', _l('premio'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_data_resgate', _l('data_resgate'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/programas_resgate');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->update_resgate_premio($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_engajamento_talentos/programas_resgate');
		}
	}
	public function delete_resgate_premio ($id) {
		$this->Gestao_engajamento_talento_model->first_resgate_premio($id);
		$this->Gestao_engajamento_talento_model->delete_resgate_premio($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_engajamento_talentos/programas_resgate');
	}

	public function programas_visualizar_reconhecimento($id) {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Visualizar');
		$vf = $this->Gestao_engajamento_talento_model->first_reconhecimento($id);
		$data['reconhecimento'] = $vf;

		$this->load->view('programas/visualizar_reconhecimento', $data);
	}

	public function programas_visualizar_premio($id) {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Visualizar');
		$vf = $this->Gestao_engajamento_talento_model->first_premio($id);
		$data['premio'] = $vf;

		$this->load->view('programas/visualizar_premio', $data);
	}

	public function programas_visualizar_resgate($id) {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Visualizar');
		$vf = $this->Gestao_engajamento_talento_model->first_resgate_premio($id);
		$data['resgate_premio'] = $vf;

		$this->load->view('programas/visualizar_resgate', $data);
	}

	/********************************************************************************
	 * Tela de Comunicações
	 *******************************************************************************/
	public function comunicacao() {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('comunicacao');
		$data['colaboradores'] = $this->Gestao_engajamento_talento_model->staffs();

		$data['comunicacao_interna'] = $this->Gestao_engajamento_talento_model->get_comunicacao_interna();
		$data['total_comunicacao_interna'] = $this->Gestao_engajamento_talento_model->total_comunicacao_interna();


		$this->load->view('comunicacao/index_comunicacao', $data);
	}
	public function add_comunicacao_interna () {
		$this->http_method('POST');

		$data = [
            'autor_id' => $this->input->post('autor') ?? '',
            'titulo' => $this->input->post('titulo') ?? '',
            'mensagem' => $this->input->post('mensagem') ?? '',
            'data_publicacao' => $this->input->post('data_publicacao') ?? '',
        ];
		$this->form_validation->set_rules('autor', _l('autor'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('titulo', _l('titulo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('mensagem', _l('mensagem'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_publicacao', _l('data_publicacao'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/comunicacao');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->create_comunicacao_interna($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_engajamento_talentos/comunicacao');
		}
	}
	public function editar_comunicacao_interna ($id) {
		$this->http_method('POST');
		$this->Gestao_engajamento_talento_model->first_comunicacao_interna($id);

		$data = [
            'autor_id' => $this->input->post('e_autor') ?? '',
            'titulo' => $this->input->post('e_titulo') ?? '',
            'mensagem' => $this->input->post('e_mensagem') ?? '',
            'data_publicacao' => $this->input->post('e_data_publicacao') ?? '',
        ];
		$this->form_validation->set_rules('e_autor', _l('autor'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_titulo', _l('titulo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_mensagem', _l('mensagem'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_data_publicacao', _l('data_publicacao'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/comunicacao');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->update_comunicacao_interna($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_engajamento_talentos/comunicacao');
		}
	}
	public function delete_comunicacao_interna ($id) {
		$this->Gestao_engajamento_talento_model->first_comunicacao_interna($id);
		$this->Gestao_engajamento_talento_model->delete_comunicacao_interna($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_engajamento_talentos/comunicacao');
	}

	public function comunicacao_visualizar_comunicacao($id) {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Visualizar');
		$vf = $this->Gestao_engajamento_talento_model->first_comunicacao_interna($id);
		$data['comunicacao_interna'] = $vf;
		$this->load->view('comunicacao/visualizar_comunicacao', $data);
	}

	/********************************************************************************
	 * Tela de Feedback
	 *******************************************************************************/
	public function feedback() {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$IDLogado = get_staff_user_id();
		$data['title'] = _l('feedback');
		$data['feedback_continuo'] = $this->Gestao_engajamento_talento_model->get_feedback_continuo($IDLogado);
		$data['staffs'] = $this->Gestao_engajamento_talento_model->staffs_not_me($IDLogado);
		$data['total_feedback_continuo'] = $this->Gestao_engajamento_talento_model->total_feedback_continuo();

		$this->load->view('feedback/index_feedback', $data);
	}
	public function add_feedback_continuo () {
		$this->http_method('POST');
		$IDLogado = get_staff_user_id();

		$data = [
            'remetente_id' => $IDLogado,
            'destinatario_id' => $this->input->post('destinatario') ?? '',
            'mensagem' => $this->input->post('mensagem') ?? '',
        ];
		$this->form_validation->set_rules('destinatario', _l('destinatario'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('mensagem', _l('mensagem'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/feedback');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->create_feedback_continuo($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_engajamento_talentos/feedback');
		}
	}
	public function delete_feedback_continuo ($id) {
		$this->Gestao_engajamento_talento_model->first_feedback_continuo($id);
		$this->Gestao_engajamento_talento_model->delete_feedback_continuo($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_engajamento_talentos/feedback');
	}

	public function feedback_visualizar_feedback($id) {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Visualizar');
		$data['feedback_continuo'] = $this->Gestao_engajamento_talento_model->first_feedback_continuo($id);

		$this->load->view('feedback/visualizar_feedback', $data);
	}

	/********************************************************************************
	 * Tela de Comunidade
	 *******************************************************************************/
	public function comunidade() {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('comunidade');
		$data['grupo_colaboracao'] = $this->Gestao_engajamento_talento_model->get_grupo_colaboracao();

		$data['total_grupo_colaboracao'] = $this->Gestao_engajamento_talento_model->total_grupo_colaboracao();
		$data['total_evento'] = $this->Gestao_engajamento_talento_model->total_evento();

		$this->load->view('comunidade/index_comunidade', $data);
	}
	public function add_grupo_colaboracao () {
		$this->http_method('POST');
		$IDLogado = get_staff_user_id();

		$data = [
            'criador_id' => $IDLogado,
            'nome' => $this->input->post('nome') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
        ];
		$this->form_validation->set_rules('nome', _l('nome'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/comunidade');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->create_grupo_colaboracao($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_engajamento_talentos/comunidade');
		}
	}
	public function editar_grupo_colaboracao ($id) {
		$this->http_method('POST');
		$this->Gestao_engajamento_talento_model->first_grupo_colaboracao($id);

		$data = [
            'nome' => $this->input->post('e_nome') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
        ];
		$this->form_validation->set_rules('e_nome', _l('nome'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/comunidade');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->update_grupo_colaboracao($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_engajamento_talentos/comunidade');
		}
	}
	public function delete_grupo_colaboracao ($id) {
		$this->Gestao_engajamento_talento_model->first_grupo_colaboracao($id);
		$this->Gestao_engajamento_talento_model->delete_grupo_colaboracao($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_engajamento_talentos/comunidade');
	}

	public function comunidade_evento() {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Evento');
		$data['staffs'] = $this->Gestao_engajamento_talento_model->staffs();
		$data['evento'] = $this->Gestao_engajamento_talento_model->get_evento();

		$this->load->view('comunidade/evento', $data);
	}
	public function add_evento () {
		$this->http_method('POST');
		$IDLogado = get_staff_user_id();

		$data = [
            'organizador_id' => $this->input->post('organizador') ?? '',
            'titulo' => $this->input->post('titulo') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
            'local' => $this->input->post('local') ?? '',
            'data_evento' => $this->input->post('data_evento') ?? '',
        ];
		$this->form_validation->set_rules('organizador', _l('organizador'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('titulo', _l('titulo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('local', _l('local'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_evento', _l('data_evento'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/comunidade_evento');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->create_evento($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_engajamento_talentos/comunidade_evento');
		}
	}
	public function editar_evento ($id) {
		$this->http_method('POST');
		$this->Gestao_engajamento_talento_model->first_evento($id);

		$data = [
            'organizador_id' => $this->input->post('e_organizador') ?? '',
            'titulo' => $this->input->post('e_titulo') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
            'local' => $this->input->post('e_local') ?? '',
            'data_evento' => $this->input->post('e_data_evento') ?? '',
        ];
		$this->form_validation->set_rules('e_organizador', _l('organizador'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_titulo', _l('titulo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_local', _l('local'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_data_evento', _l('data_evento'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/comunidade_evento');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->update_evento($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_engajamento_talentos/comunidade_evento');
		}
	}

	public function comunidade_visualizar_grupo($id) {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Visualizar');
		$data['grupo_colaboracao'] = $this->Gestao_engajamento_talento_model->first_grupo_colaboracao($id);

		$this->load->view('comunidade/visualizar_grupo', $data);
	}

	public function comunidade_visualizar_evento($id) {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}

		$data['evento'] = $this->Gestao_engajamento_talento_model->first_evento($id);
		$data['title'] = _l('Visualizar');
		$this->load->view('comunidade/visualizar_evento', $data);
	}

	/********************************************************************************
	 * Tela de Clima Organizacional
	 *******************************************************************************/
	public function clima() {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('clima');
		$data['status'] = $this->Gestao_engajamento_talento_model->get_status();
		$data['staff_list'] = $this->Gestao_engajamento_talento_model->staffs_admin();
		$data['pesquisa_clima'] = $this->Gestao_engajamento_talento_model->get_pesquisa_clima();

		$data['total_pesquisa_clima'] = $this->Gestao_engajamento_talento_model->total_pesquisa_clima();
		$data['total_pergunta_clima'] = $this->Gestao_engajamento_talento_model->total_pergunta_clima();
		$data['total_resposta_clima'] = $this->Gestao_engajamento_talento_model->total_resposta_clima();

		$this->load->view('clima/index_clima', $data);
	}
	public function add_pesquisa_clima () {
		$this->http_method('POST');

		$data = [
            'status_id' => 1,
            'titulo' => $this->input->post('titulo') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
            'data_criacao' => $this->input->post('data_criacao') ?? '',
            'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];
		$this->form_validation->set_rules('titulo', _l('titulo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_criacao', _l('data_criacao'), 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/clima');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->create_pesquisa_clima($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_engajamento_talentos/clima');
		}
	}
	public function editar_pesquisa_clima ($id) {
		$this->http_method('POST');
		$this->Gestao_engajamento_talento_model->first_pesquisa_clima($id);

		$data = [
            'titulo' => $this->input->post('e_titulo') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
            'data_criacao' => $this->input->post('e_data_criacao') ?? '',
            'aprovadores' => json_encode($this->input->post('e_aprovadores[]')) ?? '[]',
        ];
		$this->form_validation->set_rules('e_titulo', _l('titulo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_data_criacao', _l('data_criacao'), 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/clima');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->update_pesquisa_clima($data, $id);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_engajamento_talentos/clima');
		}
	}
	public function delete_pesquisa_clima ($id) {
		$this->Gestao_engajamento_talento_model->first_pesquisa_clima($id);
		$this->Gestao_engajamento_talento_model->delete_pesquisa_clima($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_engajamento_talentos/clima');
	}
	public function pesquisa_clima_aprovar($id) {
        $vf = $this->Gestao_engajamento_talento_model->first_pesquisa_clima($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_engajamento_talentos/clima');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_engajamento_talentos/clima');
		}
		$this->Gestao_engajamento_talento_model->update_pesquisa_clima(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('gestao_engajamento_talentos/clima');
    }
    public function pesquisa_clima_rejeitar($id) {
        $vf = $this->Gestao_engajamento_talento_model->first_pesquisa_clima($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_engajamento_talentos/clima');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_engajamento_talentos/clima');
		}
		$this->Gestao_engajamento_talento_model->update_pesquisa_clima(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('gestao_engajamento_talentos/clima');
    }

	public function clima_pergunta_clima() {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Pergunta de Clima');
		$data['pesquisa_clima'] = $this->Gestao_engajamento_talento_model->get_pesquisa_clima(2);
		$data['pergunta_clima'] = $this->Gestao_engajamento_talento_model->get_pergunta_clima();

		$this->load->view('clima/pergunta_clima', $data);
	}
	public function add_pergunta_clima () {
		$this->http_method('POST');

		$data = [
            'pesquisa_clima_id' => $this->input->post('pesquisa') ?? '',
            'texto' => $this->input->post('texto') ?? '',
            'tipo_resposta' => $this->input->post('tipo_resposta') ?? '',
        ];
		$this->form_validation->set_rules('pesquisa', _l('pesquisa'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('texto', _l('texto'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('tipo_resposta', _l('tipo_resposta'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/clima_pergunta_clima');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->create_pergunta_clima($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_engajamento_talentos/clima_pergunta_clima');
		}
	}
	public function editar_pergunta_clima ($id) {
		$this->http_method('POST');
		$this->Gestao_engajamento_talento_model->first_pergunta_clima($id);

		$data = [
            'pesquisa_clima_id' => $this->input->post('e_pesquisa') ?? '',
            'texto' => $this->input->post('e_texto') ?? '',
            'tipo_resposta' => $this->input->post('e_tipo_resposta') ?? '',
        ];
		$this->form_validation->set_rules('e_pesquisa', _l('pesquisa'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_texto', _l('texto'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_tipo_resposta', _l('tipo_resposta'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/clima_pergunta_clima');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->update_pergunta_clima($data, $id);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_engajamento_talentos/clima_pergunta_clima');
		}
	}
	public function delete_pergunta_clima ($id) {
		$this->Gestao_engajamento_talento_model->first_pergunta_clima($id);
		$this->Gestao_engajamento_talento_model->delete_pergunta_clima($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_engajamento_talentos/clima_pergunta_clima');
	}

	public function clima_resposta_clima() {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Resposta de Clima');
		$data['colaboradores'] = $this->Gestao_engajamento_talento_model->staffs();
		$data['pergunta_clima'] = $this->Gestao_engajamento_talento_model->get_pergunta_clima();
		$data['resposta_clima'] = $this->Gestao_engajamento_talento_model->get_resposta_clima();

		$this->load->view('clima/resposta_clima', $data);
	}
	public function add_resposta_clima () {
		$this->http_method('POST');

		$data = [
            'pergunta_clima_id' => $this->input->post('pergunta') ?? '',
            'staff_id' => $this->input->post('colaborador') ?? '',
            'resposta' => $this->input->post('resposta') ?? '',
        ];
		$this->form_validation->set_rules('pergunta', _l('pergunta'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('colaborador', _l('colaborador'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('resposta', _l('resposta'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/clima_resposta_clima');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->create_resposta_clima($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_engajamento_talentos/clima_resposta_clima');
		}
	}
	public function editar_resposta_clima ($id) {
		$this->http_method('POST');
		$this->Gestao_engajamento_talento_model->first_resposta_clima($id);

		$data = [
            'pergunta_clima_id' => $this->input->post('e_pergunta') ?? '',
            'staff_id' => $this->input->post('e_colaborador') ?? '',
            'resposta' => $this->input->post('e_resposta') ?? '',
        ];
		$this->form_validation->set_rules('e_pergunta', _l('pergunta'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_colaborador', _l('colaborador'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_resposta', _l('resposta'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/clima_resposta_clima');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->update_resposta_clima($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_engajamento_talentos/clima_resposta_clima');
		}
	}
	public function delete_resposta_clima ($id) {
		$this->Gestao_engajamento_talento_model->first_resposta_clima($id);
		$this->Gestao_engajamento_talento_model->delete_resposta_clima($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_engajamento_talentos/clima_resposta_clima');
	}

	public function clima_visualizar_pesquisa($id) {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$vf = $this->Gestao_engajamento_talento_model->first_pesquisa_clima($id);
		$data['title'] = _l('Visualizar');
        $data['pesquisa_clima'] = $vf;

		$this->load->view('clima/visualizar_pesquisa', $data);
	}

	public function clima_visualizar_pergunta($id) {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Visualizar');
		$data['pergunta_clima'] = $this->Gestao_engajamento_talento_model->first_pergunta_clima($id);

		$this->load->view('clima/visualizar_pergunta', $data);
	}

	public function clima_visualizar_resposta($id) {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Visualizar');
		$data['resposta_clima'] = $this->Gestao_engajamento_talento_model->first_resposta_clima($id);
		$this->load->view('clima/visualizar_resposta', $data);
	}

	/********************************************************************************
	 * Tela de Conflitos
	 *******************************************************************************/
	public function conflitos() {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Conflitos');
		$data['staffs'] = $this->Gestao_engajamento_talento_model->staffs();
		$data['conflito'] = $this->Gestao_engajamento_talento_model->get_conflito();

		$data['conflito_total'] = $this->Gestao_engajamento_talento_model->conflito_total();
		$data['medicao_conflito_total'] = $this->Gestao_engajamento_talento_model->medicao_conflito_total();

		$this->load->view('conflitos/index_conflitos', $data);
	}
	public function add_conflito () {
		$this->http_method('POST');

		$data = [
			'staff_id' => $this->input->post('colaborador') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
            'data_registro' => $this->input->post('data_registro') ?? '',
            'status' => 'em_andamento',
        ];

		$this->form_validation->set_rules('colaborador', _l('colaborador'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_registro', _l('data_registro'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/conflitos');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->create_conflito($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_engajamento_talentos/conflitos');
		}
	}
	public function editar_conflito ($id) {
		$this->http_method('POST');
		$this->Gestao_engajamento_talento_model->first_conflito($id);

		$data = [
			'staff_id' => $this->input->post('e_colaborador') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
            'data_registro' => $this->input->post('e_data_registro') ?? '',
            'status' => $this->input->post('e_estado') ?? '',
        ];

		$this->form_validation->set_rules('e_colaborador', _l('colaborador'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_data_registro', _l('data_registro'), 'required', ['required' => 'Preencha o campo {field}']);

		$enum_valido = ['em_andamento', 'nao_resolvido', 'resolvido'];
		$this->form_validation->set_rules('e_estado', 'Estado', ['required', [
            'enum',
            function ($value) use ($enum_valido) {
                return in_array($value, $enum_valido);
            }
        ]], ['required' => 'Selecione um Estado', 'enum' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido)]);


		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/conflitos');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->update_conflito($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_engajamento_talentos/conflitos');
		}
	}
	public function delete_conflito ($id) {
		$this->Gestao_engajamento_talento_model->first_conflito($id);
		$this->Gestao_engajamento_talento_model->delete_conflito($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_engajamento_talentos/conflitos');
	}

	public function conflitos_mediacao() {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Mediação de Conflito');
		$data['staffs'] = $this->Gestao_engajamento_talento_model->staffs();
		$data['conflito'] = $this->Gestao_engajamento_talento_model->get_conflito();

		$data['medicao_conflito'] = $this->Gestao_engajamento_talento_model->get_medicao_conflito();
		$this->load->view('conflitos/mediacao', $data);
	}
	public function add_medicao_conflito () {
		$this->http_method('POST');

		$data = [
			'conflito_id' => $this->input->post('conflito') ?? '',
			'mediador_id' => $this->input->post('mediador') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
            'data_mediacao' => $this->input->post('data_mediacao') ?? '',
            'status' => 'em_andamento',
        ];

		$this->form_validation->set_rules('conflito', _l('conflito'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('mediador', _l('mediador'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_mediacao', _l('data_mediacao'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/conflitos_mediacao');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->create_medicao_conflito($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_engajamento_talentos/conflitos_mediacao');
		}
	}
	public function editar_medicao_conflito ($id) {
		$this->http_method('POST');
		$this->Gestao_engajamento_talento_model->first_medicao_conflito($id);

		$data = [
			'conflito_id' => $this->input->post('e_conflito') ?? '',
			'mediador_id' => $this->input->post('e_mediador') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
            'data_mediacao' => $this->input->post('e_data_mediacao') ?? '',
            'status' => $this->input->post('e_estado') ?? '',
        ];

		$this->form_validation->set_rules('e_conflito', _l('conflito'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_mediador', _l('mediador'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_descricao', _l('descricao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_data_mediacao', _l('data_mediacao'), 'required', ['required' => 'Preencha o campo {field}']);

		$enum_valido = ['em_andamento', 'nao_resolvido', 'resolvido'];
		$this->form_validation->set_rules('e_estado', 'Estado', ['required', [
            'enum',
            function ($value) use ($enum_valido) {
                return in_array($value, $enum_valido);
            }
        ]], ['required' => 'Selecione um Estado', 'enum' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido)]);

		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_engajamento_talentos/conflitos_mediacao');
        }
		else {
			$insert = $this->Gestao_engajamento_talento_model->update_medicao_conflito($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_engajamento_talentos/conflitos_mediacao');
		}
	}
	public function delete_medicao_conflito ($id) {
		$this->Gestao_engajamento_talento_model->first_medicao_conflito($id);
		$this->Gestao_engajamento_talento_model->delete_medicao_conflito($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_engajamento_talentos/conflitos_mediacao');
	}

	public function conflitos_visualizar_conflito($id) {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Visualizar');
		$data['conflito'] = $this->Gestao_engajamento_talento_model->first_conflito($id);

		$this->load->view('conflitos/visualizar_conflito', $data);
	}

	public function conflitos_visualizar_mediacao($id) {
		if (!has_permission('gestao_engajamento_talentos', '', 'edit') && !is_admin()) {
			access_denied('gestao_engajamento_talentos');
		}
		$data['title'] = _l('Visualizar');
		$data['medicao_conflito'] = $this->Gestao_engajamento_talento_model->first_medicao_conflito($id);

		$this->load->view('conflitos/visualizar_mediacao', $data);
	}



}