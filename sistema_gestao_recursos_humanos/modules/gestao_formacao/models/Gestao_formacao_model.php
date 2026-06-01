<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Gestao_formacao_model extends App_Model
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
    public function get_status () {
        return $this->db->get('gf_status')->result_array();
    }
    public function get_nivel_risco () {
        return $this->db->get('gf_nivel_risco')->result_array();
    }

    public function get_impacto_qualitativo () {
        return $this->db->get('gf_impacto_qualitativo')->result_array();
    }
    public function create_impacto_qualitativo($data)
    {
        $vf_existe = $this->db->get_where('gf_impacto_qualitativo', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            set_alert('danger',"Competência já foi cadastrada");
            redirect('gestao_formacao/configuracoes?group=impacto_qualitativo');
        }
        return $this->db->insert('gf_impacto_qualitativo', $data);
    }
    public function first_impacto_qualitativo($id) {
        $query = $this->db->get_where('gf_impacto_qualitativo', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_impacto_qualitativo ($data, $id) {
        $this->first_impacto_qualitativo($id);
        $vf_existe = $this->db->get_where('gf_impacto_qualitativo', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Competência já foi cadastrada");
			    redirect('gestao_formacao/configuracoes?group=impacto_qualitativo');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_impacto_qualitativo', $data);

        return $this->first_impacto_qualitativo($id);
    }
    public function delete_impacto_qualitativo($id) {
        $first = $this->first_impacto_qualitativo($id);

        $this->db->where('id', $id);
        $this->db->delete('gf_impacto_qualitativo');
        return $first;
    }
    public function get_impacto_quantitativo () {
        return $this->db->get('gf_impacto_quantitativo')->result_array();
    }
    public function create_impacto_quantitativo($data)
    {
        $vf_existe = $this->db->get_where('gf_impacto_quantitativo', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            set_alert('danger',"Competência já foi cadastrada");
            redirect('gestao_formacao/configuracoes?group=impacto_quantitativo');
        }
        return $this->db->insert('gf_impacto_quantitativo', $data);
    }
    public function first_impacto_quantitativo($id) {
        $query = $this->db->get_where('gf_impacto_quantitativo', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_impacto_quantitativo ($data, $id) {
        $this->first_impacto_quantitativo($id);
        $vf_existe = $this->db->get_where('gf_impacto_quantitativo', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Competência já foi cadastrada");
			    redirect('gestao_formacao/configuracoes?group=impacto_quantitativo');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_impacto_quantitativo', $data);

        return $this->first_impacto_quantitativo($id);
    }
    public function delete_impacto_quantitativo($id) {
        $first = $this->first_impacto_quantitativo($id);

        $this->db->where('id', $id);
        $this->db->delete('gf_impacto_quantitativo');
        return $first;
    }

    public function get_competencia () {
        return $this->db->get('gf_competencia')->result_array();
    }
    public function create_competencia($data)
    {
        $vf_existe = $this->db->get_where('gf_competencia', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            set_alert('danger',"Competência já foi cadastrada");
            redirect('gestao_formacao/configuracoes?group=competencias');
        }
        return $this->db->insert('gf_competencia', $data);
    }
    public function first_competencia($id) {
        $query = $this->db->get_where('gf_competencia', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_competencia ($data, $id) {
        $this->first_competencia($id);
        $vf_existe = $this->db->get_where('gf_competencia', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Competência já foi cadastrada");
			    redirect('gestao_formacao/configuracoes?group=competencias');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_competencia', $data);

        return $this->first_competencia($id);
    }
    public function delete_competencia($id) {
        $first = $this->first_competencia($id);

        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_competencia');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar esta competencia, esta associada a outras entidades.");
            redirect('gestao_formacao/configuracoes?group=competencias');
        }
    }

    public function total_categoria()
    {
        $query = $this->db->get('gf_categoria')->num_rows();
        return $query;
    }
    public function get_categoria () {
        return $this->db->get('gf_categoria')->result_array();
    }
    public function create_categoria($data)
    {
        $vf_existe = $this->db->get_where('gf_categoria', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            set_alert('danger',"Categoria já foi cadastrada");
            redirect('gestao_formacao/cursos_categoria');
        }
        return $this->db->insert('gf_categoria', $data);
    }
    public function first_categoria($id) {
        $query = $this->db->get_where('gf_categoria', ['id' => $id])->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_categoria ($data, $id) {
        $this->first_categoria($id);
        $vf_existe = $this->db->get_where('gf_categoria', ['nome' => $data['nome']])->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Competência já foi cadastrada");
			    redirect('gestao_formacao/cursos_categoria');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_categoria', $data);

        return $this->first_categoria($id);
    }
    public function delete_categoria($id) {
        $first = $this->first_categoria($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_categoria');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar esta categoria, esta associada a outras entidades.");
            redirect('gestao_formacao/cursos_categoria');
        }
    }

    public function total_curso($status = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        $query = $this->db->get('gf_curso')->num_rows();
        return $query;
    }

    public function dashboard_curso ($status = null) {
        $this->db->select('
            gf_curso.*,
            gf_status.status,
            gf_categoria.nome as categoria,
        ');
        $this->db->from('gf_curso');
        $this->db->join('gf_status', 'gf_status.id  = gf_curso.status_id', 'left');
        $this->db->join('gf_categoria', 'gf_categoria.id = gf_curso.categoria_id', 'left');
        if ($status) {
            $this->db->where('gf_curso.status_id', $status);
        }
        $this->db->limit(6);
        $query = $this->db->get()->result_array();
        $cursos = '[';
        $total = '[';
        foreach ($query as $item) {
            $cursos .= '"'.$item['nome'].'",';
            $vfTotalInscritos = $this->total_inscricao_curso(null, $item['id']);
            $total .= '"'.$vfTotalInscritos.'",';
        }
        $cursos .= ']';
        $total .= ']';
        $dados = [
            'cursos' => $cursos,
            'total' => $total,
        ];
        return $dados;
    }
    public function get_curso ($status = null) {
        $this->db->select('
            gf_curso.*,
            gf_status.status,
            gf_categoria.nome as categoria,
        ');
        $this->db->from('gf_curso');
        $this->db->join('gf_status', 'gf_status.id  = gf_curso.status_id', 'left');
        $this->db->join('gf_categoria', 'gf_categoria.id = gf_curso.categoria_id', 'left');
        if ($status) {
            $this->db->where('gf_curso.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function create_curso($data)
    {
        $vf_existe = $this->db->get_where('gf_curso', [
            'nome' => $data['nome'],
            'carga_horaria' => $data['carga_horaria'],
            'status_id<>' => 3,
        ])->row_array();
        if ($vf_existe) {
            set_alert('danger',"Curso já foi cadastrada");
            redirect('gestao_formacao/cursos');
        }
        return $this->db->insert('gf_curso', $data);
    }
    public function first_curso($id) {
        $this->db->select('
            gf_curso.*,
            gf_status.status,
            gf_categoria.nome as categoria,
        ');
        $this->db->from('gf_curso');
        $this->db->join('gf_status', 'gf_status.id  = gf_curso.status_id', 'left');
        $this->db->join('gf_categoria', 'gf_categoria.id = gf_curso.categoria_id', 'left');
        $this->db->where('gf_curso.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_curso ($data, $id) {
        $this->first_curso($id);

        if (!isset($data['status_id'])) {
            $vf_existe = $this->db->get_where('gf_curso', [
                'nome' => $data['nome'],
                'carga_horaria' => $data['carga_horaria'],
                'status_id<>' => 3,
            ])->row_array();
            if ($vf_existe) {
                if ($id != $vf_existe['id']) {
                    set_alert('danger',"Curso já foi cadastrada");
                    redirect('gestao_formacao/cursos');
                }
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_curso', $data);

        return $this->first_curso($id);
    }
    public function delete_curso($id) {
        $first = $this->first_curso($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_curso');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar esta curso, esta associada a outras entidades.");
            redirect('gestao_formacao/cursos');
        }
    }

    public function total_vaga($status = null)
    {
        $query = $this->db->get('gf_vaga')->num_rows();
        return $query;
    }
    public function get_vaga () {
        $this->db->select('
            gf_vaga.*,

            gf_curso.nome as curso, gf_curso.descricao, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos, gf_curso.aprovadores
        ');
        $this->db->from('gf_vaga');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_vaga.curso_id', 'left');
        return $this->db->get()->result_array();
    }
    public function dashboard_vaga () {
        $this->db->select('
            gf_vaga.*,

            gf_curso.nome as curso, gf_curso.descricao, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos, gf_curso.aprovadores
        ');
        $this->db->from('gf_vaga');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_vaga.curso_id', 'left');
        $this->db->limit(8);
        $query = $this->db->get()->result_array();
        $cursos = '[';
        $total = '[';
        $inscritos = '[';
        $aprovados = '[';
        foreach ($query as $item) {
            $cursos .= '"'. $item['curso'] . '('. $item['carga_horaria'] .')' .'",';
            $total .= '"'. $item['total_vagas'] .'",';
            $inscritos .= '"'. $this->inscritos_total(null, $item['id']) .'",';
            $aprovados .= '"'. $this->inscritos_total(2, $item['id']) .'",';
        }
        $cursos .= ']';
        $total .= ']';
        $inscritos .= ']';
        $aprovados .= ']';
        $dados = [
            'cursos' => $cursos,
            'total' => $total,
            'inscritos' => $inscritos,
            'aprovados' => $aprovados,
        ];
        return $dados;
    }
    public function create_vaga($data)
    {
        $vf_existe = $this->db->get_where('gf_vaga', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Registro de vaga já foi cadastrada");
            redirect('gestao_formacao/cursos_vagas');
        }
        return $this->db->insert('gf_vaga', $data);
    }
    public function first_vaga($id) {
        $this->db->select('
            gf_vaga.*,

            gf_curso.nome as curso, gf_curso.descricao, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos, gf_curso.aprovadores
        ');
        $this->db->from('gf_vaga');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_vaga.curso_id', 'left');
        $this->db->where('gf_vaga.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_vaga ($data, $id) {
        $this->first_vaga($id);
        $vf_existe = $this->db->get_where('gf_vaga', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Registro de vaga já foi cadastrada");
			    redirect('gestao_formacao/cursos_vagas');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_vaga', $data);

        return $this->first_vaga($id);
    }
    public function delete_vaga($id) {
        $first = $this->first_vaga($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_vaga');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar esta vaga, esta associada a outras entidades.");
            redirect('gestao_formacao/cursos_vagas');
        }
    }

    public function inscritos_total($status = null, $vaga = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        if ($vaga != null) {
            $this->db->where('vaga_id', $vaga);
        }
        $query = $this->db->get('gf_inscricao')->num_rows();
        return $query;
    }
    public function total_inscricao_curso ($status = null, $curso = null) {
        $this->db->select('
            gf_inscricao.*,
            staff.*,

            gf_status.status,
            gf_vaga.total_vagas, gf_vaga.data_inicio, gf_vaga.data_fim,

            gf_curso.nome as curso, gf_curso.descricao, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_inscricao');
        $this->db->join('staff', 'staff.staffid = gf_inscricao.staff_id', 'left');
        $this->db->join('gf_status', 'gf_status.id  = gf_inscricao.status_id', 'left');
        $this->db->join('gf_vaga', 'gf_vaga.id  = gf_inscricao.vaga_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_vaga.curso_id', 'left');
        if ($status) {
            $this->db->where('gf_inscricao.status_id', $status);
        }
        if ($curso) {
            $this->db->where('gf_curso.id', $curso);
        }
        return $this->db->get()->num_rows();
    }
    public function get_inscricao ($status = null, $vaga = null) {
        $this->db->select('
            gf_inscricao.*,
            staff.*,

            gf_status.status,
            gf_vaga.total_vagas, gf_vaga.data_inicio, gf_vaga.data_fim,

            gf_curso.nome as curso, gf_curso.descricao, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_inscricao');
        $this->db->join('staff', 'staff.staffid = gf_inscricao.staff_id', 'left');
        $this->db->join('gf_status', 'gf_status.id  = gf_inscricao.status_id', 'left');
        $this->db->join('gf_vaga', 'gf_vaga.id  = gf_inscricao.vaga_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_vaga.curso_id', 'left');
        if ($status) {
            $this->db->where('gf_inscricao.status_id', $status);
        }
        if ($vaga) {
            $this->db->where('gf_inscricao.vaga_id', $vaga);
        }
        return $this->db->get()->result_array();
    }
    public function create_inscricao($data)
    {
        $vf_existe = $this->db->get_where('gf_inscricao', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Inscrição já foi cadastrada");
            redirect('gestao_formacao/cursos_Inscricoes');
        }
        return $this->db->insert('gf_inscricao', $data);
    }
    public function first_inscricao($id) {
        $this->db->select('
            gf_inscricao.*,
            staff.*,

            gf_status.status,
            gf_vaga.total_vagas, gf_vaga.data_inicio, gf_vaga.data_fim,

            gf_curso.nome as curso, gf_curso.descricao, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_inscricao');
        $this->db->join('staff', 'staff.staffid = gf_inscricao.staff_id', 'left');
        $this->db->join('gf_status', 'gf_status.id  = gf_inscricao.status_id', 'left');
        $this->db->join('gf_vaga', 'gf_vaga.id  = gf_inscricao.vaga_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_vaga.curso_id', 'left');
        $this->db->where('gf_inscricao.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_inscricao ($data, $id) {
        $this->first_inscricao($id);
        if (!isset($data['status_id'])) {
            $vf_existe = $this->db->get_where('gf_inscricao', $data)->row_array();
            if ($vf_existe) {
                if ($id != $vf_existe['id']) {
                    set_alert('danger',"Inscrição já foi cadastrada");
                    redirect('gestao_formacao/cursos_Inscricoes');
                }
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_inscricao', $data);

        return $this->first_inscricao($id);
    }
    public function delete_inscricao($id) {
        $first = $this->first_inscricao($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_inscricao');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar esta inscrição, esta associada a outras entidades.");
            redirect('gestao_formacao/cursos_Inscricoes');
        }
    }

    public function total_avaliacao()
    {
        $query = $this->db->get('gf_avaliacao')->num_rows();
        return $query;
    }
    public function create_avaliacao($data)
    {
        $vf_existe = $this->db->get_where('gf_avaliacao', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Inscrição já foi cadastrada");
            redirect('gestao_formacao/impacto');
        }
        return $this->db->insert('gf_avaliacao', $data);
    }
    public function get_avaliacao () {
        $this->db->select('
            gf_avaliacao.*,

            gf_inscricao.data_inscricao, gf_inscricao.aprovadores,
            staff.*,

            gf_vaga.total_vagas, gf_vaga.data_inicio, gf_vaga.data_fim,

            gf_curso.nome as curso, gf_curso.descricao, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_avaliacao');
        $this->db->join('gf_vaga', 'gf_vaga.id  = gf_avaliacao.vaga_id', 'left');
        $this->db->join('gf_inscricao', 'gf_inscricao.id  = gf_avaliacao.inscricao_id', 'left');

        $this->db->join('staff', 'staff.staffid = gf_inscricao.staff_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_vaga.curso_id', 'left');
        return $this->db->get()->result_array();
    }
    public function first_avaliacao ($id) {
        $this->db->select('
            gf_avaliacao.*,

            gf_inscricao.data_inscricao, gf_inscricao.aprovadores,
            staff.*,

            gf_vaga.total_vagas, gf_vaga.data_inicio, gf_vaga.data_fim,

            gf_curso.nome as curso, gf_curso.descricao, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_avaliacao');
        $this->db->join('gf_vaga', 'gf_vaga.id  = gf_avaliacao.vaga_id', 'left');
        $this->db->join('gf_inscricao', 'gf_inscricao.id  = gf_avaliacao.inscricao_id', 'left');

        $this->db->join('staff', 'staff.staffid = gf_inscricao.staff_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_vaga.curso_id', 'left');
        $this->db->where('gf_avaliacao.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_avaliacao ($data, $id) {
        $this->first_avaliacao($id);
        $vf_existe = $this->db->get_where('gf_avaliacao', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Inscrição já foi cadastrada");
                redirect('gestao_formacao/impacto');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_avaliacao', $data);

        return $this->first_avaliacao($id);
    }
    public function delete_avaliacao($id) {
        $first = $this->first_avaliacao($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_avaliacao');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar esta avaliação, esta associada a outras entidades.");
            redirect('gestao_formacao/impacto');
        }
    }

    public function total_historico_formacao($status = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        $query = $this->db->get('gf_historico_formacao')->num_rows();
        return $query;
    }
    public function get_historico_formacao ($status = null) {
        $this->db->select('
            gf_historico_formacao.*,
            staff.*,

            gf_status.status,

            gf_curso.nome as curso, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_historico_formacao');
        $this->db->join('staff', 'staff.staffid = gf_historico_formacao.staff_id', 'left');
        $this->db->join('gf_status', 'gf_status.id  = gf_historico_formacao.status_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_historico_formacao.curso_id', 'left');
        if ($status) {
            $this->db->where('gf_historico_formacao.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function create_historico_formacao($data)
    {
        $vf_existe = $this->db->get_where('gf_historico_formacao', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Registro de Histórico de Formação já foi cadastrada");
            redirect('gestao_formacao/formacao');
        }
        return $this->db->insert('gf_historico_formacao', $data);
    }
    public function first_historico_formacao($id) {
        $this->db->select('
            gf_historico_formacao.*,
            staff.*,

            gf_status.status,

            gf_curso.nome as curso, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_historico_formacao');
        $this->db->join('staff', 'staff.staffid = gf_historico_formacao.staff_id', 'left');
        $this->db->join('gf_status', 'gf_status.id  = gf_historico_formacao.status_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_historico_formacao.curso_id', 'left');
        $this->db->where('gf_historico_formacao.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_historico_formacao ($data, $id) {
        $this->first_historico_formacao($id);
        if (!isset($data['status_id'])) {
            $vf_existe = $this->db->get_where('gf_historico_formacao', $data)->row_array();
            if ($vf_existe) {
                if ($id != $vf_existe['id']) {
                    set_alert('danger',"Registro de Histórico de Formação já foi cadastrada");
                    redirect('gestao_formacao/formacao');
                }
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_historico_formacao', $data);

        return $this->first_historico_formacao($id);
    }
    public function delete_historico_formacao($id) {
        $first = $this->first_historico_formacao($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_historico_formacao');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar este Histórico de Formação, esta associada a outras entidades.");
            redirect('gestao_formacao/formacao');
        }
    }

    public function total_relatorio_impacto()
    {
        $query = $this->db->get('gf_relatorio_impacto')->num_rows();
        return $query;
    }
    public function get_relatorio_impacto () {
        $this->db->select('
            gf_relatorio_impacto.*,

            gf_curso.nome as curso, gf_curso.descricao, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos, gf_curso.aprovadores,

            gf_impacto_qualitativo.nome as nome_iql, gf_impacto_qualitativo.valor as valor_iql,
            gf_impacto_qualitativo.descricao as descricao_iql,

            gf_impacto_quantitativo.nome as nome_iqn, gf_impacto_quantitativo.valor as valor_iqn,
            gf_impacto_quantitativo.descricao as descricao_iqn,
        ');
        $this->db->from('gf_relatorio_impacto');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_relatorio_impacto.curso_id', 'left');
        $this->db->join('gf_impacto_qualitativo', 'gf_impacto_qualitativo.id  = gf_relatorio_impacto.impacto_qualitativo_id', 'left');
        $this->db->join('gf_impacto_quantitativo', 'gf_impacto_quantitativo.id  = gf_relatorio_impacto.impacto_quantitativo_id', 'left');
        return $this->db->get()->result_array();
    }
    public function create_relatorio_impacto($data)
    {
        $vf_existe = $this->db->get_where('gf_relatorio_impacto', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Relatório de Impacto já foi cadastrada");
            redirect('gestao_formacao/impacto_relatorio');
        }
        return $this->db->insert('gf_relatorio_impacto', $data);
    }
    public function first_relatorio_impacto ($id) {
        $this->db->select('
            gf_relatorio_impacto.*,

            gf_curso.nome as curso, gf_curso.descricao, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos, gf_curso.aprovadores,

            gf_impacto_qualitativo.nome as nome_iql, gf_impacto_qualitativo.valor as valor_iql,
            gf_impacto_qualitativo.descricao as descricao_iql,

            gf_impacto_quantitativo.nome as nome_iqn, gf_impacto_quantitativo.valor as valor_iqn,
            gf_impacto_quantitativo.descricao as descricao_iqn,
        ');
        $this->db->from('gf_relatorio_impacto');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_relatorio_impacto.curso_id', 'left');
        $this->db->join('gf_impacto_qualitativo', 'gf_impacto_qualitativo.id  = gf_relatorio_impacto.impacto_qualitativo_id', 'left');
        $this->db->join('gf_impacto_quantitativo', 'gf_impacto_quantitativo.id  = gf_relatorio_impacto.impacto_quantitativo_id', 'left');
        $this->db->where('gf_relatorio_impacto.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_relatorio_impacto ($data, $id) {
        $this->first_relatorio_impacto($id);
        $vf_existe = $this->db->get_where('gf_relatorio_impacto', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Relatório de Impacto já foi cadastrada");
                redirect('gestao_formacao/impacto_relatorio');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_relatorio_impacto', $data);

        return $this->first_relatorio_impacto($id);
    }
    public function delete_relatorio_impacto($id) {
        $first = $this->first_relatorio_impacto($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_relatorio_impacto');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar esta avaliação, esta associada a outras entidades.");
            redirect('gestao_formacao/impacto_relatorio');
        }
    }

    public function total_planeamento()
    {
        $query = $this->db->get('gf_planeamento')->num_rows();
        return $query;
    }
    public function get_planeamento () {
        $this->db->select('
            gf_planeamento.*,

            gf_curso.nome as curso, gf_curso.descricao, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos, gf_curso.aprovadores
        ');
        $this->db->from('gf_planeamento');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_planeamento.curso_id', 'left');
        return $this->db->get()->result_array();
    }
    public function create_planeamento($data)
    {
        $vf_existe = $this->db->get_where('gf_planeamento', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Registro de planeamento já foi cadastrada");
            redirect('gestao_formacao/orcamento');
        }
        return $this->db->insert('gf_planeamento', $data);
    }
    public function first_planeamento($id) {
        $this->db->select('
            gf_planeamento.*,

            gf_curso.nome as curso, gf_curso.descricao, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos, gf_curso.aprovadores
        ');
        $this->db->from('gf_planeamento');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_planeamento.curso_id', 'left');
        $this->db->where('gf_planeamento.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_planeamento ($data, $id) {
        $this->first_planeamento($id);
        $vf_existe = $this->db->get_where('gf_planeamento', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Registro de planeamento já foi cadastrada");
			    redirect('gestao_formacao/orcamento');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_planeamento', $data);

        return $this->first_planeamento($id);
    }
    public function delete_planeamento($id) {
        $first = $this->first_planeamento($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_planeamento');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar esta planeamento, esta associada a outras entidades.");
            redirect('gestao_formacao/orcamento');
        }
    }

    public function total_roi()
    {
        $query = $this->db->get('gf_roi')->num_rows();
        return $query;
    }
    public function get_roi () {
        $this->db->select('
            gf_roi.*,

            gf_curso.nome as curso, gf_curso.descricao, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos, gf_curso.aprovadores
        ');
        $this->db->from('gf_roi');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_roi.curso_id', 'left');
        return $this->db->get()->result_array();
    }
    public function create_roi($data)
    {
        $vf_existe = $this->db->get_where('gf_roi', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Registro de roi já foi cadastrada");
            redirect('gestao_formacao/orcamento_roi');
        }
        return $this->db->insert('gf_roi', $data);
    }
    public function first_roi($id) {
        $this->db->select('
            gf_roi.*,

            gf_curso.nome as curso, gf_curso.descricao, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos, gf_curso.aprovadores
        ');
        $this->db->from('gf_roi');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_roi.curso_id', 'left');
        $this->db->where('gf_roi.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_roi ($data, $id) {
        $this->first_roi($id);
        $vf_existe = $this->db->get_where('gf_roi', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Registro de roi já foi cadastrada");
			    redirect('gestao_formacao/orcamento_roi');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_roi', $data);

        return $this->first_roi($id);
    }
    public function delete_roi($id) {
        $first = $this->first_roi($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_roi');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar esta ROI, esta associada a outras entidades.");
            redirect('gestao_formacao/orcamento_roi');
        }
    }

    public function total_risco($status = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        $query = $this->db->get('gf_risco')->num_rows();
        return $query;
    }
    public function get_risco ($status = null) {
        $this->db->select('
            gf_risco.*,
            gf_status.status,
            gf_nivel_risco.nome as nivel_risco, gf_nivel_risco.valor,

            gf_curso.nome as curso, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_risco');
        $this->db->join('gf_status', 'gf_status.id  = gf_risco.status_id', 'left');
        $this->db->join('gf_nivel_risco', 'gf_nivel_risco.id  = gf_risco.nivel_risco_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_risco.curso_id', 'left');
        if ($status) {
            $this->db->where('gf_risco.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function create_risco($data)
    {
        $vf_existe = $this->db->get_where('gf_risco', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Registro de risco já foi cadastrada");
            redirect('gestao_formacao/riscos');
        }
        return $this->db->insert('gf_risco', $data);
    }
    public function first_risco($id) {
        $this->db->select('
            gf_risco.*,
            gf_status.status,
            gf_nivel_risco.nome as nivel_risco, gf_nivel_risco.valor,

            gf_curso.nome as curso, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_risco');
        $this->db->join('gf_status', 'gf_status.id  = gf_risco.status_id', 'left');
        $this->db->join('gf_nivel_risco', 'gf_nivel_risco.id  = gf_risco.nivel_risco_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_risco.curso_id', 'left');
        $this->db->where('gf_risco.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_risco ($data, $id) {
        $this->first_risco($id);
        if (!isset($data['status_id'])) {
            $vf_existe = $this->db->get_where('gf_risco', $data)->row_array();
            if ($vf_existe) {
                if ($id != $vf_existe['id']) {
                    set_alert('danger',"Registro de risco já foi cadastrada");
                    redirect('gestao_formacao/riscos');
                }
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_risco', $data);

        return $this->first_risco($id);
    }
    public function delete_risco($id) {
        $first = $this->first_risco($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_risco');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar esta Risco, esta associada a outras entidades.");
            redirect('gestao_formacao/riscos');
        }
    }

    public function total_conformidade($status = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        $query = $this->db->get('gf_conformidade')->num_rows();
        return $query;
    }
    public function get_conformidade ($status = null) {
        $this->db->select('
            gf_conformidade.*,
            gf_status.status,

            gf_curso.nome as curso, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_conformidade');
        $this->db->join('gf_status', 'gf_status.id  = gf_conformidade.status_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_conformidade.curso_id', 'left');
        if ($status) {
            $this->db->where('gf_conformidade.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function create_conformidade($data)
    {
        $vf_existe = $this->db->get_where('gf_conformidade', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Registro de conformidade já foi cadastrada");
            redirect('gestao_formacao/riscos_conformidade');
        }
        return $this->db->insert('gf_conformidade', $data);
    }
    public function first_conformidade($id) {
        $this->db->select('
            gf_conformidade.*,
            gf_status.status,

            gf_curso.nome as curso, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_conformidade');
        $this->db->join('gf_status', 'gf_status.id  = gf_conformidade.status_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_conformidade.curso_id', 'left');
        $this->db->where('gf_conformidade.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_conformidade ($data, $id) {
        $this->first_conformidade($id);
        if (!isset($data['status_id'])) {
            $vf_existe = $this->db->get_where('gf_conformidade', $data)->row_array();
            if ($vf_existe) {
                if ($id != $vf_existe['id']) {
                    set_alert('danger',"Registro de conformidade já foi cadastrada");
                    redirect('gestao_formacao/riscos_conformidade');
                }
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_conformidade', $data);

        return $this->first_conformidade($id);
    }
    public function delete_conformidade($id) {
        $first = $this->first_conformidade($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_conformidade');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar esta conformidade, esta associada a outras entidades.");
            redirect('gestao_formacao/riscos_conformidade');
        }
    }

    public function total_curso_personalizado($status = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        $query = $this->db->get('gf_curso_personalizado')->num_rows();
        return $query;
    }
    public function get_curso_personalizado ($status = null) {
        $this->db->select('
            gf_curso_personalizado.*,
            staff.*,

            gf_status.status,

            gf_curso.nome as curso, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_curso_personalizado');
        $this->db->join('staff', 'staff.staffid = gf_curso_personalizado.staff_id', 'left');
        $this->db->join('gf_status', 'gf_status.id  = gf_curso_personalizado.status_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_curso_personalizado.curso_id', 'left');
        if ($status) {
            $this->db->where('gf_curso_personalizado.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function create_curso_personalizado($data)
    {
        $vf_existe = $this->db->get_where('gf_curso_personalizado', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Registro de Curso Personalizado já foi cadastrada");
            redirect('gestao_formacao/personalizacao');
        }
        return $this->db->insert('gf_curso_personalizado', $data);
    }
    public function first_curso_personalizado($id) {
        $this->db->select('
            gf_curso_personalizado.*,
            staff.*,

            gf_status.status,

            gf_curso.nome as curso, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_curso_personalizado');
        $this->db->join('staff', 'staff.staffid = gf_curso_personalizado.staff_id', 'left');
        $this->db->join('gf_status', 'gf_status.id  = gf_curso_personalizado.status_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_curso_personalizado.curso_id', 'left');
        $this->db->where('gf_curso_personalizado.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_curso_personalizado ($data, $id) {
        $this->first_curso_personalizado($id);
        if (!isset($data['status_id'])) {
            $vf_existe = $this->db->get_where('gf_curso_personalizado', $data)->row_array();
            if ($vf_existe) {
                if ($id != $vf_existe['id']) {
                    set_alert('danger',"Registro de Curso Personalizado já foi cadastrada");
                    redirect('gestao_formacao/personalizacao');
                }
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_curso_personalizado', $data);

        return $this->first_curso_personalizado($id);
    }
    public function delete_curso_personalizado($id) {
        $first = $this->first_curso_personalizado($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_curso_personalizado');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar este Curso Personalizado, esta associada a outras entidades.");
            redirect('gestao_formacao/personalizacao');
        }
    }

    public function total_compotencia_curso()
    {
        $query = $this->db->get('gf_compotencia_curso')->num_rows();
        return $query;
    }
    public function get_compotencia_curso () {
        $this->db->select('
            gf_compotencia_curso.*,
            gf_competencia.nome as competencia,
            gf_curso.nome as curso, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_compotencia_curso');
        $this->db->join('gf_competencia', 'gf_competencia.id  = gf_compotencia_curso.competencia_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_compotencia_curso.curso_id', 'left');
        return $this->db->get()->result_array();
    }
    public function create_compotencia_curso($data)
    {
        $vf_existe = $this->db->get_where('gf_compotencia_curso', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Registro de Competência de Curso já foi cadastrada");
            redirect('gestao_formacao/competencias');
        }
        return $this->db->insert('gf_compotencia_curso', $data);
    }
    public function first_compotencia_curso($id) {
        $this->db->select('
            gf_compotencia_curso.*,
            gf_competencia.nome as competencia,
            gf_curso.nome as curso, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_compotencia_curso');
        $this->db->join('gf_competencia', 'gf_competencia.id  = gf_compotencia_curso.competencia_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_compotencia_curso.curso_id', 'left');
        $this->db->where('gf_compotencia_curso.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_compotencia_curso ($data, $id) {
        $this->first_compotencia_curso($id);
        $vf_existe = $this->db->get_where('gf_compotencia_curso', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Registro de Competência de Curso já foi cadastrada");
                redirect('gestao_formacao/competencias');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_compotencia_curso', $data);

        return $this->first_compotencia_curso($id);
    }
    public function delete_compotencia_curso($id) {
        $first = $this->first_compotencia_curso($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_compotencia_curso');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar este Competência do Curso, esta associada a outras entidades.");
            redirect('gestao_formacao/competencias');
        }
    }

    public function total_competencia_usuario()
    {
        $query = $this->db->get('gf_competencia_usuario')->num_rows();
        return $query;
    }
    public function get_competencia_usuario () {
        $this->db->select('
            gf_competencia_usuario.*,
            staff.*,

            gf_competencia.nome as competencia,
        ');
        $this->db->from('gf_competencia_usuario');
        $this->db->join('staff', 'staff.staffid = gf_competencia_usuario.staff_id', 'left');
        $this->db->join('gf_competencia', 'gf_competencia.id  = gf_competencia_usuario.competencia_id', 'left');
        return $this->db->get()->result_array();
    }
    public function create_competencia_usuario($data)
    {
        $vf_existe = $this->db->get_where('gf_competencia_usuario', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Registro de Competência do Usuário já foi cadastrada");
            redirect('gestao_formacao/competencias_competencias_usuario');
        }
        return $this->db->insert('gf_competencia_usuario', $data);
    }
    public function first_competencia_usuario($id) {
        $this->db->select('
            gf_competencia_usuario.*,
            staff.*,

            gf_competencia.nome as competencia,
        ');
        $this->db->from('gf_competencia_usuario');
        $this->db->join('staff', 'staff.staffid = gf_competencia_usuario.staff_id', 'left');
        $this->db->join('gf_competencia', 'gf_competencia.id  = gf_competencia_usuario.competencia_id', 'left');
        $this->db->where('gf_competencia_usuario.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_competencia_usuario ($data, $id) {
        $this->first_competencia_usuario($id);
        $vf_existe = $this->db->get_where('gf_competencia_usuario', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Registro de Competência do Usuário já foi cadastrada");
                redirect('gestao_formacao/competencias_competencias_usuario');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_competencia_usuario', $data);

        return $this->first_competencia_usuario($id);
    }
    public function delete_competencia_usuario($id) {
        $first = $this->first_competencia_usuario($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_competencia_usuario');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar este Competência do Usuário, esta associada a outras entidades.");
            redirect('gestao_formacao/competencias_competencias_usuario');
        }
    }

    public function total_recrutamento($status = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        $query = $this->db->get('gf_recrutamento')->num_rows();
        return $query;
    }
    public function get_recrutamento ($status = null, $vaga = null) {
        $this->db->select('
            gf_recrutamento.*,
            staff.*,

            gf_status.status,
            gf_vaga.total_vagas, gf_vaga.data_inicio, gf_vaga.data_fim,

            gf_curso.nome as curso, gf_curso.descricao, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_recrutamento');
        $this->db->join('staff', 'staff.staffid = gf_recrutamento.staff_id', 'left');
        $this->db->join('gf_status', 'gf_status.id  = gf_recrutamento.status_id', 'left');
        $this->db->join('gf_vaga', 'gf_vaga.id  = gf_recrutamento.vaga_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_vaga.curso_id', 'left');
        if ($status) {
            $this->db->where('gf_recrutamento.status_id', $status);
        }
        if ($vaga) {
            $this->db->where('gf_recrutamento.vaga_id', $vaga);
        }
        return $this->db->get()->result_array();
    }
    public function create_recrutamento($data)
    {
        $vf_existe = $this->db->get_where('gf_recrutamento', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Recrutamento já foi cadastrada");
            redirect('gestao_formacao/integracao');
        }
        return $this->db->insert('gf_recrutamento', $data);
    }
    public function first_recrutamento($id) {
        $this->db->select('
            gf_recrutamento.*,
            staff.*,

            gf_status.status,
            gf_vaga.total_vagas, gf_vaga.data_inicio, gf_vaga.data_fim,

            gf_curso.nome as curso, gf_curso.descricao, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_recrutamento');
        $this->db->join('staff', 'staff.staffid = gf_recrutamento.staff_id', 'left');
        $this->db->join('gf_status', 'gf_status.id  = gf_recrutamento.status_id', 'left');
        $this->db->join('gf_vaga', 'gf_vaga.id  = gf_recrutamento.vaga_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_vaga.curso_id', 'left');
        $this->db->where('gf_recrutamento.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_recrutamento ($data, $id) {
        $this->first_recrutamento($id);
        if (!isset($data['status_id'])) {
            $vf_existe = $this->db->get_where('gf_recrutamento', $data)->row_array();
            if ($vf_existe) {
                if ($id != $vf_existe['id']) {
                    set_alert('danger',"Recrutamento já foi cadastrada");
                    redirect('gestao_formacao/integracao');
                }
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_recrutamento', $data);

        return $this->first_recrutamento($id);
    }
    public function delete_recrutamento($id) {
        $first = $this->first_recrutamento($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_recrutamento');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar esta Recrutamento, esta associada a outras entidades.");
            redirect('gestao_formacao/integracao');
        }
    }

    public function total_aval_desempenho()
    {
        $query = $this->db->get('gf_aval_desempenho')->num_rows();
        return $query;
    }
    public function get_aval_desempenho () {
        $this->db->select('
            gf_aval_desempenho.*,
            gf_competencia.nome as competencia,

            staff.*,

            gf_vaga.total_vagas, gf_vaga.data_inicio, gf_vaga.data_fim,

            gf_curso.nome as curso, gf_curso.descricao, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_aval_desempenho');
        $this->db->join('gf_competencia', 'gf_competencia.id  = gf_aval_desempenho.competencia_id', 'left');
        $this->db->join('gf_recrutamento', 'gf_recrutamento.id  = gf_aval_desempenho.recrutamento_id', 'left');

        $this->db->join('staff', 'staff.staffid = gf_recrutamento.staff_id', 'left');
        $this->db->join('gf_vaga', 'gf_vaga.id  = gf_recrutamento.vaga_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_vaga.curso_id', 'left');
        return $this->db->get()->result_array();
    }
    public function create_aval_desempenho($data)
    {
        $vf_existe = $this->db->get_where('gf_aval_desempenho', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Registro de Competência do Usuário já foi cadastrada");
            redirect('gestao_formacao/integracao_Avaliacao_desempenho');
        }
        return $this->db->insert('gf_aval_desempenho', $data);
    }
    public function first_aval_desempenho($id) {
        $this->db->select('
            gf_aval_desempenho.*,
            gf_competencia.nome as competencia,

            staff.*,

            gf_vaga.total_vagas, gf_vaga.data_inicio, gf_vaga.data_fim,

            gf_curso.nome as curso, gf_curso.descricao, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_aval_desempenho');
        $this->db->join('gf_competencia', 'gf_competencia.id  = gf_aval_desempenho.competencia_id', 'left');
        $this->db->join('gf_recrutamento', 'gf_recrutamento.id  = gf_aval_desempenho.recrutamento_id', 'left');

        $this->db->join('staff', 'staff.staffid = gf_recrutamento.staff_id', 'left');
        $this->db->join('gf_vaga', 'gf_vaga.id  = gf_recrutamento.vaga_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_vaga.curso_id', 'left');
        $this->db->where('gf_aval_desempenho.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_aval_desempenho ($data, $id) {
        $this->first_aval_desempenho($id);
        $vf_existe = $this->db->get_where('gf_aval_desempenho', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Registro de Competência do Usuário já foi cadastrada");
                redirect('gestao_formacao/integracao_Avaliacao_desempenho');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_aval_desempenho', $data);

        return $this->first_aval_desempenho($id);
    }
    public function delete_aval_desempenho($id) {
        $first = $this->first_aval_desempenho($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_aval_desempenho');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar este Competência do Usuário, esta associada a outras entidades.");
            redirect('gestao_formacao/integracao_Avaliacao_desempenho');
        }
    }

    public function total_conformidade_regulatoria($status = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        $query = $this->db->get('gf_conformidade_regulatoria')->num_rows();
        return $query;
    }
    public function get_conformidade_regulatoria ($status = null) {
        $this->db->select('
            gf_conformidade_regulatoria.*,

            gf_status.status,

            gf_curso.nome as curso, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_conformidade_regulatoria');
        $this->db->join('gf_status', 'gf_status.id  = gf_conformidade_regulatoria.status_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_conformidade_regulatoria.curso_id', 'left');
        if ($status) {
            $this->db->where('gf_conformidade_regulatoria.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function create_conformidade_regulatoria($data)
    {
        $vf_existe = $this->db->get_where('gf_conformidade_regulatoria', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Registro de Conformidade Regulatória já foi cadastrada");
            redirect('gestao_formacao/compliance');
        }
        return $this->db->insert('gf_conformidade_regulatoria', $data);
    }
    public function first_conformidade_regulatoria($id) {
        $this->db->select('
            gf_conformidade_regulatoria.*,

            gf_status.status,

            gf_curso.nome as curso, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_conformidade_regulatoria');
        $this->db->join('gf_status', 'gf_status.id  = gf_conformidade_regulatoria.status_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_conformidade_regulatoria.curso_id', 'left');
        $this->db->where('gf_conformidade_regulatoria.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_conformidade_regulatoria ($data, $id) {
        $this->first_conformidade_regulatoria($id);
        if (!isset($data['status_id'])) {
            $vf_existe = $this->db->get_where('gf_conformidade_regulatoria', $data)->row_array();
            if ($vf_existe) {
                if ($id != $vf_existe['id']) {
                    set_alert('danger',"Registro de Conformidade Regulatória já foi cadastrada");
                    redirect('gestao_formacao/compliance');
                }
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_conformidade_regulatoria', $data);

        return $this->first_conformidade_regulatoria($id);
    }
    public function delete_conformidade_regulatoria($id) {
        $first = $this->first_conformidade_regulatoria($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_conformidade_regulatoria');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar este Conformidade Regulatória, esta associada a outras entidades.");
            redirect('gestao_formacao/compliance');
        }
    }

    public function total_certificado_acreditacao()
    {
        $query = $this->db->get('gf_certificado_acreditacao')->num_rows();
        return $query;
    }
    public function get_certificado_acreditacao () {
        $this->db->select('
            gf_certificado_acreditacao.*,

            gf_curso.nome as curso, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_certificado_acreditacao');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_certificado_acreditacao.curso_id', 'left');
        return $this->db->get()->result_array();
    }
    public function create_certificado_acreditacao($data)
    {
        $vf_existe = $this->db->get_where('gf_certificado_acreditacao', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Registro de Certificado de Acreditação já foi cadastrada");
            redirect('gestao_formacao/compliance_avaliacao');
        }
        return $this->db->insert('gf_certificado_acreditacao', $data);
    }
    public function first_certificado_acreditacao($id) {
        $this->db->select('
            gf_certificado_acreditacao.*,

            gf_curso.nome as curso, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_certificado_acreditacao');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_certificado_acreditacao.curso_id', 'left');
        $this->db->where('gf_certificado_acreditacao.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_certificado_acreditacao ($data, $id) {
        $this->first_certificado_acreditacao($id);
        $vf_existe = $this->db->get_where('gf_certificado_acreditacao', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Registro de Certificado de Acreditação já foi cadastrada");
                redirect('gestao_formacao/compliance_avaliacao');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_certificado_acreditacao', $data);

        return $this->first_certificado_acreditacao($id);
    }
    public function delete_certificado_acreditacao($id) {
        $first = $this->first_certificado_acreditacao($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_certificado_acreditacao');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar este Certificado de Acreditação, esta associada a outras entidades.");
            redirect('gestao_formacao/compliance_avaliacao');
        }
    }

    public function total_plataforma_ead($status = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        $query = $this->db->get('gf_plataforma_ead')->num_rows();
        return $query;
    }
    public function get_plataforma_ead ($status = null) {
        $this->db->select('
            gf_plataforma_ead.*,

            gf_status.status,
        ');
        $this->db->from('gf_plataforma_ead');
        $this->db->join('gf_status', 'gf_status.id  = gf_plataforma_ead.status_id', 'left');
        if ($status) {
            $this->db->where('gf_plataforma_ead.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function create_plataforma_ead($data)
    {
        $vf_existe = $this->db->get_where('gf_plataforma_ead', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Registro de Plataforma EAD já foi cadastrada");
            redirect('gestao_formacao/tec_acesso');
        }
        return $this->db->insert('gf_plataforma_ead', $data);
    }
    public function first_plataforma_ead($id) {
        $this->db->select('
            gf_plataforma_ead.*,

            gf_status.status,
        ');
        $this->db->from('gf_plataforma_ead');
        $this->db->join('gf_status', 'gf_status.id  = gf_plataforma_ead.status_id', 'left');
        $this->db->where('gf_plataforma_ead.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_plataforma_ead ($data, $id) {
        $this->first_plataforma_ead($id);
        if (!isset($data['status_id'])) {
            $vf_existe = $this->db->get_where('gf_plataforma_ead', $data)->row_array();
            if ($vf_existe) {
                if ($id != $vf_existe['id']) {
                    set_alert('danger',"Registro de Plataforma EAD já foi cadastrada");
                    redirect('gestao_formacao/tec_acesso');
                }
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_plataforma_ead', $data);

        return $this->first_plataforma_ead($id);
    }
    public function delete_plataforma_ead($id) {
        $first = $this->first_plataforma_ead($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_plataforma_ead');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar este Plataforma EAD, esta associada a outras entidades.");
            redirect('gestao_formacao/tec_acesso');
        }
    }

    public function total_acessibilidade($status = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        $query = $this->db->get('gf_acessibilidade')->num_rows();
        return $query;
    }
    public function get_acessibilidade ($status = null) {
        $this->db->select('
            gf_acessibilidade.*,
            gf_status.status,

            gf_curso.nome as curso, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_acessibilidade');
        $this->db->join('gf_status', 'gf_status.id  = gf_acessibilidade.status_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_acessibilidade.curso_id', 'left');
        if ($status) {
            $this->db->where('gf_acessibilidade.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function create_acessibilidade($data)
    {
        $vf_existe = $this->db->get_where('gf_acessibilidade', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Registro de Acessibilidade já foi cadastrada");
            redirect('gestao_formacao/tec_acesso_avaliacao');
        }
        return $this->db->insert('gf_acessibilidade', $data);
    }
    public function first_acessibilidade($id) {
        $this->db->select('
            gf_acessibilidade.*,

            gf_status.status,

            gf_curso.nome as curso, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_acessibilidade');
        $this->db->join('gf_status', 'gf_status.id  = gf_acessibilidade.status_id', 'left');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_acessibilidade.curso_id', 'left');
        $this->db->where('gf_acessibilidade.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_acessibilidade ($data, $id) {
        $this->first_acessibilidade($id);
        if (!isset($data['status_id'])) {
            $vf_existe = $this->db->get_where('gf_acessibilidade', $data)->row_array();
            if ($vf_existe) {
                if ($id != $vf_existe['id']) {
                    set_alert('danger',"Registro de Acessibilidade já foi cadastrada");
                    redirect('gestao_formacao/tec_acesso_avaliacao');
                }
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_acessibilidade', $data);

        return $this->first_acessibilidade($id);
    }
    public function delete_acessibilidade($id) {
        $first = $this->first_acessibilidade($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_acessibilidade');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar esta Acessibilidade, esta associada a outras entidades.");
            redirect('gestao_formacao/tec_acesso_avaliacao');
        }
    }

    public function total_suporte($status = null)
    {
        if ($status != null) {
            $this->db->where('status_id', $status);
        }
        $query = $this->db->get('gf_suporte')->num_rows();
        return $query;
    }
    public function get_suporte ($status = null) {
        $this->db->select('
            gf_suporte.*,
            staff.*,

            gf_status.status,
        ');
        $this->db->from('gf_suporte');
        $this->db->join('staff', 'staff.staffid = gf_suporte.staff_id', 'left');
        $this->db->join('gf_status', 'gf_status.id  = gf_suporte.status_id', 'left');
        if ($status) {
            $this->db->where('gf_suporte.status_id', $status);
        }
        return $this->db->get()->result_array();
    }
    public function create_suporte($data)
    {
        $vf_existe = $this->db->get_where('gf_suporte', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Registro de Suporte já foi cadastrada");
            redirect('gestao_formacao/suporte');
        }
        return $this->db->insert('gf_suporte', $data);
    }
    public function first_suporte($id) {
        $this->db->select('
            gf_suporte.*,
            staff.*,

            gf_status.status,
        ');
        $this->db->from('gf_suporte');
        $this->db->join('staff', 'staff.staffid = gf_suporte.staff_id', 'left');
        $this->db->join('gf_status', 'gf_status.id  = gf_suporte.status_id', 'left');
        $this->db->where('gf_suporte.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_suporte ($data, $id) {
        $this->first_suporte($id);
        if (!isset($data['status_id'])) {
            $vf_existe = $this->db->get_where('gf_suporte', $data)->row_array();
            if ($vf_existe) {
                if ($id != $vf_existe['id']) {
                    set_alert('danger',"Registro de Suporte já foi cadastrada");
                    redirect('gestao_formacao/suporte');
                }
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_suporte', $data);

        return $this->first_suporte($id);
    }
    public function delete_suporte($id) {
        $first = $this->first_suporte($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_suporte');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar este Suporte, esta associada a outras entidades.");
            redirect('gestao_formacao/suporte');
        }
    }

    public function total_recurso()
    {
        $query = $this->db->get('gf_recurso')->num_rows();
        return $query;
    }
    public function get_recurso () {
        $this->db->select('
            gf_recurso.*,

            gf_curso.nome as curso, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_recurso');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_recurso.curso_id', 'left');
        return $this->db->get()->result_array();
    }
    public function create_recurso($data)
    {
        $vf_existe = $this->db->get_where('gf_recurso', $data)->row_array();
        if ($vf_existe) {
            set_alert('danger',"Registro de Eecurso já foi cadastrada");
            redirect('gestao_formacao/suporte_recurso');
        }
        return $this->db->insert('gf_recurso', $data);
    }
    public function first_recurso($id) {
        $this->db->select('
            gf_recurso.*,

            gf_curso.nome as curso, gf_curso.carga_horaria,
            gf_curso.publico_alvo, gf_curso.requisitos
        ');
        $this->db->from('gf_recurso');
        $this->db->join('gf_curso', 'gf_curso.id  = gf_recurso.curso_id', 'left');
        $this->db->where('gf_recurso.id', $id);
        $query = $this->db->get()->row_array();
        if (!$query) {
            show_404();
            exit;
        }
        return $query;
    }
    public function update_recurso ($data, $id) {
        $this->first_recurso($id);
        $vf_existe = $this->db->get_where('gf_recurso', $data)->row_array();
        if ($vf_existe) {
            if ($id != $vf_existe['id']) {
                set_alert('danger',"Registro de Eecurso já foi cadastrada");
                redirect('gestao_formacao/suporte_recurso');
            }
        }
        $this->db->where('id', $id);
        $this->db->update('gf_recurso', $data);

        return $this->first_recurso($id);
    }
    public function delete_recurso($id) {
        $first = $this->first_recurso($id);
        try {
            $this->db->where('id', $id);
            $this->db->delete('gf_recurso');
            return $first;
        }
        catch(Exception $e) {
            set_alert('danger',"Não podes Eliminar este Eecurso, esta associada a outras entidades.");
            redirect('gestao_formacao/suporte_recurso');
        }
    }
}