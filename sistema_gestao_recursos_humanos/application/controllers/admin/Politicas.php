<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Politicas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Politica_model'); // Carregar o model
    }

    // Função para listar todas as políticas
    // Função para listar todas as políticas
    public function get()
    {
        $data['politicas'] = $this->Politica_model->get_all();
        echo json_encode($data);
    }

    // Função para visualizar uma política
    public function view($id)
    {
        $data['politica'] = $this->Politica_model->get_by_id($id);

        if (empty($data['politica'])) {
            echo json_encode(['status' => false, 'message' => 'Política não encontrada']);
            return;
        }

        echo json_encode(['status' => 'success', 'data' => $data['politica']]);
    }

    // Função para adicionar uma nova política
    public function add()
    {
        if ($this->input->post()) {
            // Valida os campos obrigatórios
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nome', 'Nome', 'required');
            $this->form_validation->set_rules('descricao', 'Descrição', 'required');
            $this->form_validation->set_rules('funcionario_id', 'ID do Funcionário', 'required|integer');
            $this->form_validation->set_rules('status_id', 'ID de Status', 'required|integer');

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
                'nome'           => $this->input->post('nome'),
                'descricao'      => $this->input->post('descricao'),
                'funcionario_id' => $this->input->post('funcionario_id'),
                'status_id'      => $this->input->post('status_id')
            );

            // Insere a política no banco
            if ($this->Politica_model->insert($data_insert)) {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Política salva com sucesso!',
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Erro ao salvar a política no banco de dados.',
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

    // Função para editar uma política
    public function edit($id)
    {
        $data['politica'] = $this->Politica_model->get_by_id($id);

        if (empty($data['politica'])) {
            show_404();  // Se não encontrar a política, exibe erro 404
        }

        if ($this->input->post()) {
            // Valida os campos
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nome', 'Nome', 'required');
            $this->form_validation->set_rules('descricao', 'Descrição', 'required');
            $this->form_validation->set_rules('funcionario_id', 'ID do Funcionário', 'required|integer');
            $this->form_validation->set_rules('status_id', 'ID de Status', 'required|integer');

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
                'nome'           => $this->input->post('nome'),
                'descricao'      => $this->input->post('descricao'),
                'funcionario_id' => $this->input->post('funcionario_id'),
                'status_id'      => $this->input->post('status_id')
            );

            // Atualiza a política no banco
            if ($this->Politica_model->update($id, $update_data)) {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Política atualizada com sucesso!',
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Erro ao atualizar a política.',
                ]);
            }
        } else {
            // Caso a requisição não seja POST, retorna os dados para edição
            $this->load->view('politica/edit', $data);
        }
    }

    // Função para excluir uma política
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

        // Tenta excluir a política
        if ($this->Politica_model->delete($id)) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Política apagada com sucesso.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Erro ao excluir a política. Verifique se o ID é válido.'
            ]);
        }
    }
}
