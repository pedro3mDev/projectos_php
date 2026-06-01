<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Feedback extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Feedback_model'); // Carrega o modelo de feedback
		$this->load->model('Gv_gestao_viagem_model');

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
	public function index()
	{
		$data['title'] = _l('gv_feedback');
        $data['tabs']['view'] = '/gestao_viagens' ;
		// var_dump("feedback");

		$data['data'] = $this->Feedback_model->get_all();
		// var_dump($data);

		$data['feedbacks'] = $this->Feedback_model->get();
        $data['orcamentos'] = $this->Gv_gestao_viagem_model->get_orcamento(2);
		$data['classificacoes'] = $this->Gv_gestao_viagem_model->get_classificacoes();

		$this->load->view('feedback/index', $data);
	}
	public function adicionar () {
		$this->http_method('POST');

		$data = [
			'orcamento_viagem_id' => $this->input->post('orcamento') ?? '',
            'classificacao_id' => $this->input->post('classificacao') ?? '',
            'feedback' => $this->input->post('feedback') ?? '',
            'data_feedback' => date('Y-m-d H:i:s'),
            // 'data_feedback' => $this->input->post('data_feedback') ?? '',
        ];
		$this->form_validation->set_rules('orcamento', _l('orcamento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('classificacao', _l('classificacao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('feedback', _l('feedback'), 'required', ['required' => 'Preencha o campo {field}']);
		// $this->form_validation->set_rules('data_feedback', _l('data_feedback'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_viagens/feedback');
        }
		else {
			$insert = $this->Feedback_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_viagens/feedback');
		}
	}
	public function delete ($id) {
		$this->Feedback_model->first($id);
		$this->Feedback_model->delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_viagens/feedback');
	}
	public function editar ($id) {
		$this->http_method('POST');
		$this->Feedback_model->first($id);

		$data = [
			'orcamento_viagem_id' => $this->input->post('e_orcamento') ?? '',
            'classificacao_id' => $this->input->post('e_classificacao') ?? '',
            'feedback' => $this->input->post('e_feedback') ?? '',
            // 'data_feedback' => date('Y-m-d H:i:s'),
            // 'data_feedback' => $this->input->post('data_feedback') ?? '',
        ];
		$this->form_validation->set_rules('e_orcamento', _l('orcamento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_classificacao', _l('classificacao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_feedback', _l('feedback'), 'required', ['required' => 'Preencha o campo {field}']);
		// $this->form_validation->set_rules('data_feedback', _l('data_feedback'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_viagens/feedback');
        }
		else {
			$insert = $this->Feedback_model->update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_viagens/feedback');
		}
	}













	// Lista todos os feedbacks
	// public function get()
	// {
	// 	$data = $this->Feedback_model->get_all();
	// 	echo json_encode($data);
	// }

	// Exibe detalhes de um feedback
	public function view($id)
	{
		$data['feedback'] = $this->Feedback_model->get_by_id($id);

		// Verificando se o feedback foi encontrado
		if (empty($data['feedback'])) {
			// Retornando um erro 404 em formato JSON
			echo json_encode(['status' => false, 'message' => 'Feedback não encontrado']);
			return;
		}

		// Retornando os dados do feedback em JSON
		echo json_encode(['status' => 'success', 'data' => $data['feedback']]);
	}

	// Exibe formulário para criar um novo feedback
	public function create()
	{
		// Verifica se há dados no POST
		if (!empty($_POST)) {
			// Valida os campos obrigatórios
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_pedido_viagem', 'Pedido de Viagem', 'required|integer');
			$this->form_validation->set_rules('id_funcionario', 'ID do Funcionário', 'required|integer');
			$this->form_validation->set_rules('feedback', 'Feedback', 'required');

			// Se a validação falhar, retorna os erros em JSON
			if ($this->form_validation->run() === FALSE) {
				echo json_encode([
					'status' => 'error',
					'message' => 'Validação falhou',
					'errors' => $this->form_validation->error_array(),
				]);
				return;
			}

			// Captura os dados válidos
			$data = [
				'id_pedido_viagem' => $this->input->post('id_pedido_viagem'),
				'id_funcionario'   => $this->input->post('id_funcionario'),
				'feedback'         => $this->input->post('feedback'),
			];

			// Insere os dados no banco
			if ($this->Feedback_model->insert($data)) {
				// Retorna sucesso
				echo json_encode([
					'status' => 'success',
					'message' => 'Feedback salvo com sucesso!',
				]);
			} else {
				// Retorna erro ao salvar no banco
				echo json_encode([
					'status' => 'error',
					'message' => 'Erro ao salvar o feedback no banco de dados.',
				]);
			}
		} else {
			// Caso $_POST esteja vazio
			echo json_encode([
				'status' => 'error',
				'message' => 'Nenhum dado foi enviado.',
			]);
		}
	}

	// Exibe formulário para editar um feedback
	public function edit($id)
	{
		// Recupera o feedback a ser editado pelo ID
		$data['feedback'] = $this->Feedback_model->get_by_id($id);

		if (empty($data['feedback'])) {
			show_404(); // Se não encontrar, exibe erro 404
		}

		// Verifica se a requisição é POST (edição)
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Valida os campos
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_pedido_viagem', 'Pedido de Viagem', 'required|integer');
			$this->form_validation->set_rules('id_funcionario', 'ID do Funcionário', 'required|integer');
			$this->form_validation->set_rules('feedback', 'Feedback', 'required');

			// Se a validação falhar, retorna os erros em JSON
			if ($this->form_validation->run() === FALSE) {
				header('Content-Type: application/json');
				echo json_encode([
					'status' => 'error',
					'message' => 'Validação falhou',
					'errors' => $this->form_validation->error_array(),
				]);
				return;
			}

			// Dados a serem atualizados
			$update_data = [
				'id_pedido_viagem' => $this->input->post('id_pedido_viagem'),
				'id_funcionario'   => $this->input->post('id_funcionario'),
				'feedback'         => $this->input->post('feedback')
			];

			// Atualiza o feedback no banco de dados
			if ($this->Feedback_model->update($id, $update_data)) {
				// Se atualizado com sucesso
				header('Content-Type: application/json');
				echo json_encode([
					'status' => 'success',
					'message' => 'Feedback atualizado com sucesso!',
				]);
			} else {
				// Se falhar ao atualizar
				header('Content-Type: application/json');
				echo json_encode([
					'status' => 'error',
					'message' => 'Erro ao atualizar o feedback.',
				]);
			}
		} else {
			// Caso a requisição não seja POST, retorna os dados para edição
			$this->load->view('feedback/edit', $data);
		}
	}
}