<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Gv_staff_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function verificados ($id) {
        $this->db->select('staff_id_viagem');
        $this->db->from('gv_staff_viagem');
        $this->db->where('pedido_viagem_id', $id);
        $query = $this->db->get();
        return array_column($query->result_array(), 'staff_id_viagem');
    }

    public function total($id)
    {
        $query = $this->db->where('pedido_viagem_id', $id)->get('gv_staff_viagem');
        return $query->num_rows();
    }

    public function staff_get($id) {
        $ids_staffs = $this->verificados($id);

        $this->db->select('*');
        $this->db->from('staff');
        if ($ids_staffs) {
            $this->db->where_not_in('staffid', $ids_staffs);
        }
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function get($id)
    {
        $this->db->select('gv_staff_viagem.*, staff.staffid, staff.firstname, staff.lastname');
        $this->db->from('gv_staff_viagem');
        $this->db->join('staff', 'staff.staffid = gv_staff_viagem.staff_id_viagem');
        $this->db->where('gv_staff_viagem.pedido_viagem_id', $id);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function first($dados) {
        $query = $this->db->get_where('gv_staff_viagem', ['id' => $dados['id'], 'pedido_viagem_id' => $dados['pedido_viagem_id']])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function create($data) {
        $query = $this->db->get_where('gv_staff_viagem', ['staff_id_viagem' => $data['staff_id_viagem'], 'pedido_viagem_id' => $data['pedido_viagem_id']])->row_array();
        if ($query) {
            return false;
        }
        return $this->db->insert('gv_staff_viagem', $data);
    }

    public function delete ($dado) {
        $first = $this->first($dado);

        $this->db->where('id', $dado['id']);
        $this->db->delete('gv_staff_viagem');

        return $first;
    }
}