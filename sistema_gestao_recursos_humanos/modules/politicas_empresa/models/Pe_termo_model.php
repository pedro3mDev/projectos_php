<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pe_termo_model extends CI_Model
{
    public function total() {
        $query = $this->db->get('pe_termo')->num_rows();
        return $query;
    }
    public function total_confidencialidade() {
        $query = $this->db->get_where()('pe_termo', ['tipo_termo' => 'confidencialidade'])->num_rows();
        return $query;
    }
    public function total_conformidade() {
        $query = $this->db->get_where()('pe_termo', ['tipo_termo' => 'conformidade'])->num_rows();
        return $query;
    }
    public function create($data) {
        $vfCategoria = $this->db->get_where('pe_termo', [
            'staff_id' => $data['staff_id'],
            'politica_id' => $data['politica_id'],
            'tipo_termo' => $data['tipo_termo'],
        ])->row_array();
        if ($vfCategoria) {
            set_alert('danger',"Termo já foi cadastrada");
            if ($data['tipo_termo'] == 'conformidade') {
                redirect('politicas_empresa/seguranca_escritorio/nova_termo_conformidade');
            }
            else {
                redirect('politicas_empresa/politicas_confidencialidade/adicionar_termo');
            }
        }
        return $this->db->insert('pe_termo', $data);
    }
    public function get($tipo = null) {
        $this->db->select('pe_termo.*, staff.staffid, staff.firstname, staff.lastname, pe_politica.titulo');
        $this->db->from('pe_termo');
        $this->db->join('staff', 'staff.staffid = pe_termo.staff_id');
        $this->db->join('pe_politica', 'pe_politica.id = pe_termo.politica_id');

        if ($tipo != null AND $tipo == 'conformidade' OR $tipo == 'confidencialidade') {
            $this->db->where('pe_termo.tipo_termo', $tipo);
        }
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function first($id) {
        $this->db->select('pe_termo.*, staff.staffid, staff.firstname, staff.lastname, pe_politica.titulo');
        $this->db->from('pe_termo');
        $this->db->join('staff', 'staff.staffid = pe_termo.staff_id');
        $this->db->join('pe_politica', 'pe_politica.id = pe_termo.politica_id');
        $this->db->where('pe_termo.id', $id);

        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function delete($id) {
        $first = $this->first($id);

        $this->db->where('id', $id);
        $this->db->delete('pe_termo');
        return $first;
    }
    public function update ($data, $id) {
        $this->first($id);
        $vfter = $this->db->get_where('pe_termo', [
            'staff_id' => $data['staff_id'],
            'politica_id' => $data['politica_id'],
            'tipo_termo' => $data['tipo_termo'],
        ])->row_array();
        if ($vfter) {
            if ($id != $vfter['id']) {
                set_alert('danger',"Termo já foi cadastrada");
                if ($vfter['tipo_termo'] == 'conformidade') {
                    redirect('politicas_empresa/seguranca_escritorio/conformidade_editar/'.$id);
                }
                else {
                    redirect('politicas_empresa/politicas_confidencialidade/confidencialidade_editar/'.$id);
                }
            }
        }
        $this->db->where('id', $id);
        $this->db->update('pe_termo', $data);

        return $this->first($id);
    }
}