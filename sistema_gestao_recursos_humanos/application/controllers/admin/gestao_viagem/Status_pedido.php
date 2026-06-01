<?php

use function Clue\StreamFilter\fun;

defined('BASEPATH') or exit('No direct script access allowed');

class Status_pedido extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gv_pedido_model');
        $this->load->model('Gv_status_pedido_model');
        $this->load->library('form_validation');

    }

    private function http_method ($vfMethod) {
        if ($_SERVER['REQUEST_METHOD'] !== $vfMethod) {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['status' => false, 'message' => 'Metodo não permitido']);
            exit;
        }
    }

    public function status($status)
    {
        $this->http_method('GET');

        if ($status != 'aprovado' AND $status != 'negado' AND $status != 'pendente') {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(['status' => false, 'message' => 'Página não Encontrada']);
            exit;
        }

        if ($status == 'pendente') {
            $dados = $this->Gv_status_pedido_model->get_pendente();
        }
        else {
            $dados = $this->Gv_status_pedido_model->get($status);
        }

        echo json_encode([
            'status' => true,
            'message' => 'sucesso',
            'dados' => $dados,
        ]);
    }

    public function fitlro_total ($status) {
        $this->http_method('GET');

        if ($status != 'aprovado' AND $status != 'negado' AND $status != 'pendente') {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(['status' => false, 'message' => 'Página não Encontrada']);
            exit;
        }

        if ($status == 'pendente') {
            $dados = $this->Gv_status_pedido_model->total_pendente();
        }
        else {
            $dados = $this->Gv_status_pedido_model->total($status);
        }

        echo json_encode([
            'status' => true,
            'message' => 'sucesso',
            'dados' => $dados,
        ]);
    }
    public function decisao () {
        $this->http_method('POST');

        $enum_valido = ['aprovado', 'negado'];
        $data = [
            'admin_id' => 1, // ID Admin Logado
            'pedido_viagem_id' => $this->input->post('pedido_viagem_id') ?? '',
            'status' => $this->input->post('status') ?? '',
        ];

        $vfPedido = $this->Gv_pedido_model->first($data['pedido_viagem_id']);

        $this->form_validation->set_rules('pedido_viagem_id', 'Pedido de Viagem', 'required', ['required' => 'Selecione o  {field}']);
        $this->form_validation->set_rules('status', 'Decisão', ['required', [
            'enum', function ($value) use ($enum_valido) {
                return in_array($value, $enum_valido);
            }
        ]], ['required' => 'Selecione o Status', 'enum' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido)]);

        if (!$this->form_validation->run()) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'erros' => validation_errors()]);
            exit;
        }

        $insert = $this->Gv_status_pedido_model->decisao($data);

        header("HTTP/1.1 201 CREATED");
        echo json_encode([
            'status' => true,
            'message' => 'Status de Pedido de Viagem adicionado com sucesso',
            'dados' => $insert
        ]);
    }
    public function update ($id) {
        $this->http_method('PUT');
        $vfPedidoStatus = $this->Gv_status_pedido_model->first($id);

        $data_form = $this->input->input_stream();

        $data = [];

        $this->form_validation->set_data($data_form);
        if (isset($data_form['pedido_viagem_id'])) {
            $this->form_validation->set_rules('pedido_viagem_id', 'Pedido de Viagem', 'required', ['required' => 'Selecione o  {field}']);
            $data['pedido_viagem_id'] = $data_form['pedido_viagem_id'];
        }
        if (isset($data_form['status'])) {
            $enum_valido = ['aprovado', 'negado'];
            $this->form_validation->set_rules('status', 'Decisão', ['required', [
                'enum', function ($value) use ($enum_valido) {
                    return in_array($value, $enum_valido);
                }
            ]], ['required' => 'Selecione uma {field}', 'enum' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido)]);
            $data['status'] = $data_form['status'];
        }

        if (!$this->form_validation->run()) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'erros' => validation_errors()]);
            exit;
        }

        $insert = $this->Gv_status_pedido_model->update($data, $vfPedidoStatus['id']);

        header("HTTP/1.1 200 SUCCESS");
        echo json_encode([
            'status' => true,
            'message' => 'Status de Pedido de Viagem Actualizado',
            'dados' => $insert
        ]);
    }

    public function delete ($id) {
        $this->http_method('DELETE');
        $vfPedidoStatus = $this->Gv_status_pedido_model->first($id);

        $delete = $this->Gv_status_pedido_model->delete($id);

        echo json_encode([
            'status' => true,
            'message' => 'Status Pedido Eliminado com sucesso',
            'dados' => $delete,
        ]);
    }
}