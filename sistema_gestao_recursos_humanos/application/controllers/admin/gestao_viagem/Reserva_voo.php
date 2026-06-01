<?php

use function Clue\StreamFilter\fun;

defined('BASEPATH') or exit('No direct script access allowed');

class Reserva_voo extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gv_pedido_model');
        $this->load->model('Gv_reserva_voo_model');
        $this->load->library('form_validation');

    }

    private function http_method ($vfMethod) {
        if ($_SERVER['REQUEST_METHOD'] !== $vfMethod) {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['status' => false, 'message' => 'Metodo não permitido']);
            exit;
        }
    }

    public function index($id_pedido)
    {
        $this->http_method('GET');
        $vfPedido = $this->Gv_pedido_model->first($id_pedido);

        echo json_encode([
            'status' => true,
            'message' => 'sucesso',
            'dados' => $this->Gv_reserva_voo_model->get($vfPedido['id'])
        ]);
    }

    public function show($id_pedido, $id)
    {
        $this->http_method('GET');
        $vfPedido = $this->Gv_pedido_model->first($id_pedido);
        $dados = [
            'id_pedido' => $vfPedido['id'],
            'id' => $id,
        ];

        echo json_encode([
            'status' => true,
            'dados' => $this->Gv_reserva_voo_model->first($dados)
        ]);
    }

    public function data_time ($data_time) {
        $da = DateTime::createFromFormat('Y-m-d H:i:s', $data_time);
        if ($da && $da->format('Y-m-d H:i:s') == $data_time) {
            return true;
        }
        $this->form_validation->set_message('data_time', 'Preencha o campo {field} corretamente');
        return false;
    }
    public function inteiro ($inteiro) {
        if (ctype_digit($inteiro)) {
            return true;
        }
        $this->form_validation->set_message('inteiro', 'Preencha o campo {field} corretamente');
        return false;
    }

    public function create ($id_pedido) {
        $this->http_method('POST');
        $vfPedido = $this->Gv_pedido_model->first($id_pedido);

        $data = [
            'admin_id' => 1, // ID Admin Logado
            'pedido_viagem_id' => $id_pedido,
            'status_id' => $this->input->post('status_id') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
            'aeroporto' => $this->input->post('aeroporto') ?? '',
            'n_passageiro' => $this->input->post('n_passageiro') ?? '',
            'partida' => $this->input->post('partida') ?? '',
            'destino' => $this->input->post('destino') ?? '',
            'data_partida' => $this->input->post('data_partida') ?? '',
            'valor' => $this->input->post('valor') ?? '',
        ];

        $this->form_validation->set_rules('status_id', 'Status', 'required', ['required' => 'Selecione o  {field}']);
        $this->form_validation->set_rules('descricao', 'Descrição', 'required', ['required' => 'Preencha o  campo {field}']);
        $this->form_validation->set_rules('aeroporto', 'Aeroporto', 'required', ['required' => 'Preencha o  campo  {field}']);
        $this->form_validation->set_rules('n_passageiro', 'Número de Passageiro', 'required|callback_inteiro|greater_than[0]', ['required' => 'Preencha o campo  {field}']);
        $this->form_validation->set_rules('partida', 'Partida', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('destino', 'Destino', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('data_partida', 'Data de Partida', 'required|callback_data_time', ['required' => 'Selecione o  {field}']);
        $this->form_validation->set_rules('valor', 'Valor da Passagem', 'required|numeric', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'erros' => validation_errors()]);
            exit;
        }

        $insert = $this->Gv_reserva_voo_model->create($data);

        header("HTTP/1.1 201 CREATED");
        echo json_encode([
            'status' => true,
            'message' => 'Reserva Cadastrada com sucesso',
            'dados' => $insert
        ]);
    }
    public function update ($id_pedido, $id) {
        $this->http_method('PUT');
        $vfPedido = $this->Gv_pedido_model->first($id_pedido);
        $vfReservaVoo = $this->Gv_reserva_voo_model->first([
            'id_pedido' => $vfPedido['id'],
            'id' => $id,
        ]);

        $data_form = $this->input->input_stream();

        $data['pedido_viagem_id'] = $vfPedido['id'];

        $this->form_validation->set_data($data_form);
        if (isset($data_form['status_id'])) {
            $this->form_validation->set_rules('status_id', 'Status', 'required', ['required' => 'Selecione o  {field}']);
            $data['status_id'] = $data_form['status_id'];
        }
        if (isset($data_form['descricao'])) {
            $this->form_validation->set_rules('descricao', 'Descrição', 'required', ['required' => 'Preencha o  campo  {field}']);
            $data['descricao'] = $data_form['descricao'];
        }
        if (isset($data_form['aeroporto'])) {
            $this->form_validation->set_rules('aeroporto', 'Aeroporto', 'required', ['required' => 'Preencha o  campo  {field}']);
            $data['aeroporto'] = $data_form['aeroporto'];
        }
        if (isset($data_form['n_passageiro'])) {
            $this->form_validation->set_rules('n_passageiro', 'Número de Passageiro', 'required|callback_inteiro|greater_than[0]', ['required' => 'Preencha o campo  {field}']);
            $data['n_passageiro'] = $data_form['n_passageiro'];
        }
        if (isset($data_form['partida'])) {
            $this->form_validation->set_rules('partida', 'Partida', 'required', ['required' => 'Preencha o campo {field}']);
            $data['partida'] = $data_form['partida'];
        }
        if (isset($data_form['destino'])) {
            $this->form_validation->set_rules('destino', 'Destino', 'required', ['required' => 'Preencha o campo {field}']);
            $data['destino'] = $data_form['destino'];
        }
        if (isset($data_form['data_partida'])) {
            $this->form_validation->set_rules('data_partida', 'Data de Partida', 'required|callback_data_time', ['required' => 'Selecione o  {field}']);
            $data['data_partida'] = $data_form['data_partida'];
        }
        if (isset($data_form['valor'])) {
            $this->form_validation->set_rules('valor', 'Valor da Passagem', 'required|numeric', ['required' => 'Preencha o campo {field}']);
            $data['valor'] = $data_form['valor'];
        }

        if (!$this->form_validation->run()) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'erros' => validation_errors()]);
            exit;
        }

        $update = $this->Gv_reserva_voo_model->update($data, $vfReservaVoo['id']);

        header("HTTP/1.1 200 SUCCESS");
        echo json_encode([
            'status' => true,
            'message' => 'Reserva de Voo actualizada com sucesso',
            'dados' => $update
        ]);
    }

    public function delete ($id_pedido, $id) {
        $this->http_method('DELETE');
        $vfPedido = $this->Gv_pedido_model->first($id_pedido);

        $delete = $this->Gv_reserva_voo_model->delete([
            'id_pedido' => $vfPedido['id'],
            'id' => $id,
        ]);

        echo json_encode([
            'status' => true,
            'message' => 'Reserva de Voo Removido com sucesso',
            'dados' => $delete,
        ]);
    }
}