<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Configuracoes_model extends CI_Model
{
    public function staffs() {
        $query = $this->db->get_where('staff', ['active' => 1]);
        return $query->result_array();
    }
    public function staffs_admin() {
        $query = $this->db->get_where('staff', [
            'admin' => 1,
            'active' => 1,
        ]);
        return $query->result_array();
    }
    public function first_staff($id) {
        $query = $this->db->get_where('staff', ['staffid' => $id]);
        return $query->result_array();
    }

    public function logs_get() {
        $this->db->select('
            activity_log.*
        ');
        $this->db->from('activity_log');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(15);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function marcacoes_get() {
        $this->db->select('
            as_marcacoes.*,
            staff.firstname, staff.lastname,
        ');
        $this->db->from('as_marcacoes');
        $this->db->join('staff', 'staff.staffid = as_marcacoes.fun_id', 'left');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(15);
        $query = $this->db->get()->result_array();
        return $query;
    }

    public function total_modulos() {
        $this->db->where('active', 1);
        $query = $this->db->get('modules')->num_rows();
        return $query;
    }
    public function total_cargos() {
        $query = $this->db->get('hr_job_position')->num_rows();
        return $query;
    }
    public function total_permissoes() {
        $query = $this->db->get('staff_permissions')->num_rows();
        return $query;
    }

    public function total_conselhos() {
        $query = $this->db->get('hr_conselhos')->num_rows();
        return $query;
    }
    public function conselhos_get() {
        $this->db->select('
            hr_conselhos.*,
            staff.firstname, staff.lastname,
        ');
        $this->db->from('hr_conselhos');
        $this->db->join('staff', 'staff.staffid = hr_conselhos.gerente_id', 'left');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function conselho_create($data) {
        $vfarea = $this->db->get_where('hr_conselhos', ['nome' => $data['nome']])->row_array();
        if ($vfarea) {
            set_alert('danger',"Conselho já foi cadastrada");
            redirect('configuracoes/sistema?group=conselhos');
        }
        return $this->db->insert('hr_conselhos', $data);
    }
    public function conselho_first($id) {
        $query = $this->db->get_where('hr_conselhos', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function conselho_update ($data, $id) {
        $this->conselho_first($id);
        $vfnivel_hierarquico = $this->db->get_where('hr_conselhos', ['nome' => $data['nome']])->row_array();
        if ($vfnivel_hierarquico) {
            if ($id != $vfnivel_hierarquico['id']) {
                set_alert('danger',"Conselho já foi cadastrada");
			    redirect('configuracoes/sistema?group=conselhos');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('hr_conselhos', $data);

        return $this->conselho_first($id);
    }
    public function conselho_delete($id) {
        $first = $this->conselho_first($id);
        // Associadas
        $total = $this->db->get_where('hr_pelorios', ['conselho_id' => $id])->num_rows();
        $total += $this->db->get_where('staff', ['conselho_id' => $id])->num_rows();
        if ($total != 0) {
            set_alert('danger',"Existe Conselho associada a este Politica");
			redirect('configuracoes/sistema?group=conselhos');
        }
        $this->db->where('id', $id);
        $this->db->delete('hr_conselhos');
        return $first;
    }

    public function total_pelorios() {
        $query = $this->db->get('hr_pelorios')->num_rows();
        return $query;
    }
    public function pelorios_get() {
        $this->db->select('
            hr_pelorios.*,
            hr_conselhos.nome as conselho,
            staff.firstname, staff.lastname,
        ');
        $this->db->from('hr_pelorios');
        $this->db->join('hr_conselhos', 'hr_conselhos.id = hr_pelorios.conselho_id', 'left');
        $this->db->join('staff', 'staff.staffid = hr_pelorios.gerente_id', 'left');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function pelorio_create($data) {
        $this->conselho_first($data['conselho_id']);
        $vfarea = $this->db->get_where('hr_pelorios', [
            'conselho_id' => $data['conselho_id'],
            'nome' => $data['nome'],
        ])->row_array();
        if ($vfarea) {
            set_alert('danger',"Pelorio já foi cadastrada");
            redirect('configuracoes/sistema?group=pelorios');
        }
        return $this->db->insert('hr_pelorios', $data);
    }
    public function pelorio_first($id) {
        $query = $this->db->get_where('hr_pelorios', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function pelorio_update ($data, $id) {
        $this->pelorio_first($id);
        $this->conselho_first($data['conselho_id']);
        $vf = $this->db->get_where('hr_pelorios', [
            'conselho_id' => $data['conselho_id'],
            'nome' => $data['nome'],
        ])->row_array();
        if ($vf) {
            if ($id != $vf['id']) {
                set_alert('danger',"Pelorio já foi cadastrada");
			    redirect('configuracoes/sistema?group=pelorios');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('hr_pelorios', $data);

        return $this->pelorio_first($id);
    }
    public function pelorio_delete($id) {
        $first = $this->pelorio_first($id);
        // Associadas
        $total = $this->db->get_where('hr_direcoes', ['pelorios_id' => $id])->num_rows();
        $total += $this->db->get_where('staff', ['pelorio_id' => $id])->num_rows();
        if ($total != 0) {
            set_alert('danger',"Existe Pelorio associada a este Politica");
			redirect('configuracoes/sistema?group=pelorios');
        }
        $this->db->where('id', $id);
        $this->db->delete('hr_pelorios');
        return $first;
    }

    public function total_direccoes() {
        $query = $this->db->get('hr_direcoes')->num_rows();
        return $query;
    }
    public function direcao_get() {
        $this->db->select('
            hr_direcoes.*,
            hr_pelorios.nome as pelorio,
            staff.firstname, staff.lastname,
        ');
        $this->db->from('hr_direcoes');
        $this->db->join('hr_pelorios', 'hr_pelorios.id = hr_direcoes.pelorios_id', 'left');
        $this->db->join('staff', 'staff.staffid = hr_direcoes.gerente_id', 'left');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function direcao_create($data) {
        $this->conselho_first($data['pelorios_id']);
        $vf = $this->db->get_where('hr_direcoes', [
            'pelorios_id' => $data['pelorios_id'],
            'nome' => $data['nome'],
        ])->row_array();
        if ($vf) {
            set_alert('danger',"Direção já foi cadastrada");
            redirect('configuracoes/sistema?group=direcoes');
        }
        return $this->db->insert('hr_direcoes', $data);
    }
    public function direcao_first($id) {
        $query = $this->db->get_where('hr_direcoes', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function direcao_update ($data, $id) {
        $this->direcao_first($id);
        $this->pelorio_first($data['pelorios_id']);

        $vf = $this->db->get_where('hr_direcoes', [
            'pelorios_id' => $data['pelorios_id'],
            'nome' => $data['nome'],
        ])->row_array();
        if ($vf) {
            if ($id != $vf['id']) {
                set_alert('danger',"Direção já foi cadastrada");
			    redirect('configuracoes/sistema?group=direcoes');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('hr_direcoes', $data);

        return $this->direcao_first($id);
    }
    public function direcao_delete($id) {
        $first = $this->direcao_first($id);
        // Associadas
        $total = $this->db->get_where('departments', ['direcoes_id' => $id])->num_rows();
        $total += $this->db->get_where('staff', ['direcao_id' => $id])->num_rows();
        if ($total != 0) {
            set_alert('danger',"Existe Pelorio associada a esta Direção");
			redirect('configuracoes/sistema?group=direcoes');
        }
        $this->db->where('id', $id);
        $this->db->delete('hr_direcoes');
        return $first;
    }

    public function total_departamentos() {
        $query = $this->db->get('departments')->num_rows();
        return $query;
    }
    public function departamento_get() {
        $this->db->select('
            departments.*,
            hr_direcoes.nome as direcao,
            staff.firstname, staff.lastname,
        ');
        $this->db->from('departments');
        $this->db->join('hr_direcoes', 'hr_direcoes.id = departments.direcoes_id', 'left');
        $this->db->join('staff', 'staff.staffid = departments.gerente_id', 'left');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function departamento_create($data) {
        $this->direcao_first($data['direcoes_id']);
        $vf = $this->db->get_where('departments', [
            'direcoes_id' => $data['direcoes_id'],
            'name' => $data['name'],
        ])->row_array();
        if ($vf) {
            set_alert('danger',"Departamento já foi cadastrada");
            redirect('configuracoes/sistema?group=departamentos');
        }
        return $this->db->insert('departments', $data);
    }
    public function departamento_first($id) {
        $query = $this->db->get_where('departments', ['departmentid' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function departamento_update ($data, $id) {
        $this->departamento_first($id);
        $this->direcao_first($data['direcoes_id']);
        $vf = $this->db->get_where('departments', [
            'direcoes_id' => $data['direcoes_id'],
            'name' => $data['name'],
        ])->row_array();
        if ($vf) {
            if ($id != $vf['departmentid']) {
                set_alert('danger',"Direção já foi cadastrada");
			    redirect('configuracoes/sistema?group=departamentos');
            }
        }
        $this->db->where('departmentid', $id);
        $this->db->update('departments', $data);

        return $this->departamento_first($id);
    }
    public function departamento_delete($id) {
        $first = $this->departamento_first($id);
        $total = $this->db->get_where('hr_seccoes', ['departments_id' => $id])->num_rows();
        $total += $this->db->get_where('staff', ['departamento_id' => $id])->num_rows();
        if ($total != 0) {
            set_alert('danger',"Existe Pelorio associada a esta Departamento");
			redirect('configuracoes/sistema?group=departamentos');
        }
        $this->db->where('departmentid', $id);
        $this->db->delete('departments');
        return $first;
    }

    public function total_seccoes() {
        $query = $this->db->get('hr_seccoes')->num_rows();
        return $query;
    }
    public function seccao_get() {
        $this->db->select('
            hr_seccoes.*,
            departments.name as departamento,
            staff.firstname, staff.lastname,
        ');
        $this->db->from('hr_seccoes');
        $this->db->join('departments', 'departments.departmentid = hr_seccoes.departments_id', 'left');
        $this->db->join('staff', 'staff.staffid = hr_seccoes.gerente_id', 'left');
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function seccao_create($data) {
        $this->departamento_first($data['departments_id']);
        $vf = $this->db->get_where('hr_seccoes', [
            'departments_id' => $data['departments_id'],
            'nome' => $data['nome'],
        ])->row_array();
        if ($vf) {
            set_alert('danger',"Departamento já foi cadastrada");
            redirect('configuracoes/sistema?group=seccoes');
        }
        return $this->db->insert('hr_seccoes', $data);
    }
    public function seccao_first($id) {
        $query = $this->db->get_where('hr_seccoes', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function seccao_update ($data, $id) {
        $this->seccao_first($id);
        $this->departamento_first($data['departments_id']);
        $vf = $this->db->get_where('hr_seccoes', [
            'departments_id' => $data['departments_id'],
            'nome' => $data['nome'],
        ])->row_array();
        if ($vf) {
            if ($id != $vf['id']) {
                set_alert('danger',"Secção já foi cadastrada");
			    redirect('configuracoes/sistema?group=seccoes');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('hr_seccoes', $data);

        return $this->seccao_first($id);
    }
    public function seccao_delete($id) {
        $first = $this->departamento_first($id);
        $total = 0;
        $total += $this->db->get_where('staff', ['seccao_id' => $id])->num_rows();
        if ($total != 0) {
            set_alert('danger',"Existe Pelorio associada a esta Secção");
			redirect('configuracoes/sistema?group=seccoes');
        }
        $this->db->where('id', $id);
        $this->db->delete('hr_seccoes');
        return $first;
    }
}