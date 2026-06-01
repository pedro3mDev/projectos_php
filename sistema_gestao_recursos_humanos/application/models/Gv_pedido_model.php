<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Gv_pedido_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function total($filtro = null) {
        if ($filtro != null AND $filtro != 'nacional' AND $filtro != 'internacional') {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(['status' => false, 'message' => 'Página não Encontrada']);
            exit;
        }
        if ($filtro != null) {
            $this->db->where('tipo_viagem', $filtro);
        }

        $query = $this->db->get('gv_pedido_viagem')->num_rows();
        return $query;
    }

    public function get($limit = NULL, $offset = null, $pesquisa = null)
    {
        if ($limit) {
            if ($offset) {
                $this->db->limit($limit, $offset);
            }
            else {
                $this->db->limit($limit);
            }
        }
        if ($pesquisa) {
            $this->db->like('objetivo', $pesquisa);
            $this->db->or_like('destino', $pesquisa);
        }

        $query = $this->db->get('gv_pedido_viagem');
        return $query->result_array();
    }

    public function first($id) {
        $query = $this->db->get_where('gv_pedido_viagem', ['id' => $id])->row_array();
        if (!$query) {
            header("HTTP/1.1 404 NOT FOUND");
            echo json_encode(['status' => false, 'message' => 'Pedido de Viagem não encontrado']);
            exit;
        }
        return $query;
    }

    public function create($data) {
        return $this->db->insert('gv_pedido_viagem', $data);
    }
    public function update($data, $id)  {
        $this->db->where('id', $id);
        $this->db->update('gv_pedido_viagem', $data);

        return $this->first($id);
    }

    public function delete ($id) {
        $first = $this->first($id);

        $this->db->where('id', $id);
        $this->db->delete('gv_pedido_viagem');

        return $first;
    }
}