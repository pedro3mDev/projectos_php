<?php

use function Clue\StreamFilter\fun;

defined('BASEPATH') or exit('No direct script access allowed');

// function gv_status_exists($name){
// 	$CI = & get_instance();
// 	$i = count($CI->db->query('Select * from '.db_prefix().'gv_status where status = '.$name)->result_array());
// 	if($i == 0){
// 		return 0;
// 	}
// 	if($i > 0){
// 		return 1;
// 	}
// }


function gv_tipo_viagem_exists($id){
	$CI = & get_instance();
	$i = count($CI->db->query('Select * from '.db_prefix().'gv_tipo_viagem where id = '.$id)->result_array());
	if($i == 0){
		return 0;
	}
	if($i > 0){
		return 1;
	}
}
// function pl_status_exists($name){
// 	$CI = & get_instance();
// 	$i = count($CI->db->query('Select * from '.db_prefix().'pl_status where status = '.$name)->result_array());
// 	if($i == 0){
// 		return 0;
// 	}
// 	if($i > 0){
// 		return 1;
// 	}
// }

// function bellmanFord($graph, $vertices, $start) {
//     // Inicializar as distâncias e predecessores
//     $dist = [];
//     $predecessor = [];
//     foreach ($vertices as $vertex) {
//         $dist[$vertex] = INF; // Define a distância como infinito
//         $predecessor[$vertex] = null; // Sem predecessor inicial
//     }
//     $dist[$start] = 0; // Distância da origem para ela mesma é 0

//     // Relaxar todas as arestas |V| - 1 vezes
//     $vertexCount = count($vertices);
//     for ($i = 0; $i < $vertexCount - 1; $i++) {
//         foreach ($graph as $edge) {
//             [$u, $v, $w] = $edge; // Origem, destino, peso
//             if ($dist[$u] != INF && $dist[$u] + $w < $dist[$v]) {
//                 $dist[$v] = $dist[$u] + $w;
//                 $predecessor[$v] = $u; // Atualizar o predecessor
//             }
//         }
//     }

//     // Verificar ciclos de peso negativo
//     foreach ($graph as $edge) {
//         [$u, $v, $w] = $edge;
//         if ($dist[$u] != INF && $dist[$u] + $w < $dist[$v]) {
//             return "Ciclo de peso negativo detectado!";
//         }
//     }

//     return [$dist, $predecessor];
// }
// // Função para reconstruir o percurso
// function reconstruirPercurso($predecessor, $destination) {
//     $path = [];
//     while ($destination !== null) {
//         array_unshift($path, $destination); // Adiciona no início do array
//         $destination = $predecessor[$destination];
//     }
//     return $path;
// }

// function bellmanForda($graph, $vertices, $start) {
//     // Inicializar as distâncias
//     $dist = [];
//     foreach ($vertices as $vertex) {
//         $dist[$vertex] = INF; // Define a distância como infinito
//     }
//     $dist[$start] = 0; // Distância da origem para ela mesma é 0

//     // Relaxar todas as arestas |V| - 1 vezes
//     $vertexCount = count($vertices);
//     for ($i = 0; $i < $vertexCount - 1; $i++) {
//         foreach ($graph as $edge) {
//             [$u, $v, $w] = $edge; // Origem, destino, peso
//             if ($dist[$u] != INF && $dist[$u] + $w < $dist[$v]) {
//                 $dist[$v] = $dist[$u] + $w;
//             }
//         }
//     }

//     // Verificar ciclos de peso negativo
//     foreach ($graph as $edge) {
//         [$u, $v, $w] = $edge;
//         if ($dist[$u] != INF && $dist[$u] + $w < $dist[$v]) {
//             return "Ciclo de peso negativo detectado!";
//         }
//     }

//     return $dist;
// }

function nome_funcinario_comunicacao ($id) {
    $CI = & get_instance();
    $CI->db->select('
        gv_staff_comunicacao.*,
        staff.*,
    ');
    $CI->db->from('gv_staff_comunicacao');

    $CI->db->join('staff', 'staff.staffid = gv_staff_comunicacao.staff_id', 'left');
    $CI->db->where('comunicacao_viagem_id', $id);
    $query = $CI->db->get()->result_array();
    if ($query == null) {
        return 'Nenhum selecionado';
    }
    else {
        $dados = '';
        foreach ($query as $item) {
            $dados .=  $item['firstname'] .' '. $item['lastname'] . '<br>';
        }
        return $dados;
    }
}

function multi_staff ($id) {
    $CI = & get_instance();
    $query = $CI->db->get_where('gv_staff_viagem', ['pedido_viagem_id' => $id])->result_array();
    if ($query == null) {
        return '[]';
    }
    else {
        $c = '[';
        foreach ($query as $item) {
            if ($item === end($query)) {
                $c .= '"' .$item['staff_id']. '"';
            }
            else {
                $c .= '"' .$item['staff_id']. '",';
            }
        }
        $c .= ']';
        return $c;
    }
}
function multi_staff_comunicacao ($id) {
    $CI = & get_instance();
    $query = $CI->db->get_where('gv_staff_comunicacao', ['comunicacao_viagem_id' => $id])->result_array();
    if ($query == null) {
        return '[]';
    }
    else {
        $c = '[';
        foreach ($query as $item) {
            if ($item === end($query)) {
                $c .= '"' .$item['staff_id']. '"';
            }
            else {
                $c .= '"' .$item['staff_id']. '",';
            }
        }
        $c .= ']';
        return $c;
    }
}

function total_reserva ($reserva) {
    $total = 0;
    $CI = & get_instance();
    $hotel = $CI->db->get_where('gv_hotel', ['id' => $reserva['hotel_id']])->row_array();
    if ($hotel) {
        $total += $hotel['preco'];
    }
    $voo = $CI->db->get_where('gv_voo', ['id' => $reserva['voo_id']])->row_array();
    if ($voo) {
        $total += $voo['preco'];
    }
    $transporte = $CI->db->get_where('gv_transporte', ['id' => $reserva['transporte_id']])->row_array();
    if ($transporte) {
        $total += $transporte['preco'];
    }
    return $total;
}
function send_email_gestao_viagem($to='',$subject='',$message=''){
    $CI = &get_instance();
    $CI->load->library('email');
    $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'mail.petabytelda.com',
            'smtp_port' => '587',
            'smtp_user' => 'webmaster@petabytelda.com',
            'smtp_pass' => 'Master.2040',
            'smtp_crypto' => 'tls', // ou ssl se necessário
            'charset' => 'utf-8',
            'mailtype' => 'html',
            'newline' => "\r\n"
    );

    $CI->email->initialize($config);
    $CI->email->from('webmaster@petabytelda.com', 'CSC Angola');
    $CI->email->to($to);
    $CI->email->subject($subject);
    $CI->email->message($message);

    if ($CI->email->send()) {
        echo 'E-mail enviado com sucesso.';
    } else {
        echo 'Erro ao enviar o e-mail: ' . $CI->email->print_debugger();
    }
}
?>