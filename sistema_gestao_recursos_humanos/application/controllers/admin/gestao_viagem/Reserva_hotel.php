<?php

use function Clue\StreamFilter\fun;

defined('BASEPATH') or exit('No direct script access allowed');

class Reserva_hotel extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gv_pedido_model');
        $this->load->model('Gv_reserva_hotel_model');
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
            'dados' => $this->Gv_reserva_hotel_model->get($vfPedido['id'])
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
            'dados' => $this->Gv_reserva_hotel_model->first($dados)
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
            'hotel' => $this->input->post('hotel') ?? '',
            'data_checkin' => $this->input->post('data_checkin') ?? '',
            'data_checkout' => $this->input->post('data_checkout') ?? '',
            'valor' => $this->input->post('valor') ?? '',
        ];

        $this->form_validation->set_rules('status_id', 'Status', 'required', ['required' => 'Selecione o  {field}']);
        $this->form_validation->set_rules('hotel', 'Hotel', 'required', ['required' => 'Preencha o  campo {field}']);
        $this->form_validation->set_rules('data_checkin', 'Data de Checkin', 'required|callback_data_time', ['required' => 'Selecione o  {field}']);
        $this->form_validation->set_rules('data_checkout', 'Data de Checkout', 'required|callback_data_time', ['required' => 'Selecione o  {field}']);
        $this->form_validation->set_rules('valor', 'Valor da Hospedagem', 'required|numeric', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'erros' => validation_errors()]);
            exit;
        }

        $insert = $this->Gv_reserva_hotel_model->create($data);

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
        $vfReservaHotel = $this->Gv_reserva_hotel_model->first([
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
        if (isset($data_form['hotel'])) {
            $this->form_validation->set_rules('hotel', 'Hotel', 'required', ['required' => 'Preencha o  campo  {field}']);
            $data['hotel'] = $data_form['hotel'];
        }
        if (isset($data_form['data_checkin'])) {
            $this->form_validation->set_rules('data_checkin', 'Data de Checkin', 'required|callback_data_time', ['required' => 'Selecione o  {field}']);
            $data['data_checkin'] = $data_form['data_checkin'];
        }
        if (isset($data_form['data_checkout'])) {
            $this->form_validation->set_rules('data_checkout', 'Data de Checkout', 'required|callback_data_time', ['required' => 'Selecione o  {field}']);
            $data['data_checkout'] = $data_form['data_checkout'];
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

        $update = $this->Gv_reserva_hotel_model->update($data, $vfReservaHotel['id']);

        header("HTTP/1.1 200 SUCCESS");
        echo json_encode([
            'status' => true,
            'message' => 'Reserva de Hotel actualizada com sucesso',
            'dados' => $update
        ]);
    }

    public function delete ($id_pedido, $id) {
        $this->http_method('DELETE');
        $vfPedido = $this->Gv_pedido_model->first($id_pedido);

        $delete = $this->Gv_reserva_hotel_model->delete([
            'id_pedido' => $vfPedido['id'],
            'id' => $id,
        ]);

        echo json_encode([
            'status' => true,
            'message' => 'Reserva de Hotel Removido com sucesso',
            'dados' => $delete,
        ]);
    }
}