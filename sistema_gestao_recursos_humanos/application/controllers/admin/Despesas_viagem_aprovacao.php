<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Despesas_viagem_aprovacao extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Despesas_aprovacao_model');
    }

    // Lista todas as aprovações de despesas
    public function get()
    {
        $data['aprovacoes'] = $this->Despesas_aprovacao_model->get_all();
        echo json_encode($data);
    }

    // Exibe detalhes de uma aprovação de despesa
    public function view($id)
    {
        // Recupera a aprovação pelo ID
        $data['aprovacao'] = $this->Despesas_aprovacao_model->get_by_id($id);

        // Se não encontrar a aprovação, retorna um erro em JSON
        if (empty($data['aprovacao'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Aprovação não encontrada.',
            ]);
            return;
        }

        // Retorna os dados da aprovação como JSON
        echo json_encode([
            'status' => true,
            'data' => $data['aprovacao']
        ]);
    }


    // Exibe formulário para criar uma nova aprovação de despesa
    public function create()
    {
        // Verifica se a requisição é POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Carrega a biblioteca de validação de formulários
            $this->load->library('form_validation');

            // Define as regras de validação dos campos
            $this->form_validation->set_rules('id_despesa', 'Despesa', 'required|integer');
            $this->form_validation->set_rules('id_funcionario', 'Funcionário', 'required|integer');
            $this->form_validation->set_rules('id_status', 'Status', 'required|integer');

            // Verifica se a validação dos dados foi bem-sucedida
            if ($this->form_validation->run() === FALSE) {
                // Retorna os erros de validação como JSON
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Validação falhou',
                    'errors' => $this->form_validation->error_array()
                ]);
                return;
            }

            // Coleta os dados do POST
            $data = [
                'id_despesa'    => $this->input->post('id_despesa'),
                'id_funcionario' => $this->input->post('id_funcionario'),
                'id_status'     => $this->input->post('id_status')
            ];

            // Tenta inserir os dados no banco
            if ($this->Despesas_aprovacao_model->insert($data)) {
                // Retorna uma resposta de sucesso em formato JSON
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Aprovação de despesa salva com sucesso!'
                ]);
            } else {
                // Retorna uma resposta de erro em formato JSON
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Erro ao salvar a aprovação da despesa.'
                ]);
            }
        } else {
            // Caso não seja uma requisição POST
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'Método de requisição inválido.'
            ]);
        }
    }


    // Exibe formulário para editar uma aprovação de despesa
    public function edit($id)
    {
        // Busca a aprovação de despesa pelo ID
        $data['aprovacao'] = $this->Despesas_aprovacao_model->get_by_id($id);

        // Se a despesa não existir, retorna erro 404
        if (empty($data['aprovacao'])) {
            show_404();
        }

        // Verifica se a requisição é POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Carrega a biblioteca de validação de formulários
            $this->load->library('form_validation');

            // Define as regras de validação para os campos
            $this->form_validation->set_rules('id_despesa', 'Despesa', 'required|integer');
            $this->form_validation->set_rules('id_funcionario', 'Funcionário', 'required|integer');
            $this->form_validation->set_rules('id_status', 'Status', 'required|integer');

            // Verifica se a validação dos dados foi bem-sucedida
            if ($this->form_validation->run() === FALSE) {
                // Retorna os erros de validação como JSON
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Validação falhou',
                    'errors' => $this->form_validation->error_array()
                ]);
                return;
            }

            // Coleta os dados do POST
            $update_data = [
                'id_despesa'    => $this->input->post('id_despesa'),
                'id_funcionario' => $this->input->post('id_funcionario'),
                'id_status'     => $this->input->post('id_status')
            ];

            // Tenta atualizar os dados no banco
            if ($this->Despesas_aprovacao_model->update($id, $update_data)) {
                // Retorna uma resposta de sucesso em formato JSON
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Aprovação da despesa atualizada com sucesso!'
                ]);
            } else {
                // Retorna uma resposta de erro em formato JSON
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Erro ao atualizar a aprovação da despesa.'
                ]);
            }
        } else {
            // Caso a requisição não seja POST
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'Método de requisição inválido.'
            ]);
        }
    }


    // Exclui uma aprovação de despesa
    public function delete($id)
    {
        // Verifica se o ID da despesa existe e se a exclusão foi bem-sucedida
        if ($this->Despesas_aprovacao_model->delete($id)) {
            // Resposta de sucesso
            echo json_encode([
                'status' => 'success',
                'message' => 'Aprovação da despesa excluída com sucesso!'
            ]);
        } else {
            // Caso a exclusão falhe, retorna erro
            echo json_encode([
                'status' => 'error',
                'message' => 'Erro ao excluir a aprovação da despesa.'
            ]);
        }
    }
}
