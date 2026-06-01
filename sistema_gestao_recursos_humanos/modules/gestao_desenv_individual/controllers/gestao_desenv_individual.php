<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Recruitment Controller
 */
class Gestao_desenv_individual extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Gestao_desenvolvimento_individual_model');
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
	/**
	 * Tela de Dashboard
	 */
	public function dashboard()
	{
		if (!has_permission('gestao_desenv_individual', '', 'edit') && !is_admin()) {
			access_denied('gestao_desenv_individual');
		}
		$data['title'] = _l('Dashboard');
		$data['avaliacao'] = $this->Gestao_desenvolvimento_individual_model->contar_avaliacao();
		$data['mentoria'] = $this->Gestao_desenvolvimento_individual_model->contar_mentoria();
		$data['plano'] = $this->Gestao_desenvolvimento_individual_model->contar_plano();
		$data['carreira'] = $this->Gestao_desenvolvimento_individual_model->contar_carreira();
		$data['contar_avaliacao'] = $this->Gestao_desenvolvimento_individual_model->contar_dados();
		$data['contar_mentoria'] = $this->Gestao_desenvolvimento_individual_model->contar_mentoria_dados();
		$data['contar_planos'] = $this->Gestao_desenvolvimento_individual_model->contar_plano_dados();
		$data['plano_sugerido_dados'] = $this->Gestao_desenvolvimento_individual_model->plano_sugerido_dados();
		$this->load->view('dashboard/index', $data);
	}

	/**
	 * ======================== Tela de planos ==============================================
	 * ======================================================================================
	 * ======================================================================================
	 */
	public function planos()
	{
		if (!has_permission('gestao_desenv_individual', '', 'edit') && !is_admin()) {
			access_denied('gestao_desenv_individual');
		}
		$data['title'] = _l('planos');
		$data['staff_list'] = $this->Gestao_desenvolvimento_individual_model->staffs_admin();
		$data['mentoria'] = $this->Gestao_desenvolvimento_individual_model->get_mentoria();
		$data['avaliacoes'] = $this->Gestao_desenvolvimento_individual_model->get_avaliacao();
		$data['plano'] = $this->Gestao_desenvolvimento_individual_model->get_plano();
		$data['status'] = $this->Gestao_desenvolvimento_individual_model->get_status();
		$this->load->view('planos/index', $data);
	}

	public function filtrar_planos()
	{
		$avaliacao = $this->input->post('avaliacao');
		$status = $this->input->post('status');

		$planos = $this->Gestao_desenvolvimento_individual_model->get_filtered_planos($avaliacao, $status);

		foreach ($planos as $plano): ?>
			<tr>
				<td><a href="#"><?= htmlspecialchars($plano['meta']); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($plano['descricao'] ?? 'Sem descrição'); ?></a></td>
				<td><a href="#"><?= date('d/m/Y', strtotime($plano['prazo'])); ?></a></td>
				<td><a href="#"><?= date('d/m/Y', strtotime($plano['data_fim'])); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($plano['pontuacao_recomendado']); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($plano['status_nome']); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($plano['mentoria_nome']); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($plano['avaliacao_nome']); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($plano['aprovadores_nomes'] ?? 'Nenhum'); ?></a></td>
				<td>
					<?php if ($plano['status_id'] == 1): ?>
						<a href="<?php echo admin_url('gestao_desenv_individual/plano_aprovar/' . $plano['id']); ?>"
							class="btn btn-success" style="color: white;">
							Aprovar
						</a>
						<a onclick="return confirm('Tens certeza que desejas rejeitar?');"
							href="<?php echo admin_url('gestao_desenv_individual/plano_rejeitar/' . $plano['id']); ?>"
							class="text-white btn btn-danger" style="background-color:#FFA500; border-color:#FFA500; color:#fff;">
							Rejeitar
						</a>
					<?php endif ?>
					<a href="#" class="btn btn-success btn-icon">
						<i style="color: white;" class="fa fa-eye"></i>
					</a>
					<a href="#" class="btn btn-default btn-edit-plano" data-id="<?= $plano['id']; ?>"
						data-meta="<?= htmlspecialchars($plano['meta']); ?>"
						data-descricao="<?= htmlspecialchars($plano['descricao']); ?>" data-prazo="<?= $plano['prazo']; ?>"
						data-data_fim="<?= $plano['data_fim']; ?>"
						data-pontuacao_recomendado="<?= $plano['pontuacao_recomendado']; ?>"
						data-mentoria_id="<?= $plano['mentoria_id']; ?>"
						data-aprovadores="<?= !empty($plano['aprovadores']) ? implode(',', json_decode($plano['aprovadores'], true)) : ''; ?>"
						data-avaliacao_id="<?= $plano['avaliacao_id']; ?>" data-toggle="modal" data-target="#editar">
						<i class="fa fa-edit"></i>
					</a>
					<a onclick="return confirm('Tem certeza que deseja excluir?');"
						href="<?= base_url('gestao_desenv_individual/delete_plano/' . $plano['id']); ?>"
						class="btn btn-danger btn-icon _delete">
						<i style="color: white;" class="fa fa-trash"></i>
					</a>
				</td>
			</tr>
		<?php endforeach;
	}

	public function add_plano()
	{
		$this->http_method('POST');

		$data = [
			'meta' => $this->input->post('meta') ?? '',
			'descricao' => $this->input->post('descricao') ?? '',
			'prazo' => $this->input->post('prazo') ?? '',
			'data_fim' => $this->input->post('data_fim') ?? '',
			'pontuacao_recomendado' => $this->input->post('pontuacao_recomendado') ?? '',
			'mentoria_id' => $this->input->post('mentoria_id') ?? '',
			'avaliacao_id' => $this->input->post('avaliacao_id') ?? '',
			'status_id' => 1,
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
		];
		$this->form_validation->set_rules('meta', _l('meta'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('prazo', _l('prazo'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('pontuacao_recomendado', _l('pontuacao_recomendado'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_fim', _l('data_fim'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('mentoria_id', _l('mentoria_id'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);
		$this->form_validation->set_rules('avaliacao_id', _l('avaliacao_id'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_desenv_individual/planos');
		} else {
			$insert = $this->Gestao_desenvolvimento_individual_model->create_plano($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_desenv_individual/planos');
		}
	}



	public function editar_plano()
	{
		$this->form_validation->set_rules('meta', 'meta', 'required');
		$this->form_validation->set_rules('prazo', 'prazo', 'required');
		$this->form_validation->set_rules('data_fim', 'data_fim', 'required');
		$this->form_validation->set_rules('pontuacao_recomendado', 'pontuacao_recomendado', 'required');
		$this->form_validation->set_rules('mentoria_id', 'mentoria_id ', 'required');
		$this->form_validation->set_rules('avaliacao_id', 'avaliacao_id', 'required');
		$this->form_validation->set_rules('aprovadores[]', 'Aprovadores', 'required');

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$plano_id = $this->input->post('id');


		$data = [
			'meta' => $this->input->post('meta'),
			'descricao' => $this->input->post('descricao'),
			'prazo' => $this->input->post('prazo'),
			'data_fim' => $this->input->post('data_fim'),
			'pontuacao_recomendado' => $this->input->post('pontuacao_recomendado'),
			'mentoria_id' => $this->input->post('mentoria_id'),
			'avaliacao_id' => $this->input->post('avaliacao_id'),
			'aprovadores' => json_encode($this->input->post('aprovadores')) ?? '[]',

		];

		$this->db->where('id', $plano_id);
		$this->db->update('gdi_plano_desenvolvimento', $data);

		set_alert('success', 'Plano atualizada com sucesso.');
		redirect('gestao_desenv_individual/planos');
	}
	public function delete_plano($id)
	{
		$relacionamento = $this->Gestao_desenvolvimento_individual_model->verificar_relacionamento_plano($id);

		if ($relacionamento) {
			set_alert('danger', "Não podes eliminar esses dados a um relacionamento!");
			return redirect('gestao_desenv_individual/planos');
		}

		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}


		$this->db->where('id', $id);
		$deleted = $this->db->delete('gdi_plano_desenvolvimento');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Mentoria deletada com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar a plano.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function plano_aprovar($id)
	{
		$vf = $this->Gestao_desenvolvimento_individual_model->plano_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger', "Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_desenv_individual/planos');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger', "Erro, tente novamente.");
			return redirect('gestao_desenv_individual/planos');
		}
		$this->Gestao_desenvolvimento_individual_model->plano_update(['status_id' => 2], $id);
		set_alert('success', "Aprovado com sucesso.");
		return redirect('gestao_desenv_individual/planos');
	}
	public function plano_rejeitar($id)
	{
		$vf = $this->Gestao_desenvolvimento_individual_model->plano_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger', "Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_desenv_individual/planos');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger', "Erro, tente novamente.");
			return redirect('gestao_desenv_individual/planos');
		}
		$this->Gestao_desenvolvimento_individual_model->plano_update(['status_id' => 3], $id);
		set_alert('success', "Rejeitado com sucesso.");
		return redirect('gestao_desenv_individual/planos');
	}


	public function planos_analise_grafica() {
		if (!has_permission('gestao_desenv_individual', '', 'edit') && !is_admin()) {
			access_denied('gestao_desenv_individual');
		}
		$data['title'] = _l('Análise de Grafica');
		$this->load->view('planos/analise_grafica', $data);
	}


	/**
	 * ========================== Tela de avaliacoes ===========================================
	 * =========================================================================================
	 * =========================================================================================
	 * 
	 */

	//Recomendar Planos (Algoritmo)
	public function recomendar_planos()
	{
		if (!has_permission('gestao_desenv_individual', '', 'edit') && !is_admin()) {
			access_denied('gestao_desenv_individual');
		}
		$data['title'] = _l('Sugestões');
		$data['recomendar_plano'] = $this->Gestao_desenvolvimento_individual_model->plano_sugerido();
		$this->load->view('avaliacoes/index_recomendar_planos', $data);
	}

	public function avaliacoes()
	{
		if (!has_permission('gestao_desenv_individual', '', 'edit') && !is_admin()) {
			access_denied('gestao_desenv_individual');
		}
		$data['title'] = _l('avaliacoes');
		$data['staff_list'] = $this->Gestao_desenvolvimento_individual_model->staffs_admin();
		$data['staff'] = $this->Gestao_desenvolvimento_individual_model->staffs();
		$data['tipo_avaliacao'] = $this->Gestao_desenvolvimento_individual_model->get_tipo_avaliacao();
		$data['avaliacoes'] = $this->Gestao_desenvolvimento_individual_model->get_avaliacao();
		$data['status'] = $this->Gestao_desenvolvimento_individual_model->get_status();
		$this->load->view('avaliacoes/index', $data);
	}

	public function filtrar_avaliacao()
	{
		$tipo_avaliacao = $this->input->post('tipo_avaliacaoo');
		$status = $this->input->post('status');

		$avaliacoes = $this->Gestao_desenvolvimento_individual_model->get_filtered_avaliacoes($tipo_avaliacao, $status);

		foreach ($avaliacoes as $avaliacao): ?>
			<tr>
				<td> <a href="#"><?= htmlspecialchars($avaliacao['nome']); ?></a> </td>
				<td> <a href="#"><?= htmlspecialchars($avaliacao['meta']); ?></a> </td>
				<td> <a href="#"><?= htmlspecialchars($avaliacao['descricao'] ?? 'Sem descrição'); ?></a> </td>
				<td> <a href="#"><?= date('d/m/Y', strtotime($avaliacao['data_fim'])); ?></a> </td>
				<td> <a href="#"><?= htmlspecialchars($avaliacao['primeiro_nome'] . " " . $avaliacao['segundo_nome']); ?></a> </td>
				<td> <a href="#"><?= htmlspecialchars($avaliacao['aprovadores_nomes'] ?? 'Nenhum'); ?></a> </td>
				<td> <a href="#"><?= htmlspecialchars($avaliacao['tipo_nome']); ?></a> </td>
				<td> <a href="#"><?= htmlspecialchars($avaliacao['status_nome']); ?></a> </td>
				<td> <a href="#"><?= date('d/m/Y', strtotime($avaliacao['prazo'])); ?></a> </td>
				<td> <a href="#"><?= htmlspecialchars($avaliacao['pontuacao']); ?></a> </td>
				<td>
					<?php if ($avaliacao['status_id'] == 1): ?>
						<a href="<?php echo admin_url('gestao_desenv_individual/avaliacao_aprovar/' . $avaliacao['id']); ?>"
							class="btn btn-success" style="color: white;">
							Aprovar
						</a>
						<a onclick="return confirm('Tens certeza que desejas rejeitar?');"
							href="<?php echo admin_url('gestao_desenv_individual/avaliacao_rejeitar/' . $avaliacao['id']); ?>"
							class="text-white btn btn-danger" style="background-color:#FFA500; border-color:#FFA500; color:#fff;">
							Rejeitar
						</a>
					<?php endif ?>
					<a href="#" class="btn btn-success btn-icon">
						<i style="color: white;" class="fa fa-eye"></i>
					</a>
					<a href="#" class="btn btn-default btn-edit-avaliacao" data-id="<?= $avaliacao['id']; ?>"
						data-nome="<?= $avaliacao['nome']; ?>" data-meta="<?= $avaliacao['meta']; ?>"
						data-descricao="<?= $avaliacao['descricao']; ?>" data-data_fim="<?= $avaliacao['data_fim']; ?>"
						data-prazo="<?= $avaliacao['prazo']; ?>" data-pontuacao="<?= $avaliacao['pontuacao']; ?>"
						data-aprovadores="<?= implode(',', json_decode($avaliacao['aprovadores'], true)); ?>"
						data-tipo_avaliacao="<?= $avaliacao['tipo_avaliacao_id']; ?>" data-staf_id="<?= $avaliacao['staf_id']; ?>"
						data-toggle="modal" data-target="#editar">
						<i class="fa fa-edit"></i>
					</a>
					<a onclick="return confirm('Tem certeza que deseja excluir?');"
						href="<?= base_url('gestao_desenv_individual/delete_avaliacao/' . $avaliacao['id']); ?>"
						class="btn btn-danger btn-icon _delete">
						<i style="color: white;" class="fa fa-trash"></i>
					</a>
				</td>
			</tr>
		<?php endforeach;
	}


	public function add_avaliacao()
	{
		$this->http_method('POST');

		$data = [
			'nome' => $this->input->post('nome') ?? '',
			'meta' => $this->input->post('meta') ?? '',
			'descricao' => $this->input->post('descricao') ?? '',
			'data_fim' => $this->input->post('data_fim') ?? '',
			'prazo' => $this->input->post('prazo') ?? '',
			'pontuacao' => $this->input->post('pontuacao') ?? '',
			'status_id' => 1,
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
			'staf_id' => $this->input->post('funcionário[]') ?? '',
			'tipo_avaliacao_id' => $this->input->post('tipo_avaliacao_id') ?? '',
		];
		$this->form_validation->set_rules('nome', _l('nome'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('meta', _l('meta'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionário[]', _l('funcionário[]'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_fim', _l('data_fim'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('tipo_avaliacao_id', _l('tipo_avaliacao_id'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);
		$this->form_validation->set_rules('prazo', _l('prazo'), 'required', ['required' => 'Preencha o campo {field}']);

		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_desenv_individual/avaliacoes');
		} else {
			$insert = $this->Gestao_desenvolvimento_individual_model->create_avaliacao($data);

			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_desenv_individual/avaliacoes');
		}
	}

	public function delete_avaliacao($id)
	{
		$relacionamento = $this->Gestao_desenvolvimento_individual_model->verificar_relacionamento_avaçiacao($id);

		if ($relacionamento) {
			set_alert('danger', "Não podes eliminar esses dados a um relacionamento!");
			return redirect('gestao_desenv_individual/avaliacoes');
		}
		// Verifica se o ID foi passado
		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']); // Retorna para a página anterior
		}

		// Deleta a avaliação no banco de dados
		$this->db->where('id', $id);
		$deleted = $this->db->delete('gdi_avaliacao');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Avaliação deletada com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar a avaliação.');
		}

		redirect($_SERVER['HTTP_REFERER']); // Retorna para a página anterior
	}

	public function editar_avaliacao()
	{
		$this->form_validation->set_rules('nome', 'Nome', 'required');
		$this->form_validation->set_rules('meta', 'Meta', 'required');
		$this->form_validation->set_rules('descricao', 'Descrição', 'required');
		$this->form_validation->set_rules('data_fim', 'Data de Fim', 'required');
		$this->form_validation->set_rules('tipo_avaliacao_id', 'Tipo de Avaliação', 'required');
		$this->form_validation->set_rules('prazo', 'Prazo', 'required');
		$this->form_validation->set_rules('pontuacao', 'Pontuação', 'required');
		$this->form_validation->set_rules('aprovadores[]', 'Aprovadores', 'required');
		$this->form_validation->set_rules('funcionario[]', 'funcionario', 'required');

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$avaliacao_id = $this->input->post('id');

		// Dados principais da avaliação
		$data = [
			'nome' => $this->input->post('nome'),
			'meta' => $this->input->post('meta'),
			'descricao' => $this->input->post('descricao'),
			'data_fim' => $this->input->post('data_fim'),
			'staf_id' => $this->input->post('funcionario'),
			'tipo_avaliacao_id' => $this->input->post('tipo_avaliacao_id'), // Correção do nome do campo
			'prazo' => $this->input->post('prazo'),
			'pontuacao' => $this->input->post('pontuacao'),
			'aprovadores' => json_encode($this->input->post('aprovadores')) ?? '[]',

		];

		$this->db->where('id', $avaliacao_id);
		$this->db->update('gdi_avaliacao', $data);

		set_alert('success', 'Avaliação atualizada com sucesso.');
		redirect('gestao_desenv_individual/avaliacoes');
	}

	public function avaliacao_aprovar($id)
	{
		$vf = $this->Gestao_desenvolvimento_individual_model->avaliacao_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger', "Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_desenv_individual/avaliacoes');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger', "Erro, tente novamente.");
			return redirect('gestao_desenv_individual/avaliacoes');
		}
		$this->Gestao_desenvolvimento_individual_model->avaliacao_update(['status_id' => 2], $id);
		set_alert('success', "Aprovado com sucesso.");
		return redirect('gestao_desenv_individual/avaliacoes');
	}
	public function avaliacao_rejeitar($id)
	{
		$vf = $this->Gestao_desenvolvimento_individual_model->avaliacao_first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger', "Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_desenv_individual/avaliacoes');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger', "Erro, tente novamente.");
			return redirect('gestao_desenv_individual/avaliacoes');
		}
		$this->Gestao_desenvolvimento_individual_model->avaliacao_update(['status_id' => 3], $id);
		set_alert('success', "Rejeitado com sucesso.");
		return redirect('gestao_desenv_individual/avaliacoes');
	}

	public function aprovar_avaliacao()
	{
		$this->load->library('session');

		$id = $this->input->post('id');
		$user_id = $this->session->userdata('staffid');

		if (!$id) {
			echo json_encode(['error' => 'ID da avaliação não foi informado.']);
			return;
		}

		if (!$user_id) {
			echo json_encode(['error' => 'Usuário não autenticado.']);
			return;
		}

		// Buscar a avaliação no banco
		$avaliacao = $this->db->get_where('gdi_avaliacao', ['id' => $id])->row_array();

		if (!$avaliacao) {
			echo json_encode(['error' => 'Avaliação não encontrada.']);
			return;
		}

		// Verifica se o campo 'aprovadores' é um JSON válido
		$aprovadores = json_decode($avaliacao['aprovadores'], true);
		if (json_last_error() !== JSON_ERROR_NONE) {
			echo json_encode(['error' => 'Erro ao decodificar aprovadores.']);
			return;
		}

		// Verifica se o usuário tem permissão
		if (!is_array($aprovadores) || !in_array($user_id, $aprovadores)) {
			echo json_encode(['error' => 'Você não tem permissão para aprovar esta avaliação.']);
			return;
		}

		// Atualiza o status no banco de dados
		$this->db->where('id', $id);
		$update = $this->db->update('gdi_avaliacao', ['status' => 'Aprovado']);

		if (!$update) {
			echo json_encode(['error' => 'Erro ao atualizar o banco de dados.']);
			return;
		}

		echo json_encode(['success' => 'Avaliação aprovada com sucesso.']);
	}


	public function rejeitar_avaliacao()
	{
		$id = $this->input->post('id');
		$user_id = $this->session->userdata('staffid');

		if (!$id) {
			echo json_encode(['error' => 'ID da avaliação não foi informado.']);
			return;
		}

		if (!$user_id) {
			echo json_encode(['error' => 'Usuário não autenticado.']);
			return;
		}

		$avaliacao = $this->db->get_where('gdi_avaliacao', ['id' => $id])->row_array();

		if (!$avaliacao) {
			echo json_encode(['error' => 'Avaliação não encontrada.']);
			return;
		}

		$aprovadores = json_decode($avaliacao['aprovadores'], true);

		if (!is_array($aprovadores) || !in_array($user_id, $aprovadores)) {
			echo json_encode(['error' => 'Você não tem permissão para rejeitar esta avaliação.']);
			return;
		}

		$this->db->where('id', $id);
		$this->db->update('gdi_avaliacao', ['status' => 'Rejeitado']);

		echo json_encode(['success' => 'Avaliação rejeitada com sucesso.']);
	}



	/**
	 * =============================== Tela Análise de Tendencia ===============================================
	 * =========================================================================================================
	 * =========================================================================================================
	 */
	public function analise()
	{
		if (!has_permission('gestao_desenv_individual', '', 'edit') && !is_admin()) {
			access_denied('gestao_desenv_individual');
		}
		$data['title'] = _l('Analise Desempenho');
		$data['staff'] = $this->Gestao_desenvolvimento_individual_model->staffs();
		$this->load->view('avaliacoes/analise_tendencia', $data);
	}

	public function get_avaliacoes_grafico($funcionario_id = null)
	{
		$this->load->database();
		$this->db->select('gdi_avaliacao.nome, gdi_avaliacao.pontuacao');
		$this->db->from('gdi_avaliacao');

		if ($funcionario_id) {
			$this->db->where('gdi_avaliacao.staf_id', $funcionario_id);
		} else {
			// Buscar as 12 maiores pontuações quando não há filtro por funcionário
			$this->db->order_by('gdi_avaliacao.pontuacao', 'DESC');
			$this->db->limit(12);
		}

		$query = $this->db->get();
		echo json_encode($query->result());
	}



	/**
	 * =================================== Tela de mentoria ===================================================
	 * ========================================================================================================
	 * ========================================================================================================
	 */
	public function mentoria()
	{
		if (!has_permission('gestao_desenv_individual', '', 'edit') && !is_admin()) {
			access_denied('gestao_desenv_individual');
		}
		$data['title'] = _l('mentoria');
		$data['staff_list'] = $this->Gestao_desenvolvimento_individual_model->staffs_admin();
		$data['staff'] = $this->Gestao_desenvolvimento_individual_model->staffs();
		$data['mentoria'] = $this->Gestao_desenvolvimento_individual_model->get_mentoria();
		$data['status'] = $this->Gestao_desenvolvimento_individual_model->get_status();
		$this->load->view('mentoria/index', $data);
	}

	public function filtrar_mentoria()
	{
		$funcionario = $this->input->post('funcionario');
		$status = $this->input->post('status');

		$mentorias = $this->Gestao_desenvolvimento_individual_model->get_filtered_mentorias($funcionario, $status);

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
						<a href="<?php echo admin_url('gestao_desenv_individual/mentoria_aprovar/' . $mentoria['id']); ?>"
							class="btn btn-success" style="color: white;">
							Aprovar
						</a>
						<a onclick="return confirm('Tens certeza que desejas rejeitar?');"
							href="<?php echo admin_url('gestao_desenv_individual/mentoria_rejeitar/' . $mentoria['id']); ?>"
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
	public function add_mentoria()
	{
		$this->http_method('POST');

		$data = [
			'nome' => $this->input->post('nome') ?? '',
			'descricao' => $this->input->post('descricao') ?? '',
			'data_seccao' => $this->input->post('data_seccao') ?? '',
			'feedback' => $this->input->post('feedback') ?? '',
			'status_id' => 1,
			'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
			'staff_id' => $this->input->post('funcionário') ?? '',
		];
		$this->form_validation->set_rules('nome', _l('nome'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_seccao', _l('data_seccao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('feedback', _l('feedback'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('aprovadores[]', _l('aprovadores'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('funcionário', _l('funcionário'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_desenv_individual/mentoria');
		} else {
			$insert = $this->Gestao_desenvolvimento_individual_model->create_mentoria($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_desenv_individual/mentoria');
		}
	}

	public function aprovar_mentoria($id)
	{
		$vf = $this->Gestao_desenvolvimento_individual_model->first_mentoria($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger', "Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_desenv_individual/mentoria');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger', "Erro, tente novamente.");
			return redirect('gestao_desenv_individual/mentoria');
		}
		$this->Gestao_desenvolvimento_individual_model->mentorias_update(['status_id' => 2], $id);
		set_alert('success', "Aprovado com sucesso.");
		return redirect('gestao_desenv_individual/mentoria');
	}
	public function mentoria_rejeitar($id)
	{
		$vf = $this->Gestao_desenvolvimento_individual_model->first_mentoria($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger', "Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_desenv_individual/mentoria');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger', "Erro, tente novamente.");
			return redirect('gestao_desenv_individual/mentoria');
		}
		$this->Gestao_desenvolvimento_individual_model->mentorias_update(['status_id' => 3], $id);
		set_alert('success', "Rejeitado com sucesso.");
		return redirect('gestao_desenv_individual/mentoria');
	}

	public function editar_mentoria()
	{
		$this->form_validation->set_rules('nome', 'Nome', 'required');
		$this->form_validation->set_rules('data_seccao', 'Data de Secção', 'required');
		$this->form_validation->set_rules('feedback', 'Feedback', 'required');
		$this->form_validation->set_rules('aprovadores[]', 'Aprovadores', 'required');
		$this->form_validation->set_rules('funcionario[]', 'funcionario', 'required');

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$mentoria_id = $this->input->post('id');


		$data = [
			'nome' => $this->input->post('nome'),
			'descricao' => $this->input->post('descricao'),
			'data_seccao' => $this->input->post('data_seccao'),
			'staff_id' => $this->input->post('funcionario'),
			'feedback' => $this->input->post('feedback'),
			'aprovadores' => json_encode($this->input->post('aprovadores')) ?? '[]',

		];

		$this->db->where('id', $mentoria_id);
		$this->db->update('gdi_mentoria', $data);

		set_alert('success', 'Mentoria atualizada com sucesso.');
		redirect('gestao_desenv_individual/mentoria');
	}
	public function delete_mentoria($id)
	{
		$relacionamento = $this->Gestao_desenvolvimento_individual_model->verificar_relacionamento_mentoria($id);

		if ($relacionamento) {
			set_alert('danger', "Não podes eliminar esses dados a um relacionamento!");
			return redirect('gestao_desenv_individual/mentoria');
		}

		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}


		$this->db->where('id', $id);
		$deleted = $this->db->delete('gdi_mentoria');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Mentoria deletada com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar a Mentoria.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function mentoria_analise_grafica() {
		if (!has_permission('gestao_desenv_individual', '', 'edit') && !is_admin()) {
			access_denied('gestao_desenv_individual');
		}
		$data['title'] = _l('Análise de Grafica');
		$this->load->view('mentoria/analise_grafica', $data);
	}

	/**
	 * ================================= Tela de carreira ==================================================
	 * =====================================================================================================
	 * =====================================================================================================
	 */
	public function carreira()
	{
		if (!has_permission('gestao_desenv_individual', '', 'edit') && !is_admin()) {
			access_denied('gestao_desenv_individual');
		}
		$data['title'] = _l('carreira');
		$data['plano'] = $this->Gestao_desenvolvimento_individual_model->get_plano();
		$data['habilidade'] = $this->Gestao_desenvolvimento_individual_model->get_tipo_habilidade();
		$data['carreira'] = $this->Gestao_desenvolvimento_individual_model->get_carreira();
		$this->load->view('carreira/index', $data);
	}

	public function filtrar_carreira()
	{


		$plano = $this->input->post('plano');
		$habilidade = $this->input->post('habilidade');

		$carreiras = $this->Gestao_desenvolvimento_individual_model->get_filtered_carreiras($plano, $habilidade);

		foreach ($carreiras as $carreira): ?>
			<tr>
				<td><a href="#"><?= htmlspecialchars($carreira['nome']); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($carreira['descricao'] ?? 'Sem descrição'); ?></a></td>
				<td><a href="#"><?= date('d/m/Y', strtotime($carreira['data_seccao'])); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($carreira['habilidade_nomes'] ?? 'Nenhuma'); ?></a></td>
				<td><a href="#"><?= htmlspecialchars($carreira['plano_meta']); ?></a></td>
				<td>
					<a href="#" class="btn btn-success btn-icon"><i style="color: white;" class="fa fa-eye"></i></a>
					<a href="#" class="btn btn-default btn-edit-carreira" data-id="<?= $carreira['id']; ?>"
						data-nome="<?= $carreira['nome']; ?>" data-descricao="<?= $carreira['descricao']; ?>"
						data-data_seccao="<?= $carreira['data_seccao']; ?>" data-plano_id="<?= $carreira['plano_id']; ?>"
						data-habilidade_id="<?= implode(',', json_decode($carreira['habilidade_id'], true)); ?>" data-toggle="modal"
						data-target="#editar">
						<i class="fa fa-edit"></i>
					</a>

					<a onclick="return confirm('Tem certeza que deseja excluir?');"
						href="<?= base_url('gestao_desenv_individual/delete_carreira/' . $carreira['id']); ?>"
						class="btn btn-danger btn-icon _delete">
						<i style="color: white;" class="fa fa-trash"></i>
					</a>
				</td>
			</tr>
		<?php endforeach;
	}


	public function add_carreira()
	{
		$this->http_method('POST');

		$data = [
			'nome' => $this->input->post('nome') ?? '',
			'descricao' => $this->input->post('descricao') ?? '',
			'data_seccao' => $this->input->post('data_seccao') ?? '',
			'plano_id' => $this->input->post('plano_id') ?? '',
			'habilidade_id' => json_encode($this->input->post('habilidade_id') ?? []),
		];

		$this->form_validation->set_rules('nome', _l('nome'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_seccao', _l('data_seccao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('plano_id', _l('plano_id'), 'required|integer', ['required' => 'Preencha o campo {field}', 'integer' => 'O campo {field} deve ser um número válido']);
		$this->form_validation->set_rules('habilidade_id[]', _l('habilidade_id'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_desenv_individual/carreira');
		} else {
			$insert = $this->Gestao_desenvolvimento_individual_model->create_carreira($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_desenv_individual/carreira');
		}
	}

	public function editar_carreira()
	{
		$this->form_validation->set_rules('nome', 'Nome', 'required');
		$this->form_validation->set_rules('data_seccao', 'Data de Secção', 'required');
		$this->form_validation->set_rules('plano_id', 'plano_id', 'required');
		$this->form_validation->set_rules('habilidade_id[]', 'habilidade_id', 'required');

		if ($this->form_validation->run() == false) {
			set_alert('danger', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}

		$carreira_id = $this->input->post('id');


		$data = [
			'nome' => $this->input->post('nome'),
			'descricao' => $this->input->post('descricao'),
			'data_seccao' => $this->input->post('data_seccao'),
			'habilidade_id' => json_encode($this->input->post('habilidade_id') ?? []),
			'plano_id' => $this->input->post('plano_id'),

		];

		$this->db->where('id', $carreira_id);
		$this->db->update('gdi_carreira', $data);

		set_alert('success', 'Carreira atualizada com sucesso.');
		redirect('gestao_desenv_individual/carreira');
	}
	public function delete_carreira($id)
	{

		if (!$id) {
			$this->session->set_flashdata('error', 'ID inválido.');
			redirect($_SERVER['HTTP_REFERER']);
		}


		$this->db->where('id', $id);
		$deleted = $this->db->delete('gdi_carreira');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Carreira deletada com sucesso.');
		} else {
			$this->session->set_flashdata('error', 'Erro ao deletar a Carreira.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}


	public function carreira_analise_grafica() {
		if (!has_permission('gestao_desenv_individual', '', 'edit') && !is_admin()) {
			access_denied('gestao_desenv_individual');
		}
		$data['title'] = _l('Análise de Grafica');
		$this->load->view('carreira/analise_grafica', $data);
	}

	#===================== Telas de visualizações =====================================
	public function visualizar_avaliacao_one($id)
	{
		if (!has_permission('gestao_desenv_individual', '', 'edit') && !is_admin()) {
			access_denied('gestao_desenv_individual');
		}
		$data['title'] = _l('Visualizar');
		$data['avaliacao'] = $this->Gestao_desenvolvimento_individual_model->avaliacao_first($id);
		$this->load->view('avaliacoes/visualizar_avaliacao', $data);
	} 

	public function visualizar_plano_one($id)
	{
		if (!has_permission('gestao_desenv_individual', '', 'edit') && !is_admin()) {
			access_denied('gestao_desenv_individual');
		}
		$data['title'] = _l('Visualizar');
		$data['plano'] = $this->Gestao_desenvolvimento_individual_model->plano_first($id);
		$this->load->view('planos/visualizar_plano', $data);
	} 

	public function visualizar_mentoria_one($id)
	{
		if (!has_permission('gestao_desenv_individual', '', 'edit') && !is_admin()) {
			access_denied('gestao_desenv_individual');
		}
		$data['title'] = _l('Visualizar');
		$data['mentoria'] = $this->Gestao_desenvolvimento_individual_model->first_mentoria($id);
		$this->load->view('mentoria/visualizar_mentoria', $data);
	} 

	public function visualizar_carreira_one($id)
	{
		if (!has_permission('gestao_desenv_individual', '', 'edit') && !is_admin()) {
			access_denied('gestao_desenv_individual');
		}
		$data['title'] = _l('Visualizar');
		$data['carreira'] = $this->Gestao_desenvolvimento_individual_model->carreira_first($id);
		$this->load->view('carreira/visualizar_carreira', $data);
	} 


	/**
	 * Tela de configuracoes
	 */
	public function configuracoes()
	{
		if (!has_permission('gestao_desenv_individual', '', 'edit') && !is_admin()) {
			access_denied('gestao_desenv_individual');
		}

		$data['title'] = _l('configuracoes');
		$data['group'] = $this->input->get('group');
		$data['tab'][] = 'status';
		$data['tab'][] = 'tipo_avaliacao';
		$data['tab'][] = 'tipo_habilidade';

		if ($data['group'] == '') {
			$data['title'] = _l('status');
			$data['group'] = 'status';
			$data['status'] = $this->Gestao_desenvolvimento_individual_model->get_status();
		} elseif ($data['group'] == 'status') {
			$data['title'] = _l('status');
			$data['status'] = $this->Gestao_desenvolvimento_individual_model->get_status();
		} elseif ($data['group'] == 'tipo_avaliacao') {
			$data['title'] = _l('tipo_avaliacao');
			$data['tipo_avaliacao'] = $this->Gestao_desenvolvimento_individual_model->get_tipo_avaliacao();
		} elseif ($data['group'] == 'tipo_habilidade') {
			$data['title'] = _l('tipo_habilidade');
			$data['tipo_habilidade'] = $this->Gestao_desenvolvimento_individual_model->get_tipo_habilidade();
		} else {
			set_alert('danger', "Configuração não encontrada");
			redirect('gestao_desenv_individual/configuracoes?group=status');
		}

		$data['tabs']['view'] = 'includes/' . $data['group'];
		$this->load->view('configuracoes/index', $data);
	}

	#======================== Tipo de Avaliação ========================================
	public function add_tipo_avaliacao()
	{
		$this->http_method('POST');

		$data = [
			'nome' => $this->input->post('tipo_avaliacao') ?? '',
			'descricao' => $this->input->post('descricao') ?? '',
		];
		$this->form_validation->set_rules('tipo_avaliacao', _l('tipo_avaliacao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_desenv_individual/configuracoes?group=tipo_avaliacao');
		} else {
			$insert = $this->Gestao_desenvolvimento_individual_model->create_tipo_avaliacao($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_desenv_individual/configuracoes?group=tipo_avaliacao');
		}
	}

	public function editar_tipo_avaliacao($id)
	{
		$this->http_method('POST');
		$this->Gestao_desenvolvimento_individual_model->first_tipo_avaliacao($id);

		$data = [
			'nome' => $this->input->post('e_tipo_avaliacao') ?? '',
			'descricao' => $this->input->post('e_descricao') ?? '',
		];
		$this->form_validation->set_rules('e_tipo_avaliacao', _l('tipo_avaliacao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_desenv_individual/configuracoes?group=tipo_avaliacao');
		} else {
			$this->Gestao_desenvolvimento_individual_model->update_tipo_avaliacao($data, $id);
			set_alert('success', "Actualizado com sucesso");
			redirect('gestao_desenv_individual/configuracoes?group=tipo_avaliacao');
		}
	}
	public function delete_tipo_avaliacao($id)
	{
		$relacionamento = $this->Gestao_desenvolvimento_individual_model->verificar_relacionamento_tipo_avaçiacao($id);

		if ($relacionamento) {
			set_alert('danger', "Não podes eliminar esses dados a um relacionamento!");
			return redirect('gestao_desenv_individual/configuracoes?group=tipo_avaliacao');
		}
		$this->Gestao_desenvolvimento_individual_model->first_tipo_avaliacao($id);
		$this->Gestao_desenvolvimento_individual_model->delete_tipo_avaliacao($id);
		set_alert('success', "Eliminado com sucesso");
		redirect('gestao_desenv_individual/configuracoes?group=tipo_avaliacao');
	}


	#==================== tipo_habilidade =========================================================

	public function add_tipo_habilidade()
	{
		$this->http_method('POST');

		$data = [
			'nome' => $this->input->post('tipo_habilidade') ?? '',
			'descricao' => $this->input->post('descricao') ?? '',
		];
		$this->form_validation->set_rules('tipo_habilidade', _l('tipo_habilidade'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_desenv_individual/configuracoes?group=tipo_habilidade');
		} else {
			$insert = $this->Gestao_desenvolvimento_individual_model->create_tipo_habilidade($data);
			set_alert('success', "Cadastrado com sucesso");
			redirect('gestao_desenv_individual/configuracoes?group=tipo_habilidade');
		}
	}

	public function editar_tipo_habilidade($id)
	{
		$this->http_method('POST');
		$this->Gestao_desenvolvimento_individual_model->first_tipo_habilidade($id);

		$data = [
			'nome' => $this->input->post('e_tipo_habilidade') ?? '',
			'descricao' => $this->input->post('e_descricao') ?? '',
		];
		$this->form_validation->set_rules('e_tipo_habilidade', _l('tipo_habilidade'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger', "Preenchas os campos correctamente");
			redirect('gestao_desenv_individual/configuracoes?group=tipo_habilidade');
		} else {
			$this->Gestao_desenvolvimento_individual_model->update_tipo_habilidade($data, $id);
			set_alert('success', "Actualizado com sucesso");
			redirect('gestao_desenv_individual/configuracoes?group=tipo_habilidade');
		}
	}
	public function delete_tipo_habilidade($id)
	{
		$relacionamento = $this->Gestao_desenvolvimento_individual_model->verificar_relacionamento_carreira($id);

		if ($relacionamento) {
			set_alert('danger', "Não podes eliminar esses dados a um relacionamento!");
			return redirect('gestao_desenv_individual/configuracoes?group=tipo_habilidade');
		}

		$this->Gestao_desenvolvimento_individual_model->first_tipo_habilidade($id);
		$this->Gestao_desenvolvimento_individual_model->delete_tipo_habilidade($id);
		set_alert('success', "Eliminado com sucesso");
		redirect('gestao_desenv_individual/configuracoes?group=tipo_habilidade');
	}
}