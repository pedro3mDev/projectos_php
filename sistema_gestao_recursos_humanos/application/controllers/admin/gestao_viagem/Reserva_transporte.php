<?php

use function Clue\StreamFilter\fun;

defined('BASEPATH') or exit('No direct script access allowed');

class Reserva_transporte extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gv_pedido_model');
        $this->load->model('Gv_reserva_transporte_model');
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
            'dados' => $this->Gv_reserva_transporte_model->get($vfPedido['id'])
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
            'dados' => $this->Gv_reserva_transporte_model->first($dados)
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
            'tipo_reserva' => $this->input->post('tipo_reserva') ?? '',

            'valor' => $this->input->post('valor') ?? '',
        ];

        $this->form_validation->set_rules('status_id', 'Status', 'required', ['required' => 'Selecione o  {field}']);
        $this->form_validation->set_rules('descricao', 'Descrição', 'required', ['required' => 'Preencha o  campo {field}']);

        $enum_valido = ['taxi', 'car_sharing', 'rent_a_car', 'renting'];
        $this->form_validation->set_rules('tipo_reserva', 'Tipo de Reserva', ['required', [
            'enum', function ($value) use ($enum_valido) {
                return in_array($value, $enum_valido);
            }
        ]], ['required' => 'Selecione um {field}', 'enum' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido)]);

        if ($data['tipo_reserva'] == 'taxi') {
            $data['local_partida'] = $this->input->post('local_partida') ?? '';
            $data['local_destino'] = $this->input->post('local_destino') ?? '';
            $this->form_validation->set_rules('local_partida', 'Local de Partida', 'required', ['required' => 'Preencha o campo {field}']);
            $this->form_validation->set_rules('local_destino', 'Local de Distino', 'required', ['required' => 'Preencha o campo {field}']);
        }
        else {
            $data['local_partida'] = $this->input->post('local_partida') ?? '';
            $data['local_destino'] = $this->input->post('local_destino') ?? '';
        }
        $this->form_validation->set_rules('valor', 'Valor', 'required|numeric', [
            'required' => 'Preencha o campo {field}',
            'numeric' => 'Preencha o campo {field} apenas com número',
        ]);

        if (!$this->form_validation->run()) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'erros' => validation_errors()]);
            exit;
        }

        $insert = $this->Gv_reserva_transporte_model->create($data);

        header("HTTP/1.1 201 CREATED");
        echo json_encode([
            'status' => true,
            'message' => 'Reserva cadastrada com sucesso',
            'dados' => $insert
        ]);
    }
    public function update ($id_pedido, $id) {
        $this->http_method('PUT');
        $vfPedido = $this->Gv_pedido_model->first($id_pedido);
        $vfReservaTransporte = $this->Gv_reserva_transporte_model->first([
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
            $this->form_validation->set_rules('hotel', 'Descrição', 'required', ['required' => 'Preencha o  campo  {field}']);
            $data['descricao'] = $data_form['descricao'];
        }
        if (isset($data_form['tipo_reserva'])) {
            $enum_valido = ['taxi', 'car_sharing', 'rent_a_car', 'renting'];
            $this->form_validation->set_rules('tipo_reserva', 'Tipo de Reserva', ['required', [
                'enum', function ($value) use ($enum_valido) {
                    return in_array($value, $enum_valido);
                }
            ]], ['required' => 'Selecione um {field}', 'enum' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido)]);
            $data['tipo_reserva'] = $data_form['tipo_reserva'];
        }
        if (isset($data['tipo_reserva']) AND $data['tipo_reserva'] == 'taxi') {
            if (isset($data_form['local_partida'])) {
                $this->form_validation->set_rules('local_partida', 'Local de Partida', 'required', ['required' => 'Preencha o campo {field}']);
                $data['local_partida'] = $data_form['local_partida'];
            }
            if (isset($data_form['local_destino'])) {
                $this->form_validation->set_rules('local_destino', 'Local de Distino', 'required', ['required' => 'Preencha o campo {field}']);
                $data['local_destino'] = $data_form['local_destino'];
            }
        }
        if (isset($data_form['local_partida'])) {
            $data['local_partida'] = $data_form['local_partida'];
            $this->form_validation->set_rules('local_partida', 'Local de Partida', 'required|min_length[3]', ['required' => 'Preencha o campo {field}']);
        }
        if (isset($data_form['local_destino'])) {
            $data['local_destino'] = $data_form['local_destino'];
            $this->form_validation->set_rules('local_destino', 'Local de Distino', 'required|min_length[3]', ['required' => 'Preencha o campo {field}']);
        }
        if (isset($data_form['valor'])) {
            $this->form_validation->set_rules('valor', 'Valor da Passagem', 'required|numeric', ['required' => 'Preencha o campo {field}']);
            $data['valor'] = $data_form['valor'];
        }
        // var_dump($data_form);
        // return;
        if (!$this->form_validation->run()) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'erros' => validation_errors()]);
            exit;
        }

        $update = $this->Gv_reserva_transporte_model->update($data, $vfReservaTransporte['id']);

        header("HTTP/1.1 200 SUCCESS");
        echo json_encode([
            'status' => true,
            'message' => 'Reserva de Transporte actualizada com sucesso',
            'dados' => $update
        ]);
    }

    public function delete ($id_pedido, $id) {
        $this->http_method('DELETE');
        $vfPedido = $this->Gv_pedido_model->first($id_pedido);

        $delete = $this->Gv_reserva_transporte_model->delete([
            'id_pedido' => $vfPedido['id'],
            'id' => $id,
        ]);

        echo json_encode([
            'status' => true,
            'message' => 'Reserva de Transporte Removido com sucesso',
            'dados' => $delete,
        ]);
    }
}