<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Gv_status_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = NULL)
    {
        $query = $this->db->get('gv_status');
        return $query->result_array();
    }

    public function first($id) {
        $query = $this->db->get_where('gv_status', ['id' => $id])->row_array();
        if (!$query) {
            header("HTTP/1.1 404 NOT FOUND");
            echo json_encode(['status' => false, 'message' => 'Dados não encontrado']);
            exit;
        }
        return $query;
    }

    public function create($data) {
        $vfstatus = $this->db->get_where('gv_status', ['status' => $data['status']])->row_array();
        if ($vfstatus) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'message' => 'Status já foi cadastrado.']);
            exit;
        }
        return $this->db->insert('gv_status', $data);
    }

    public function update ($id, $data) {
        $vfstatus = $this->db->get_where('gv_status', ['status' => $data['status']])->row_array();
        if ($vfstatus) {
            if ($id != $vfstatus['id']) {
                header("HTTP/1.1 400 BAD REQUEST");
                echo json_encode(['status' => false, 'message' => 'Status já foi cadastrado.']);
                exit;
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gv_status', $data);

        return $this->first($id);
    }

    public function delete ($id) {
        $vfstatus = $this->first($id);

        $this->db->where('id', $id);
        $this->db->delete('gv_status');

        return $vfstatus;
    }
}