<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Recruitment Controller
 */
class Gestao_remuneracao extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('gestao_remuneracao_model');
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
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Dashboard');
		$data['contar_faixa_salarial'] = $this->gestao_remuneracao_model->contar_faixa_salarial();
		$data['contar_brenchmark'] = $this->gestao_remuneracao_model->contar_brenchmark();
		$data['contar_comparacao'] = $this->gestao_remuneracao_model->contar_comparacao();
		$data['contar_relatorio_comparativo'] = $this->gestao_remuneracao_model->contar_relatorio_comparativo();
		$data['contar_dados_ajuste_salarial'] = $this->gestao_remuneracao_model->contar_dados_ajuste_salarial();
		$data['processamento_pagamento_valores'] = $this->gestao_remuneracao_model->processamento_pagamento_valores();
		$data['bonus_valores'] = $this->gestao_remuneracao_model->bonus_valores();
		$data['contar_dados_pacote_beneficio'] = $this->gestao_remuneracao_model->contar_dados_pacote_beneficio();
		$data['contar_subsidio_ferias'] = $this->gestao_remuneracao_model->contar_subsidio_ferias();
		$this->load->view('dashboard/index', $data);
	}

	/********************************************************************************
	 * Telas de Definição e Actualização
	 *******************************************************************************/
	public function definicao()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Definicao');
		$data['faixa_salarial'] = $this->gestao_remuneracao_model->get_faixa_salarial();
		$data['tipo_categorias'] = $this->gestao_remuneracao_model->get_tipo_categoria();
		$data['cargos'] = $this->gestao_remuneracao_model->cargos_get();
		$this->load->view('definicao_actualizacao/index_definicao_actualizacao', $data);
	}

	public function add_faixa_salarial()
	{
		$this->http_method('POST');
		$salario_max = $this->input->post('salario_max');
		$salario_min = $this->input->post('salario_min');

		$data = [
			'salario_min' => $this->input->post('salario_min'),
			'salario_max' => $this->input->post('salario_max'),
			'data_atualizacao' => $this->input->post('data_atualizacao'),
			'cargo_id' => $this->input->post('cargo_id'),
			'tipo_categoria_id' => $this->input->post('tipo_categoria_id'),
		];

		$this->form_validation->set_rules('salario_min', _l('salario_min'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('salario_max', _l('salario_max'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_atualizacao', _l('data_atualizacao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('cargo_id', _l('cargo_id'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('tipo_categoria_id', _l('tipo_categoria_id'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preencha os campos corretamente");
			redirect('gestao_remuneracao/definicao');
		} else {

			if ($salario_min >= $salario_max) {
				set_alert('danger', "O Salario Minimo dve ser Menor que o Maximo");
				redirect('gestao_remuneracao/definicao');
			}

			$insert = $this->gestao_remuneracao_model->create_faixa_salarial($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/definicao');
		}
	}

	public function editar_faixa_salarial()
	{
		$this->form_validation->set_rules('salario_min', 'salario_min', 'required');
		$this->form_validation->set_rules('salario_max', 'salario_max', 'required');
		$this->form_validation->set_rules('data_atualizacao', 'data_atualizacao', 'required');
		$this->form_validation->set_rules('cargo_id', 'cargo_id', 'required');
		$this->form_validation->set_rules('tipo_categoria_id', 'tipo_categoria_id', 'required');

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$salario_max = $this->input->post('salario_max');
		$salario_min = $this->input->post('salario_min');
		$variavel_id = $this->input->post('id');

		if ($salario_min >= $salario_max) {
			set_alert('danger', "O Salario Minimo dve ser Menor que o Maximo");
			redirect('gestao_remuneracao/definicao');
		}

		$data = [
			'salario_min' => $this->input->post('salario_min'),
			'salario_max' => $this->input->post('salario_max'),
			'data_atualizacao' => $this->input->post('data_atualizacao'),
			'cargo_id' => $this->input->post('cargo_id'),
			'tipo_categoria_id' => $this->input->post('tipo_categoria_id'),
		];

		$this->db->where('id', $variavel_id);
		$this->db->update('gr_faixa_salarial', $data);

		set_alert('success', 'Atualizado com sucesso.');
		redirect('gestao_remuneracao/definicao');
	}

	public function delete_faixa_salarial($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_faixa_salarial');

		if ($deleted) {
			$this->session->set_flashdata('success', 'deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	#=========================== definicao_benchmark_salarial ==================================
	public function definicao_benchmark_salarial()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Benchmark Salarial');
		$data['benchmark_salarial'] = $this->gestao_remuneracao_model->get_benchmark_salarial();
		$this->load->view('definicao_actualizacao/benchmark_salarial', $data);
	}
	public function add_benchmark_salarial()
	{
		$this->http_method('POST');

		$data = [
			'setor' => $this->input->post('setor'),
			'nivel_experiencia' => $this->input->post('nivel_experiencia'),
			'media_salarial' => $this->input->post('media_salarial'),
			'data_referencia' => $this->input->post('data_referencia'),
		];

		$this->form_validation->set_rules('setor', _l('setor'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('nivel_experiencia', _l('nivel_experiencia'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('media_salarial', _l('media_salarial'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_referencia', _l('data_referencia'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preencha os campos corretamente");
			redirect('gestao_remuneracao/definicao_benchmark_salarial');
		} else {

			$insert = $this->gestao_remuneracao_model->create_benchmark_salarial($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/definicao_benchmark_salarial');
		}
	}

	public function editar_benchmark_salarial()
	{
		$this->form_validation->set_rules('setor', 'setor', 'required');
		$this->form_validation->set_rules('nivel_experiencia', 'nivel_experiencia', 'required');
		$this->form_validation->set_rules('media_salarial', 'media_salarial', 'required');
		$this->form_validation->set_rules('data_referencia', 'data_referencia', 'required');

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$variavel_id = $this->input->post('id');

		$data = [
			'setor' => $this->input->post('setor') ?? '',
			'nivel_experiencia' => $this->input->post('nivel_experiencia'),
			'media_salarial' => $this->input->post('media_salarial'),
			'data_referencia' => $this->input->post('data_referencia'),
		];

		$this->db->where('id', $variavel_id);
		$this->db->update('gr_benchmark_salarial', $data);

		set_alert('success', 'Atualizado com sucesso.');
		redirect('gestao_remuneracao/definicao_benchmark_salarial');
	}

	public function delete_benchmark_salarial($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_benchmark_salarial');

		if ($deleted) {
			$this->session->set_flashdata('success', 'deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	#=============================================================================================
	public function definicao_visualizar_faixa($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['faixa_salarial'] = $this->gestao_remuneracao_model->get_faixa_salarial_filter($id);
		$this->load->view('definicao_actualizacao/visualizar_faixa', $data);
	}

	public function definicao_visualizar_benchmark($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['benchmark_salarial'] = $this->gestao_remuneracao_model->get_benchmark_salarial_filter($id);
		$this->load->view('definicao_actualizacao/visualizar_benchmark', $data);
	}

	/********************************************************************************
	 * Telas de Comparação
	 *******************************************************************************/
	public function comparacao()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Definicao');
		$data['faixa_salarial'] = $this->gestao_remuneracao_model->get_faixa_salarial();
		$data['benchmark_salarial'] = $this->gestao_remuneracao_model->get_benchmark_salarial();
		$data['comparacao_salarial'] = $this->gestao_remuneracao_model->get_comparacao_salarial();
		$this->load->view('comparacao/index_comparacao', $data);
	}

	public function add_comparacao_salarial()
	{
		$this->http_method('POST');

		$data = [
			'diferenca_percentual' => $this->input->post('diferenca_percentual'),
			'benchmark_salarial_id' => $this->input->post('benchmark_salarial_id'),
			'faixa_salarial_id' => $this->input->post('faixa_salarial_id'),
		];

		$this->form_validation->set_rules('diferenca_percentual', _l('diferenca_percentual'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('benchmark_salarial_id', _l('benchmark_salarial_id'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('faixa_salarial_id', _l('faixa_salarial_id'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preencha os campos corretamente");
			redirect('gestao_remuneracao/comparacao');
		} else {
			$insert = $this->gestao_remuneracao_model->create_comparacao_salarial($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/comparacao');
		}
	}

	public function editar_comparacao_salarial()
	{
		$this->form_validation->set_rules('diferenca_percentual', 'diferenca_percentual', 'required');
		$this->form_validation->set_rules('benchmark_salarial_id', 'benchmark_salarial_id', 'required');
		$this->form_validation->set_rules('faixa_salarial_id', 'faixa_salarial_id', 'required');

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$variavel_id = $this->input->post('id');

		$data = [
			'diferenca_percentual' => $this->input->post('diferenca_percentual'),
			'benchmark_salarial_id' => $this->input->post('benchmark_salarial_id'),
			'faixa_salarial_id' => $this->input->post('faixa_salarial_id'),
		];

		$this->db->where('id', $variavel_id);
		$this->db->update('gr_comparacao_salarial', $data);

		set_alert('success', 'Atualizado com sucesso.');
		redirect('gestao_remuneracao/comparacao');
	}

	public function delete_comparacao_salarial($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_comparacao_salarial');

		if ($deleted) {
			$this->session->set_flashdata('success', 'deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	#=========================== Relatorio Comparativo =================================
	public function comparacao_relatorio_comparativo()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Relatório Comparativo');
		$data['relatorio_comparativo'] = $this->gestao_remuneracao_model->get_relatorio_comparativo();
		$this->load->view('comparacao/relatorio_comparativo', $data);
	}
	public function add_relatorio_comparativo()
	{
		$this->http_method('POST');

		$data = [
			'descricao' => $this->input->post('descricao') ?? '',
			'data_geracao' => $this->input->post('data_geracao'),
		];

		$this->form_validation->set_rules('data_geracao', _l('data_geracao'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger', "Preencha os campos corretamente");
			redirect('gestao_remuneracao/comparacao_relatorio_comparativo');
		} else {

			$insert = $this->gestao_remuneracao_model->create_relatorio_comparativo($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/comparacao_relatorio_comparativo');
		}
	}

	public function editar_relatorio_comparativo()
	{
		//$this->form_validation->set_rules('periodicidade', 'periodicidade', 'required');
		$this->form_validation->set_rules('data_geracao', 'Data de Geração', 'required');

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$ciclo_reserva_salarial_id = $this->input->post('id');

		$data = [
			'descricao' => $this->input->post('descricao'),
			'data_geracao' => $this->input->post('data_geracao'),
		];

		$this->db->where('id', $ciclo_reserva_salarial_id);
		$this->db->update('gr_relatorio_comparativo', $data);

		set_alert('success', 'Relatorio Corporativo atualizado com sucesso.');
		redirect('gestao_remuneracao/comparacao_relatorio_comparativo');
	}

	public function delete_relatorio_comparativo($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_relatorio_comparativo');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Relatorio Corporativo deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar a Relatorio Corporativo.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	#==================================================================================
	public function comparacao_visualizar_comparacao_salarial($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['comparacao_salarial'] = $this->gestao_remuneracao_model->get_comparacao_salarial_filter($id);
		$this->load->view('comparacao/visualizar_comparacao_salarial', $data);
	}

	public function comparacao_visualizar_relatorio($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['comparativo_relatorio'] = $this->gestao_remuneracao_model->get_comparativo_relatorio_filter($id);
		$this->load->view('comparacao/visualizar_relatorio', $data);
	}


	/********************************************************************************
	 * Telas de Revisão e Ajustes
	 *******************************************************************************/
	public function revisao()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Definicao');
		$data['ciclo_revisao_salarial'] = $this->gestao_remuneracao_model->get_ciclo_revisao_salarial();
		$this->load->view('revisao/index_revisao', $data);
	}

	public function add_ciclo_revisao_salarial()
	{
		$this->http_method('POST');

		$data_inicio = $this->input->post('data_inicio') ?? '';
		$data_fim = $this->input->post('data_fim') ?? '';

		$data = [
			'periodicidade' => $this->input->post('periodicidade') ?? '',
			'data_inicio' => $data_inicio,
			'data_fim' => $data_fim,
		];

		$this->form_validation->set_rules('periodicidade', _l('periodicidade'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_inicio', _l('data_inicio'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_fim', _l('data_fim'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger', "Preencha os campos corretamente");
			redirect('gestao_remuneracao/revisao');
		} else {
			// Verifica se data_inicio é menor que data_fim
			if (strtotime($data_inicio) >= strtotime($data_fim)) {
				set_alert('danger', "A data de início deve ser menor que a data de fim.");
				redirect('gestao_remuneracao/revisao');
			}

			$insert = $this->gestao_remuneracao_model->create_ciclo_revisao_salarial($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/revisao');
		}
	}

	public function editar_ciclo_reserva_salarial()
	{
		$this->form_validation->set_rules('periodicidade', 'periodicidade', 'required');
		$this->form_validation->set_rules('data_inicio', 'Data de Inicio', 'required');
		$this->form_validation->set_rules('data_fim', 'Data de Fim', 'required');

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$ciclo_reserva_salarial_id = $this->input->post('id');

		$data_inicio = $this->input->post('data_inicio') ?? '';
		$data_fim = $this->input->post('data_fim') ?? '';


		$data = [
			'periodicidade' => $this->input->post('periodicidade'),
			'data_inicio' => $this->input->post('data_inicio'),
			'data_fim' => $this->input->post('data_fim'),
		];

		if (strtotime($data_inicio) >= strtotime($data_fim)) {
			set_alert('danger', "A data de início deve ser menor que a data de fim.");
			redirect('gestao_remuneracao/revisao');
		}

		$this->db->where('id', $ciclo_reserva_salarial_id);
		$this->db->update('gr_ciclo_revisao_salarial', $data);

		set_alert('success', 'Ciclo de Resreva Salarial atualizado com sucesso.');
		redirect('gestao_remuneracao/revisao');
	}

	public function delete_ciclo_revisao_salarial($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_ciclo_revisao_salarial');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Ciclo de Revisão Salarial deletada com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar a plano.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	# ============================== Ajuste Salarial ===============================================
	public function revisao_ajuste_salarial()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Ajuste Salarial');
		$data['staff'] = $this->gestao_remuneracao_model->staffs();
		$data['staff_list'] = $this->gestao_remuneracao_model->staffs_admin();
		$data['ajuste_salarial'] = $this->gestao_remuneracao_model->get_ajuste_salarial();
		$this->load->view('revisao/ajuste_salarial', $data);
	}
	public function filtrar_ajuste_salarial()
	{
		$funcionario = $this->input->post('funcionario');
		$status = $this->input->post('status');

		$mentorias = $this->gestao_remuneracao_model->get_filtered_mentorias($funcionario, $status);

		foreach ($mentorias as $mentoria): ?>
			<tr>
				<td><a href="#"><?= htmlspecialchars($mentoria['nome']); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($mentoria['descricao'] ?? 'Sem descrição'); ?></a></td>
				<td><a href="#"><?= date('d/m/Y', strtotime($mentoria['data_seccao'])); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($mentoria['primeiro_nome'] . " " . $mentoria['segundo_nome']); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($mentoria['feedback']); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($mentoria['status_nome']); ?></a></td>
				<td> <a href="#"><?= htmlspecialchars($mentoria['aprovadores_nomes'] ?? 'Nenhum'); ?></a> </td>
				<td>
					<?php if ($mentoria['status_id'] == 1): ?>
						<a href="<?php echo admin_url('gestao_remuneracao/mentoria_aprovar/' . $mentoria['id']); ?>"
							class="btn btn-success" style="color: white;">
							Aprovar
						</a>
						<a onclick="return confirm('Tens certeza que desejas rejeitar?');"
							href="<?php echo admin_url('gestao_remuneracao/mentoria_rejeitar/' . $mentoria['id']); ?>"
							class="text-white btn btn-danger" style="background-color:#FFA500; border-color:#FFA500; color:#fff;">
							Rejeitar
						</a>
					<?php endif ?>
					<a href="#" class="btn btn-success btn-icon">
						<i style="color: white;" class="fa fa-eye"></i>
					</a>
					<a href="#" class="btn btn-default btn-edit-mentoria" data-id="<?= $mentoria['id']; ?>"
						data-nome="<?= htmlspecialchars($mentoria['nome']); ?>"
						data-descricao="<?= htmlspecialchars($mentoria['descricao']); ?>"
						data-data_seccao="<?= $mentoria['data_seccao']; ?>"
						data-feedback="<?= htmlspecialchars($mentoria['feedback']); ?>"
						data-aprovadores="<?= !empty($mentoria['aprovadores']) ? implode(',', json_decode($mentoria['aprovadores'], true)) : ''; ?>"
						data-staff_id="<?= $mentoria['staff_id']; ?>" data-toggle="modal" data-target="#editar">
						<i class="fa fa-edit"></i>
					</a>
					<a onclick="return confirm('Tem certeza que deseja excluir?');"
						href="<?= base_url('gestao_desenv_individual/delete_mentoria/' . $mentoria['id']); ?>"
						class="btn btn-danger btn-icon _delete">
						<i style="color: white;" class="fa fa-trash"></i>
					</a>
				</td>
			</tr>
		<?php endforeach;
	}
	public function add_ajuste_salarial()
	{
		$this->http_method('POST');

		$data = [
			'percentual_aumento' => $this->input->post('percentual_aumento') ?? '',
			'motivo' => $this->input->post('motivo') ?? '',
			'status_id' => 1,
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
			'staff_id' => $this->input->post('funcionario') ?? '',
		];
		$this->form_validation->set_rules('percentual_aumento', _l('percentual_aumento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('motivo', _l('motivo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_remuneracao/revisao_ajuste_salarial');
		} else {
			$insert = $this->gestao_remuneracao_model->create_ajuste_Salarial($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/revisao_ajuste_salarial');
		}
	}

	public function aprovar_ajuste_salarial($id)
	{
		$vf = $this->gestao_remuneracao_model->first_ajuste_salarial($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger', "Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_remuneracao/revisao_ajuste_salarial');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger', "Erro, tente novamente.");
			return redirect('gestao_remuneracao/revisao_ajuste_salarial');
		}
		$this->gestao_remuneracao_model->ajuste_salarial_update(['status_id' => 2], $id);
		set_alert('success', "Aprovado com sucesso.");
		return redirect('gestao_remuneracao/revisao_ajuste_salarial');
	}
	public function rejeitar_ajuste_salarial($id)
	{
		$vf = $this->gestao_remuneracao_model->first_ajuste_salarial($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger', "Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_remuneracao/revisao_ajuste_salarial');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger', "Erro, tente novamente.");
			return redirect('gestao_remuneracao/revisao_ajuste_salarial');
		}
		$this->gestao_remuneracao_model->ajuste_salarial_update(['status_id' => 3], $id);
		set_alert('success', "Rejeitado com sucesso.");
		return redirect('gestao_remuneracao/revisao_ajuste_salarial');
	}

	public function editar_ajuste_salarial()
	{
		$this->form_validation->set_rules('percentual_aumento', 'percentual_aumento', 'required');
		$this->form_validation->set_rules('motivo', 'motivo', 'required');
		$this->form_validation->set_rules('aprovadores[]', 'Aprovadores', 'required');
		$this->form_validation->set_rules('funcionario[]', 'funcionario', 'required');

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$mentoria_id = $this->input->post('id');


		$data = [
			'percentual_aumento' => $this->input->post('percentual_aumento'),
			'motivo' => $this->input->post('motivo'),
			'staff_id' => $this->input->post('funcionario'),
			'aprovadores' => json_encode($this->input->post('aprovadores')) ?? '[]',

		];

		$this->db->where('id', $mentoria_id);
		$this->db->update('gr_ajuste_salarial', $data);

		set_alert('success', 'Ajuste Salarial atualizada com sucesso.');
		redirect('gestao_remuneracao/revisao_ajuste_salarial');
	}
	public function delete_ajuste_salarial($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_ajuste_salarial');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Ajuste Salarial deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar a Ajuste Salarial.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	#===========================================================================================
	public function revisao_visualizar_ciclo($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['ciclo_revisao'] = $this->gestao_remuneracao_model->get_ciclo_revisao_salarial_filter($id);
		$this->load->view('revisao/visualizar_ciclo', $data);
	}

	public function revisao_visualizar_ajuste($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['revisao_ajuste'] = $this->gestao_remuneracao_model->get_ajuste_salarial_filter($id);
		$this->load->view('revisao/visualizar_ajuste', $data);
	}

	/********************************************************************************
	 * Telas de Gerenciamento de Pacotes
	 *******************************************************************************/

	#============================Pacote Beneficio ============================
	public function gerenciamento()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Definicao');
		$data['staff_list'] = $this->gestao_remuneracao_model->staffs_admin();
		$data['pacote_beneficio'] = $this->gestao_remuneracao_model->get_pacote_beneficio();
		$this->load->view('gerenciamento/index_gerenciamento', $data);
	}
	public function filtrar_pacote_beneficio()
	{
		$funcionario = $this->input->post('funcionario');
		$status = $this->input->post('status');

		$mentorias = $this->gestao_remuneracao_model->get_filtered_pacote_beneficios($funcionario, $status);

		foreach ($mentorias as $mentoria): ?>
			<tr>
				<td><a href="#"><?= htmlspecialchars($mentoria['nome']); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($mentoria['descricao'] ?? 'Sem descrição'); ?></a></td>
				<td><a href="#"><?= date('d/m/Y', strtotime($mentoria['data_seccao'])); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($mentoria['primeiro_nome'] . " " . $mentoria['segundo_nome']); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($mentoria['feedback']); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($mentoria['status_nome']); ?></a></td>
				<td> <a href="#"><?= htmlspecialchars($mentoria['aprovadores_nomes'] ?? 'Nenhum'); ?></a> </td>
				<td>
					<?php if ($mentoria['status_id'] == 1): ?>
						<a href="<?php echo admin_url('gestao_remuneracao/mentoria_aprovar/' . $mentoria['id']); ?>"
							class="btn btn-success" style="color: white;">
							Aprovar
						</a>
						<a onclick="return confirm('Tens certeza que desejas rejeitar?');"
							href="<?php echo admin_url('gestao_remuneracao/mentoria_rejeitar/' . $mentoria['id']); ?>"
							class="text-white btn btn-danger" style="background-color:#FFA500; border-color:#FFA500; color:#fff;">
							Rejeitar
						</a>
					<?php endif ?>
					<a href="#" class="btn btn-success btn-icon">
						<i style="color: white;" class="fa fa-eye"></i>
					</a>
					<a href="#" class="btn btn-default btn-edit-mentoria" data-id="<?= $mentoria['id']; ?>"
						data-nome="<?= htmlspecialchars($mentoria['nome']); ?>"
						data-descricao="<?= htmlspecialchars($mentoria['descricao']); ?>"
						data-data_seccao="<?= $mentoria['data_seccao']; ?>"
						data-feedback="<?= htmlspecialchars($mentoria['feedback']); ?>"
						data-aprovadores="<?= !empty($mentoria['aprovadores']) ? implode(',', json_decode($mentoria['aprovadores'], true)) : ''; ?>"
						data-staff_id="<?= $mentoria['staff_id']; ?>" data-toggle="modal" data-target="#editar">
						<i class="fa fa-edit"></i>
					</a>
					<a onclick="return confirm('Tem certeza que deseja excluir?');"
						href="<?= base_url('gestao_desenv_individual/delete_mentoria/' . $mentoria['id']); ?>"
						class="btn btn-danger btn-icon _delete">
						<i style="color: white;" class="fa fa-trash"></i>
					</a>
				</td>
			</tr>
		<?php endforeach;
	}
	public function add_pacote_beneficio()
	{
		$this->http_method('POST');

		$data = [
			'descricao' => $this->input->post('descricao') ?? '',
			'elegibilidade' => $this->input->post('elegibilidade'),
			'status_id' => 1,
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
		];
		$this->form_validation->set_rules('elegibilidade', _l('elegibilidade'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_remuneracao/gerenciamento');
		} else {
			$insert = $this->gestao_remuneracao_model->create_pacote_beneficio($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/gerenciamento');
		}
	}

	public function aprovar_pacote_beneficio($id)
	{
		$vf = $this->gestao_remuneracao_model->first_pacote_beneficio($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger', "Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_remuneracao/gerenciamento');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger', "Erro, tente novamente.");
			return redirect('gestao_remuneracao/gerenciamento');
		}
		$this->gestao_remuneracao_model->pacote_beneficio_update(['status_id' => 2], $id);
		set_alert('success', "Aprovado com sucesso.");
		return redirect('gestao_remuneracao/gerenciamento');
	}
	public function rejeitar_pacote_beneficio($id)
	{
		$vf = $this->gestao_remuneracao_model->first_pacote_beneficio($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger', "Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_remuneracao/gerenciamento');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger', "Erro, tente novamente.");
			return redirect('gestao_remuneracao/gerenciamento');
		}
		$this->gestao_remuneracao_model->pacote_beneficio_update(['status_id' => 3], $id);
		set_alert('success', "Rejeitado com sucesso.");
		return redirect('gestao_remuneracao/gerenciamento');
	}

	public function editar_pacote_beneficio()
	{
		$this->form_validation->set_rules('descricao', 'descricao', 'required');
		$this->form_validation->set_rules('elegibilidade', 'elegibilidade', 'required');
		$this->form_validation->set_rules('aprovadores[]', 'Aprovadores', 'required');

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$pacote_beneficio_id = $this->input->post('id');


		$data = [
			'descricao' => $this->input->post('descricao'),
			'elegibilidade' => $this->input->post('elegibilidade'),
			'aprovadores' => json_encode($this->input->post('aprovadores')) ?? '[]',

		];

		$this->db->where('id', $pacote_beneficio_id);
		$this->db->update('gr_pacote_beneficio', $data);

		set_alert('success', 'Ajuste Salarial atualizada com sucesso.');
		redirect('gestao_remuneracao/gerenciamento');
	}
	public function delete_pacote_beneficio($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_pacote_beneficio');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Ajuste Salarial deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar a Ajuste Salarial.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}
	#================================ Beneficio Funcionario ===================================================
	public function gerenciamento_beneficio_funcionario()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Benefício do Funcionário');
		$data['staff'] = $this->gestao_remuneracao_model->staffs();
		$data['pacote_beneficio'] = $this->gestao_remuneracao_model->get_pacote_beneficio();
		$data['beneficio_funcionario'] = $this->gestao_remuneracao_model->get_beneficio_funcionario();
		$this->load->view('gerenciamento/beneficio_funcionario', $data);
	}
	public function add_beneficio_funcionario()
	{
		$this->http_method('POST');
		$data_inicio = $this->input->post('data_inicio') ?? '';
		$data_fim = $this->input->post('data_fim') ?? '';

		$data = [
			'data_inicio' => $this->input->post('data_inicio') ?? '',
			'data_fim' => $this->input->post('data_fim'),
			'staff_id' => $this->input->post('funcionario'),
			'beneficio_id' => $this->input->post('beneficio_id'),
		];
		$this->form_validation->set_rules('data_inicio', _l('data_inicio'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_fim', _l('data_fim'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('beneficio_id', _l('beneficio_id'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_remuneracao/gerenciamento_beneficio_funcionario');
		} else {
			// Verifica se data_inicio é menor que data_fim
			if (strtotime($data_inicio) >= strtotime($data_fim)) {
				set_alert('danger', "A data de início deve ser menor que a data de fim.");
				redirect('gestao_remuneracao/gerenciamento_beneficio_funcionario');
			}

			$insert = $this->gestao_remuneracao_model->create_beneficio_funcionario($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/gerenciamento_beneficio_funcionario');
		}
	}
	public function editar_beneficio_funcionario()
	{
		$this->form_validation->set_rules('data_inicio', 'data_inicio', 'required');
		$this->form_validation->set_rules('data_fim', 'data_fim', 'required');
		$this->form_validation->set_rules('beneficio_id', 'beneficio_id', 'required');
		$this->form_validation->set_rules('funcionario[]', 'funcionario', 'required');

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$pacote_beneficio_id = $this->input->post('id');

		$data = [
			'data_inicio' => $this->input->post('data_inicio'),
			'data_fim' => $this->input->post('data_fim'),
			'beneficio_id' => $this->input->post('beneficio_id'),
			'staff_id' => $this->input->post('funcionario'),

		];

		$this->db->where('id', $pacote_beneficio_id);
		$this->db->update('gr_beneficio_funcionario', $data);

		set_alert('success', 'Beneficio Funciionario atualizada com sucesso.');
		redirect('gestao_remuneracao/gerenciamento_beneficio_funcionario');
	}
	public function delete_beneficio_funcionario($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_beneficio_funcionario');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Ajuste Salarial deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar a Ajuste Salarial.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}
	#=====================================================================================
	public function gerenciamento_visualizar_pacote($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['pacote'] = $this->gestao_remuneracao_model->get_pacote($id);
		$this->load->view('gerenciamento/visualizar_pacote', $data);
	}
	#=======================================================================================
	public function gerenciamento_visualizar_beneficio_funcionario($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['beneficio_f'] = $this->gestao_remuneracao_model->get_beneficio_funcionario_filter($id);
		$this->load->view('gerenciamento/visualizar_beneficio_funcionario', $data);
	}


	/********************************************************************************
	 * Telas de Inscrição e Gestão
	 *******************************************************************************/
	# ============================== Inscrição =======================================
	public function inscricao()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Definicao');
		$data['staff'] = $this->gestao_remuneracao_model->staffs();
		$data['staff_list'] = $this->gestao_remuneracao_model->staffs_admin();
		$data['pacote_beneficio'] = $this->gestao_remuneracao_model->get_pacote_beneficio();
		$data['solicitacao_beneficio'] = $this->gestao_remuneracao_model->get_solicitacao_beneficio();
		$this->load->view('inscricao/index_inscricao', $data);
	}
	public function add_solicitacao_beneficio()
	{
		$this->http_method('POST');

		$data = [
			'data_solicitacao' => $this->input->post('data_solicitacao') ?? '',
			'beneficio_id' => $this->input->post('beneficio_id'),
			'staff_id' => $this->input->post('funcionario'),
			'status_id' => 1,
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
		];
		$this->form_validation->set_rules('data_solicitacao', _l('data_solicitacao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('beneficio_id', _l('beneficio_id'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_remuneracao/inscricao');
		} else {
			$insert = $this->gestao_remuneracao_model->create_solicitacao_beneficio($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/inscricao');
		}
	}

	public function aprovar_solicitacao_beneficio($id)
	{
		$vf = $this->gestao_remuneracao_model->first_solicitacao_beneficio($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger', "Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_remuneracao/inscricao');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger', "Erro, tente novamente.");
			return redirect('gestao_remuneracao/inscricao');
		}
		$this->gestao_remuneracao_model->solicitacao_beneficio_update(['status_id' => 2], $id);
		set_alert('success', "Aprovado com sucesso.");
		return redirect('gestao_remuneracao/inscricao');
	}
	public function rejeitar_solicitacao_beneficio($id)
	{
		$vf = $this->gestao_remuneracao_model->first_solicitacao_beneficio($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger', "Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_remuneracao/inscricao');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger', "Erro, tente novamente.");
			return redirect('gestao_remuneracao/inscricao');
		}
		$this->gestao_remuneracao_model->solicitacao_beneficio_update(['status_id' => 3], $id);
		set_alert('success', "Rejeitado com sucesso.");
		return redirect('gestao_remuneracao/inscricao');
	}

	public function editar_solicitacao_beneficio()
	{
		$this->form_validation->set_rules('data_solicitacao', 'data_solicitacao', 'required');
		$this->form_validation->set_rules('beneficio_id', 'beneficio_id', 'required');
		$this->form_validation->set_rules('funcionario[]', 'funcionario', 'required');
		$this->form_validation->set_rules('aprovadores[]', 'Aprovadores', 'required');

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$pacote_beneficio_id = $this->input->post('id');

		$data = [
			'data_solicitacao' => $this->input->post('data_solicitacao'),
			'beneficio_id' => $this->input->post('beneficio_id'),
			'staff_id' => $this->input->post('funcionario'),
			'aprovadores' => json_encode($this->input->post('aprovadores')) ?? '[]',
		];

		$this->db->where('id', $pacote_beneficio_id);
		$this->db->update('gr_solicitacao_beneficio', $data);

		set_alert('success', 'Ajuste Salarial atualizada com sucesso.');
		redirect('gestao_remuneracao/inscricao');
	}
	public function delete_solicitacao_beneficio($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_solicitacao_beneficio');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Ajuste Salarial deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar a Ajuste Salarial.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}
	#=============================== Alteracao de Beneficio ================================
	public function inscricao_alteracao_beneficio()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Alteração de Benefício');
		$data['staff'] = $this->gestao_remuneracao_model->staffs();
		$data['pacote_beneficio'] = $this->gestao_remuneracao_model->get_pacote_beneficio();
		$data['alterar_beneficio'] = $this->gestao_remuneracao_model->get_alterar_beneficio();
		$this->load->view('inscricao/alteracao_beneficio', $data);
	}
	public function add_alterar_beneficio()
	{
		$this->http_method('POST');

		$data = [
			'descricao' => $this->input->post('descricao'),
			'staff_id' => $this->input->post('funcionario'),
			'beneficio_id' => $this->input->post('beneficio_id'),
		];
		$this->form_validation->set_rules('beneficio_id', _l('beneficio_id'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_remuneracao/inscricao_alteracao_beneficio');
		} else {
			// Verifica se data_inicio é menor que data_fim
			$insert = $this->gestao_remuneracao_model->create_alterar_beneficio($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/inscricao_alteracao_beneficio');
		}
	}
	public function editar_alterar_beneficio()
	{
		$this->form_validation->set_rules('beneficio_id', 'beneficio_id', 'required');
		$this->form_validation->set_rules('funcionario[]', 'funcionario', 'required');

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$pacote_beneficio_id = $this->input->post('id');

		$data = [
			'descricao' => $this->input->post('descricao'),
			'beneficio_id' => $this->input->post('beneficio_id'),
			'staff_id' => $this->input->post('funcionario'),

		];

		$this->db->where('id', $pacote_beneficio_id);
		$this->db->update('gr_alterar_beneficio', $data);

		set_alert('success', 'Beneficio Funciionario atualizada com sucesso.');
		redirect('gestao_remuneracao/inscricao_alteracao_beneficio');
	}
	public function delete_alterar_beneficio($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_alterar_beneficio');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Ajuste Salarial deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar a Ajuste Salarial.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}
	#=======================================================================================
	public function inscricao_visualizar_solicitacao($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['inscricao'] = $this->gestao_remuneracao_model->get_solicitacao_beneficio_filter($id);
		$this->load->view('inscricao/visualizar_solicitacao', $data);
	}

	public function inscricao_visualizar_alteracao($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['alteracao'] = $this->gestao_remuneracao_model->get_alterar_beneficio_filter($id);
		$this->load->view('inscricao/visualizar_alteracao', $data);
	}

	/********************************************************************************
	 * Telas de Cálculo
	 *******************************************************************************/
	public function calculo()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Definicao');
		$data['staff'] = $this->gestao_remuneracao_model->staffs();
		$data['faixa_salarial'] = $this->gestao_remuneracao_model->get_faixa_salarial();
		$data['calculo_salario'] = $this->gestao_remuneracao_model->get_calculo_salario();
		$this->load->view('calculo/index_calculo', $data);
	}

	public function add_calculo_salario()
	{
		$this->http_method('POST');

		$data = [
			'bonus' => $this->input->post('bonus'),
			'descontos' => $this->input->post('descontos'),
			'salario_final' => $this->input->post('salario_final'),
			'staff_id' => $this->input->post('funcionario'),
			'faixa_salarial_id' => $this->input->post('faixa_salarial_id'),
		];

		$this->form_validation->set_rules('bonus', _l('bonus'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descontos', _l('descontos'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('salario_final', _l('salario_final'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario[]'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('faixa_salarial_id', _l('faixa_salarial_id'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preencha os campos corretamente");
			redirect('gestao_remuneracao/calculo');
		} else {
			$insert = $this->gestao_remuneracao_model->create_calculo_salario($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/calculo');
		}
	}

	public function editar_calculo_salario()
	{
		$this->form_validation->set_rules('bonus', _l('bonus'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('descontos', _l('descontos'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('salario_final', _l('salario_final'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario[]'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('faixa_salarial_id', _l('faixa_salarial_id'), 'required', ['required' => 'Preencha o campo {field}']);

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$variavel_id = $this->input->post('id');

		$data = [
			'bonus' => $this->input->post('bonus'),
			'descontos' => $this->input->post('descontos'),
			'salario_final' => $this->input->post('salario_final'),
			'staff_id' => $this->input->post('funcionario'),
			'faixa_salarial_id' => $this->input->post('faixa_salarial_id'),
		];

		$this->db->where('id', $variavel_id);
		$this->db->update('gr_calculo_salario', $data);

		set_alert('success', 'Atualizado com sucesso.');
		redirect('gestao_remuneracao/calculo');
	}

	public function delete_calculo_salario($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_calculo_salario');

		if ($deleted) {
			$this->session->set_flashdata('success', 'deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	#===========================================================================
	public function calculo_formula_calculo()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Fórmula do Cálculo');
		$data['formula_calculo'] = $this->gestao_remuneracao_model->get_formula_calculo();
		$this->load->view('calculo/formula_calculo', $data);
	}

	public function add_formula_calculo()
	{
		$this->http_method('POST');

		$data = [
			'descricao' => $this->input->post('descricao'),
			'regra' => $this->input->post('regra'),
			'data_atualizacao' => $this->input->post('data_atualizacao'),
		];

		$this->form_validation->set_rules('regra', _l('regra'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_atualizacao', _l('data_atualizacao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preencha os campos corretamente");
			redirect('gestao_remuneracao/calculo_formula_calculo');
		} else {

			$insert = $this->gestao_remuneracao_model->create_formula_calculo($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/calculo_formula_calculo');
		}
	}

	public function editar_formula_calculo()
	{
		$this->form_validation->set_rules('regra', 'regra', 'required');
		$this->form_validation->set_rules('data_atualizacao', 'data_atualizacao', 'required');

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$variavel_id = $this->input->post('id');

		$data = [
			'descricao' => $this->input->post('descricao'),
			'regra' => $this->input->post('regra'),
			'data_atualizacao' => $this->input->post('data_atualizacao'),
		];

		$this->db->where('id', $variavel_id);
		$this->db->update('gr_formula_calculo', $data);

		set_alert('success', 'Atualizado com sucesso.');
		redirect('gestao_remuneracao/calculo_formula_calculo');
	}

	public function delete_formula_calculo($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_formula_calculo');

		if ($deleted) {
			$this->session->set_flashdata('success', 'deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}
	#=====================================================================================
	public function calculo_visualizar_calculo_salario($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['calculo_salario'] = $this->gestao_remuneracao_model->get_calculo_salario_filter($id);
		$this->load->view('calculo/visualizar_calculo_salario', $data);
	}

	public function calculo_visualizar_formula_salario($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['calculo_formula'] = $this->gestao_remuneracao_model->get_formula_calculo_filter($id);
		$this->load->view('calculo/visualizar_formula_salario', $data);
	}

	/********************************************************************************
	 * Telas de Integração 
	 *******************************************************************************/
	public function integracao()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Definicao');
		$data['staff'] = $this->gestao_remuneracao_model->staffs();
		$data['staff_list'] = $this->gestao_remuneracao_model->staffs_admin();
		$data['bancos'] = $this->gestao_remuneracao_model->get_banco();
		$data['processamento_pagamento'] = $this->gestao_remuneracao_model->get_processamento_pagamento();
		$this->load->view('integracao/index_integracao', $data);
	}
	public function filtrar_processamento_pagamento()
	{
		$funcionario = $this->input->post('funcionario');
		$status = $this->input->post('status');

		$mentorias = $this->gestao_remuneracao_model->get_processamento_pagamento($funcionario, $status);

		foreach ($mentorias as $mentoria): ?>
			<tr>
				<td><a href="#"><?= htmlspecialchars($mentoria['nome']); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($mentoria['descricao'] ?? 'Sem descrição'); ?></a></td>
				<td><a href="#"><?= date('d/m/Y', strtotime($mentoria['data_seccao'])); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($mentoria['primeiro_nome'] . " " . $mentoria['segundo_nome']); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($mentoria['feedback']); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($mentoria['status_nome']); ?></a></td>
				<td> <a href="#"><?= htmlspecialchars($mentoria['aprovadores_nomes'] ?? 'Nenhum'); ?></a> </td>
				<td>
					<?php if ($mentoria['status_id'] == 1): ?>
						<a href="<?php echo admin_url('gestao_remuneracao/mentoria_aprovar/' . $mentoria['id']); ?>"
							class="btn btn-success" style="color: white;">
							Aprovar
						</a>
						<a onclick="return confirm('Tens certeza que desejas rejeitar?');"
							href="<?php echo admin_url('gestao_remuneracao/mentoria_rejeitar/' . $mentoria['id']); ?>"
							class="text-white btn btn-danger" style="background-color:#FFA500; border-color:#FFA500; color:#fff;">
							Rejeitar
						</a>
					<?php endif ?>
					<a href="#" class="btn btn-success btn-icon">
						<i style="color: white;" class="fa fa-eye"></i>
					</a>
					<a href="#" class="btn btn-default btn-edit-mentoria" data-id="<?= $mentoria['id']; ?>"
						data-nome="<?= htmlspecialchars($mentoria['nome']); ?>"
						data-descricao="<?= htmlspecialchars($mentoria['descricao']); ?>"
						data-data_seccao="<?= $mentoria['data_seccao']; ?>"
						data-feedback="<?= htmlspecialchars($mentoria['feedback']); ?>"
						data-aprovadores="<?= !empty($mentoria['aprovadores']) ? implode(',', json_decode($mentoria['aprovadores'], true)) : ''; ?>"
						data-staff_id="<?= $mentoria['staff_id']; ?>" data-toggle="modal" data-target="#editar">
						<i class="fa fa-edit"></i>
					</a>
					<a onclick="return confirm('Tem certeza que deseja excluir?');"
						href="<?= base_url('gestao_desenv_individual/delete_mentoria/' . $mentoria['id']); ?>"
						class="btn btn-danger btn-icon _delete">
						<i style="color: white;" class="fa fa-trash"></i>
					</a>
				</td>
			</tr>
		<?php endforeach;
	}
	public function add_processamento_pagamento()
	{
		$this->http_method('POST');

		$data = [
			'valor' => $this->input->post('valor') ?? '',
			'data_pagamento' => $this->input->post('data_pagamento') ?? '',
			'status_id' => 1,
			'aprovadores' => json_encode($this->input->post('aprovadores[]')),
			'banco_id' => $this->input->post('banco_id'),
			'staff_id' => $this->input->post('funcionario'),
		];
		$this->form_validation->set_rules('valor', _l('valor'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_pagamento', _l('data_pagamento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('banco_id', _l('banco_id'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_remuneracao/integracao');
		} else {
			$insert = $this->gestao_remuneracao_model->create_processamento_pagamento($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/integracao');
		}
	}

	public function aprovar_processamento_pagamento($id)
	{
		$vf = $this->gestao_remuneracao_model->first_processamento_pagamento($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger', "Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_remuneracao/integracao');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger', "Erro, tente novamente.");
			return redirect('gestao_remuneracao/integracao');
		}
		$this->gestao_remuneracao_model->processamento_pagamento_update(['status_id' => 2], $id);
		set_alert('success', "Aprovado com sucesso.");
		return redirect('gestao_remuneracao/integracao');
	}
	public function rejeitar_processamento_pagamento($id)
	{
		$vf = $this->gestao_remuneracao_model->first_processamento_pagamento($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger', "Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_remuneracao/integracao');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger', "Erro, tente novamente.");
			return redirect('gestao_remuneracao/integracao');
		}
		$this->gestao_remuneracao_model->processamento_pagamento_update(['status_id' => 3], $id);
		set_alert('success', "Rejeitado com sucesso.");
		return redirect('gestao_remuneracao/integracao');
	}

	public function editar_processamento_pagamento()
	{
		$this->form_validation->set_rules('valor', _l('valor'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_pagamento', _l('data_pagamento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('banco_id', _l('banco_id'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);
		
		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$id = $this->input->post('id');


		$data = [
			'valor' => $this->input->post('valor'),
			'data_pagamento' => $this->input->post('data_pagamento'),
			'aprovadores' => json_encode($this->input->post('aprovadores[]')),
			'banco_id' => $this->input->post('banco_id'),
			'staff_id' => $this->input->post('funcionario'),
		];

		$this->db->where('id', $id);
		$this->db->update('gr_processamento_pagamento', $data);

		set_alert('success', 'Atualizada com sucesso.');
		redirect('gestao_remuneracao/integracao');
	}
	public function delete_processamento_pagamento($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_processamento_pagamento');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Ajuste Salarial deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar a Ajuste Salarial.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	#====================================================================================
	public function integracao_arquivo()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Arquivo de Pagamento');
		$data['arquivo_pagamento'] = $this->gestao_remuneracao_model->get_arquivo_pagamento();
		$this->load->view('integracao/arquivo', $data);
	}
	public function add_arquivo_pagamento()
	{
		$this->http_method('POST');

		$data = [
			'descricao' => $this->input->post('descricao'),
			'formato' => $this->input->post('formato'),
			'data_exportacao' => $this->input->post('data_exportacao'),
		];

		$this->form_validation->set_rules('formato', _l('formato'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_exportacao', _l('data_exportacao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preencha os campos corretamente");
			redirect('gestao_remuneracao/integracao_arquivo');
		} else {

			$insert = $this->gestao_remuneracao_model->create_arquivo_pagamento($data);
			set_alert('success', "Cadastrado com sucesso!");
			redirect('gestao_remuneracao/integracao_arquivo');
		}
	}

	public function editar_arquivo_pagamento()
	{
		$this->form_validation->set_rules('formato', 'formato', 'required');
		$this->form_validation->set_rules('data_exportacao', 'data_exportacao', 'required');

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$variavel_id = $this->input->post('id');

		$data = [
			'descricao' => $this->input->post('descricao'),
			'formato' => $this->input->post('formato'),
			'data_exportacao' => $this->input->post('data_exportacao'),
		];

		$this->db->where('id', $variavel_id);
		$this->db->update('gr_arquivo_pagamento', $data);

		set_alert('success', 'Atualizado com sucesso.');
		redirect('gestao_remuneracao/integracao_arquivo');
	}

	public function delete_arquivo_pagamento($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_arquivo_pagamento');

		if ($deleted) {
			$this->session->set_flashdata('success', 'deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}
	#====================================================================================
	public function integracao_arquivo_visualizar_processamento($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['pagamento'] = $this->gestao_remuneracao_model->first_processamento_pagamento($id);
		$this->load->view('integracao/visualizar_processamento', $data);
	}

	public function integracao_visualizar_arquivo($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['arquivo'] = $this->gestao_remuneracao_model->get_arquivo_pagamento_filter($id);
		$this->load->view('integracao/visualizar_arquivo', $data);
	}


	/********************************************************************************
	 * Telas de Regulamentações 
	 *******************************************************************************/
	public function regulamentacoes()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Definicao');
		$data['regulacao_fiscal'] = $this->gestao_remuneracao_model->get_regulacao_fiscal();
		$this->load->view('regulamentacoes/index_regulamentacoes', $data);
	}
	public function add_regulacao_fiscal()
	{
		$this->http_method('POST');

		$data = [
			'descricao' => $this->input->post('descricao'),
			'legislacao_aplicavel' => $this->input->post('legislacao_aplicavel'),
			'data_atualizacao' => $this->input->post('data_atualizacao'),
		];

		$this->form_validation->set_rules('legislacao_aplicavel', _l('legislacao_aplicavel'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_atualizacao', _l('data_atualizacao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preencha os campos corretamente");
			redirect('gestao_remuneracao/regulamentacoes');
		} else {

			$insert = $this->gestao_remuneracao_model->create_regulacao_fiscal($data);
			set_alert('success', "Cadastrado com sucesso!");
			redirect('gestao_remuneracao/regulamentacoes');
		}
	}

	public function editar_regulacao_fiscal()
	{
		$this->form_validation->set_rules('legislacao_aplicavel', _l('legislacao_aplicavel'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_atualizacao', _l('data_atualizacao'), 'required', ['required' => 'Preencha o campo {field}']);
		
		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$variavel_id = $this->input->post('id');

		$data = [
			'descricao' => $this->input->post('descricao'),
			'legislacao_aplicavel' => $this->input->post('legislacao_aplicavel'),
			'data_atualizacao' => $this->input->post('data_atualizacao'),
		];

		$this->db->where('id', $variavel_id);
		$this->db->update('gr_regulacao_fiscal', $data);

		set_alert('success', 'Atualizado com sucesso.');
		redirect('gestao_remuneracao/regulamentacoes');
	}

	public function delete_regulacao_fiscal($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_regulacao_fiscal');

		if ($deleted) {
			$this->session->set_flashdata('success', 'deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

#=========================================================================================

	public function regulamentacoes_documento_auditoria()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Documento de Auditoria');
		$data['staff_list'] = $this->gestao_remuneracao_model->staffs_admin();
		$data['documento_auditoria'] = $this->gestao_remuneracao_model->get_documento_auditoria();
		$this->load->view('regulamentacoes/documento_auditoria', $data);
	}
	public function filtrar_documento_auditoria()
	{
		$funcionario = $this->input->post('funcionario');
		$status = $this->input->post('status');

		$mentorias = $this->gestao_remuneracao_model->get_filtered_documento_auditoria($funcionario, $status);

		foreach ($mentorias as $mentoria): ?>
			<tr>
				<td><a href="#"><?= htmlspecialchars($mentoria['nome']); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($mentoria['descricao'] ?? 'Sem descrição'); ?></a></td>
				<td><a href="#"><?= date('d/m/Y', strtotime($mentoria['data_seccao'])); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($mentoria['primeiro_nome'] . " " . $mentoria['segundo_nome']); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($mentoria['feedback']); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($mentoria['status_nome']); ?></a></td>
				<td> <a href="#"><?= htmlspecialchars($mentoria['aprovadores_nomes'] ?? 'Nenhum'); ?></a> </td>
				<td>
					<?php if ($mentoria['status_id'] == 1): ?>
						<a href="<?php echo admin_url('gestao_remuneracao/mentoria_aprovar/' . $mentoria['id']); ?>"
							class="btn btn-success" style="color: white;">
							Aprovar
						</a>
						<a onclick="return confirm('Tens certeza que desejas rejeitar?');"
							href="<?php echo admin_url('gestao_remuneracao/mentoria_rejeitar/' . $mentoria['id']); ?>"
							class="text-white btn btn-danger" style="background-color:#FFA500; border-color:#FFA500; color:#fff;">
							Rejeitar
						</a>
					<?php endif ?>
					<a href="#" class="btn btn-success btn-icon">
						<i style="color: white;" class="fa fa-eye"></i>
					</a>
					<a href="#" class="btn btn-default btn-edit-mentoria" data-id="<?= $mentoria['id']; ?>"
						data-nome="<?= htmlspecialchars($mentoria['nome']); ?>"
						data-descricao="<?= htmlspecialchars($mentoria['descricao']); ?>"
						data-data_seccao="<?= $mentoria['data_seccao']; ?>"
						data-feedback="<?= htmlspecialchars($mentoria['feedback']); ?>"
						data-aprovadores="<?= !empty($mentoria['aprovadores']) ? implode(',', json_decode($mentoria['aprovadores'], true)) : ''; ?>"
						data-staff_id="<?= $mentoria['staff_id']; ?>" data-toggle="modal" data-target="#editar">
						<i class="fa fa-edit"></i>
					</a>
					<a onclick="return confirm('Tem certeza que deseja excluir?');"
						href="<?= base_url('gestao_desenv_individual/delete_mentoria/' . $mentoria['id']); ?>"
						class="btn btn-danger btn-icon _delete">
						<i style="color: white;" class="fa fa-trash"></i>
					</a>
				</td>
			</tr>
		<?php endforeach;
	}
	public function add_documento_auditoria()
	{
		$this->http_method('POST');

		$data = [
			'tipo_documento' => $this->input->post('tipo_documento'),
			'data_geracao' => $this->input->post('data_geracao'),
			'status_id' => 1,
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
		];
		$this->form_validation->set_rules('tipo_documento', _l('tipo_documento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_geracao', _l('data_geracao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_remuneracao/regulamentacoes_documento_auditoria');
		} else {
			$insert = $this->gestao_remuneracao_model->create_documento_auditoria($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/regulamentacoes_documento_auditoria');
		}
	}

	public function aprovar_documento_auditoria($id)
	{
		$vf = $this->gestao_remuneracao_model->first_documento_auditoria($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger', "Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_remuneracao/regulamentacoes_documento_auditoria');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger', "Erro, tente novamente.");
			return redirect('gestao_remuneracao/regulamentacoes_documento_auditoria');
		}
		$this->gestao_remuneracao_model->documento_auditoria_update(['status_id' => 2], $id);
		set_alert('success', "Aprovado com sucesso.");
		return redirect('gestao_remuneracao/regulamentacoes_documento_auditoria');
	}
	public function rejeitar_documento_auditoria($id)
	{
		$vf = $this->gestao_remuneracao_model->first_documento_auditoria($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger', "Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_remuneracao/regulamentacoes_documento_auditoria');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger', "Erro, tente novamente.");
			return redirect('gestao_remuneracao/regulamentacoes_documento_auditoria');
		}
		$this->gestao_remuneracao_model->documento_auditoria_update(['status_id' => 3], $id);
		set_alert('success', "Rejeitado com sucesso.");
		return redirect('gestao_remuneracao/regulamentacoes_documento_auditoria');
	}

	public function editar_documento_auditoria()
	{
		$this->form_validation->set_rules('tipo_documento', _l('tipo_documento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_geracao', _l('data_geracao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		
		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$mentoria_id = $this->input->post('id');

		$data = [
			'tipo_documento' => $this->input->post('tipo_documento'),
			'data_geracao' => $this->input->post('data_geracao'),
			'status_id' => 1,
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
		];

		$this->db->where('id', $mentoria_id);
		$this->db->update('gr_documento_auditoria', $data);

		set_alert('success', 'Ajuste Salarial atualizada com sucesso.');
		redirect('gestao_remuneracao/regulamentacoes_documento_auditoria');
	}
	public function delete_documento_auditoria($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_documento_auditoria');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

#==========================================================================================

	public function regulamentacoes_visualizar_regulacao($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['fiscal'] = $this->gestao_remuneracao_model->get_regulacao_fiscal_filter($id);
		$this->load->view('regulamentacoes/visualizar_regulacao', $data);
	}

	public function regulamentacoes_visualizar_ducumento($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['documento'] = $this->gestao_remuneracao_model->first_documento_auditoria($id);
		$this->load->view('regulamentacoes/visualizar_ducumento', $data);
	}

	/********************************************************************************
	 * Telas de Processamentos
	 *******************************************************************************/
	public function processamentos()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Definicao');
		$data['staff'] = $this->gestao_remuneracao_model->staffs();
		$data['vencimento_funcionario'] = $this->gestao_remuneracao_model->get_vencimento_funcionario();
		$this->load->view('processamentos/index_processamentos', $data);
	}

	public function add_vencimento_funcionario()
	{
		$this->http_method('POST');

		$data = [
			'salario_base' => $this->input->post('salario_base'),
			'bonus' => $this->input->post('bonus'),
			'salario_liquido' => $this->input->post('salario_liquido'),
			'beneficios' => $this->input->post('beneficios'),
			'staff_id' => $this->input->post('funcionario'),
		];
		$this->form_validation->set_rules('salario_base', _l('salario_base'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('bonus', _l('bonus'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('salario_liquido', _l('salario_liquido'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('beneficios', _l('beneficios'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_remuneracao/processamentos');
		} else {
			$insert = $this->gestao_remuneracao_model->create_vencimento_funcionario($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/processamentos');
		}
	}
	public function editar_vencimento_funcionario()
	{
		$this->form_validation->set_rules('salario_base', _l('salario_base'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('bonus', _l('bonus'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('salario_liquido', _l('salario_liquido'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('beneficios', _l('beneficios'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);
		
		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}
		$id = $this->input->post('id');
		$data = [
			'salario_base' => $this->input->post('salario_base'),
			'bonus' => $this->input->post('bonus'),
			'salario_liquido' => $this->input->post('salario_liquido'),
			'beneficios' => $this->input->post('beneficios'),
			'staff_id' => $this->input->post('funcionario'),
		];

		$this->db->where('id', $id);
		$this->db->update('gr_vencimento_funcionario', $data);

		set_alert('success', 'Atualizada com sucesso.');
		redirect('gestao_remuneracao/processamentos');
	}
	public function delete_vencimento_funcionario($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_vencimento_funcionario');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

#==========================================================================================
	public function processamentos_subsidio_ferias()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Subsídio de Férias');
		$data['staff'] = $this->gestao_remuneracao_model->staffs();
		$data['subsidio_ferias'] = $this->gestao_remuneracao_model->get_subsidio_ferias();
		$this->load->view('processamentos/subsidio_ferias', $data);
	}
	public function add_subsidio_ferias()
	{
		$this->http_method('POST');

		$data = [
			'valor' => $this->input->post('valor'),
			'data_pagamento' => $this->input->post('data_pagamento'),
			'staff_id' => $this->input->post('funcionario'),
		];
		$this->form_validation->set_rules('valor', _l('valor'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_pagamento', _l('data_pagamento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_remuneracao/processamentos_subsidio_ferias');
		} else {
			$insert = $this->gestao_remuneracao_model->create_subsidio_ferias($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/processamentos_subsidio_ferias');
		}
	}
	public function editar_subsidio_ferias()
	{
		$this->form_validation->set_rules('valor', _l('valor'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_pagamento', _l('data_pagamento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);
		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}
		$id = $this->input->post('id');
		$data = [
			'valor' => $this->input->post('valor'),
			'data_pagamento' => $this->input->post('data_pagamento'),
			'staff_id' => $this->input->post('funcionario'),
		];

		$this->db->where('id', $id);
		$this->db->update('gr_subsidio_ferias', $data);

		set_alert('success', 'Atualizada com sucesso.');
		redirect('gestao_remuneracao/processamentos_subsidio_ferias');
	}
	public function delete_subsidio_ferias($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_subsidio_ferias');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
#====================================================================================
	public function processamentos_subsidio_natal()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Subsídio de Natal');
		$data['staff'] = $this->gestao_remuneracao_model->staffs();
		$data['subsidio_natal'] = $this->gestao_remuneracao_model->get_subsidio_natal();
		$this->load->view('processamentos/subsidio_natal', $data);
	}
	public function add_subsidio_natal()
	{
		$this->http_method('POST');

		$data = [
			'valor' => $this->input->post('valor'),
			'data_pagamento' => $this->input->post('data_pagamento'),
			'staff_id' => $this->input->post('funcionario'),
		];
		$this->form_validation->set_rules('valor', _l('valor'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_pagamento', _l('data_pagamento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_remuneracao/processamentos_subsidio_natal');
		} else {
			$insert = $this->gestao_remuneracao_model->create_subsidio_natal($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/processamentos_subsidio_natal');
		}
	}
	public function editar_subsidio_natal()
	{
		$this->form_validation->set_rules('valor', _l('valor'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_pagamento', _l('data_pagamento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);
		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}
		$id = $this->input->post('id');
		$data = [
			'valor' => $this->input->post('valor'),
			'data_pagamento' => $this->input->post('data_pagamento'),
			'staff_id' => $this->input->post('funcionario'),
		];

		$this->db->where('id', $id);
		$this->db->update('gr_subsidio_natal', $data);

		set_alert('success', 'Atualizada com sucesso.');
		redirect('gestao_remuneracao/processamentos_subsidio_natal');
	}
	public function delete_subsidio_natal($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_subsidio_natal');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
#=====================================================================================
	public function processamentos_rescisao_contrato()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Rescisão de Contrato');
		$data['staff'] = $this->gestao_remuneracao_model->staffs();
		$data['rescisao_contrato'] = $this->gestao_remuneracao_model->get_rescisao_contrato();
		$this->load->view('processamentos/rescisao_contrato', $data);
	}

	public function add_rescisao_contrato()
	{
		$this->http_method('POST');

		$data = [
			'indiminizacao' => $this->input->post('indiminizacao'),
			'ferias_vencidas' => $this->input->post('ferias_vencidas'),
			'total_pago' => $this->input->post('total_pago'),
			'staff_id' => $this->input->post('funcionario'),
		];
		$this->form_validation->set_rules('indiminizacao', _l('indiminizacao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('ferias_vencidas', _l('ferias_vencidas'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('total_pago', _l('total_pago'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_remuneracao/processamentos_rescisao_contrato');
		} else {
			$insert = $this->gestao_remuneracao_model->create_rescisao_contrato($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/processamentos_rescisao_contrato');
		}
	}
	public function editar_rescisao_contrato()
	{
		$this->form_validation->set_rules('indiminizacao', _l('indiminizacao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('ferias_vencidas', _l('ferias_vencidas'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('total_pago', _l('total_pago'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionario[]', _l('funcionario'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);
		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}
		$id = $this->input->post('id');
		$data = [
			'indiminizacao' => $this->input->post('indiminizacao'),
			'ferias_vencidas' => $this->input->post('ferias_vencidas'),
			'total_pago' => $this->input->post('total_pago'),
			'staff_id' => $this->input->post('funcionario'),
		];

		$this->db->where('id', $id);
		$this->db->update('gr_rescisao_contrato', $data);

		set_alert('success', 'Atualizada com sucesso.');
		redirect('gestao_remuneracao/processamentos_rescisao_contrato');
	}
	public function delete_rescisao_contrato($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_rescisao_contrato');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
#=======================================================================================
	public function processamentos_visualizar_vencimento($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['vencimento'] =  $this->gestao_remuneracao_model->get_vencimento_funcionario_filter($id);
		$this->load->view('processamentos/visualizar_vencimento', $data);
	}

	public function processamentos_visualizar_subsidio_ferias($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['ferias'] =  $this->gestao_remuneracao_model->get_subsidio_ferias_filter($id);
		$this->load->view('processamentos/visualizar_subsidio_ferias', $data);
	}

	public function processamentos_visualizar_subsidio_natal($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['natal'] =  $this->gestao_remuneracao_model->get_subsidio_natal_filter($id);
		$this->load->view('processamentos/visualizar_subsidio_natal', $data);
	}

	public function processamentos_visualizar_rescisao_contrato($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['contrato'] =  $this->gestao_remuneracao_model->get_rescisao_contrato_filter($id);
		$this->load->view('processamentos/visualizar_rescisao_contrato', $data);
	}


	/********************************************************************************
	 * Telas de Relatórios 
	 *******************************************************************************/
	public function relatorios()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Definicao');
		$data['relatorio_salario'] =  $this->gestao_remuneracao_model->get_relatorio_salario();
		$this->load->view('relatorios/index_relatorios', $data);
	}

	public function add_relatorio_salario()
	{
		$this->http_method('POST');

		$data = [
			'descricao' => $this->input->post('descricao'),
			'data_geracao' => $this->input->post('data_geracao'),
		];
		$this->form_validation->set_rules('data_geracao', _l('data_geracao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_remuneracao/relatorios');
		} else {
			$insert = $this->gestao_remuneracao_model->create_relatorio_salario($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/relatorios');
		}
	}
	public function editar_relatorio_salario()
	{
		$this->form_validation->set_rules('data_geracao', _l('data_geracao'), 'required', ['required' => 'Preencha o campo {field}']);
		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}
		$id = $this->input->post('id');
		$data = [
			'descricao' => $this->input->post('descricao'),
			'data_geracao' => $this->input->post('data_geracao'),
		];

		$this->db->where('id', $id);
		$this->db->update('gr_relatorio_salario', $data);

		set_alert('success', 'Atualizada com sucesso.');
		redirect('gestao_remuneracao/relatorios');
	}
	public function delete_relatorio_salario($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_relatorio_salario');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
#==========================================================================================
	public function relatorios_analise_custo()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Análise de Custo');
		$data['departamentos'] =$this->gestao_remuneracao_model->get_departamento();
		$data['analise_custo'] = $this->gestao_remuneracao_model->get_analise_custo();
		$this->load->view('relatorios/analise_custo', $data);
	}
	public function add_analise_custo()
	{
		$this->http_method('POST');

		$data = [
			'custo_total' => $this->input->post('custo_total'),
			'data_referencia' => $this->input->post('data_referencia'),
			'departamento_id' => $this->input->post('departamento_id'),
		];
		$this->form_validation->set_rules('custo_total', _l('custo_total'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_referencia', _l('data_referencia'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('departamento_id', _l('departamento_id'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_remuneracao/relatorios_analise_custo');
		} else {
			$insert = $this->gestao_remuneracao_model->create_analise_custo($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/relatorios_analise_custo');
		}
	}
	public function editar_analise_custo()
	{
		$this->form_validation->set_rules('custo_total', _l('custo_total'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_referencia', _l('data_referencia'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('departamento_id', _l('departamento_id'), 'required', ['required' => 'Preencha o campo {field}']);
		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}
		$id = $this->input->post('id');
		$data = [
			'custo_total' => $this->input->post('custo_total'),
			'data_referencia' => $this->input->post('data_referencia'),
			'departamento_id' => $this->input->post('departamento_id'),
		];

		$this->db->where('id', $id);
		$this->db->update('gr_analise_custo', $data);

		set_alert('success', 'Atualizada com sucesso.');
		redirect('gestao_remuneracao/relatorios_analise_custo');
	}
	public function delete_analise_custo($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_analise_custo');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
#=====================================================================================

	public function relatorios_relatorio_equidade()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Relatório de Equidade Salarial');
		$data['relatorio_equidade_salarial'] =  $this->gestao_remuneracao_model->get_relatorio_equidade_salarial();
		$this->load->view('relatorios/relatorio_equidade', $data);
	}

	public function add_relatorio_equidade_salarial()
	{
		$this->http_method('POST');

		$data = [
			'analise_genero' => $this->input->post('analise_genero'),
			'analise_idade' => $this->input->post('analise_idade'),
			'disparidade_identificada' => $this->input->post('disparidade_identificada'),
		];
		$this->form_validation->set_rules('analise_genero', _l('analise_genero'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('analise_idade', _l('analise_idade'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('disparidade_identificada', _l('disparidade_identificada'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_remuneracao/relatorios_relatorio_equidade');
		} else {
			$insert = $this->gestao_remuneracao_model->create_relatorio_equidade_salarial($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/relatorios_relatorio_equidade');
		}
	}
	public function editar_relatorio_equidade_salarial()
	{
		$this->form_validation->set_rules('analise_genero', _l('analise_genero'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('analise_idade', _l('analise_idade'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('disparidade_identificada', _l('disparidade_identificada'), 'required', ['required' => 'Preencha o campo {field}']);
		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}
		$id = $this->input->post('id');
		$data = [
			'analise_genero' => $this->input->post('analise_genero'),
			'analise_idade' => $this->input->post('analise_idade'),
			'disparidade_identificada' => $this->input->post('disparidade_identificada'),
		];

		$this->db->where('id', $id);
		$this->db->update('gr_relatorio_equidade_salarial', $data);

		set_alert('success', 'Atualizada com sucesso.');
		redirect('gestao_remuneracao/relatorios_relatorio_equidade');
	}
	public function delete_relatorio_equidade_salarial($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_relatorio_equidade_salarial');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

#==================================================================================

	public function relatorios_relatorio_previsao()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Relatórioo de Previsão');
		$data['relatorio_previsao'] = $this->gestao_remuneracao_model->get_relatorio_previsao();
		$this->load->view('relatorios/relatorio_previsao', $data);
	}
	public function add_relatorio_previsao()
	{
		$this->http_method('POST');

		$data = [
			'descricao' => $this->input->post('descricao'),
			'impacto_financeiro' => $this->input->post('impacto_financeiro'),
			'data_geracao' => $this->input->post('data_geracao'),
		];
		$this->form_validation->set_rules('impacto_financeiro', _l('impacto_financeiro'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_geracao', _l('data_geracao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_remuneracao/relatorios_relatorio_previsao');
		} else {
			$insert = $this->gestao_remuneracao_model->create_relatorio_previsao($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/relatorios_relatorio_previsao');
		}
	}
	public function editar_relatorio_previsao()
	{
		$this->form_validation->set_rules('impacto_financeiro', _l('impacto_financeiro'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_geracao', _l('data_geracao'), 'required', ['required' => 'Preencha o campo {field}']);
		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}
		$id = $this->input->post('id');
		$data = [
			'descricao' => $this->input->post('descricao'),
			'impacto_financeiro' => $this->input->post('impacto_financeiro'),
			'data_geracao' => $this->input->post('data_geracao'),
		];

		$this->db->where('id', $id);
		$this->db->update('gr_relatorio_previsao', $data);

		set_alert('success', 'Atualizada com sucesso.');
		redirect('gestao_remuneracao/relatorios_relatorio_previsao');
	}
	public function delete_relatorio_previsao($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_relatorio_previsao');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

#=====================================================================================
	public function relatorios_mapa_inss()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Mapa INSS');
		$data['mapa_inss'] = $this->gestao_remuneracao_model->get_mapa_inss();
		$this->load->view('relatorios/mapa_inss', $data);
	}
	public function add_mapa_inss()
	{
		$this->http_method('POST');

		$data = [
			'descricao' => $this->input->post('descricao'),
			'data_envio' => $this->input->post('data_envio'),
		];
		$this->form_validation->set_rules('data_envio', _l('data_envio'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_remuneracao/relatorios_mapa_inss');
		} else {
			$insert = $this->gestao_remuneracao_model->create_mapa_inss($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/relatorios_mapa_inss');
		}
	}
	public function editar_mapa_inss()
	{
		$this->form_validation->set_rules('data_envio', _l('data_envio'), 'required', ['required' => 'Preencha o campo {field}']);
		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}
		$id = $this->input->post('id');
		$data = [
			'descricao' => $this->input->post('descricao'),
			'data_envio' => $this->input->post('data_envio'),
		];

		$this->db->where('id', $id);
		$this->db->update('gr_mapa_inss', $data);

		set_alert('success', 'Atualizada com sucesso.');
		redirect('gestao_remuneracao/relatorios_mapa_inss');
	}
	public function delete_mapa_inss($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_mapa_inss');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

#=======================================================================================
	public function relatorios_mapa_irt()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Mapa IRT');
		$data['mapa_irt'] =  $this->gestao_remuneracao_model->get_mapa_irt();
		$this->load->view('relatorios/mapa_irt', $data);
	}

	public function add_mapa_irt()
	{
		$this->http_method('POST');

		$data = [
			'descricao' => $this->input->post('descricao'),
			'data_envio' => $this->input->post('data_envio'),
		];
		$this->form_validation->set_rules('data_envio', _l('data_envio'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_remuneracao/relatorios_mapa_irt');
		} else {
			$insert = $this->gestao_remuneracao_model->create_mapa_irt($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/relatorios_mapa_irt');
		}
	}
	public function editar_mapa_irt()
	{
		$this->form_validation->set_rules('data_envio', _l('data_envio'), 'required', ['required' => 'Preencha o campo {field}']);
		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}
		$id = $this->input->post('id');
		$data = [
			'descricao' => $this->input->post('descricao'),
			'data_envio' => $this->input->post('data_envio'),
		];

		$this->db->where('id', $id);
		$this->db->update('gr_mapa_irt', $data);

		set_alert('success', 'Atualizada com sucesso.');
		redirect('gestao_remuneracao/relatorios_mapa_irt');
	}
	public function delete_mapa_irt($id)
	{
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}

		$this->db->where('id', $id);
		$deleted = $this->db->delete('gr_mapa_irt');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Deletado com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar.');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
#=====================================================================================
	public function relatorios_visualizar_relatorio_salario($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['relatorio'] = $this->gestao_remuneracao_model->get_relatorio_salario_filter($id);
		$this->load->view('relatorios/visualizar_relatorio_salario', $data);
	}

	public function relatorios_visualizar_analise_custo($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['custo'] = $this->gestao_remuneracao_model->get_analise_custo_filter($id);
		$this->load->view('relatorios/visualizar_analise_custo', $data);
	}

	public function relatorios_visualizar_relatorio_equidade($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['equidade'] = $this->gestao_remuneracao_model->get_relatorio_equidade_salarial_filter($id);
		$this->load->view('relatorios/visualizar_relatorio_equidade', $data);
	}

	public function relatorios_visualizar_relatorio_previsao($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['previsao'] = $this->gestao_remuneracao_model->get_relatorio_previsao_filter($id);
		$this->load->view('relatorios/visualizar_relatorio_previsao', $data);
	}

	public function relatorios_visualizar_mapa_inss($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['inss'] = $this->gestao_remuneracao_model->get_mapa_inss_filter($id);
		$this->load->view('relatorios/visualizar_mapa_inss', $data);
	}

	public function relatorios_visualizar_mapa_irt($id)
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}
		$data['title'] = _l('Visualizar');
		$data['irt'] = $this->gestao_remuneracao_model->get_mapa_irt_filter($id);
		$this->load->view('relatorios/visualizar_mapa_irt', $data);
	}

	public function configuracoes()
	{
		if (!has_permission('gestao_remuneracao', '', 'edit') && !is_admin()) {
			access_denied('gestao_remuneracao');
		}

		$data['title'] = _l('configuracoes');
		$data['group'] = $this->input->get('group');
		$data['tab'][] = 'status';
		$data['tab'][] = 'banco';
		$data['tab'][] = 'tipo_categoria';

		if ($data['group'] == '') {
			$data['title'] = _l('status');
			$data['group'] = 'status';
			$data['group'] = 'tipo_categoria';
			$data['status'] = $this->gestao_remuneracao_model->get_status();
		} elseif ($data['group'] == 'status') {
			$data['title'] = _l('status');
			$data['status'] = $this->gestao_remuneracao_model->get_status();
		} elseif ($data['group'] == 'tipo_categoria') {
			$data['title'] = _l('tipo_categoria');
			$data['tipo_categoria'] = $this->gestao_remuneracao_model->get_tipo_categoria();
		} elseif ($data['group'] == 'banco') {
			$data['title'] = _l('banco');
			$data['banco'] = $this->gestao_remuneracao_model->get_banco();
		} else {
			set_alert('danger', "Configuração não encontrada");
			redirect('gestao_remuneracao/configuracoes?group=status');
		}

		$data['tabs']['view'] = 'includes/' . $data['group'];
		$this->load->view('configuracoes/index', $data);
	}

	#======================== Tipo de Avaliação ========================================
	public function add_tipo_categoria()
	{
		$this->http_method('POST');

		$data = [
			'nome' => $this->input->post('tipo_categoria') ?? '',
			'descricao' => $this->input->post('descricao') ?? '',
		];
		$this->form_validation->set_rules('tipo_categoria', _l('tipo_categoria'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_remuneracao/configuracoes?group=tipo_categoria');
		} else {
			$insert = $this->gestao_remuneracao_model->create_tipo_categoria($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/configuracoes?group=tipo_categoria');
		}
	}

	public function editar_tipo_categoria($id)
	{
		$this->http_method('POST');
		$this->gestao_remuneracao_model->first_tipo_categoria($id);

		$data = [
			'nome' => $this->input->post('e_tipo_categoria') ?? '',
			'descricao' => $this->input->post('e_descricao') ?? '',
		];
		$this->form_validation->set_rules('e_tipo_categoria', _l('tipo_categoria'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_remuneracao/configuracoes?group=tipo_categoria');
		} else {
			$this->gestao_remuneracao_model->update_tipo_categoria($data, $id);
			set_alert('success', "Actualizado com sucesso");
			redirect('gestao_remuneracao/configuracoes?group=tipo_categoria');
		}
	}
	public function delete_tipo_categoria($id)
	{
		/* $relacionamento = $this->gestao_remuneracao_model->verificar_relacionamento_tipo_categoria($id);
							 
							 if($relacionamento){
								 set_alert('danger', "Não podes eliminar esses dados a um relacionamento!");
								 return redirect('gestao_remuneracao/configuracoes?group=tipo_categoria');
							 } */
		$this->gestao_remuneracao_model->first_tipo_categoria($id);
		$this->gestao_remuneracao_model->delete_tipo_categoria($id);
		set_alert('success', "Eliminado com sucesso");
		redirect('gestao_remuneracao/configuracoes?group=tipo_categoria');
	}
	#=========================== Banco ==========================
	public function add_banco()
	{
		$this->http_method('POST');

		$data = [
			'nome' => $this->input->post('banco') ?? '',
			'descricao' => $this->input->post('descricao') ?? '',
		];
		$this->form_validation->set_rules('banco', _l('banco'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_remuneracao/configuracoes?group=banco');
		} else {
			$insert = $this->gestao_remuneracao_model->create_banco($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_remuneracao/configuracoes?group=banco');
		}
	}

	public function editar_banco($id)
	{
		$this->http_method('POST');
		$this->gestao_remuneracao_model->first_banco($id);

		$data = [
			'nome' => $this->input->post('e_banco') ?? '',
			'descricao' => $this->input->post('e_descricao') ?? '',
		];
		$this->form_validation->set_rules('e_banco', _l('banco'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_remuneracao/configuracoes?group=banco');
		} else {
			$this->gestao_remuneracao_model->update_banco($data, $id);
			set_alert('success', "Actualizado com sucesso");
			redirect('gestao_remuneracao/configuracoes?group=banco');
		}
	}
	public function delete_banco($id)
	{
		/* $relacionamento = $this->gestao_remuneracao_model->verificar_relacionamento_tipo_categoria($id);
							 
							 if($relacionamento){
								 set_alert('danger', "Não podes eliminar esses dados a um relacionamento!");
								 return redirect('gestao_remuneracao/configuracoes?group=tipo_categoria');
							 } */
		$this->gestao_remuneracao_model->first_banco($id);
		$this->gestao_remuneracao_model->delete_banco($id);
		set_alert('success', "Eliminado com sucesso");
		redirect('gestao_remuneracao/configuracoes?group=banco');
	}
}