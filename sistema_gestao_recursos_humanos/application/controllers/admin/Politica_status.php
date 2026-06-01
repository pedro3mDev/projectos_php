<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Politica_status extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Politica_status_model'); // Carregar o model
  }

  // Função para listar todos os politica status
  // Função para listar todos os status das políticas
  public function get()
  {
    $data['politica_status'] = $this->Politica_status_model->get_all();
    echo json_encode($data);
  }

  // Função para visualizar um status da política específico
  public function view($id)
  {
    $data['politica_status'] = $this->Politica_status_model->get_by_id($id);

    if (empty($data['politica_status'])) {
      echo json_encode(['status' => false, 'message' => 'Status da política não encontrado']);
      return;
    }

    echo json_encode(['status' => 'success', 'data' => $data['politica_status']]);
  }

  // Função para adicionar um novo status de política
  public function add()
  {
    if ($this->input->post()) {
      // Valida os campos obrigatórios
      $this->load->library('form_validation');
      $this->form_validation->set_rules('nome', 'Nome', 'required');
      $this->form_validation->set_rules('descricao', 'Descrição', 'required');

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

      // Dados a serem inseridos
      $data_insert = array(
        'nome'       => $this->input->post('nome'),
        'descricao'  => $this->input->post('descricao')
      );

      // Insere o status de política no banco
      if ($this->Politica_status_model->insert($data_insert)) {
        header('Content-Type: application/json');
        echo json_encode([
          'status' => 'success',
          'message' => 'Status da política salvo com sucesso!',
        ]);
      } else {
        header('Content-Type: application/json');
        echo json_encode([
          'status' => 'error',
          'message' => 'Erro ao salvar o status da política no banco de dados.',
        ]);
      }
    } else {
      // Caso não tenha dados no POST
      header('Content-Type: application/json');
      echo json_encode([
        'status' => 'error',
        'message' => 'Nenhum dado foi enviado.',
      ]);
    }
  }

  // Função para editar um status de política
  public function edit($id)
  {
    $data['politica_status'] = $this->Politica_status_model->get_by_id($id);

    if (empty($data['politica_status'])) {
      show_404();  // Se não encontrar o status da política, exibe erro 404
    }

    if ($this->input->post()) {
      // Valida os campos
      $this->load->library('form_validation');
      $this->form_validation->set_rules('nome', 'Nome', 'required');
      $this->form_validation->set_rules('descricao', 'Descrição', 'required');

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
      $update_data = array(
        'nome'       => $this->input->post('nome'),
        'descricao'  => $this->input->post('descricao')
      );

      // Atualiza o status da política no banco
      if ($this->Politica_status_model->update($id, $update_data)) {
        header('Content-Type: application/json');
        echo json_encode([
          'status' => 'success',
          'message' => 'Status da política atualizado com sucesso!',
        ]);
      } else {
        header('Content-Type: application/json');
        echo json_encode([
          'status' => 'error',
          'message' => 'Erro ao atualizar o status da política.',
        ]);
      }
    } else {
      // Caso a requisição não seja POST, retorna os dados para edição
      $this->load->view('politica_status/edit', $data);
    }
  }

  // Função para excluir um status de política
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

    // Tenta excluir o status da política
    if ($this->Politica_status_model->delete($id)) {
      echo json_encode([
        'status' => 'success',
        'message' => 'Status da política apagado com sucesso.'
      ]);
    } else {
      echo json_encode([
        'status' => 'error',
        'message' => 'Erro ao excluir o status da política. Verifique se o ID é válido.'
      ]);
    }
  }
}
