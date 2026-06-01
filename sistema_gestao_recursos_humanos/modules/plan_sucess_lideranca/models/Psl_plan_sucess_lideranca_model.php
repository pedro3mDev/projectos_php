<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Psl_plan_sucess_lideranca_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function staffs() {
        $query = $this->db->get_where('staff', ['active' => 1]);
        return $query->result_array();
    }
    public function cargos_get() {
        $query = $this->db->get('hr_job_position');
        return $query->result_array();
    }
    public function staffs_admin() {
        $query = $this->db->get_where('staff', [
            'admin' => 1,
            'active' => 1,
        ]);
        return $query->result_array();
    }
    public function get_desempenho () {
        return $this->db->get('psl_desempenho')->result_array();
    }
    public function get_potencial () {
        return $this->db->get('psl_potencial')->result_array();
    }
    public function get_nivel_critico () {
        return $this->db->get('psl_nivel_critico')->result_array();
    }
    public function get_status () {
        return $this->db->get('psl_status')->result_array();
    }
    public function get_feedback () {
        return $this->db->get('psl_feedback')->result_array();
    }
    public function get_impacto () {
        return $this->db->get('psl_impacto')->result_array();
    }
    public function get_nivel_risco () {
        return $this->db->get('psl_nivel_risco')->result_array();
    }

    public function get_competencia () {
        return $this->db->get('psl_competencia')->result_array();
    }
    public function create_competencia($data)
    {
        $vf_existe = $this->db->get_where('psl_competencia', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            set_alert('danger',"Competência já foi cadastrada");
            redirect('plan_sucess_lideranca/configuracoes?group=competencia');
        }
        return $this->db->insert('psl_competencia', $data);
    }
    public function first_competencia($id) {
        $query = $this->db->get_where('psl_competencia', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_competencia ($data, $id) {
        $this->first_competencia($id);
        $vf_existe = $this->db->get_where('psl_competencia', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Competência já foi cadastrada");
			    redirect('plan_sucess_lideranca/configuracoes?group=competencia');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('psl_competencia', $data);

        return $this->first_competencia($id);
    }
    public function delete_competencia($id) {
        $first = $this->first_competencia($id);

        // $total = 0;
        // $total += $this->db->get_where('gv_pedido_viagem',  ['categoria_id' => $id])->num_rows();
        // if ($total) {
        //     set_alert('danger',"Existe Pedido de Viagem associada com esta Categória");
		//  	redirect('plan_sucess_lideranca/configuracoes?group=competencia');
        // }
        $this->db->where('id', $id);
        $this->db->delete('psl_competencia');
        return $first;
    }

    public function ultimo_id($data) {
        $this->db->where('status_id', $data['status_id']);
        $this->db->where('staff_id', $data['staff_id']);
        $this->db->where('potencial_id', $data['potencial_id']);
        $this->db->where('desempenho_id', $data['desempenho_id']);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('psl_talento');
        return $query->row_array();
    }
    public function create_talento_competencia($dados) {
        $query = $this->db->get_where('psl_talento_competencia', ['competencia_id' => $dados['competencia_id'], 'talento_id' => $dados['talento_id']])->row_array();
        if (!$query) {
            return $this->db->insert('psl_talento_competencia', $dados);
        }
    }

    public function talento_total($status = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        $query = $this->db->get('psl_talento')->num_rows();
        return $query;
    }
    public function talento_create($data, $competencias)
    {
        $inserir = $this->db->insert('psl_talento', $data);
        if ($inserir) {
            $id = $this->ultimo_id($data);
            foreach ($competencias as $a) {
                $this->create_talento_competencia([
                    'competencia_id' => $a,
                    'talento_id' => $id['id']
                ]);
            }
        }
    }
    public function talento_get($status = NULL)
    {
        $this->db->select('
            psl_talento.*,
            staff.*,
            psl_desempenho.nome as desempenho,
            psl_potencial.nome as potencial,
            psl_status.status,
        ');
        $this->db->from('psl_talento');
        $this->db->join('staff', 'staff.staffid = psl_talento.staff_id', 'left');
        $this->db->join('psl_desempenho', 'psl_desempenho.id = psl_talento.desempenho_id', 'left');
        $this->db->join('psl_potencial', 'psl_potencial.id = psl_talento.potencial_id', 'left');
        $this->db->join('psl_status', 'psl_status.id = psl_talento.status_id', 'left');
        if ($status) {
            $this->db->where('psl_talento.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function talento_first($id)
    {
        $this->db->select('
            psl_talento.*,
            staff.*,
            psl_desempenho.nome as desempenho,
            psl_potencial.nome as potencial,
            psl_status.status,
        ');
        $this->db->from('psl_talento');
        $this->db->join('staff', 'staff.staffid = psl_talento.staff_id', 'left');
        $this->db->join('psl_desempenho', 'psl_desempenho.id = psl_talento.desempenho_id', 'left');
        $this->db->join('psl_potencial', 'psl_potencial.id = psl_talento.potencial_id', 'left');
        $this->db->join('psl_status', 'psl_status.id = psl_talento.status_id', 'left');
        $this->db->where('psl_talento.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function delete_competencias_telanto($id, $competencias_id) {
        $this->db->select('*');
        $this->db->from('psl_talento_competencia');
        $this->db->where('talento_id', $id);
        $this->db->where_not_in('competencia_id', $competencias_id);
        return $this->db->delete();
    }
    public function talento_update($data, $competencias, $id)
    {
        $this->talento_first($id);
        $this->db->where('id', $id);
        $this->db->update('psl_talento', $data);

        // Eliminar os competencias que nao existem e adicionar os novos
        $this->delete_competencias_telanto($id, $competencias);
        foreach ($competencias as $a) {
            $this->create_talento_competencia([
                'competencia_id' => $a,
                'talento_id' => $id
            ]);
        }
        return $this->talento_first($id);
    }
    public function talento_delete($id)
    {
        $first = $this->talento_first($id);

        // $total = 0;
        // $total += $this->db->get_where('gv_reserva',  ['pedido_viagem_id' => $id])->num_rows();
        // if ($total) {
        //     set_alert('danger',"Existe Reserva associadas com este Pedido");
		//  	redirect('gestao_viagens/pedidos');
        // }

        $this->db->where('id', $id);
        $this->db->delete('psl_talento');

        return $first;
    }
    public function talento_update_status($data, $id)
    {
        $this->talento_first($id);
        $this->db->where('id', $id);
        $this->db->update('psl_talento', $data);
        return $this->talento_first($id);
    }

    public function avaliacao_competencias_total($status = null, $nota_resticao = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        if ($nota_resticao != null) {
            $this->db->where("nota " . $nota_resticao['res'], $nota_resticao['nota']);
        }
        $query = $this->db->get('psl_avaliacao_competencia')->num_rows();
        return $query;
    }
    public function avaliacao_competencias_create($data)
    {
        return $this->db->insert('psl_avaliacao_competencia', $data);
    }
    public function avaliacao_competencias_get($status = NULL)
    {
        $this->db->select('
            psl_avaliacao_competencia.*,
            staff.*,
            psl_competencia.nome as competencia,
            psl_status.status,
        ');
        $this->db->from('psl_avaliacao_competencia');
        $this->db->join('staff', 'staff.staffid = psl_avaliacao_competencia.staff_id', 'left');
        $this->db->join('psl_competencia', 'psl_competencia.id = psl_avaliacao_competencia.competencia_id', 'left');
        $this->db->join('psl_status', 'psl_status.id = psl_avaliacao_competencia.status_id', 'left');
        if ($status) {
            $this->db->where('psl_avaliacao_competencia.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function avaliacao_competencias_first($id)
    {
        $this->db->select('
            psl_avaliacao_competencia.*,
            staff.*,
            psl_competencia.nome as competencia,
            psl_status.status,
        ');
        $this->db->from('psl_avaliacao_competencia');
        $this->db->join('staff', 'staff.staffid = psl_avaliacao_competencia.staff_id', 'left');
        $this->db->join('psl_competencia', 'psl_competencia.id = psl_avaliacao_competencia.competencia_id', 'left');
        $this->db->join('psl_status', 'psl_status.id = psl_avaliacao_competencia.status_id', 'left');
        $this->db->where('psl_avaliacao_competencia.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function avaliacao_competencias_update ($data, $id) {
        $this->avaliacao_competencias_first($id);

        $this->db->where('id', $id);
        $this->db->update('psl_avaliacao_competencia', $data);

        return $this->avaliacao_competencias_first($id);
    }
    public function avaliacao_competencias_delete($id)
    {
        $first = $this->avaliacao_competencias_first($id);

        // $total = 0;
        // $total += $this->db->get_where('gv_reserva',  ['pedido_viagem_id' => $id])->num_rows();
        // if ($total) {
        //     set_alert('danger',"Existe Reserva associadas com este Pedido");
		//  	redirect('gestao_viagens/pedidos');
        // }

        $this->db->where('id', $id);
        $this->db->delete('psl_avaliacao_competencia');

        return $first;
    }
    public function avaliacao_competencias_update_status($data, $id)
    {
        $this->avaliacao_competencias_first($id);
        $this->db->where('id', $id);
        $this->db->update('psl_avaliacao_competencia', $data);

        return $this->avaliacao_competencias_first($id);
    }

    public function potencial_desenvolvimento_total($status = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        $query = $this->db->get('psl_potencial_desenvolvimento')->num_rows();
        return $query;
    }
    public function potencial_desenvolvimento_get($status = NULL)
    {
        $this->db->select('
            psl_potencial_desenvolvimento.*,
            staff.*,
            psl_potencial.nome as potencial,
            psl_status.status,
        ');
        $this->db->from('psl_potencial_desenvolvimento');
        $this->db->join('staff', 'staff.staffid = psl_potencial_desenvolvimento.staff_id', 'left');
        $this->db->join('psl_potencial', 'psl_potencial.id = psl_potencial_desenvolvimento.potencial_id', 'left');
        $this->db->join('psl_status', 'psl_status.id = psl_potencial_desenvolvimento.status_id', 'left');
        if ($status) {
            $this->db->where('psl_potencial_desenvolvimento.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function potencial_desenvolvimento_first($id)
    {
        $this->db->select('
            psl_potencial_desenvolvimento.*,
            staff.*,
            psl_potencial.nome as potencial,
            psl_status.status,
        ');
        $this->db->from('psl_potencial_desenvolvimento');
        $this->db->join('staff', 'staff.staffid = psl_potencial_desenvolvimento.staff_id', 'left');
        $this->db->join('psl_potencial', 'psl_potencial.id = psl_potencial_desenvolvimento.potencial_id', 'left');
        $this->db->join('psl_status', 'psl_status.id = psl_potencial_desenvolvimento.status_id', 'left');
        $this->db->where('psl_potencial_desenvolvimento.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function potencial_desenvolvimento_create($data)
    {
        return $this->db->insert('psl_potencial_desenvolvimento', $data);
    }
    public function potencial_desenvolvimento_update ($data, $id) {
        $this->potencial_desenvolvimento_first($id);

        $this->db->where('id', $id);
        $this->db->update('psl_potencial_desenvolvimento', $data);

        return $this->potencial_desenvolvimento_first($id);
    }
    public function potencial_desenvolvimento_delete($id)
    {
        $first = $this->potencial_desenvolvimento_first($id);

        // $total = 0;
        // $total += $this->db->get_where('gv_reserva',  ['pedido_viagem_id' => $id])->num_rows();
        // if ($total) {
        //     set_alert('danger',"Existe Reserva associadas com este Pedido");
		//  	redirect('gestao_viagens/pedidos');
        // }

        $this->db->where('id', $id);
        $this->db->delete('psl_potencial_desenvolvimento');

        return $first;
    }
    public function potencial_desenvolvimento_update_status($data, $id)
    {
        $this->potencial_desenvolvimento_first($id);
        $this->db->where('id', $id);
        $this->db->update('psl_potencial_desenvolvimento', $data);

        return $this->potencial_desenvolvimento_first($id);
    }

    public function mapa_sucessao_total($status = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        $query = $this->db->get('psl_mapa_sucessao')->num_rows();
        return $query;
    }
    public function mapa_sucessao_get($status = NULL)
    {
        $this->db->select('
            psl_mapa_sucessao.*,
            hr_job_position.position_name as cargo,
            psl_competencia.nome as competencia,
            psl_status.status,
        ');
        $this->db->from('psl_mapa_sucessao');
        $this->db->join('hr_job_position', 'hr_job_position.position_id  = psl_mapa_sucessao.cargo_id', 'left');
        $this->db->join('psl_competencia', 'psl_competencia.id = psl_mapa_sucessao.competencia_id', 'left');
        $this->db->join('psl_status', 'psl_status.id = psl_mapa_sucessao.status_id', 'left');
        if ($status) {
            $this->db->where('psl_mapa_sucessao.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function mapa_sucessao_first($id)
    {
        $this->db->select('
            psl_mapa_sucessao.*,
            hr_job_position.position_name as cargo,
            psl_status.status,
            
            psl_competencia.nome as competencia,
        ');
        $this->db->from('psl_mapa_sucessao');
        $this->db->join('hr_job_position', 'hr_job_position.position_id  = psl_mapa_sucessao.cargo_id', 'left');
        $this->db->join('psl_competencia', 'psl_competencia.id = psl_mapa_sucessao.competencia_id', 'left');
        $this->db->join('psl_status', 'psl_status.id = psl_mapa_sucessao.status_id', 'left');
        $this->db->where('psl_mapa_sucessao.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function mapa_sucessao_create($data)
    {
        return $this->db->insert('psl_mapa_sucessao', $data);
    }
    public function mapa_sucessao_update ($data, $id) {
        $this->mapa_sucessao_first($id);
        $this->db->where('id', $id);
        $this->db->update('psl_mapa_sucessao', $data);
        return $this->mapa_sucessao_first($id);
    }
    public function mapa_sucessao_update_status($data, $id)
    {
        $this->mapa_sucessao_first($id);
        $this->db->where('id', $id);
        $this->db->update('psl_mapa_sucessao', $data);

        return $this->mapa_sucessao_first($id);
    }
    public function mapa_sucessao_delete($id)
    {
        $first = $this->mapa_sucessao_first($id);

        // $total = 0;
        // $total += $this->db->get_where('gv_reserva',  ['pedido_viagem_id' => $id])->num_rows();
        // if ($total) {
        //     set_alert('danger',"Existe Reserva associadas com este Pedido");
		//  	redirect('gestao_viagens/pedidos');
        // }
        $this->db->where('id', $id);
        $this->db->delete('psl_mapa_sucessao');

        return $first;
    }

    public function plano_desenvolvimento_total($status = NULL, $nivel_critico = NULL)
    {
        $this->db->select('
            psl_plano_desenvolvimento.*,
            staff.*,
            psl_status.status,

            psl_mapa_sucessao.id as mapa_id,
            hr_job_position.position_name as cargo,
            psl_competencia.nome as competencia,

            psl_posicao_chave.nome as posicao_chave, psl_posicao_chave.descricao as p_descricao,
            psl_nivel_critico.nome as nivel_critico,
        ');
        $this->db->from('psl_plano_desenvolvimento');
        $this->db->join('staff', 'staff.staffid = psl_plano_desenvolvimento.staff_id', 'left');
        $this->db->join('psl_status', 'psl_status.id = psl_plano_desenvolvimento.status_id', 'left');

        $this->db->join('psl_mapa_sucessao', 'psl_mapa_sucessao.id = psl_plano_desenvolvimento.mapa_sucessao_id', 'left');
        $this->db->join('hr_job_position', 'hr_job_position.position_id  = psl_mapa_sucessao.cargo_id', 'left');
        $this->db->join('psl_competencia', 'psl_competencia.id = psl_mapa_sucessao.competencia_id', 'left');

        $this->db->join('psl_posicao_chave', 'psl_posicao_chave.id = psl_plano_desenvolvimento.posicao_chave_id', 'left');
        $this->db->join('psl_nivel_critico', 'psl_nivel_critico.id = psl_posicao_chave.nivel_critico_id', 'left');
        if ($status) {
            $this->db->where('psl_plano_desenvolvimento.status_id', $status);
        }
        if ($nivel_critico) {
            $this->db->where('psl_nivel_critico.nome', $nivel_critico);
        }
        return $this->db->get()->num_rows();
    }
    public function plano_desenvolvimento_get($status = NULL)
    {
        $this->db->select('
            psl_plano_desenvolvimento.*,
            staff.*,
            psl_status.status,

            psl_mapa_sucessao.id as mapa_id,
            hr_job_position.position_name as cargo,
            psl_competencia.nome as competencia,

            psl_posicao_chave.nome as posicao_chave, psl_posicao_chave.descricao as p_descricao,
            psl_nivel_critico.nome as nivel_critico,
        ');
        $this->db->from('psl_plano_desenvolvimento');
        $this->db->join('staff', 'staff.staffid = psl_plano_desenvolvimento.staff_id', 'left');
        $this->db->join('psl_status', 'psl_status.id = psl_plano_desenvolvimento.status_id', 'left');

        $this->db->join('psl_mapa_sucessao', 'psl_mapa_sucessao.id = psl_plano_desenvolvimento.mapa_sucessao_id', 'left');
        $this->db->join('hr_job_position', 'hr_job_position.position_id  = psl_mapa_sucessao.cargo_id', 'left');
        $this->db->join('psl_competencia', 'psl_competencia.id = psl_mapa_sucessao.competencia_id', 'left');

        $this->db->join('psl_posicao_chave', 'psl_posicao_chave.id = psl_plano_desenvolvimento.posicao_chave_id', 'left');
        $this->db->join('psl_nivel_critico', 'psl_nivel_critico.id = psl_posicao_chave.nivel_critico_id', 'left');
        if ($status) {
            $this->db->where('psl_plano_desenvolvimento.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function plano_desenvolvimento_first($id)
    {
        $this->db->select('
            psl_plano_desenvolvimento.*,
            staff.*,
            psl_status.status,

            psl_mapa_sucessao.id as mapa_id,
            hr_job_position.position_name as cargo,
            psl_competencia.nome as competencia,

            psl_posicao_chave.nome as posicao_chave, psl_posicao_chave.descricao as p_descricao,
            psl_nivel_critico.nome as nivel_critico,
        ');
        $this->db->from('psl_plano_desenvolvimento');
        $this->db->join('staff', 'staff.staffid = psl_plano_desenvolvimento.staff_id', 'left');
        $this->db->join('psl_status', 'psl_status.id = psl_plano_desenvolvimento.status_id', 'left');

        $this->db->join('psl_mapa_sucessao', 'psl_mapa_sucessao.id = psl_plano_desenvolvimento.mapa_sucessao_id', 'left');
        $this->db->join('hr_job_position', 'hr_job_position.position_id  = psl_mapa_sucessao.cargo_id', 'left');
        $this->db->join('psl_competencia', 'psl_competencia.id = psl_mapa_sucessao.competencia_id', 'left');

        $this->db->join('psl_posicao_chave', 'psl_posicao_chave.id = psl_plano_desenvolvimento.posicao_chave_id', 'left');
        $this->db->join('psl_nivel_critico', 'psl_nivel_critico.id = psl_posicao_chave.nivel_critico_id', 'left');

        $this->db->where('psl_plano_desenvolvimento.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function plano_desenvolvimento_create($data)
    {
        return $this->db->insert('psl_plano_desenvolvimento', $data);
    }
    public function plano_desenvolvimento_update ($data, $id) {
        $this->plano_desenvolvimento_first($id);
        $this->db->where('id', $id);
        $this->db->update('psl_plano_desenvolvimento', $data);
        return $this->plano_desenvolvimento_first($id);
    }
    public function plano_desenvolvimento_delete($id)
    {
        $first = $this->plano_desenvolvimento_first($id);

        // $total = 0;
        // $total += $this->db->get_where('gv_reserva',  ['pedido_viagem_id' => $id])->num_rows();
        // if ($total) {
        //     set_alert('danger',"Existe Reserva associadas com este Pedido");
		//  	redirect('gestao_viagens/pedidos');
        // }
        $this->db->where('id', $id);
        $this->db->delete('psl_plano_desenvolvimento');

        return $first;
    }

    public function posicao_chave_get($nivel_critico = NULL)
    {
        $this->db->select('
            psl_posicao_chave.*,
            psl_nivel_critico.nome as nivel_critico,
        ');
        $this->db->from('psl_posicao_chave');
        $this->db->join('psl_nivel_critico', 'psl_nivel_critico.id = psl_posicao_chave.nivel_critico_id', 'left');
        if ($nivel_critico) {
            $this->db->where('psl_posicao_chave.nivel_critico_id', $nivel_critico);
        }
        return $this->db->get()->result_array();
    }
    public function posicao_chave_first($id)
    {
        $this->db->select('
            psl_posicao_chave.*,
            psl_nivel_critico.nome as nivel_critico,
        ');
        $this->db->from('psl_posicao_chave');
        $this->db->join('psl_nivel_critico', 'psl_nivel_critico.id = psl_posicao_chave.nivel_critico_id', 'left');
        $this->db->where('psl_posicao_chave.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function posicao_chave_create($data)
    {
        return $this->db->insert('psl_posicao_chave', $data);
    }
    public function posicao_chave_update ($data, $id) {
        $this->posicao_chave_first($id);
        $this->db->where('id', $id);
        $this->db->update('psl_posicao_chave', $data);
        return $this->posicao_chave_first($id);
    }
    public function posicao_chave_delete($id)
    {
        $first = $this->posicao_chave_first($id);

        // $total = 0;
        // $total += $this->db->get_where('gv_reserva',  ['pedido_viagem_id' => $id])->num_rows();
        // if ($total) {
        //     set_alert('danger',"Existe Reserva associadas com este Pedido");
		//  	redirect('gestao_viagens/pedidos');
        // }
        $this->db->where('id', $id);
        $this->db->delete('psl_posicao_chave');

        return $first;
    }

    public function programa_lideranca_total($status = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        $query = $this->db->get('psl_programa_lideranca')->num_rows();
        return $query;
    }
    public function programa_lideranca_get($status = NULL)
    {
        $this->db->select('
            psl_programa_lideranca.*,
            psl_status.status,
        ');
        $this->db->from('psl_programa_lideranca');
        $this->db->join('psl_status', 'psl_status.id = psl_programa_lideranca.status_id', 'left');
        if ($status) {
            $this->db->where('psl_programa_lideranca.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function programa_lideranca_first($id)
    {
        $this->db->select('
            psl_programa_lideranca.*,
            psl_status.status,
        ');
        $this->db->from('psl_programa_lideranca');
        $this->db->join('psl_status', 'psl_status.id = psl_programa_lideranca.status_id', 'left');
        $this->db->where('psl_programa_lideranca.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function programa_lideranca_create($data)
    {
        return $this->db->insert('psl_programa_lideranca', $data);
    }
    public function programa_lideranca_update ($data, $id) {
        $this->programa_lideranca_first($id);
        $this->db->where('id', $id);
        $this->db->update('psl_programa_lideranca', $data);
        return $this->programa_lideranca_first($id);
    }
    public function programa_lideranca_delete($id)
    {
        $first = $this->programa_lideranca_first($id);

        // $total = 0;
        // $total += $this->db->get_where('gv_reserva',  ['pedido_viagem_id' => $id])->num_rows();
        // if ($total) {
        //     set_alert('danger',"Existe Reserva associadas com este Pedido");
		//  	redirect('gestao_viagens/pedidos');
        // }
        $this->db->where('id', $id);
        $this->db->delete('psl_programa_lideranca');

        return $first;
    }

    public function treinamento_lideranca_get($status = NULL)
    {
        $this->db->select('
            psl_treinamento_lideranca.*,

            psl_programa_lideranca.nome as programa, psl_programa_lideranca.descricao as p_descricao, 
            psl_programa_lideranca.data_inicio, psl_programa_lideranca.data_fim,

            psl_status.status,
        ');
        $this->db->from('psl_treinamento_lideranca');
        $this->db->join('psl_programa_lideranca', 'psl_programa_lideranca.id = psl_treinamento_lideranca.programa_lideranca_id', 'left');
        $this->db->join('psl_status', 'psl_status.id = psl_treinamento_lideranca.status_id', 'left');
        if ($status) {
            $this->db->where('psl_treinamento_lideranca.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function treinamento_lideranca_first($id)
    {
        $this->db->select('
            psl_treinamento_lideranca.*,

            psl_programa_lideranca.nome as programa, psl_programa_lideranca.descricao as p_descricao, 
            psl_programa_lideranca.data_inicio, psl_programa_lideranca.data_fim,

            psl_status.status,
        ');
        $this->db->from('psl_treinamento_lideranca');
        $this->db->join('psl_programa_lideranca', 'psl_programa_lideranca.id = psl_treinamento_lideranca.programa_lideranca_id', 'left');
        $this->db->join('psl_status', 'psl_status.id = psl_treinamento_lideranca.status_id', 'left');
        $this->db->where('psl_treinamento_lideranca.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function treinamento_lideranca_create($data)
    {
        return $this->db->insert('psl_treinamento_lideranca', $data);
    }
    public function treinamento_lideranca_update ($data, $id) {
        $this->treinamento_lideranca_first($id);
        $this->db->where('id', $id);
        $this->db->update('psl_treinamento_lideranca', $data);
        return $this->treinamento_lideranca_first($id);
    }
    public function treinamento_lideranca_delete($id)
    {
        $first = $this->treinamento_lideranca_first($id);

        // $total = 0;
        // $total += $this->db->get_where('gv_reserva',  ['pedido_viagem_id' => $id])->num_rows();
        // if ($total) {
        //     set_alert('danger',"Existe Reserva associadas com este Pedido");
		//  	redirect('gestao_viagens/pedidos');
        // }
        $this->db->where('id', $id);
        $this->db->delete('psl_treinamento_lideranca');

        return $first;
    }

    public function avaliacao_lideranca_get($status = NULL)
    {
        $this->db->select('
            psl_avaliacao_lideranca.*,

            psl_treinamento_lideranca.descricao as t_descricao, psl_treinamento_lideranca.carga_horaria,
            psl_treinamento_lideranca.aprovadores,

            psl_programa_lideranca.nome as programa, psl_programa_lideranca.descricao as p_descricao, 
            psl_programa_lideranca.data_inicio, psl_programa_lideranca.data_fim,

            psl_feedback.nome as feedback,
            psl_status.status,

            staff.*,
            psl_desempenho.nome as desempenho,
            psl_potencial.nome as potencial,
        ');
        $this->db->from('psl_avaliacao_lideranca');
        $this->db->join('psl_treinamento_lideranca', 'psl_treinamento_lideranca.id = psl_avaliacao_lideranca.treinamento_lideranca_id', 'left');
        $this->db->join('psl_programa_lideranca', 'psl_programa_lideranca.id = psl_treinamento_lideranca.programa_lideranca_id', 'left');
        $this->db->join('psl_feedback', 'psl_feedback.id = psl_avaliacao_lideranca.feedback_id', 'left');
        $this->db->join('psl_status', 'psl_status.id = psl_avaliacao_lideranca.status_id', 'left');

        $this->db->join('psl_talento', 'psl_talento.id = psl_avaliacao_lideranca.talento_id', 'left');
        $this->db->join('staff', 'staff.staffid = psl_talento.staff_id', 'left');
        $this->db->join('psl_desempenho', 'psl_desempenho.id = psl_talento.desempenho_id', 'left');
        $this->db->join('psl_potencial', 'psl_potencial.id = psl_talento.potencial_id', 'left');

        if ($status) {
            $this->db->where('psl_avaliacao_lideranca.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function avaliacao_lideranca_first($id)
    {
        $this->db->select('
            psl_avaliacao_lideranca.*,

            psl_treinamento_lideranca.descricao as t_descricao, psl_treinamento_lideranca.carga_horaria,
            psl_treinamento_lideranca.aprovadores,

            psl_programa_lideranca.nome as programa, psl_programa_lideranca.descricao as p_descricao, 
            psl_programa_lideranca.data_inicio, psl_programa_lideranca.data_fim,

            psl_feedback.nome as feedback,
            psl_status.status,

            staff.*,
            psl_desempenho.nome as desempenho,
            psl_potencial.nome as potencial,
        ');
        $this->db->from('psl_avaliacao_lideranca');
        $this->db->join('psl_treinamento_lideranca', 'psl_treinamento_lideranca.id = psl_avaliacao_lideranca.treinamento_lideranca_id', 'left');
        $this->db->join('psl_programa_lideranca', 'psl_programa_lideranca.id = psl_treinamento_lideranca.programa_lideranca_id', 'left');
        $this->db->join('psl_feedback', 'psl_feedback.id = psl_avaliacao_lideranca.feedback_id', 'left');
        $this->db->join('psl_status', 'psl_status.id = psl_avaliacao_lideranca.status_id', 'left');

        $this->db->join('psl_talento', 'psl_talento.id = psl_avaliacao_lideranca.talento_id', 'left');
        $this->db->join('staff', 'staff.staffid = psl_talento.staff_id', 'left');
        $this->db->join('psl_desempenho', 'psl_desempenho.id = psl_talento.desempenho_id', 'left');
        $this->db->join('psl_potencial', 'psl_potencial.id = psl_talento.potencial_id', 'left');

        $this->db->where('psl_avaliacao_lideranca.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function avaliacao_lideranca_create($data)
    {
        return $this->db->insert('psl_avaliacao_lideranca', $data);
    }
    public function avaliacao_lideranca_update ($data, $id) {
        $this->avaliacao_lideranca_first($id);
        $this->db->where('id', $id);
        $this->db->update('psl_avaliacao_lideranca', $data);
        return $this->avaliacao_lideranca_first($id);
    }
    public function avaliacao_lideranca_delete($id)
    {
        $first = $this->avaliacao_lideranca_first($id);
        // $total = 0;
        // $total += $this->db->get_where('gv_reserva',  ['pedido_viagem_id' => $id])->num_rows();
        // if ($total) {
        //     set_alert('danger',"Existe Reserva associadas com este Pedido");
		//  	redirect('gestao_viagens/pedidos');
        // }
        $this->db->where('id', $id);
        $this->db->delete('psl_avaliacao_lideranca');

        return $first;
    }

    public function competencia_cargo_get()
    {        
        $this->db->select('
            psl_competencia_cargo.*,
            psl_competencia.nome as competencia,
            hr_job_position.position_name as cargo,
        ');
        $this->db->from('psl_competencia_cargo');
        $this->db->join('hr_job_position', 'hr_job_position.position_id  = psl_competencia_cargo.cargo_id', 'left');
        $this->db->join('psl_competencia', 'psl_competencia.id = psl_competencia_cargo.competencia_id', 'left');
        return $this->db->get()->result_array();
    }
    public function competencia_cargo_first($id)
    {
        $this->db->select('
            psl_competencia_cargo.*,
            psl_competencia.nome as competencia,
            hr_job_position.position_name as cargo,
        ');
        $this->db->from('psl_competencia_cargo');
        $this->db->join('hr_job_position', 'hr_job_position.position_id  = psl_competencia_cargo.cargo_id', 'left');
        $this->db->join('psl_competencia', 'psl_competencia.id = psl_competencia_cargo.competencia_id', 'left');
        $this->db->where('psl_competencia_cargo.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function competencia_cargo_create($data)
    {
        $vf_existe = $this->db->get_where('psl_competencia_cargo', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Competência já foi cadastrada");
            redirect('plan_sucess_lideranca/competencias');
        }
        return $this->db->insert('psl_competencia_cargo', $data);
    }
    public function competencia_cargo_update ($data, $id) {
        $this->competencia_cargo_first($id);
        $vf_existe = $this->db->get_where('psl_competencia_cargo', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Competência já foi cadastrada");
			    redirect('plan_sucess_lideranca/competencias');
            }
        }

        $this->db->where('id', $id);
        $this->db->update('psl_competencia_cargo', $data);
        return $this->competencia_cargo_first($id);
    }
    public function competencia_cargo_delete($id)
    {
        $first = $this->competencia_cargo_first($id);
        // $total = 0;
        // $total += $this->db->get_where('gv_reserva',  ['pedido_viagem_id' => $id])->num_rows();
        // if ($total) {
        //     set_alert('danger',"Existe Reserva associadas com este Pedido");
		//  	redirect('gestao_viagens/pedidos');
        // }
        $this->db->where('id', $id);
        $this->db->delete('psl_competencia_cargo');

        return $first;
    }

    public function avaliacao_nivel_get()
    {
        $this->db->select('
            psl_avaliacao_nivel.*,
            psl_potencial.nome as potencial,

            psl_avaliacao_competencia.nota, psl_avaliacao_competencia.data_avaliacao,
            staff.*,
            psl_competencia.nome as competencia,
        ');
        $this->db->from('psl_avaliacao_nivel');
        $this->db->join('psl_avaliacao_competencia', 'psl_avaliacao_competencia.id = psl_avaliacao_nivel.avaliacao_competencia_id', 'left');
        $this->db->join('psl_potencial', 'psl_potencial.id = psl_avaliacao_nivel.potencial_id', 'left');

        $this->db->join('staff', 'staff.staffid = psl_avaliacao_competencia.staff_id', 'left');
        $this->db->join('psl_competencia', 'psl_competencia.id = psl_avaliacao_competencia.competencia_id', 'left');
        return $this->db->get()->result_array();
    }
    public function avaliacao_nivel_first($id)
    {
        $this->db->select('
            psl_avaliacao_nivel.*,
            psl_potencial.nome as potencial,

            psl_avaliacao_competencia.nota, psl_avaliacao_competencia.data_avaliacao,
            staff.*,
            psl_competencia.nome as competencia,
        ');
        $this->db->from('psl_avaliacao_nivel');
        $this->db->join('psl_avaliacao_competencia', 'psl_avaliacao_competencia.id = psl_avaliacao_nivel.avaliacao_competencia_id', 'left');
        $this->db->join('psl_potencial', 'psl_potencial.id = psl_avaliacao_nivel.potencial_id', 'left');

        $this->db->join('staff', 'staff.staffid = psl_avaliacao_competencia.staff_id', 'left');
        $this->db->join('psl_competencia', 'psl_competencia.id = psl_avaliacao_competencia.competencia_id', 'left');
        $this->db->where('psl_avaliacao_nivel.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function avaliacao_nivel_create($data)
    {
        $vf_existe = $this->db->get_where('psl_avaliacao_nivel',$data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Avaliação já foi cadastrada");
            redirect('plan_sucess_lideranca/competencias_avaliacao2');
        }
        return $this->db->insert('psl_avaliacao_nivel', $data);
    }
    public function avaliacao_nivel_update ($data, $id) {
        $this->avaliacao_nivel_first($id);
        $vf_existe = $this->db->get_where('psl_avaliacao_nivel', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Avaliação já foi cadastrada");
			    redirect('plan_sucess_lideranca/competencias_avaliacao2');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('psl_avaliacao_nivel', $data);
        return $this->avaliacao_nivel_first($id);
    }
    public function avaliacao_nivel_delete($id)
    {
        $first = $this->avaliacao_nivel_first($id);
        // $total = 0;
        // $total += $this->db->get_where('gv_reserva',  ['pedido_viagem_id' => $id])->num_rows();
        // if ($total) {
        //     set_alert('danger',"Existe Reserva associadas com este Pedido");
		//  	redirect('gestao_viagens/pedidos');
        // }
        $this->db->where('id', $id);
        $this->db->delete('psl_avaliacao_nivel');

        return $first;
    }



    public function plano_aquisicao_competencia_total($status = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        $query = $this->db->get('psl_plano_aquisicao_competencia')->num_rows();
        return $query;
    }
    public function plano_aquisicao_competencia_get($status = null)
    {
        $this->db->select('
            psl_plano_aquisicao_competencia.*,
            staff.*,
            psl_status.status,
            psl_competencia.nome as competencia,
        ');
        $this->db->from('psl_plano_aquisicao_competencia');
        $this->db->join('staff', 'staff.staffid = psl_plano_aquisicao_competencia.staff_id', 'left');
        $this->db->join('psl_status', 'psl_status.id = psl_plano_aquisicao_competencia.status_id', 'left');
        $this->db->join('psl_competencia', 'psl_competencia.id = psl_plano_aquisicao_competencia.competencia_id', 'left');
        if ($status) {
            $this->db->where('psl_plano_aquisicao_competencia.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function plano_aquisicao_competencia_first($id)
    {
        $this->db->select('
            psl_plano_aquisicao_competencia.*,
            staff.*,
            psl_status.status,
            psl_competencia.nome as competencia,
        ');
        $this->db->from('psl_plano_aquisicao_competencia');
        $this->db->join('staff', 'staff.staffid = psl_plano_aquisicao_competencia.staff_id', 'left');
        $this->db->join('psl_status', 'psl_status.id = psl_plano_aquisicao_competencia.status_id', 'left');
        $this->db->join('psl_competencia', 'psl_competencia.id = psl_plano_aquisicao_competencia.competencia_id', 'left');
        $this->db->where('psl_plano_aquisicao_competencia.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function plano_aquisicao_competencia_create($data)
    {
        return $this->db->insert('psl_plano_aquisicao_competencia', $data);
    }
    public function plano_aquisicao_competencia_update ($data, $id) {
        $this->plano_aquisicao_competencia_first($id);
        $this->db->where('id', $id);
        $this->db->update('psl_plano_aquisicao_competencia', $data);
        return $this->plano_aquisicao_competencia_first($id);
    }
    public function plano_aquisicao_competencia_delete($id)
    {
        $first = $this->plano_aquisicao_competencia_first($id);
        // $total = 0;
        // $total += $this->db->get_where('gv_reserva',  ['pedido_viagem_id' => $id])->num_rows();
        // if ($total) {
        //     set_alert('danger',"Existe Reserva associadas com este Pedido");
		//  	redirect('gestao_viagens/pedidos');
        // }
        $this->db->where('id', $id);
        $this->db->delete('psl_plano_aquisicao_competencia');

        return $first;
    }

    public function mentoria_total($status = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        $query = $this->db->get('psl_mentoria')->num_rows();
        return $query;
    }
    public function mentoria_get($status = null)
    {
        $this->db->select('
            psl_mentoria.*,
            mentor.firstname as p_nome_mentor, mentor.lastname as s_nome_mentor,
            mentorado.firstname as p_nome_mentorado, mentorado.lastname as s_nome_mentorado,
            psl_status.status,
        ');
        $this->db->from('psl_mentoria');
        $this->db->join('staff as mentor', 'mentor.staffid = psl_mentoria.mentor_id', 'left');
        $this->db->join('staff as mentorado', 'mentorado.staffid = psl_mentoria.mentorado_id', 'left');
        $this->db->join('psl_status', 'psl_status.id = psl_mentoria.status_id', 'left');
        if ($status) {
            $this->db->where('psl_mentoria.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function mentoria_first($id)
    {
        $this->db->select('
            psl_mentoria.*,
            mentor.firstname as p_nome_mentor, mentor.lastname as s_nome_mentor,
            mentorado.firstname as p_nome_mentorado, mentorado.lastname as s_nome_mentorado,
            psl_status.status,
        ');
        $this->db->from('psl_mentoria');
        $this->db->join('staff as mentor', 'mentor.staffid = psl_mentoria.mentor_id', 'left');
        $this->db->join('staff as mentorado', 'mentorado.staffid = psl_mentoria.mentorado_id', 'left');
        $this->db->join('psl_status', 'psl_status.id = psl_mentoria.status_id', 'left');
        $this->db->where('psl_mentoria.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function mentoria_create($data)
    {
        return $this->db->insert('psl_mentoria', $data);
    }
    public function mentoria_update ($data, $id) {
        $this->mentoria_first($id);
        $this->db->where('id', $id);
        $this->db->update('psl_mentoria', $data);
        return $this->mentoria_first($id);
    }
    public function mentoria_delete($id)
    {
        $first = $this->mentoria_first($id);
        // $total = 0;
        // $total += $this->db->get_where('gv_reserva',  ['pedido_viagem_id' => $id])->num_rows();
        // if ($total) {
        //     set_alert('danger',"Existe Reserva associadas com este Pedido");
		//  	redirect('gestao_viagens/pedidos');
        // }
        $this->db->where('id', $id);
        $this->db->delete('psl_mentoria');

        return $first;
    }

    public function coaching_total($status = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        $query = $this->db->get('psl_coaching')->num_rows();
        return $query;
    }
    public function coaching_get($status = null)
    {
        $this->db->select('
            psl_coaching.*,
            coach.firstname as p_nome_coach, coach.lastname as s_nome_coach,
            funcionario.firstname as p_nome_funcionario, funcionario.lastname as s_nome_funcionario,
            psl_status.status,
        ');
        $this->db->from('psl_coaching');
        $this->db->join('staff as coach', 'coach.staffid = psl_coaching.coach_id', 'left');
        $this->db->join('staff as funcionario', 'funcionario.staffid = psl_coaching.staff_id', 'left');
        $this->db->join('psl_status', 'psl_status.id = psl_coaching.status_id', 'left');
        if ($status) {
            $this->db->where('psl_coaching.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function coaching_first($id)
    {
        $this->db->select('
            psl_coaching.*,
            coach.firstname as p_nome_coach, coach.lastname as s_nome_coach,
            funcionario.firstname as p_nome_funcionario, funcionario.lastname as s_nome_funcionario,
            psl_status.status,
        ');
        $this->db->from('psl_coaching');
        $this->db->join('staff as coach', 'coach.staffid = psl_coaching.coach_id', 'left');
        $this->db->join('staff as funcionario', 'funcionario.staffid = psl_coaching.staff_id', 'left');
        $this->db->join('psl_status', 'psl_status.id = psl_coaching.status_id', 'left');
        $this->db->where('psl_coaching.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function coaching_create($data)
    {
        return $this->db->insert('psl_coaching', $data);
    }
    public function coaching_update ($data, $id) {
        $this->coaching_first($id);
        $this->db->where('id', $id);
        $this->db->update('psl_coaching', $data);
        return $this->coaching_first($id);
    }
    public function coaching_delete($id)
    {
        $first = $this->coaching_first($id);
        // $total = 0;
        // $total += $this->db->get_where('gv_reserva',  ['pedido_viagem_id' => $id])->num_rows();
        // if ($total) {
        //     set_alert('danger',"Existe Reserva associadas com este Pedido");
		//  	redirect('gestao_viagens/pedidos');
        // }
        $this->db->where('id', $id);
        $this->db->delete('psl_coaching');

        return $first;
    }

    public function feedback_lideranca_get($status = null)
    {
        $this->db->select('
            psl_feedback_lideranca.*,
            mentor.firstname as p_nome_mentor, mentor.lastname as s_nome_mentor,
            funcionario.firstname as p_nome_funcionario, funcionario.lastname as s_nome_funcionario,
        ');
        $this->db->from('psl_feedback_lideranca');
        $this->db->join('staff as mentor', 'mentor.staffid = psl_feedback_lideranca.mentor_id', 'left');
        $this->db->join('staff as funcionario', 'funcionario.staffid = psl_feedback_lideranca.staff_id', 'left');
        if ($status) {
            $this->db->where('psl_feedback_lideranca.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function feedback_lideranca_first($id)
    {
        $this->db->select('
            psl_feedback_lideranca.*,
            mentor.firstname as p_nome_mentor, mentor.lastname as s_nome_mentor,
            funcionario.firstname as p_nome_funcionario, funcionario.lastname as s_nome_funcionario,
        ');
        $this->db->from('psl_feedback_lideranca');
        $this->db->join('staff as mentor', 'mentor.staffid = psl_feedback_lideranca.mentor_id', 'left');
        $this->db->join('staff as funcionario', 'funcionario.staffid = psl_feedback_lideranca.staff_id', 'left');
        $this->db->where('psl_feedback_lideranca.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function feedback_lideranca_create($data)
    {
        return $this->db->insert('psl_feedback_lideranca', $data);
    }
    public function feedback_lideranca_update ($data, $id) {
        $this->feedback_lideranca_first($id);
        $this->db->where('id', $id);
        $this->db->update('psl_feedback_lideranca', $data);
        return $this->feedback_lideranca_first($id);
    }
    public function feedback_lideranca_delete($id)
    {
        $first = $this->feedback_lideranca_first($id);
        // $total = 0;
        // $total += $this->db->get_where('gv_reserva',  ['pedido_viagem_id' => $id])->num_rows();
        // if ($total) {
        //     set_alert('danger',"Existe Reserva associadas com este Pedido");
		//  	redirect('gestao_viagens/pedidos');
        // }
        $this->db->where('id', $id);
        $this->db->delete('psl_feedback_lideranca');

        return $first;
    }

    public function risco_sucessao_get()
    {
        $this->db->select('
            psl_risco_sucessao.*,
            hr_job_position.position_name as cargo,
            psl_nivel_risco.nome as nivel_risco,
            psl_impacto.nome as impacto
        ');
        $this->db->from('psl_risco_sucessao');
        $this->db->join('hr_job_position', 'hr_job_position.position_id  = psl_risco_sucessao.cargo_id', 'left');
        $this->db->join('psl_nivel_risco', 'psl_nivel_risco.id = psl_risco_sucessao.nivel_risco_id', 'left');
        $this->db->join('psl_impacto', 'psl_impacto.id = psl_risco_sucessao.impacto_id', 'left');
        return $this->db->get()->result_array();
    }
    public function risco_sucessao_first($id)
    {
        $this->db->select('
            psl_risco_sucessao.*,
            hr_job_position.position_name as cargo,
            psl_nivel_risco.nome as nivel_risco,
            psl_impacto.nome as impacto
        ');
        $this->db->from('psl_risco_sucessao');
        $this->db->join('hr_job_position', 'hr_job_position.position_id  = psl_risco_sucessao.cargo_id', 'left');
        $this->db->join('psl_nivel_risco', 'psl_nivel_risco.id = psl_risco_sucessao.nivel_risco_id', 'left');
        $this->db->join('psl_impacto', 'psl_impacto.id = psl_risco_sucessao.impacto_id', 'left');
        $this->db->where('psl_risco_sucessao.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function risco_sucessao_create($data)
    {
        return $this->db->insert('psl_risco_sucessao', $data);
    }
    public function risco_sucessao_update ($data, $id) {
        $this->risco_sucessao_first($id);
        $this->db->where('id', $id);
        $this->db->update('psl_risco_sucessao', $data);
        return $this->risco_sucessao_first($id);
    }
    public function risco_sucessao_delete($id)
    {
        $first = $this->risco_sucessao_first($id);
        // $total = 0;
        // $total += $this->db->get_where('gv_reserva',  ['pedido_viagem_id' => $id])->num_rows();
        // if ($total) {
        //     set_alert('danger',"Existe Reserva associadas com este Pedido");
		//  	redirect('gestao_viagens/pedidos');
        // }
        $this->db->where('id', $id);
        $this->db->delete('psl_risco_sucessao');

        return $first;
    }

    public function impacto_perda_talento_create($data)
    {
        return $this->db->insert('psl_impacto_perda_talento', $data);
    }

    public function impacto_perda_talento_get()
    {
        $this->db->select('
            psl_impacto_perda_talento.*,
            staff.*,
            psl_impacto.nome as impacto
        ');
        $this->db->from('psl_impacto_perda_talento');
        $this->db->join('staff', 'staff.staffid = psl_impacto_perda_talento.staff_id', 'left');
        $this->db->join('psl_impacto', 'psl_impacto.id = psl_impacto_perda_talento.impacto_id', 'left');
        return $this->db->get()->result_array();
    }
    public function impacto_perda_talento_first($id)
    {
        $this->db->select('
            psl_impacto_perda_talento.*,
            staff.*,
            psl_impacto.nome as impacto
        ');
        $this->db->from('psl_impacto_perda_talento');
        $this->db->join('staff', 'staff.staffid = psl_impacto_perda_talento.staff_id', 'left');
        $this->db->join('psl_impacto', 'psl_impacto.id = psl_impacto_perda_talento.impacto_id', 'left');
        $this->db->where('psl_impacto_perda_talento.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function impacto_perda_talento_update ($data, $id) {
        $this->impacto_perda_talento_first($id);
        $this->db->where('id', $id);
        $this->db->update('psl_impacto_perda_talento', $data);
        return $this->impacto_perda_talento_first($id);
    }
    public function impacto_perda_talento_delete($id)
    {
        $first = $this->impacto_perda_talento_first($id);
        // $total = 0;
        // $total += $this->db->get_where('gv_reserva',  ['pedido_viagem_id' => $id])->num_rows();
        // if ($total) {
        //     set_alert('danger',"Existe Reserva associadas com este Pedido");
		//  	redirect('gestao_viagens/pedidos');
        // }
        $this->db->where('id', $id);
        $this->db->delete('psl_impacto_perda_talento');

        return $first;
    }

    public function programa_retencao_create($data)
    {
        return $this->db->insert('psl_programa_retencao', $data);
    }
    public function programa_retencao_get()
    {
        $this->db->select('
            psl_programa_retencao.*,

            staff.*,
            psl_desempenho.nome as desempenho,
            psl_potencial.nome as potencial,
        ');
        $this->db->from('psl_programa_retencao');

        $this->db->join('psl_estrategia_engajamento', 'psl_estrategia_engajamento.id = psl_programa_retencao.estrategia_engajamento_id', 'left');
        $this->db->join('psl_talento', 'psl_talento.id = psl_estrategia_engajamento.talento_id', 'left');
        $this->db->join('staff', 'staff.staffid = psl_talento.staff_id', 'left');
        $this->db->join('psl_desempenho', 'psl_desempenho.id = psl_talento.desempenho_id', 'left');
        $this->db->join('psl_potencial', 'psl_potencial.id = psl_talento.potencial_id', 'left');
        return $this->db->get()->result_array();
    }
    public function programa_retencao_first($id)
    {
        $this->db->select('
            psl_programa_retencao.*,

            staff.*,
            psl_desempenho.nome as desempenho,
            psl_potencial.nome as potencial,
        ');
        $this->db->from('psl_programa_retencao');

        $this->db->join('psl_estrategia_engajamento', 'psl_estrategia_engajamento.id = psl_programa_retencao.estrategia_engajamento_id', 'left');
        $this->db->join('psl_talento', 'psl_talento.id = psl_estrategia_engajamento.talento_id', 'left');
        $this->db->join('staff', 'staff.staffid = psl_talento.staff_id', 'left');
        $this->db->join('psl_desempenho', 'psl_desempenho.id = psl_talento.desempenho_id', 'left');
        $this->db->join('psl_potencial', 'psl_potencial.id = psl_talento.potencial_id', 'left');

        $this->db->where('psl_programa_retencao.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function programa_retencao_update ($data, $id) {
        $this->programa_retencao_first($id);
        $this->db->where('id', $id);
        $this->db->update('psl_programa_retencao', $data);
        return $this->programa_retencao_first($id);
    }
    public function programa_retencao_delete($id)
    {
        $first = $this->programa_retencao_first($id);
        // $total = 0;
        // $total += $this->db->get_where('gv_reserva',  ['pedido_viagem_id' => $id])->num_rows();
        // if ($total) {
        //     set_alert('danger',"Existe Reserva associadas com este Pedido");
		//  	redirect('gestao_viagens/pedidos');
        // }
        $this->db->where('id', $id);
        $this->db->delete('psl_programa_retencao');

        return $first;
    }

    public function estrategia_engajamento_total($status = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        $query = $this->db->get('psl_estrategia_engajamento')->num_rows();
        return $query;
    }
    public function estrategia_engajamento_get($status = NULL)
    {
        $this->db->select('
            psl_estrategia_engajamento.*,
            psl_status.status,

            staff.*,
            psl_desempenho.nome as desempenho,
            psl_potencial.nome as potencial,
        ');
        $this->db->from('psl_estrategia_engajamento');
        $this->db->join('psl_status', 'psl_status.id = psl_estrategia_engajamento.status_id', 'left');

        $this->db->join('psl_talento', 'psl_talento.id = psl_estrategia_engajamento.talento_id', 'left');
        $this->db->join('staff', 'staff.staffid = psl_talento.staff_id', 'left');
        $this->db->join('psl_desempenho', 'psl_desempenho.id = psl_talento.desempenho_id', 'left');
        $this->db->join('psl_potencial', 'psl_potencial.id = psl_talento.potencial_id', 'left');

        if ($status) {
            $this->db->where('psl_estrategia_engajamento.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function estrategia_engajamento_create($data)
    {
        return $this->db->insert('psl_estrategia_engajamento', $data);
    }
    public function estrategia_engajamento_first($id)
    {
        $this->db->select('
            psl_estrategia_engajamento.*,
            psl_status.status,

            staff.*,
            psl_desempenho.nome as desempenho,
            psl_potencial.nome as potencial,
        ');
        $this->db->from('psl_estrategia_engajamento');
        $this->db->join('psl_status', 'psl_status.id = psl_estrategia_engajamento.status_id', 'left');

        $this->db->join('psl_talento', 'psl_talento.id = psl_estrategia_engajamento.talento_id', 'left');
        $this->db->join('staff', 'staff.staffid = psl_talento.staff_id', 'left');
        $this->db->join('psl_desempenho', 'psl_desempenho.id = psl_talento.desempenho_id', 'left');
        $this->db->join('psl_potencial', 'psl_potencial.id = psl_talento.potencial_id', 'left');

        $this->db->where('psl_estrategia_engajamento.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function estrategia_engajamento_update ($data, $id) {
        $this->estrategia_engajamento_first($id);
        $this->db->where('id', $id);
        $this->db->update('psl_estrategia_engajamento', $data);
        return $this->estrategia_engajamento_first($id);
    }
    public function estrategia_engajamento_delete($id)
    {
        $first = $this->estrategia_engajamento_first($id);
        // $total = 0;
        // $total += $this->db->get_where('gv_reserva',  ['pedido_viagem_id' => $id])->num_rows();
        // if ($total) {
        //     set_alert('danger',"Existe Reserva associadas com este Pedido");
		//  	redirect('gestao_viagens/pedidos');
        // }
        $this->db->where('id', $id);
        $this->db->delete('psl_estrategia_engajamento');

        return $first;
    }
}