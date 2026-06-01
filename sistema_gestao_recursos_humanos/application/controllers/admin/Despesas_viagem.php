<?php

use app\services\imap\Imap;
use app\services\imap\ConnectionErrorException;
use Ddeboer\Imap\Exception\MailboxDoesNotExistException;

defined('BASEPATH') or exit('No direct script access allowed');

class Despesas_viagem extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Despesas_model');
  }

  // Lista todas as despesas
  public function get()
  {
    $data = $this->Despesas_model->get_all();
    echo json_encode($data);
  }

  // Exibe detalhes de uma despesa
  public function view($id)
  {
    $data['despesa'] = $this->Despesas_model->get_by_id($id);

    // Verificando se a despesa foi encontrada
    if (empty($data['despesa'])) {
      // Retornando um erro 404 em formato JSON
      echo json_encode(['status' => false, 'message' => 'Despesa não encontrada']);
      return;
    }

    // Retornando os dados da despesa em JSON
    echo json_encode(['status' => 'success', 'data' => $data['despesa']]);
  }

  // Exibe formulário para criar uma nova despesa
  public function create()
  {
    // Verifica se há dados no POST
    if (!empty($_POST)) {
      // Valida os campos obrigatórios
      $this->load->library('form_validation');
      $this->form_validation->set_rules('id_pedido_viagem', 'Pedido de Viagem', 'required|integer');
      $this->form_validation->set_rules('despesa', 'Despesa', 'required');
      $this->form_validation->set_rules('valor', 'Valor', 'required|decimal');
      $this->form_validation->set_rules('comprovante', 'Comprovante', 'required');

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
        'despesa'          => $this->input->post('despesa'),
        'valor'            => $this->input->post('valor'),
        'comprovante'      => $this->input->post('comprovante'),
      ];

      // Insere os dados no banco
      if ($this->Despesas_model->insert($data)) {
        // Retorna sucesso
        echo json_encode([
          'status' => 'success',
          'message' => 'Despesa salva com sucesso!',
        ]);
      } else {
        // Retorna erro ao salvar no banco
        echo json_encode([
          'status' => 'error',
          'message' => 'Erro ao salvar a despesa no banco de dados.',
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


  // Exibe formulário para editar uma despesa
  public function edit($id)
  {
    // Recupera a despesa a ser editada pelo ID
    $data['despesa'] = $this->Despesas_model->get_by_id($id);

    if (empty($data['despesa'])) {
      show_404(); // Se não encontrar, exibe erro 404
    }

    // Verifica se a requisição é POST (edição)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Valida os campos
      $this->load->library('form_validation');
      $this->form_validation->set_rules('id_pedido_viagem', 'Pedido de Viagem', 'required|integer');
      $this->form_validation->set_rules('despesa', 'Despesa', 'required');
      $this->form_validation->set_rules('valor', 'Valor', 'required|decimal');
      $this->form_validation->set_rules('comprovante', 'Comprovante', 'required');

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
        'despesa'          => $this->input->post('despesa'),
        'valor'            => $this->input->post('valor'),
        'comprovante'      => $this->input->post('comprovante')
      ];

      // Atualiza a despesa no banco de dados
      if ($this->Despesas_model->update($id, $update_data)) {
        // Se atualizado com sucesso
        header('Content-Type: application/json');
        echo json_encode([
          'status' => 'success',
          'message' => 'Despesa atualizada com sucesso!',
        ]);
      } else {
        // Se falhar ao atualizar
        header('Content-Type: application/json');
        echo json_encode([
          'status' => 'error',
          'message' => 'Erro ao atualizar a despesa.',
        ]);
      }
    } else {
      // Caso a requisição não seja POST, retorna os dados para edição
      $this->load->view('despesas/edit', $data);
    }
  }


  // Exclui uma despesa
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

    // Tenta excluir a despesa
    if ($this->Despesas_model->delete($id)) {
      echo json_encode([
        'status' => 'success',
        'message' => 'Despesa apagada com sucesso.'
      ]);
    } else {
      echo json_encode([
        'status' => 'error',
        'message' => 'Erro ao excluir a despesa. Verifique se o ID é válido.'
      ]);
    }
  }
}
