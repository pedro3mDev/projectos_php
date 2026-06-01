<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Gv_equipa_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function total($id)
    {
        $query = $this->db->where('pedido_viagem_id', $id)->get('gv_equipa_viagem');
        return $query->num_rows();
    }

    public function get($id)
    {
        $query = $this->db->where('pedido_viagem_id', $id)->get('gv_equipa_viagem');
        return $query->result_array();
    }

    public function first($dados) {
        if (!isset($dados['id_pedido']) OR !isset($dados['id_equipa'])) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'message' => 'Dados não encontrado']);
            exit;
        }
        $query = $this->db->get_where('gv_equipa_viagem', ['id' => $dados['id_equipa'], 'pedido_viagem_id' => $dados['id_pedido']])->row_array();
        if (!$query) {
            header("HTTP/1.1 404 NOT FOUND");
            echo json_encode(['status' => false, 'message' => 'Membro da Equipa de Viagem não encontrado']);
            exit;
        }
        return $query;
    }

    public function create($data) {
        $query = $this->db->get_where('gv_equipa_viagem', ['funcionario_id' => $data['funcionario_id'], 'pedido_viagem_id' => $data['pedido_viagem_id']])->row_array();
        if ($query) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'message' => 'Membro da Equipa já Adicionado']);
            exit;
        }
        return $this->db->insert('gv_equipa_viagem', $data);
    }
    public function update($data, $id)  {
        $query = $this->db->get_where('gv_equipa_viagem', ['funcionario_id' => $data['funcionario_id'], 'pedido_viagem_id' => $data['pedido_viagem_id']])->row_array();
        if ($query) {
            if ($query['id'] != $id) {
                header("HTTP/1.1 400 BAD REQUEST");
                echo json_encode(['status' => false, 'message' => 'Membro da Equipa já Adicionado']);
                exit;
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gv_equipa_viagem', $data);

        return $this->first([
            'id_pedido' => $data['pedido_viagem_id'],
            'id_equipa' => $id
        ]);
    }

    public function delete ($dado) {
        $first = $this->first($dado);

        $this->db->where('id', $dado['id_equipa']);
        $this->db->delete('gv_equipa_viagem');

        return $first;
    }
}