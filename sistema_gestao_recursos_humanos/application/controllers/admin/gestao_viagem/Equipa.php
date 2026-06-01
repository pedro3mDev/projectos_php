<?php

use function Clue\StreamFilter\fun;

defined('BASEPATH') or exit('No direct script access allowed');

class Equipa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gv_pedido_model');
        $this->load->model('Gv_equipa_model');
        $this->load->library('form_validation');

    }

    private function http_method ($vfMethod) {
        if ($_SERVER['REQUEST_METHOD'] !== $vfMethod) {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['status' => false, 'message' => 'Metodo não permitido']);
            exit;
        }
    }

    public function total ($id_pedido) {
        $this->http_method('GET');
        $vfPedido = $this->Gv_pedido_model->first($id_pedido);


        echo json_encode([
            'status' => true,
            'message' => 'sucesso',
            'dados' => $this->Gv_equipa_model->total($vfPedido['id'])
        ]);
    }

    public function index($id_pedido)
    {
        $this->http_method('GET');
        $vfPedido = $this->Gv_pedido_model->first($id_pedido);


        echo json_encode([
            'status' => true,
            'message' => 'sucesso',
            'dados' => $this->Gv_equipa_model->get($vfPedido['id'])
        ]);
    }

    public function show($id_pedido, $id_equipa)
    {
        $this->http_method('GET');
        $vfPedido = $this->Gv_pedido_model->first($id_pedido);
        $dados = [
            'id_pedido' => $vfPedido['id'],
            'id_equipa' => $id_equipa,
        ];

        echo json_encode([
            'status' => true,
            'dados' => $this->Gv_equipa_model->first($dados)
        ]);
    }

    public function create ($id_pedido) {
        $this->http_method('POST');
        $vfPedido = $this->Gv_pedido_model->first($id_pedido);

        $data = [
            'admin_id' => 1, // ID Admin Logado
            'pedido_viagem_id' => $id_pedido,
            'funcionario_id' => $this->input->post('funcionario_id') ?? '',
        ];

        $this->form_validation->set_rules('funcionario_id', 'Funcionário', 'required', ['required' => 'Selecione o  {field}']);

        if (!$this->form_validation->run()) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'erros' => validation_errors()]);
            exit;
        }

        $insert = $this->Gv_equipa_model->create($data);

        header("HTTP/1.1 201 CREATED");
        echo json_encode([
            'status' => true,
            'message' => 'Status criado com sucesso',
            'dados' => $insert
        ]);
    }
    public function update ($id_pedido, $id_equipa) {
        $this->http_method('PUT');
        $vfPedido = $this->Gv_pedido_model->first($id_pedido);
        $vfEquipa = $this->Gv_equipa_model->first([
            'id_pedido' => $vfPedido['id'],
            'id_equipa' => $id_equipa,
        ]);

        $data_form = $this->input->input_stream();

        // $data['admin_id'] = 1;
        $data['pedido_viagem_id'] = $vfPedido['id'];

        $this->form_validation->set_data($data_form);
        if (isset($data_form['funcionario_id'])) {
            $this->form_validation->set_rules('funcionario_id', 'Funcionário', 'required', ['required' => 'Selecione o  {field}']);
            $data['funcionario_id'] = $data_form['funcionario_id'];
        }

        if (!$this->form_validation->run()) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'erros' => validation_errors()]);
            exit;
        }

        $insert = $this->Gv_equipa_model->update($data, $vfEquipa['id']);

        header("HTTP/1.1 200 SUCCESS");
        echo json_encode([
            'status' => true,
            'message' => 'Pedido de Viagem criado com sucesso',
            'dados' => $insert
        ]);
    }

    public function delete ($id_pedido, $id_equipa) {
        $this->http_method('DELETE');
        $vfPedido = $this->Gv_pedido_model->first($id_pedido);


        $delete = $this->Gv_equipa_model->delete([
            'id_pedido' => $vfPedido['id'],
            'id_equipa' => $id_equipa,
        ]);

        echo json_encode([
            'status' => true,
            'message' => 'Membro Removido com sucesso',
            'dados' => $delete,
        ]);
    }
}