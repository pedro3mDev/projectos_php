<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Plan_forca_trabalho extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('plan_forca_trabalho_model');
		$this->load->library(['form_validation', 'upload']);

	}
	private function http_method($vfMethod)
	{
		if ($_SERVER['REQUEST_METHOD'] !== $vfMethod) {
			header("HTTP/1.1 405 Method Not Allowed");
			echo json_encode(['status' => false, 'message' => 'Metodo não permitido']);
			exit;
		}
	}
	/********************************************************************************
	 * Tela de Dashboard
	 *******************************************************************************/
	public function dashboard()
	{
		if (!has_permission('plan_forca_trabalho', '', 'edit') && !is_admin()) {
			access_denied('plan_forca_trabalho');
		}
		$data['title'] = _l('Dashboard');
		$this->load->view('dashboard/index', $data);
	}

	/********************************************************************************
	 * Tela de Analise
	 *******************************************************************************/
	public function analise()
	{
		if (!has_permission('plan_forca_trabalho', '', 'edit') && !is_admin()) {
			access_denied('plan_forca_trabalho');
		}
		$data['title'] = _l('analise');
		$data['staff_list'] = $this->plan_forca_trabalho_model->staffs_admin();
		$data['analise'] = $this->plan_forca_trabalho_model->get_analise();
		$data['departamento'] = $this->plan_forca_trabalho_model->get_departamento();
		$this->load->view('analise/index_analise', $data);
	}

	public function add_Analise_necessidade()
	{
		$this->http_method('POST');

		$data = [
			'descricao' => $this->input->post('descricao') ?? '',
			'prazo' => $this->input->post('prazo') ?? '',
			'quantidade' => $this->input->post('quantidade') ?? '',
			'status_id' => 1,
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
			'departamento_id' => $this->input->post('departamento_id') ?? '',
		];
		$this->form_validation->set_rules('quantidade', _l('quantidade'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('departamento_id', _l('departamento_id'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);
		$this->form_validation->set_rules('prazo', _l('prazo'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('plan_forca_trabalho/analise');
		} else {
			$insert = $this->plan_forca_trabalho_model->create_analise($data);

			set_alert('success', "Cadastrado com sucesso");
			redirect('plan_forca_trabalho/analise');
		}
	}

	public function delete_analise_necessidade($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect('plan_forca_trabalho/analise');
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('pft_necessidade_pessoal');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Deletada com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}

		redirect('plan_forca_trabalho/analise');
	}


	public function editar_analise_necessidade()
	{
		$this->form_validation->set_rules('quantidade', _l('quantidade'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('departamento_id', _l('departamento_id'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);
		$this->form_validation->set_rules('prazo', _l('prazo'), 'required', ['required' => 'Preencha o campo {field}']);


		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$avaliacao_id = $this->input->post('id');

		// Dados principais da avaliação
		$data = [
			'descricao' => $this->input->post('descricao') ?? '',
			'prazo' => $this->input->post('prazo') ?? '',
			'quantidade' => $this->input->post('quantidade') ?? '',
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
			'departamento_id' => $this->input->post('departamento_id') ?? '',
		];

		$this->db->where('id', $avaliacao_id);
		$this->db->update('pft_necessidade_pessoal', $data);

		set_alert('success', 'atualizada com sucesso.');
		redirect('plan_forca_trabalho/analise');
	}

	public function analise_aprovar($id)
	{
		$vf = $this->plan_forca_trabalho_model->analise_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger', "Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_forca_trabalho/analise');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger', "Erro, tente novamente.");
			return redirect('plan_forca_trabalho/analise');
		}
		$this->plan_forca_trabalho_model->analise_update(['status_id' => 2], $id);
		set_alert('success', "Aprovado com sucesso.");
		return redirect('plan_forca_trabalho/analise');
	}
	public function analise_rejeitar($id)
	{
		$vf = $this->plan_forca_trabalho_model->analise_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger', "Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_forca_trabalho/analise');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger', "Erro, tente novamente.");
			return redirect('plan_forca_trabalho/analise');
		}
		$this->plan_forca_trabalho_model->analise_update(['status_id' => 3], $id);
		set_alert('success', "Rejeitado com sucesso.");
		return redirect('plan_forca_trabalho/analise');
	}


	/********************************************************************************
	 * Tela de planeamento
	 *******************************************************************************/
	public function planeamento()
	{
		if (!has_permission('plan_forca_trabalho', '', 'edit') && !is_admin()) {
			access_denied('plan_forca_trabalho');
		}
		$data['title'] = _l('planeamento');
		$data['planeamento'] = $this->plan_forca_trabalho_model->get_planeamento();
		$data['tipo_planeamento'] = $this->plan_forca_trabalho_model->get_tipo_planeamto();
		$this->load->view('planeamento/index_planeamento', $data);
	}

	public function add_planeamento()
	{
		$this->http_method('POST');

		$data = [
			'previsao_demanda' => $this->input->post('previsao_demanda'),
			'data_criacao' => $this->input->post('data_criacao'),
			'tipo_planeamento_id' => $this->input->post('tipo_planeamento_id'),
		];
		$this->form_validation->set_rules('previsao_demanda', _l('previsao_demanda'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_criacao', _l('data_criacao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('tipo_planeamento_id', _l('tipo_planeamento_id'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);

		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('plan_forca_trabalho/planeamento');
		} else {
			$insert = $this->plan_forca_trabalho_model->create_planeamento($data);

			set_alert('success', "Cadastrado com sucesso");
			redirect('plan_forca_trabalho/planeamento');
		}
	}

	public function delete_planeamento($id)
	{

		// Verifica se o ID foi passado
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']); // Retorna para a página anterior
		}

		// Deleta a avaliação no banco de dados
		$this->db->where('id', $id);
		$deleted = $this->db->delete('pft_planeamento_recursos');

		if ($deleted) {
			$this->session->set_flashdata('success', 'deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}

		redirect($_SERVER['HTTP_REFERER']); // Retorna para a página anterior
	}

	public function editar_planeamento()
	{
		$this->form_validation->set_rules('previsao_demanda', 'previsao_demanda', 'required');
		$this->form_validation->set_rules('data_criacao', 'Data de Fim', 'required');
		$this->form_validation->set_rules('tipo_planeamento_id', 'Tipo de planeamento', 'required');

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$id = $this->input->post('id');

		// Dados principais da avaliação
		$data = [
			'previsao_demanda' => $this->input->post('previsao_demanda'),
			'data_criacao' => $this->input->post('data_criacao'),
			'tipo_planeamento_id' => $this->input->post('tipo_planeamento_id'), // Correção do nome do campo
		];

		$this->db->where('id', $id);
		$this->db->update('pft_planeamento_recursos', $data);

		set_alert('success', 'Atualizado com sucesso.');
		redirect('plan_forca_trabalho/planeamento');
	}



	/********************************************************************************
	 * Tela de identificacao
	 *******************************************************************************/
	public function identificacao()
	{
		if (!has_permission('plan_forca_trabalho', '', 'edit') && !is_admin()) {
			access_denied('plan_forca_trabalho');
		}
		$data['title'] = _l('identificacao');
		$data['staff'] = $this->plan_forca_trabalho_model->staffs();
		$data['competencia_funcionario'] = $this->plan_forca_trabalho_model->get_competencia_funcionario();
		$data['competencia'] = $this->plan_forca_trabalho_model->get_competencia();
		$this->load->view('identificacao/index_identificacao', $data);
	}

	public function add_competencia_funcionario()
	{
		$this->http_method('POST');

		$data = [
			'nivel' => $this->input->post('nivel') ?? '',
			'staff_id' => $this->input->post('funcionario[]') ?? '',
			'competencia_id' => $this->input->post('competencia_id') ?? '',
		];
		$this->form_validation->set_rules('nivel', _l('nivel'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario[]'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('competencia_id', _l('competencia_id'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);

		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('plan_forca_trabalho/identificacao');
		} else {
			$insert = $this->plan_forca_trabalho_model->create_competencia_funcionario($data);

			set_alert('success', "Cadastrado com sucesso");
			redirect('plan_forca_trabalho/identificacao');
		}
	}

	public function delete_competencia_funcionario($id)
	{

		// Deleta a avaliação no banco de dados
		$this->db->where('id', $id);
		$deleted = $this->db->delete('pft_competencia_funcionario');

		if ($deleted) {
			$this->session->set_flashdata('success', 'deletada com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}
		redirect($_SERVER['HTTP_REFERER']); // Retorna para a página anterior
	}

	public function editar_competencia_funcionario()
	{
		$this->form_validation->set_rules('nivel', _l('nivel'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario[]'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('competencia_id', _l('competencia_id'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$id = $this->input->post('id');

		$data = [
			'nivel' => $this->input->post('nivel') ?? '',
			'staff_id' => $this->input->post('funcionario[]') ?? '',
			'competencia_id' => $this->input->post('competencia_id') ?? '',
		];

		$this->db->where('id', $id);
		$this->db->update('pft_competencia_funcionario', $data);

		set_alert('success', 'atualizada com sucesso.');
		redirect('plan_forca_trabalho/identificacao');
	}


	/********************************************************************************
	 * Tela de alocacao
	 *******************************************************************************/
	public function alocacao()
	{
		if (!has_permission('plan_forca_trabalho', '', 'edit') && !is_admin()) {
			access_denied('plan_forca_trabalho');
		}
		$data['title'] = _l('alocacao');
		$data['staff'] = $this->plan_forca_trabalho_model->staffs();
		$data['projeto'] = $this->plan_forca_trabalho_model->get_projeto();
		$data['alocacao'] = $this->plan_forca_trabalho_model->get_alocacao();
		$this->load->view('alocacao/index_alocacao', $data);
	}

	public function add_alocacao()
	{
		$this->http_method('POST');

		$data = [
			'data_inicio' => $this->input->post('data_inicio') ?? '',
			'data_fim' => $this->input->post('data_fim') ?? '',
			'staff_id' => $this->input->post('funcionario[]') ?? '',
			'projeto_id' => $this->input->post('projeto_id') ?? '',
		];
		$this->form_validation->set_rules('data_inicio', _l('data_inicio'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_fim', _l('data_fim'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario[]'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('projeto_id', _l('projeto_id'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);

		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('plan_forca_trabalho/alocacao');
		} else {
			$insert = $this->plan_forca_trabalho_model->create_alocacao($data);

			set_alert('success', "Cadastrado com sucesso");
			redirect('plan_forca_trabalho/alocacao');
		}
	}

	public function delete_alocacao($id)
	{

		// Deleta a avaliação no banco de dados
		$this->db->where('id', $id);
		$deleted = $this->db->delete('pft_alocacao');

		if ($deleted) {
			$this->session->set_flashdata('success', 'deletada com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}
		redirect($_SERVER['HTTP_REFERER']); // Retorna para a página anterior
	}

	public function editar_alocacao()
	{
		$this->form_validation->set_rules('data_inicio', _l('data_inicio'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_fim', _l('data_fim'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario[]'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('projeto_id', _l('projeto_id'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$id = $this->input->post('id');

		$data = [
			'data_inicio' => $this->input->post('data_inicio') ?? '',
			'data_fim' => $this->input->post('data_fim') ?? '',
			'staff_id' => $this->input->post('funcionario[]') ?? '',
			'projeto_id' => $this->input->post('projeto_id') ?? '',
		];

		$this->db->where('id', $id);
		$this->db->update('pft_alocacao', $data);

		set_alert('success', 'atualizada com sucesso.');
		redirect('plan_forca_trabalho/alocacao');
	}



	/********************************************************************************
	 * Tela de previsao
	 *******************************************************************************/
	public function projeto()
	{
		if (!has_permission('plan_forca_trabalho', '', 'edit') && !is_admin()) {
			access_denied('plan_forca_trabalho');
		}
		$data['title'] = _l('previsao');
		$data['staff'] = $this->plan_forca_trabalho_model->staffs();
		$data['staff_list'] = $this->plan_forca_trabalho_model->staffs_admin();
		$data['projeto'] = $this->plan_forca_trabalho_model->get_projeto();
		$this->load->view('projeto/index_projeto', $data);
	}

	public function add_projeto()
	{
		$this->http_method('POST');

		$data = [
			'descricao' => $this->input->post('descricao') ?? '',
			'nome' => $this->input->post('nome') ?? '',
			'status_id' => 1,
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
			'staff_id' => $this->input->post('funcionario[]') ?? '[]',
		];
		$this->form_validation->set_rules('nome', _l('nome'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario[]'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('plan_forca_trabalho/projeto');
		} else {
			$insert = $this->plan_forca_trabalho_model->create_projeto($data);

			set_alert('success', "Cadastrado com sucesso");
			redirect('plan_forca_trabalho/projeto');
		}
	}

	public function delete_projeto($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect('plan_forca_trabalho/projeto');
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('pft_projeto');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Deletada com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}

		redirect('plan_forca_trabalho/projeto');
	}


	public function editar_projeto()
	{
		$this->form_validation->set_rules('nome', _l('nome'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario[]'), 'required', ['required' => 'Preencha o campo {field}']);


		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$avaliacao_id = $this->input->post('id');

		// Dados principais da avaliação
		$data = [
			'descricao' => $this->input->post('descricao') ?? '',
			'nome' => $this->input->post('nome') ?? '',
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
			'staff_id' => $this->input->post('funcionario[]') ?? '[]',
		];

		$this->db->where('id', $avaliacao_id);
		$this->db->update('pft_projeto', $data);

		set_alert('success', 'atualizada com sucesso.');
		redirect('plan_forca_trabalho/projeto');
	}

	public function projeto_aprovar($id)
	{
		$vf = $this->plan_forca_trabalho_model->projeto_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger', "Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_forca_trabalho/projeto');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger', "Erro, tente novamente.");
			return redirect('plan_forca_trabalho/projeto');
		}
		$this->plan_forca_trabalho_model->projeto_update(['status_id' => 2], $id);
		set_alert('success', "Aprovado com sucesso.");
		return redirect('plan_forca_trabalho/projeto');
	}
	public function projeto_rejeitar($id)
	{
		$vf = $this->plan_forca_trabalho_model->projeto_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger', "Erro, você não faz parte da lista dos aprovadores.");
			return redirect('plan_forca_trabalho/projeto');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger', "Erro, tente novamente.");
			return redirect('plan_forca_trabalho/projeto');
		}
		$this->plan_forca_trabalho_model->projeto_update(['status_id' => 3], $id);
		set_alert('success', "Rejeitado com sucesso.");
		return redirect('plan_forca_trabalho/projeto');
	}

	/********************************************************************************
	 * Tela de simulacao
	 *******************************************************************************/
	public function simulacao()
	{
		if (!has_permission('plan_forca_trabalho', '', 'edit') && !is_admin()) {
			access_denied('plan_forca_trabalho');
		}
		$data['title'] = _l('simulacao');
		$data['simulacao'] = $this->plan_forca_trabalho_model->get_simulacao();
		$this->load->view('simulacao/index_simulacao', $data);
	}


	public function add_simulacao()
	{
		$this->http_method('POST');

		$data = [
			'descricao' => $this->input->post('descricao') ?? '',
			'impacto_previsto' => $this->input->post('impacto_previsto') ?? '',
			'data_criacao' => $this->input->post('data_criacao') ?? '',
		];
		$this->form_validation->set_rules('impacto_previsto', _l('impacto_previsto'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_criacao', _l('data_criacao'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('plan_forca_trabalho/simulacao');
		} else {
			$insert = $this->plan_forca_trabalho_model->create_simulacao($data);

			set_alert('success', "Cadastrado com sucesso");
			redirect('plan_forca_trabalho/simulacao');
		}
	}

	public function delete_simulacao($id)
	{

		// Deleta a avaliação no banco de dados
		$this->db->where('id', $id);
		$deleted = $this->db->delete('pft_simulacao');

		if ($deleted) {
			$this->session->set_flashdata('success', 'deletada com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}
		redirect($_SERVER['HTTP_REFERER']); // Retorna para a página anterior
	}

	public function editar_simulacao()
	{
		$this->form_validation->set_rules('impacto_previsto', _l('impacto_previsto'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_criacao', _l('data_criacao'), 'required', ['required' => 'Preencha o campo {field}']);

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$id = $this->input->post('id');

		$data = [
			'descricao' => $this->input->post('descricao') ?? '',
			'impacto_previsto' => $this->input->post('impacto_previsto') ?? '',
			'data_criacao' => $this->input->post('data_criacao') ?? '',
		];

		$this->db->where('id', $id);
		$this->db->update('pft_simulacao', $data);

		set_alert('success', 'atualizada com sucesso.');
		redirect('plan_forca_trabalho/simulacao');
	}

	/********************************************************************************
	 * Tela de ajustes
	 *******************************************************************************/
	public function ajustes()
	{
		if (!has_permission('plan_forca_trabalho', '', 'edit') && !is_admin()) {
			access_denied('plan_forca_trabalho');
		}
		$data['title'] = _l('ajustes');
		$data['ajuste'] = $this->plan_forca_trabalho_model->get_ajuste();
		$data['recurso'] = $this->plan_forca_trabalho_model->get_recurso();
		$this->load->view('ajustes/index_ajustes', $data);
	}


	public function add_ajuste()
	{
		$this->http_method('POST');

		$data = [
			'kpi_impactado' => $this->input->post('kpi_impactado') ?? '',
			'anotacao' => $this->input->post('nova_alocacao') ?? '',
			'data' => $this->input->post('data_atualizacao') ?? '',
			'motivo' => $this->input->post('motivo') ?? '',
			'recurso_id' => $this->input->post('recurso_id') ?? '',
		];
		$this->form_validation->set_rules('kpi_impactado', _l('kpi_impactado'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('nova_alocacao', _l('nova_alocacao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('motivo', _l('motivo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_atualizacao', _l('data_atualizacao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('recurso_id', _l('recurso_id'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('plan_forca_trabalho/ajustes');
		} else {
			$insert = $this->plan_forca_trabalho_model->create_ajuste($data);

			set_alert('success', "Cadastrado com sucesso");
			redirect('plan_forca_trabalho/ajustes');
		}
	}

	public function delete_ajuste($id)
	{

		// Deleta a avaliação no banco de dados
		$this->db->where('id', $id);
		$deleted = $this->db->delete('pft_ajuste');

		if ($deleted) {
			$this->session->set_flashdata('success', 'deletada com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}
		redirect($_SERVER['HTTP_REFERER']); // Retorna para a página anterior
	}

	public function editar_ajuste()
	{
		$this->form_validation->set_rules('kpi_impactado', _l('kpi_impactado'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('nova_alocacao', _l('nova_alocacao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('motivo', _l('motivo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_atualizacao', _l('data_atualizacao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('recurso_id', _l('recurso_id'), 'required', ['required' => 'Preencha o campo {field}']);

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$id = $this->input->post('id');

		$data = [
			'kpi_impactado' => $this->input->post('kpi_impactado') ?? '',
			'anotacao' => $this->input->post('nova_alocacao') ?? '',
			'data' => $this->input->post('data_atualizacao') ?? '',
			'motivo' => $this->input->post('motivo') ?? '',
			'recurso_id' => $this->input->post('recurso_id') ?? '',
		];

		$this->db->where('id', $id);
		$this->db->update('pft_ajuste', $data);

		set_alert('success', 'atualizada com sucesso.');
		redirect('plan_forca_trabalho/ajustes');
	}


	/********************************************************************************
	 * Tela de monitoramento
	 *******************************************************************************/
	public function monitoramento()
	{
		if (!has_permission('plan_forca_trabalho', '', 'edit') && !is_admin()) {
			access_denied('plan_forca_trabalho');
		}
		$data['title'] = _l('monitoramento');
		$data['monitoramento'] = $this->plan_forca_trabalho_model->get_monitoramento();
		$data['plano'] = $this->plan_forca_trabalho_model->get_plano();
		$this->load->view('monitoramento/index_monitoramento', $data);
	}

	public function add_monitoramento()
	{
		$this->http_method('POST');

		$data = [
			'kpi_avaliado' => $this->input->post('kpi_avaliado') ?? '',
			'resultado' => $this->input->post('resultado') ?? '',
			'data_registro' => $this->input->post('data_registro') ?? '',
			'plano_id' => $this->input->post('plano_id') ?? '',
		];
		$this->form_validation->set_rules('kpi_avaliado', _l('kpi_avaliado'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('resultado', _l('resultado'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_registro', _l('data_registro'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('plano_id', _l('plano_id'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('plan_forca_trabalho/monitoramento');
		} else {
			$insert = $this->plan_forca_trabalho_model->create_monitoramento($data);

			set_alert('success', "Cadastrado com sucesso");
			redirect('plan_forca_trabalho/monitoramento');
		}
	}

	public function delete_monitoramento($id)
	{

		// Deleta a avaliação no banco de dados
		$this->db->where('id', $id);
		$deleted = $this->db->delete('pft_monitoramento_plano');

		if ($deleted) {
			$this->session->set_flashdata('success', 'deletada com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}
		redirect($_SERVER['HTTP_REFERER']); // Retorna para a página anterior
	}

	public function editar_monitoramento()
	{
		$this->form_validation->set_rules('kpi_avaliado', _l('kpi_avaliado'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('resultado', _l('resultado'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_registro', _l('data_registro'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('plano_id', _l('plano_id'), 'required', ['required' => 'Preencha o campo {field}']);

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$id = $this->input->post('id');

		$data = [
			'kpi_avaliado' => $this->input->post('kpi_avaliado') ?? '',
			'resultado' => $this->input->post('resultado') ?? '',
			'data_registro' => $this->input->post('data_registro') ?? '',
			'plano_id' => $this->input->post('plano_id') ?? '',
		];

		$this->db->where('id', $id);
		$this->db->update('pft_monitoramento_plano', $data);

		set_alert('success', 'atualizada com sucesso.');
		redirect('plan_forca_trabalho/monitoramento');
	}




	/********************************************************************************
	 * Tela de integracao
	 *******************************************************************************/
	public function integracao()
	{
		if (!has_permission('plan_forca_trabalho', '', 'edit') && !is_admin()) {
			access_denied('plan_forca_trabalho');
		}
		$data['title'] = _l('integracao');
		$data['staff'] = $this->plan_forca_trabalho_model->staffs();
		$data['integracao'] = $this->plan_forca_trabalho_model->get_integracao();
		$this->load->view('integracao/index_integracao', $data);
	}

	public function add_integracao()
	{
		$this->http_method('POST');

		$data = [
			'valor' => $this->input->post('valor') ?? '',
			'data_pagamento' => $this->input->post('data_pagamento') ?? '',
			'staff_id' => $this->input->post('funcionario[]') ?? '',
		];
		$this->form_validation->set_rules('valor', _l('valor'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_pagamento', _l('data_pagamento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario[]'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('plan_forca_trabalho/integracao');
		} else {
			$insert = $this->plan_forca_trabalho_model->create_integracao($data);

			set_alert('success', "Cadastrado com sucesso");
			redirect('plan_forca_trabalho/integracao');
		}
	}

	public function delete_integracao($id)
	{

		// Deleta a avaliação no banco de dados
		$this->db->where('id', $id);
		$deleted = $this->db->delete('pft_integracao');

		if ($deleted) {
			$this->session->set_flashdata('success', 'deletada com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}
		redirect($_SERVER['HTTP_REFERER']); // Retorna para a página anterior
	}

	public function editar_integracao()
	{
		$this->form_validation->set_rules('valor', _l('valor'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_pagamento', _l('data_pagamento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario[]'), 'required', ['required' => 'Preencha o campo {field}']);

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$id = $this->input->post('id');

		$data = [
			'valor' => $this->input->post('valor') ?? '',
			'data_pagamento' => $this->input->post('data_pagamento') ?? '',
			'staff_id' => $this->input->post('funcionario[]') ?? '',
		];

		$this->db->where('id', $id);
		$this->db->update('pft_integracao', $data);

		set_alert('success', 'atualizada com sucesso.');
		redirect('plan_forca_trabalho/integracao');
	}


	/********************************************************************************
	 * Tela de previsao
	 *******************************************************************************/
	public function previsao()
	{
		if (!has_permission('plan_forca_trabalho', '', 'edit') && !is_admin()) {
			access_denied('plan_forca_trabalho');
		}
		$data['title'] = _l('previsao');
		$data['previsao'] = $this->plan_forca_trabalho_model->get_previsaos();
		$data['departamento'] = $this->plan_forca_trabalho_model->get_departamento();
		$data['tipo_previsao'] = $this->plan_forca_trabalho_model->get_previsao();
		$this->load->view('previsao/index_previsao', $data);
	}

	public function add_previsaos()
	{
		$this->http_method('POST');

		$data = [
			'dado_entrada' => $this->input->post('dado_entrada') ?? '',
			'resultado_previsao' => $this->input->post('resultado_previsao') ?? '',
			'data' => $this->input->post('data') ?? '',
			'tipo_previsao_id' => $this->input->post('tipo_previsao_id') ?? '',
			'departamento_id' => $this->input->post('departamento_id') ?? '',
		];
		$this->form_validation->set_rules('dado_entrada', _l('dado_entrada'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('resultado_previsao', _l('resultado_previsao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data', _l('data'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('tipo_previsao_id', _l('tipo_previsao_id'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('departamento_id', _l('tipo_previsao_id'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('plan_forca_trabalho/previsao');
		} else {
			$insert = $this->plan_forca_trabalho_model->create_previsaos($data);

			set_alert('success', "Cadastrado com sucesso");
			redirect('plan_forca_trabalho/previsao');
		}
	}

	public function delete_previsaos($id)
	{

		// Deleta a avaliação no banco de dados
		$this->db->where('id', $id);
		$deleted = $this->db->delete('pft_previsao');

		if ($deleted) {
			$this->session->set_flashdata('success', 'deletada com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}
		redirect($_SERVER['HTTP_REFERER']); // Retorna para a página anterior
	}

	public function editar_previsaos()
	{
		$this->form_validation->set_rules('dado_entrada', _l('dado_entrada'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('resultado_previsao', _l('resultado_previsao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data', _l('data'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('tipo_previsao_id', _l('tipo_previsao_id'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('departamento_id', _l('tipo_previsao_id'), 'required', ['required' => 'Preencha o campo {field}']);

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$id = $this->input->post('id');

		$data = [
			'dado_entrada' => $this->input->post('dado_entrada') ?? '',
			'resultado_previsao' => $this->input->post('resultado_previsao') ?? '',
			'data' => $this->input->post('data') ?? '',
			'tipo_previsao_id' => $this->input->post('tipo_previsao_id') ?? '',
			'departamento_id' => $this->input->post('departamento_id') ?? '',
		];

		$this->db->where('id', $id);
		$this->db->update('pft_previsao', $data);

		set_alert('success', 'atualizada com sucesso.');
		redirect('plan_forca_trabalho/previsao');
	}

	/**
	 * Summary of configuracoes
	 * Todas configurações
	 * @return void
	 */
	public function configuracoes()
	{
		if (!has_permission('Plan_forca_trabalho', '', 'edit') && !is_admin()) {
			access_denied('Plan_forca_trabalho');
		}

		$data['title'] = _l('configuracoes');
		$data['group'] = $this->input->get('group');
		$data['tab'][] = 'status';
		$data['tab'][] = 'tipo_planeamento';
		$data['tab'][] = 'competencia';
		$data['tab'][] = 'plano';
		$data['tab'][] = 'recurso';
		$data['tab'][] = 'previsao';

		if ($data['group'] == '') {
			$data['title'] = _l('status');
			$data['group'] = 'status';
			$data['status'] = $this->plan_forca_trabalho_model->get_status();
		} elseif ($data['group'] == 'status') {
			$data['title'] = _l('status');
			$data['status'] = $this->plan_forca_trabalho_model->get_status();
		} elseif ($data['group'] == 'tipo_planeamento') {
			$data['title'] = _l('tipo_planeamento');
			$data['tipo_planeamento'] = $this->plan_forca_trabalho_model->get_tipo_planeamto();
		} elseif ($data['group'] == 'competencia') {
			$data['title'] = _l('competencia');
			$data['competencia'] = $this->plan_forca_trabalho_model->get_competencia();
		} elseif ($data['group'] == 'plano') {
			$data['title'] = _l('plano');
			$data['plano'] = $this->plan_forca_trabalho_model->get_plano();
		} elseif ($data['group'] == 'recurso') {
			$data['title'] = _l('recurso');
			$data['recurso'] = $this->plan_forca_trabalho_model->get_recurso();
		} elseif ($data['group'] == 'previsao') {
			$data['title'] = _l('previsao');
			$data['previsao'] = $this->plan_forca_trabalho_model->get_previsao();
		} else {
			set_alert('danger', "Configuração não encontrada");
			redirect('Plan_forca_trabalho/configuracoes?group=status');
		}

		$data['tabs']['view'] = 'includes/' . $data['group'];
		$this->load->view('configuracoes/index', $data);
	}

	#======================== Tipo de Avaliação ========================================
	public function add_tipo_planeamento()
	{
		$this->http_method('POST');

		$data = [
			'nome' => $this->input->post('tipo_planeamento') ?? '',
			'descricao' => $this->input->post('descricao') ?? '',
		];
		$this->form_validation->set_rules('tipo_planeamento', _l('tipo_planeamento'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('Plan_forca_trabalho/configuracoes?group=tipo_planeamento');
		} else {
			$insert = $this->plan_forca_trabalho_model->create_tipo_planeamento($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('Plan_forca_trabalho/configuracoes?group=tipo_planeamento');
		}
	}

	public function editar_tipo_planeamento($id)
	{
		$this->http_method('POST');
		$this->plan_forca_trabalho_model->first_tipo_planeamento($id);

		$data = [
			'nome' => $this->input->post('e_tipo_planeamento') ?? '',
			'descricao' => $this->input->post('e_descricao') ?? '',
		];
		$this->form_validation->set_rules('e_tipo_planeamento', _l('tipo_planeamento'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('Plan_forca_trabalho/configuracoes?group=tipo_planeamento');
		} else {
			$this->plan_forca_trabalho_model->update_tipo_planeamento($data, $id);
			set_alert('success', "Actualizado com sucesso");
			redirect('Plan_forca_trabalho/configuracoes?group=tipo_planeamento');
		}
	}
	public function delete_tipo_planeamento($id)
	{
		$this->plan_forca_trabalho_model->first_tipo_planeamento($id);
		$this->plan_forca_trabalho_model->delete_tipo_planeamento($id);
		set_alert('success', "Eliminado com sucesso");
		redirect('Plan_forca_trabalho/configuracoes?group=tipo_planeamento');
	}


	#======================== Competencia ========================================
	public function add_competencia()
	{
		$this->http_method('POST');

		$data = [
			'nome' => $this->input->post('competencia') ?? '',
			'descricao' => $this->input->post('descricao') ?? '',
		];
		$this->form_validation->set_rules('competencia', _l('competencia'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('Plan_forca_trabalho/configuracoes?group=competencia');
		} else {
			$insert = $this->plan_forca_trabalho_model->create_competencia($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('Plan_forca_trabalho/configuracoes?group=competencia');
		}
	}

	public function editar_competencia($id)
	{
		$this->http_method('POST');
		$this->plan_forca_trabalho_model->first_competencia($id);

		$data = [
			'nome' => $this->input->post('e_competencia') ?? '',
			'descricao' => $this->input->post('e_descricao') ?? '',
		];
		$this->form_validation->set_rules('e_competencia', _l('competencia'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('Plan_forca_trabalho/configuracoes?group=competencia');
		} else {
			$this->plan_forca_trabalho_model->update_competencia($data, $id);
			set_alert('success', "Actualizado com sucesso");
			redirect('Plan_forca_trabalho/configuracoes?group=competencia');
		}
	}
	public function delete_competencia($id)
	{
		$this->plan_forca_trabalho_model->first_competencia($id);
		$this->plan_forca_trabalho_model->delete_competencia($id);
		set_alert('success', "Eliminado com sucesso");
		redirect('Plan_forca_trabalho/configuracoes?group=competencia');
	}

	#======================== Plano ========================================
	public function add_plano()
	{
		$this->http_method('POST');

		$data = [
			'nome' => $this->input->post('plano') ?? '',
			'descricao' => $this->input->post('descricao') ?? '',
		];
		$this->form_validation->set_rules('plano', _l('plano'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('Plan_forca_trabalho/configuracoes?group=plano');
		} else {
			$insert = $this->plan_forca_trabalho_model->create_plano($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('Plan_forca_trabalho/configuracoes?group=plano');
		}
	}

	public function editar_plano($id)
	{
		$this->http_method('POST');
		$this->plan_forca_trabalho_model->first_plano($id);

		$data = [
			'nome' => $this->input->post('e_plano') ?? '',
			'descricao' => $this->input->post('e_descricao') ?? '',
		];
		$this->form_validation->set_rules('e_plano', _l('plano'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('Plan_forca_trabalho/configuracoes?group=plano');
		} else {
			$this->plan_forca_trabalho_model->update_plano($data, $id);
			set_alert('success', "Actualizado com sucesso");
			redirect('Plan_forca_trabalho/configuracoes?group=plano');
		}
	}
	public function delete_plano($id)
	{
		$this->plan_forca_trabalho_model->first_plano($id);
		$this->plan_forca_trabalho_model->delete_plano($id);
		set_alert('success', "Eliminado com sucesso");
		redirect('Plan_forca_trabalho/configuracoes?group=plano');
	}


	#======================== Recurso ========================================
	public function add_recurso()
	{
		$this->http_method('POST');

		$data = [
			'nome' => $this->input->post('recurso') ?? '',
			'descricao' => $this->input->post('descricao') ?? '',
		];
		$this->form_validation->set_rules('recurso', _l('recurso'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('Plan_forca_trabalho/configuracoes?group=recurso');
		} else {
			$insert = $this->plan_forca_trabalho_model->create_recurso($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('Plan_forca_trabalho/configuracoes?group=recurso');
		}
	}

	public function editar_recurso($id)
	{
		$this->http_method('POST');
		$this->plan_forca_trabalho_model->first_recurso($id);

		$data = [
			'nome' => $this->input->post('e_recurso') ?? '',
			'descricao' => $this->input->post('e_descricao') ?? '',
		];
		$this->form_validation->set_rules('e_recurso', _l('recurso'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('Plan_forca_trabalho/configuracoes?group=recurso');
		} else {
			$this->plan_forca_trabalho_model->update_recurso($data, $id);
			set_alert('success', "Actualizado com sucesso");
			redirect('Plan_forca_trabalho/configuracoes?group=recurso');
		}
	}
	public function delete_recurso($id)
	{
		$this->plan_forca_trabalho_model->first_recurso($id);
		$this->plan_forca_trabalho_model->delete_recurso($id);
		set_alert('success', "Eliminado com sucesso");
		redirect('Plan_forca_trabalho/configuracoes?group=recurso');
	}

	#========================== Previsao ===================================
	public function add_previsao()
	{
		$this->http_method('POST');

		$data = [
			'nome' => $this->input->post('previsao') ?? '',
			'descricao' => $this->input->post('descricao') ?? '',
		];
		$this->form_validation->set_rules('previsao', _l('previsao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('Plan_forca_trabalho/configuracoes?group=previsao');
		} else {
			$insert = $this->plan_forca_trabalho_model->create_previsao($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('Plan_forca_trabalho/configuracoes?group=previsao');
		}
	}

	public function editar_previsao($id)
	{
		$this->http_method('POST');
		$this->plan_forca_trabalho_model->first_previsao($id);

		$data = [
			'nome' => $this->input->post('e_previsao') ?? '',
			'descricao' => $this->input->post('e_descricao') ?? '',
		];
		$this->form_validation->set_rules('e_previsao', _l('previsao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('Plan_forca_trabalho/configuracoes?group=previsao');
		} else {
			$this->plan_forca_trabalho_model->update_previsao($data, $id);
			set_alert('success', "Actualizado com sucesso");
			redirect('Plan_forca_trabalho/configuracoes?group=previsao');
		}
	}
	public function delete_previsao($id)
	{
		$this->plan_forca_trabalho_model->first_previsao($id);
		$this->plan_forca_trabalho_model->delete_previsao($id);
		set_alert('success', "Eliminado com sucesso");
		redirect('Plan_forca_trabalho/configuracoes?group=previsao');
	}

}