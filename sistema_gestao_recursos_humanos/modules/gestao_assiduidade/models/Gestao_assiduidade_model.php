<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gestao_assiduidade_model extends App_Model {
	public function __construct() {
		parent::__construct();
	}
    public function vf_ferias_existe($id, $data_inicio, $data_fim) {
        $ano = date('Y');
        $query = $this->db->get_where('as_ferias', [
            'ano_fiscal' => $ano,
            'func_id' => $id,
        ])->result_array();
        foreach ($query as $q) {
            if (strtotime($q['de']) <= strtotime($data_inicio) AND strtotime($q['ate']) >= strtotime($data_inicio)) {
                return true;
            }
            elseif (strtotime($q['de']) == strtotime($data_inicio)) {
                return true;
            }
        }
        return false;
    }
    public function get_staff($id = '', $where = [])
	{
		$select_str = '*,CONCAT(firstname," ",lastname) as full_name';
		if (is_staff_logged_in() && $id != '' && $id == get_staff_user_id()) {
			$select_str .= ',(SELECT COUNT(*) FROM ' . db_prefix() . 'notifications WHERE touserid=' . get_staff_user_id() . ' and isread=0) as total_unread_notifications, (SELECT COUNT(*) FROM ' . db_prefix() . 'todos WHERE finished=0 AND staffid=' . get_staff_user_id() . ') as total_unfinished_todos';
		}

		$this->db->select($select_str);
		$this->db->where($where);

		if (is_numeric($id)) {
			$this->db->where('staffid', $id);
			$staff = $this->db->get(db_prefix() . 'staff')->row();
			return $staff;
		}
		$this->db->order_by('firstname', 'desc');

		return $this->db->get(db_prefix() . 'staff')->result_array();
	}
    public function get_staff_by_department($id = '')
	{
            $this->db->select('staff.staffid as staffid,staff.firstname as firstname,staff.lastname as lastname,staff.turnos_id as turnos_id, dpt.name as name_dpt, staff.turnos_id as turnos_id');
            $this->db->from('tblstaff_departments as staff_dpt');
            $this->db->join('tbldepartments as dpt', 'staff_dpt.departmentid = dpt.departmentid');
            $this->db->join('tblstaff as staff', 'staff.staffid = staff_dpt.staffid');
            $this->db->where('dpt.departmentid',$id);
            $query = $this->db->get();
            return  $query->result_array();
    }
    public function get_departments(){
        return $this->db->get(db_prefix() . 'departments')->result_array();
    }
    public function get_departments_by_id($id= ''){
        $this->db->where('departmentid',$id);
        return $this->db->get(db_prefix() . 'departments')->row();
    }


    //PERIODO LABORAL
    public function get_periodos() { 
        return $this->db->get(db_prefix() . 'as_periodo_laboral')->result_array();
	}
    public function get_periodos_by_id($id = '') { 
        if ($id != '') {
            $this->db->where('id', $id);
             return $this->db->get(db_prefix() . 'as_periodo_laboral')->row();
        }
       return [];
	}
	public function add_periodos($data=[]) { 
        try {
            $this->db->insert(db_prefix() . 'as_periodo_laboral', $data);
            return true;
        } catch (\Throwable $th) {
            return false;
        } 
	}
    public function edit_periodos($id,$data=[]) { 
        try {
            $this->db->where('id', $id);
		    $this->db->update(db_prefix() . 'as_periodo_laboral', $data);
            return true;
        } catch (\Throwable $th) {
            return false;
        } 
	}

    public function delete_periodos($id,$data=[]) { 
        try {
            $this->db->where('id', $id);
            $this->db->delete(db_prefix() . 'as_periodo_laboral');
            return true;
        } catch (\Throwable $th) {
            return false;
        } 
	}
 //END PERIODO LABORAL

//FERIADOS
     public function get_feriados() { 
        return $this->db->get(db_prefix() . 'as_feriados')->result_array();
	}
	public function add_feriados($data=[]) { 
        try {
            $this->db->insert(db_prefix() . 'as_feriados', $data);
            return true;
        } catch (\Throwable $th) {
            return false;
        } 
	}
    public function edit_feriados($id,$data=[]) { 
        try {
            $this->db->where('id', $id);
		    $this->db->update(db_prefix() . 'as_feriados', $data);
            return true;
        } catch (\Throwable $th) {
            return false;
        } 
	}

    public function delete_feriados($id,$data=[]) { 
        try {
            $this->db->where('id', $id);
            $this->db->delete(db_prefix() . 'as_feriados');
            return true;
        } catch (\Throwable $th) {
            return false;
        } 
	}
 //END FERIADOS
 //BIOMETRICOS
 public function get_biometricos() { 
    return $this->db->get(db_prefix() . 'as_biometricos')->result_array();
}
public function add_biometricos($data=[]) { 
    try {
        $this->db->insert(db_prefix() . 'as_biometricos', $data);
        return true;
    } catch (\Throwable $th) {
        return false;
    } 
}
public function edit_biometricos($id,$data=[]) { 
    try {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'as_biometricos', $data);
        return true;
    } catch (\Throwable $th) {
        return false;
    } 
}

public function delete_biometricos($id,$data=[]) { 
    try {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'as_biometricos');
        return true;
    } catch (\Throwable $th) {
        return false;
    } 
}
//END BIOMETRICOS

 //HORARIOS E TURNOS 
 public function get_horario_turno() { 
    return $this->db->get(db_prefix() . 'as_turnos')->result_array();
}
public function get_horario_turno_by_id($id= '') { 
    if ($id != '') {
        $this->db->where('id',$id);
        return $this->db->get(db_prefix() . 'as_turnos')->row();
    }else {
        return false;
    }
}
public function add_horario_turno($data=[]) { 
    try {
        $this->db->insert(db_prefix() . 'as_turnos', $data);
        return true;
    } catch (\Throwable $th) {
        echo  $th;die;
        return false;
    } 
}
public function edit_horario_turno($id,$data=[]) { 
    try {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'as_turnos', $data);
        return true;
    } catch (\Throwable $th) {
        return false;
    } 
}

public function delete_horario_turno($id,$data=[]) { 
    try {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'as_turnos');
        return true;
    } catch (\Throwable $th) {
        return false;
    } 
}
//END HORARIOS E TURNOS 
   
public function  atr_horario_turno($id,$data=[]) { 
  
    try {
        $this->db->where('staffid', $id);
        $this->db->update(db_prefix() . 'staff', $data); 
        return true;
    } catch (\Throwable $th) {
        return false;
    } 
}
public function add_marcacoes($data= [],$parms= []){ 
    foreach ($data as $key => $value) {
        try {
            $this->db->where('fun_id', $parms['funcionarios_id']);
            $this->db->where('data',    $value);
            $rs = $this->db->get(db_prefix() . 'as_marcacoes')->result_array();
            if (count($rs)<=0) {
                $this->db->insert(db_prefix() . 'as_marcacoes', [
                    'data'  => $value,
                    'fun_id'=> $parms['funcionarios_id'],
                    'dep_id'=> $parms['departmentid'],
                 ]);
            }
        } catch (\Throwable $th) {
        } 
   }
}
public function edit_marcacoes($id,$data=[]){ 
    try {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'as_marcacoes', $data); 
        return true;
    } catch (\Throwable $th) {
        return false;
    }
}
public function add_marcacoes_in_out($data= []){ 
        try {
            $this->db->insert(db_prefix() . 'as_marcacoes_in_out',$data);
            $total_trab_dec = 0;
            $num            = 0; 
            $marc_in_out_array = $this->get_marcacoes_in_out($data['marc_id']);
            foreach ($marc_in_out_array as $key => $value) {
                $num++;
                $total_trab_dec += $this->resolveHora($value['marc_in'],$value['marc_out'])['hora_decimal'];
            }
            if ($total_trab_dec > 8.00) {
                $val['horas_extras']      = number_format(($total_trab_dec-8),2);
                $val['horas_trabalhadas'] = '8.00';
                $this->edit_marcacoes($data['marc_id'],$val);
            }else {
                $val['horas_trabalhadas'] = number_format($total_trab_dec,2);
                $this->edit_marcacoes($data['marc_id'],$val);
            }
           
            return true;
        } catch (\Throwable $th) {
        } 
}
public function rem_marcacoes_in_out($id,$id_mark){ 
    try { 
        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'as_marcacoes_in_out');

        $total_trab_dec = 0;
        $num            = 0; 
        $marc_in_out_array = $this->get_marcacoes_in_out($id_mark);
        foreach ($marc_in_out_array as $key => $value) {
            $num++;
            $total_trab_dec += $this->resolveHora($value['marc_in'],$value['marc_out'])['hora_decimal'];      
        }
        if ($total_trab_dec > 8.00) {
            $val['horas_extras']      = number_format(($total_trab_dec-8),2);
            $val['horas_trabalhadas'] = '8.00';
            $this->edit_marcacoes($id_mark,$val);
        }else {
            $val['horas_trabalhadas'] = number_format($total_trab_dec,2);
            $this->edit_marcacoes($id_mark,$val);
        }
        return true;
    } catch (\Throwable $th) {
       echo $th;die;
    } 
}
public function get_marcacoes_in_out($id){ 
    if ($id != '') {
        $this->db->where('marc_id',$id);
        $this->db->order_by('marc_in','asc');
        return $this->db->get(db_prefix() . 'as_marcacoes_in_out')->result_array();
    }else {
        return [];
    }
}
public function get_marcacoes_by_data_and_id_func($data='',$fun_id=''){ 
    if ($data != '') {
        $this->db->where('data',$data);
        $this->db->where('fun_id',$fun_id);
        return $this->db->get(db_prefix() . 'as_marcacoes')->row();
    }else {
        return [];
    }
}

public function get_minha_assiduidade($funcionarios_id='',$de='',$ate=''){ 
    if ($de != '' && $ate !='') {
        $this->db->where('data >=',$de);
        $this->db->where('data <=',$ate);
        $this->db->where('fun_id',$funcionarios_id);
        return $this->db->get(db_prefix() . 'as_marcacoes')->result_array();
    }else {
        return $this->db->get(db_prefix() . 'as_marcacoes')->result_array();
    }
}


public function get_assiduidade_dpt($dep_id='',$de='',$ate=''){ 
    if ($de != '' && $ate !='' && $dep_id !='0') {
        $this->db->where('data >=',$de);
        $this->db->where('data <=',$ate);
        if ($dep_id!=0) {
            $this->db->where('dep_id',$dep_id);
        }
        $this->db->order_by('fun_id', 'desc');
        return $this->db->get(db_prefix() . 'as_marcacoes')->result_array();
    }else {
        $this->db->order_by('fun_id', 'desc');
        return $this->db->get(db_prefix() . 'as_marcacoes')->result_array();
    }
}
public function get_assiduidade_diaria_dpt($dep_id='',$de='',$ate=''){ 
    if ($de != '' && $ate !='') {
        $this->db->where('data >=',$de);
        $this->db->where('data <=',$ate);
        if ($dep_id!=0) {
            $this->db->where('dep_id',$dep_id);
        }
        $this->db->order_by('fun_id', 'desc');
        return $this->db->get(db_prefix() . 'as_marcacoes')->result_array();
    }else {
        $this->db->order_by('fun_id', 'desc');
        return $this->db->get(db_prefix() . 'as_marcacoes')->result_array();
    }
}


public function resolveHora($entrada='',$saida=''){
        $timestamp_entrada = strtotime($entrada);
        $timestamp_saida = strtotime($saida);
        $diferenca_segundos = $timestamp_saida - $timestamp_entrada;
        $horas_decimal = $diferenca_segundos / 3600;
        $horas_formato_normal = gmdate("H:i", $diferenca_segundos);
        $data['hora_normal'] = $horas_formato_normal;
        $data['hora_decimal'] = $horas_decimal;
        return $data;
}


//CONF. FERIAS
public function get_conf_ferias() { 
    $result = $this->db->get(db_prefix() . 'as_conf_ferias')->result_array();
    if(count($result) <= 0){
        try {
            $this->db->insert(db_prefix() . 'as_conf_ferias', [
                'limite_dias_ferias'        => '30',
                'n_func_em_ferias'          => '10',
                'email_notificacao_inicio'  => 'A sua féria foi aprovada!',
                'email_notificacao_termino' => 'As suas ferias terminaram!',
             ]);
            $result = $this->db->get(db_prefix() . 'as_conf_ferias')->result_array();
        } catch (\Throwable $th) {
            return [];
        }
        
    }
    return $result;
}
public function salvar_conf_ferias($input=[]) { 
    try {
        $this->db->where('id',$input['id']);
        $this->db->update(db_prefix() . 'as_conf_ferias', $input);
         return true;
    } catch (\Throwable $th) {
        return false;
    }
}
//GESTAO FERIAS
    public function get_gestao_ferias($filtros = []) {
        $this->db->select('*'); 
        if (isset($filtros['departmentid']) && $filtros['departmentid']  != '0') {
            $this->db->where('dep_id',$filtros['departmentid']);
        }
        if(isset($filtros['funcao_id'])) {
           
        }
        if (isset($filtros['estado']) && $filtros['estado'] != '0') {
            $this->db->where('estado',$filtros['estado']);
        }
        $this->db->order_by('id','desc');
        $result = $this->db->get(db_prefix() . 'as_ferias')->result_array();
        return $result;
    }

    
    public function get_gestao_ferias_funcionarios($filtros = []) {
        $this->db->select('*'); 
        if (isset($filtros['filtros']['departmentid']) && $filtros['filtros']['departmentid']  != '0') {
            $this->db->where('dep_id',$filtros['filtros']['departmentid']);
        }
        if (isset($filtros['estado']) && $filtros['estado'] != '0') {
            $this->db->where('estado',$filtros['estado']);
        }
        $this->db->order_by('id','desc');
        $result = $this->db->get(db_prefix() . 'as_ferias')->result_array();
        return $result;
    }
    public function add_gestao_ferias($input=[]) { 
        try {
            $this->db->insert(db_prefix() . 'as_ferias', [
                'descricao'                      => $input['descricao'],
                'func_id'                        => $input['func_id'],
                'dep_id'                         => $input['dep_id'],
                'funcao_id'                      => $input['funcao_id'],
                'estado'                         => $input['estado'],
                'de'                             => $input['de'],
                'ate'                            => $input['ate'],
                'data'                           => $input['data'],
                'n_dias'                         => $input['n_dias'], 
                'dias_usados'                    => '0',
                'ano_fiscal'                     => date('Y'),
            ]);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function update_estado_gestao_ferias($input){
        try {
            $data['estado']         = $input['estado'];
            if ($input['estado'] == 'E') {
                $data['data_inicio']    = date('Y-m-d');
            }
           
            $this->db->where('id',$input['id']);
            $this->db->update(db_prefix() . 'as_ferias', $data);
             return true;
        } catch (\Throwable $th) {
            return false;
        }
    }


    

    public function add_marcacoes_in_out_painel(){ 
        $json = [];
        $id_func = get_staff_user_id();
        $this->db->where('data',date('Y-m-d'));
        $this->db->where('fun_id',$id_func);
        $result =  $this->db->get(db_prefix() . 'as_marcacoes')->row();

        if (!isset($result)) {
           return false;
        }
         
        $this->db->where('marc_id',$result->id);  
        $this->db->where('marc_out',null);
        $result1 =  $this->db->get(db_prefix() . 'as_marcacoes_in_out')->row();
        if (!isset($result1)) {
            $data = [];
            try {
                $data['marc_id']  = $result->id;
                $data['marc_in']  = date('H:i:s');
                $this->db->insert(db_prefix() . 'as_marcacoes_in_out',$data);
                return true;
            } catch (\Throwable $th) {
                return false;
            }

        }else {
            $data = [];
            try {
                
                $this->db->where('marc_id',$result->id);  
                $result1 =  $this->db->get(db_prefix() . 'as_marcacoes_in_out')->result_array();
                $id_in_out = $result1[count($result1) - 1]['id'];

                $data['marc_out']  = date('H:i:s');
                $this->db->where('id',$id_in_out);
                $this->db->update(db_prefix() . 'as_marcacoes_in_out',$data);

                $total_trab_dec = 0;
                $num            = 0; 
                $marc_in_out_array = $this->get_marcacoes_in_out($result->id);
                foreach ($marc_in_out_array as $key => $value) {
                    $num++;
                    $total_trab_dec += $this->resolveHora($value['marc_in'],$value['marc_out'])['hora_decimal'];
                }
                if ($total_trab_dec > 8.00) {
                    $val['horas_extras']      = number_format(($total_trab_dec-8),2);
                    $val['horas_trabalhadas'] = '8.00';
                    $this->edit_marcacoes($result->id,$val);
                }else {
                    $val['horas_trabalhadas'] = number_format($total_trab_dec,2);
                    $this->edit_marcacoes($result->id,$val);
                }
               
                return true;
            } catch (\Throwable $th) {
                return false;
            } 
        }

   }



    public function get_cards() {
        //total de funcionarios
        $result                             = $this->gestao_assiduidade_model->get_staff('', ['active' => 1]);
        $data['total_funcionarios']         =   count( $result  );

        $ano = date('Y');
        $primeiro_dia = date('Y-m-d', strtotime("first day of January $ano"));
        $ultimo_dia = date('Y-m-d', strtotime("last day of December $ano"));

 
        $this->db->where('data >=', $primeiro_dia);
        $this->db->where('data <=', $ultimo_dia);
        $result  = $this->db->get(db_prefix() . 'as_marcacoes')->result_array();

        $data['total_registros'] = 0;
        $horas_extras = 0;
        foreach ($result as $key => $value) {
            $rs_extra = isset($value['horas_extras'])?$value['horas_extras']: 0;
            if ($rs_extra > 0) {
                $horas_extras ++; 
            }
           
            $this->db->where('marc_id', $value['id']);
            $result_1  = $this->db->get(db_prefix() . 'as_marcacoes_in_out')->result_array();
            $data['total_registros']                +=   count( $result_1  );
        }

        $data['estatisticas']['check_in']           = $data['total_registros']; 
        $data['estatisticas']['horas_extras']       = $horas_extras; 
       
        $data['total_turnos']         = count($this->get_horario_turno());
        $data['total_entrevistas']    = 0;  

        $result  = $this->db->get(db_prefix() . 'as_feriados')->result_array();
        $data['total_feriados']       = count($result); 
        
        $data['em_lecencas']   =  count($this->get_gestao_ferias(['estado'=>'E']));

        $meses = array(
            1 => array('posicao' => '01', 'numero' => 1, 'nome' => 'Janeiro'),
            2 => array('posicao' => '02', 'numero' => 2, 'nome' => 'Fevereiro'),
            3 => array('posicao' => '03', 'numero' => 3, 'nome' => 'Março'),
            4 => array('posicao' => '04', 'numero' => 4, 'nome' => 'Abril'),
            5 => array('posicao' => '05', 'numero' => 5, 'nome' => 'Maio'),
            6 => array('posicao' => '06', 'numero' => 6, 'nome' => 'Junho'),
            7 => array('posicao' => '07', 'numero' => 7, 'nome' => 'Julho'),
            8 => array('posicao' => '08', 'numero' => 8, 'nome' => 'Agosto'),
            9 => array('posicao' => '09', 'numero' => 9, 'nome' => 'Setembro'),
            10 => array('posicao' => '10', 'numero' => 10, 'nome' => 'Outubro'),
            11 => array('posicao' => '11', 'numero' => 11, 'nome' => 'Novembro'),
            12 => array('posicao' => '12', 'numero' => 12, 'nome' => 'Dezembro')
        );
        
        // Horas extras por mes e presencas por mes
        $he_vector = [];
        foreach ($meses as $key => $value) {
           $he_vector [$value['posicao']]      =  0;
           $check_in_vector[$value['posicao']] =  0;
           $horas_extras                       =  0;
           $check_in                           =  0;

           $primeiro_dia = isset($this->obterPrimeiroUltimoDiaMes($value['posicao'])['data1'])?$this->obterPrimeiroUltimoDiaMes($value['posicao'])['data1']: 0;
           $ultimo_dia   = isset($this->obterPrimeiroUltimoDiaMes($value['posicao'])['data2'])?$this->obterPrimeiroUltimoDiaMes($value['posicao'])['data2']: 0;

           $this->db->where('data >=', $primeiro_dia);
           $this->db->where('data <=', $ultimo_dia);
           $result  = $this->db->get(db_prefix() . 'as_marcacoes')->result_array();

           foreach ($result as $key => $val) {
               $horas_extras += isset($val['horas_extras'])?$val['horas_extras']: 0;
               //Dados de presencas no mes
                $this->db->where('marc_id', $val['id']);
                $result_1  = $this->db->get(db_prefix() . 'as_marcacoes_in_out')->result_array();
                $check_in          += count( $result_1  );
           }
           $he_vector [$value['posicao']]          = $horas_extras;
           $check_in_vector[$value['posicao']]     = $check_in;
           
        }
        $data['grafico_he']         =  $he_vector;
        $data['grafico_presenca']   =  $check_in_vector;


        $data['biometricos']  =  $this->get_biometricos();

        return $data;
    }
    public function obterPrimeiroUltimoDiaMes($mes) {
        $ano = date('Y');
        $primeiro_dia = date('Y-m-d', strtotime("first day of $ano-$mes-01"));
        $ultimo_dia = date('Y-m-d', strtotime("last day of $ano-$mes-01"));
        
        return [
            'data1' =>$primeiro_dia,
            'data2' => $ultimo_dia,
        ];
    }
    
}