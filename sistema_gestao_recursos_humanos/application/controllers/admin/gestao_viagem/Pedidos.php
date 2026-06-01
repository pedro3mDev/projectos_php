<?php

use function Clue\StreamFilter\fun;

defined('BASEPATH') or exit('No direct script access allowed');

class Pedidos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gv_pedido_model');
        $this->load->library('form_validation');

    }

    private function http_method ($vfMethod) {
        if ($_SERVER['REQUEST_METHOD'] !== $vfMethod) {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['status' => false, 'message' => 'Metodo não permitido']);
            exit;
        }
    }
    public function total($filtro = null) {

        if (!empty($filtro) AND $filtro != 'nacional' AND $filtro != 'internacional') {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(['status' => false, 'message' => 'Página não Encontrada']);
            exit;
        }
        echo json_encode([
            'status' => true,
            'message' => 'sucesso',
            'dados' => $this->Gv_pedido_model->total($filtro)
        ]);
    }
    public function index()
    {
        $this->http_method('GET');

        $pagina = (int) $this->input->get('pagina') ?? 1;
        $limit = (int) $this->input->get('limit') ?? 10;
        $offset = ($pagina - 1) * $limit;
        $pesquisa = $this->input->get('pesquisa') ?? null;

        echo json_encode([
            'status' => true,
            'message' => 'sucesso',
            'dados' => $this->Gv_pedido_model->get($limit, $offset, $pesquisa)
        ]);
    }

    public function show($id)
    {
        $this->http_method('GET');
        echo json_encode([
            'status' => true,
            'dados' => $this->Gv_pedido_model->first($id)
        ]);
    }

    public function enum_valido ($dado) {
        $enum_valido = ['nacional', 'internacional'];

        if (in_array($dado, $enum_valido)) {
            return true;
        }
        return false;
    }
    public function data ($data) {
        $da = DateTime::createFromFormat('Y-m-d', $data);
        if ($da && $da->format('Y-m-d') == $data) {
            return true;
        }
        $this->form_validation->set_message('data', 'Preencha o campo {field} corretamente');
        return false;
    }
    public function datainicio($data) {
        $data_actual = date('Y-m-d');
        if (strtotime($data) <  strtotime($data_actual)) {
            $this->form_validation->set_message('datainicio', 'A {field} não pode ser menor que a data actual');
            return false;
        }
        return true;
    }
    public function  datafim ($data) {
        $data_inicio = $this->input->post('data_inicio');
        if (strtotime($data) < strtotime($data_inicio)) {
            $this->form_validation->set_message('datafim', 'A {field} não pode ser menor que a data inicial');
            return false;
        }
        return true;
    }

    public function create () {
        $this->http_method('POST');

        $enum_valido = ['nacional', 'internacional'];
        $data = [
            'funcionario_id' => $this->input->post('funcionario_id') ?? '',
            'status_id' => $this->input->post('status_id') ?? '',
            'tipo_viagem' => $this->input->post('tipo_viagem') ?? '',
            'objetivo' => $this->input->post('objetivo') ?? '',
            'destino' => $this->input->post('destino') ?? '',
            'data_inicio' => $this->input->post('data_inicio') ?? '',
            'data_fim' => $this->input->post('data_fim') ?? '',
        ];

        // $this->form_validation->set_data($data);
        $this->form_validation->set_rules('funcionario_id', 'Funcionário', 'required', ['required' => 'Selecione o  {field}']);
        $this->form_validation->set_rules('status_id', 'Status', 'required', ['required' => 'Selecione o {field}']);

        // $this->form_validation->set_rules('tipo_viagem', 'Tipo de Viagem', 'required|callback_enum_valido', [
        //     'required' => 'Selecione o {field}',
        //     'callback_enum_valido' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido),
        // ]);

        $this->form_validation->set_rules('tipo_viagem', 'Tipo de Viagem', ['required', [
            'enum', function ($value) use ($enum_valido) {
                return in_array($value, $enum_valido);
            }
        ]], ['required' => 'Selecione o Status', 'enum' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido)]);

        $this->form_validation->set_rules('objetivo', 'Objetivo', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('destino', 'Destino', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('data_inicio', 'Data Início', 'required|callback_data|callback_datainicio', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('data_fim', 'Data Fim', 'required|callback_data|callback_datafim', ['required' => 'Preencha o campo {field}']);


        if (!$this->form_validation->run()) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'erros' => validation_errors()]);
            exit;
        }

        $insert = $this->Gv_pedido_model->create($data);

        header("HTTP/1.1 201 CREATED");
        echo json_encode([
            'status' => true,
            'message' => 'Pedido de Viagem Adicionado com sucesso',
            'dados' => $insert
        ]);
    }

    public function update ($id) {
        $this->http_method('PUT');
        $data_form = $this->input->input_stream();

        $enum_valido = ['nacional', 'internacional'];
        $data = [];

        $this->form_validation->set_data($data_form);
        if (isset($data_form['funcionario_id'])) {
            $this->form_validation->set_rules('funcionario_id', 'Funcionário', 'required', ['required' => 'Selecione o  {field}']);
            $data['funcionario_id'] = $data_form['funcionario_id'];
        }
        if (isset($data_form['status_id'])) {
            $this->form_validation->set_rules('status_id', 'Status', 'required', ['required' => 'Selecione o {field}']);
            $data['status_id'] = $data_form['status_id'];
        }
        if (isset($data_form['tipo_viagem'])) {
            $this->form_validation->set_rules('tipo_viagem', 'Tipo de Viagem', ['required', [
                'enum', function ($value) use ($enum_valido) {
                    return in_array($value, $enum_valido);
                }
            ]], ['required' => 'Selecione o Status', 'enum' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido)]);
            $data['tipo_viagem'] = $data_form['tipo_viagem'];
        }
        if (isset($data_form['objetivo'])) {
            $this->form_validation->set_rules('objetivo', 'Objetivo', 'required', ['required' => 'Preencha o campo {field}']);
            $data['objetivo'] = $data_form['objetivo'];
        }
        if (isset($data_form['destino'])) {
            $this->form_validation->set_rules('destino', 'Destino', 'required', ['required' => 'Preencha o campo {field}']);
            $data['destino'] = $data_form['destino'];
        }
        if (isset($data_form['data_inicio'])) {
            $this->form_validation->set_rules('data_inicio', 'Data Início', 'required|callback_data|callback_datainicio', ['required' => 'Preencha o campo {field}']);
            $data['data_inicio'] = $data_form['data_inicio'];
        }
        if (isset($data_form['data_fim'])) {
            $this->form_validation->set_rules('data_fim', 'Data Fim', 'required|callback_data|callback_datafim', ['required' => 'Preencha o campo {field}']);
            $data['data_fim'] = $data_form['data_fim'];
        }

        if (!$this->form_validation->run()) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'erros' => validation_errors()]);
            exit;
        }

        $insert = $this->Gv_pedido_model->update($data, $id);

        header("HTTP/1.1 200 SUCCESS");
        echo json_encode([
            'status' => true,
            'message' => 'Pedido de Viagem criado com sucesso',
            'dados' => $insert
        ]);
    }
    public function delete ($id) {
        $this->http_method('DELETE');

        $delete = $this->Gv_pedido_model->delete($id);

        echo json_encode([
            'status' => true,
            'message' => 'Pedido de Viagem Eliminado com sucesso',
            'dados' => $delete,
        ]);
    }
}