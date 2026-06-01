<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Feedback extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Feedback_model'); // Carrega o modelo de feedback
  }

  // Lista todos os feedbacks
  public function get()
  {
    $data = $this->Feedback_model->get_all();
    echo json_encode($data);
  }

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

  // Exclui um feedback
  public function delete($id)
  {
    // Validação do ID
    if (empty($id) || !is_numeric($id)) {
      echo json_encode([
        'status' => 'error',
        'message' => 'ID inválido ou não fornecido.'
      ]);
      return;
    }

    // Tenta excluir o feedback
    if ($this->Feedback_model->delete($id)) {
      echo json_encode([
        'status' => 'success',
        'message' => 'Feedback apagado com sucesso.'
      ]);
    } else {
      echo json_encode([
        'status' => 'error',
        'message' => 'Erro ao excluir o feedback. Verifique se o ID é válido.'
      ]);
    }
  }
}
