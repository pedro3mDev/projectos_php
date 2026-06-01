<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Recruitment Controller
 */
class Orcamentos extends AdminController
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Gv_gestao_viagem_model');

		$this->load->library(['form_validation', 'upload']);
    }
    private function http_method($vfMethod)
    {
        if ($_SERVER['REQUEST_METHOD'] !== $vfMethod) {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['status' => false, 'message' => 'Metodo não permitido']);
            exit;
        }
    }

    public function index()
    {
        $data['title'] = _l('gv_orcamentos');
        $data['total'] = 0;
        $data['total_nacional'] = 0;
        $data['total_internacional'] = 0;

        $data['total_pendente'] = 0;
        $data['total_aprovado'] = 0;
        $data['total_rejeitado'] = 0;

        $pagina = (int) $this->input->get('pagina') ?? 1;
        $limit = (int) $this->input->get('limit') ?? 10;
        $offset = ($pagina - 1) * $limit;
        $pesquisa = $this->input->get('pesquisa') ?? null;

        $data['orcamentos'] = $this->Gv_gestao_viagem_model->get_orcamento();

        $data['staffs'] = $this->Gv_gestao_viagem_model->staffs();
        $data['reservas'] = $this->Gv_gestao_viagem_model->get_reserva(2);
        $data['staff_list'] = $this->Gv_gestao_viagem_model->staffs_admin();

        $data['estimativa_viagem'] = $this->Gv_gestao_viagem_model->get_estimativa();

        $this->load->view('orcamentos/orcamentos', $data);
    }
    public function add_orcamento () {
		$this->http_method('POST');

		$data = [
            'status_id' => 1,
            'reserva_id' => $this->input->post('reserva') ?? '',
            'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];
		$this->form_validation->set_rules('reserva', _l('reserva'), 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_viagens/orcamentos');
        }
		else {
			$insert = $this->Gv_gestao_viagem_model->create_orcamento($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_viagens/orcamentos');
		}
	}
    public function editar_orcamento ($id) {
		$this->http_method('POST');
        $this->Gv_gestao_viagem_model->first_orcamento($id);

		$data = [
            'reserva_id' => $this->input->post('reserva_e') ?? '',
            'aprovadores' => json_encode($this->input->post('aprovadores_e[]')) ?? '[]',
        ];
		$this->form_validation->set_rules('reserva_e', _l('reserva'), 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('aprovadores_e[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_viagens/orcamentos');
        }
		else {
			$insert = $this->Gv_gestao_viagem_model->update_orcamento($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_viagens/orcamentos');
		}
	}
    public function status_orcamento_rejeitar($id) {
        $vf = $this->Gv_gestao_viagem_model->first_orcamento($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_viagens/orcamentos');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_viagens/orcamentos');
		}
		$this->Gv_gestao_viagem_model->update_orcamento(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('gestao_viagens/orcamentos');
    }
    public function aprovar_orcamento($id) {
        $this->http_method('POST');
        $vf = $this->Gv_gestao_viagem_model->first_orcamento($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_viagens/orcamentos');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_viagens/orcamentos');
		}

		$data = [
            'status_id' => 2,
            'estimativa_viagem_id' => $this->input->post('estimativa') ?? '',
        ];
		$this->form_validation->set_rules('estimativa', _l('estimativa'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_viagens/orcamentos');
        }
		else {
			$insert = $this->Gv_gestao_viagem_model->update_orcamento($data, $id);
			set_alert('success',"Aprovado com sucesso");
			redirect('gestao_viagens/orcamentos');
		}
    }
    public function delete_orcamento($id) {
		$this->Gv_gestao_viagem_model->first_orcamento($id);
		$this->Gv_gestao_viagem_model->delete_orcamento($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_viagens/orcamentos');
	}


    // public function form()
    // {
    //     $data['pedido'] = $this->Gv_pedido_model->get();
    //     $data['title'] = _l('gv_novo_orcamentos');
    //     $this->load->view('orcamentos/form', $data);
    // }

    // public function store()
    // {
    //     $this->http_method('POST');

    //     // $enum_valido = ['nacional', 'internacional'];
    //     $data = [
    //         'staff_id' => get_staff_user_id(), // ID do Usuario Logado
    //         'pedido_viagem_id' => $this->input->post('pedido_viagem_id') ?? '',
    //         'orcamento' => $this->input->post('orcamento') ?? '',
    //         // 'destino' => $this->input->post('destino') ?? '',
    //         // 'data_inicio' => $this->input->post('data_inicio') ?? '',
    //         // 'data_fim' => $this->input->post('data_fim') ?? '',
    //     ];

    //     // $this->form_validation->set_rules('tipo_viagem', 'Tipo de Viagem', ['required', [
    //     //     'enum',
    //     //     function ($value) use ($enum_valido) {
    //     //         return in_array($value, $enum_valido);
    //     //     }
    //     // ]], ['required' => 'Selecione o Status', 'enum' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido)]);

    //     $this->form_validation->set_rules('pedido_viagem_id', 'pedido_viagem_id', 'required', ['required' => 'Preencha o campo {field}']);
    //     $this->form_validation->set_rules('orcamento', 'orcamento', 'required', ['required' => 'Preencha o campo {field}']);
    //     // $this->form_validation->set_rules('data_inicio', 'Data Início', 'required|callback_data|callback_datainicio', ['required' => 'Preencha o campo {field}']);
    //     // $this->form_validation->set_rules('data_fim', 'Data Fim', 'required|callback_data|callback_datafim', ['required' => 'Preencha o campo {field}']);


    //     if (!$this->form_validation->run()) {
    //         // set_alert('warning', validation_errors());
    //         // redirect('gestao_viagens/pedidos/novo');

    //         $dataView['title'] = _l('gv_novo_orcamentos');
    //         $this->load->view('orcamentos/form', $dataView);
    //     } else {
    //         // var_dump($data);die();
    //         $insert = $this->Gv_orcamento_viagem_model->create($data);
    //         set_alert('success', "Cadastrado com sucesso");

    //         if ($insert) {
    //             set_alert('success', "Orçamento Adicionado");
    //             // redirect('gestao_viagens/pedidos/pedido/'.$id);
    //             redirect('gestao_viagens/orcamentos/index');
    //         } else {
    //             set_alert('danger', "Orçamento já foi Adicionado");
    //             // redirect('gestao_viagens/pedidos/pedido/'.$id);
    //             redirect('gestao_viagens/orcamentos/form');
    //             // $this->load->view('orcamentos/form', $dataView);
    //         }
    //     }
    // }

    // public function enum_valido ($dado) {
    //     $enum_valido = ['nacional', 'internacional'];

    //     if (in_array($dado, $enum_valido)) {
    //         return true;
    //     }
    //     return false;
    // }
    // public function data ($data) {
    //     $da = DateTime::createFromFormat('Y-m-d', $data);
    //     if ($da && $da->format('Y-m-d') == $data) {
    //         return true;
    //     }
    //     $this->form_validation->set_message('data', 'Preencha o campo {field} corretamente');
    //     return false;
    // }
    // public function datainicio($data) {
    //     $data_actual = date('Y-m-d');
    //     if (strtotime($data) <  strtotime($data_actual)) {
    //         $this->form_validation->set_message('datainicio', 'A {field} não pode ser menor que a data actual');
    //         return false;
    //     }
    //     return true;
    // }
    // public function  datafim ($data) {
    //     $data_inicio = $this->input->post('data_inicio');
    //     if (strtotime($data) < strtotime($data_inicio)) {
    //         $this->form_validation->set_message('datafim', 'A {field} não pode ser menor que a data inicial');
    //         return false;
    //     }
    //     return true;
    // }


    // public function novo() {
    // 	$data['title'] = _l('gv_novo_pedido');

    // 	$this->load->view('pedidos/novo', $data);
    // }
    // public function adicionar () {
    //     $this->http_method('POST');

    //     $enum_valido = ['nacional', 'internacional'];
    //     $data = [
    //         'staff_id' => get_staff_user_id(), // ID do Usuario Logado
    //         'tipo_viagem' => $this->input->post('tipo_viagem') ?? '',
    //         'objetivo' => $this->input->post('objetivo') ?? '',
    //         'destino' => $this->input->post('destino') ?? '',
    //         'data_inicio' => $this->input->post('data_inicio') ?? '',
    //         'data_fim' => $this->input->post('data_fim') ?? '',
    //     ];

    //     $this->form_validation->set_rules('tipo_viagem', 'Tipo de Viagem', ['required', [
    //         'enum', function ($value) use ($enum_valido) {
    //             return in_array($value, $enum_valido);
    //         }
    //     ]], ['required' => 'Selecione o Status', 'enum' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido)]);

    //     $this->form_validation->set_rules('objetivo', 'Objetivo', 'required', ['required' => 'Preencha o campo {field}']);
    //     $this->form_validation->set_rules('destino', 'Destino', 'required', ['required' => 'Preencha o campo {field}']);
    //     $this->form_validation->set_rules('data_inicio', 'Data Início', 'required|callback_data|callback_datainicio', ['required' => 'Preencha o campo {field}']);
    //     $this->form_validation->set_rules('data_fim', 'Data Fim', 'required|callback_data|callback_datafim', ['required' => 'Preencha o campo {field}']);


    //     if (!$this->form_validation->run()) {
    // 		// set_alert('warning', validation_errors());
    // 		// redirect('gestao_viagens/pedidos/novo');

    // 		$dataView['title'] = _l('gv_novo_pedido');
    //         $this->load->view('pedidos/novo', $dataView);
    //     }
    // 	else {
    // 		$insert = $this->Gv_pedido_model->create($data);
    // 		set_alert('success',"Cadastrado com sucesso");
    // 		redirect('gestao_viagens/pedidos/novo');
    // 	}

    // }

    // public function editar($id) {
    // 	$data['title'] = _l('gv_editar_pedido');
    // 	$vfPedido = $this->Gv_pedido_model->first($id);

    // 	$data['pedido'] = $vfPedido;
    // 	$this->load->view('pedidos/editar', $data);
    // }

    // public function actualizar($id)
    // {
    //     $this->http_method('POST');
    //     $vfPedido = $this->Gv_pedido_model->first($id);

    //     $enum_valido = ['nacional', 'internacional'];
    //     $data = [
    //         // 'staff_id' => get_staff_user_id(), // ID do Usuario Logado
    //         'tipo_viagem' => $this->input->post('tipo_viagem') ?? '',
    //         'objetivo' => $this->input->post('objetivo') ?? '',
    //         'destino' => $this->input->post('destino') ?? '',
    //         'data_inicio' => $this->input->post('data_inicio') ?? '',
    //         'data_fim' => $this->input->post('data_fim') ?? '',
    //     ];

    //     $this->form_validation->set_rules('tipo_viagem', 'Tipo de Viagem', ['required', [
    //         'enum',
    //         function ($value) use ($enum_valido) {
    //             return in_array($value, $enum_valido);
    //         }
    //     ]], ['required' => 'Selecione o Status', 'enum' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido)]);

    //     $this->form_validation->set_rules('objetivo', 'Objetivo', 'required', ['required' => 'Preencha o campo {field}']);
    //     $this->form_validation->set_rules('destino', 'Destino', 'required', ['required' => 'Preencha o campo {field}']);
    //     $this->form_validation->set_rules('data_inicio', 'Data Início', 'required|callback_data|callback_datainicio', ['required' => 'Preencha o campo {field}']);
    //     $this->form_validation->set_rules('data_fim', 'Data Fim', 'required|callback_data|callback_datafim', ['required' => 'Preencha o campo {field}']);


    //     if (!$this->form_validation->run()) {
    //         $dataView['title'] = _l('gv_editar_pedido');
    //         $dataView['pedido'] = $vfPedido;
    //         $this->load->view('pedidos/editar', $dataView);
    //     } else {
    //         $this->Gv_pedido_model->update($data, $id);
    //         set_alert('success', "Atualizado com sucesso");
    //         redirect('gestao_viagens/pedidos/editar/' . $id);
    //     }
    // }

    // public function pedido($id)
    // {
    //     $vfPedido = $this->Gv_pedido_model->first($id);

    //     $data['pedido'] = $vfPedido;
    //     $data['staffs'] = $this->Gv_staff_model->get($vfPedido['id']);
    //     $data['staffs_add'] = $this->Gv_staff_model->staff_get($vfPedido['id']);

    //     $data['status_all'] = $this->Gv_status_model->get();
    //     $data['res_hotel'] = $this->Gv_reserva_hotel_model->get($vfPedido['id']);
    //     $data['res_voo'] = $this->Gv_reserva_voo_model->get($vfPedido['id']);
    //     $data['res_transporte'] = $this->Gv_reserva_transporte_model->get($vfPedido['id']);

    //     $data['decisao'] = $this->Gv_decisao_viagem_model->first_pedido($vfPedido['id']);
    //     $data['orcamento'] = $this->Gv_orcamento_viagem_model->first_pedido($vfPedido['id']);
    //     if (isset($data['orcamento'])) {
    //         $data['reembolso'] = $this->Gv_reembolso_model->first_orcamento($data['orcamento']['id']);
    //     } else {
    //         $data['reembolso'] = NULL;
    //     }

    //     $data['title'] = _l('pedidos_viagens') . ' - ' . $vfPedido['objetivo'];

    //     $this->load->view('pedidos/pedido', $data);
    // }
    // public function adicionar_membro($id)
    // {
    //     $this->http_method('POST');
    //     $vfPedido = $this->Gv_pedido_model->first($id);

    //     $data = [
    //         'staff_id' => get_staff_user_id(), // ID do Usuario Logado
    //         'staff_id_viagem' => $this->input->post('staff') ?? '',
    //         'pedido_viagem_id' => $id,
    //     ];
    //     $this->form_validation->set_rules('staff', '', 'required', ['required' => 'Selecione alguem.']);
    //     if (!$this->form_validation->run()) {
    //         set_alert('warning', 'Selecione alguem.');
    //         redirect('gestao_viagens/pedidos/pedido/' . $id);
    //     } else {
    //         $insert = $this->Gv_staff_model->create($data);
    //         if ($insert) {
    //             set_alert('success', "Adicionado com sucesso");
    //             redirect('gestao_viagens/pedidos/pedido/' . $id);
    //         } else {
    //             set_alert('danger', "Já foi Adicionado");
    //             redirect('gestao_viagens/pedidos/pedido/' . $id);
    //         }
    //     }
    // }
    // public function eliminar_membro($id_pedido, $id)
    // {
    //     $this->http_method('GET');
    //     $vfPedido = $this->Gv_pedido_model->first($id_pedido);

    //     $data = [
    //         'pedido_viagem_id' => $id_pedido,
    //         'id' => $id,
    //     ];
    //     $this->Gv_staff_model->delete($data);
    //     set_alert('success', "Removido com sucesso");
    //     redirect('gestao_viagens/pedidos/pedido/' . $id_pedido);
    // }

    // public function aprovar($id)
    // {
    //     $this->http_method('GET');
    //     $vfPedido = $this->Gv_pedido_model->first($id);

    //     $data = [
    //         'staff_id' => get_staff_user_id(), // ID do Usuario Logado
    //         'decisao' => 'aprovado',
    //         'pedido_viagem_id' => $id,
    //     ];

    //     $insert = $this->Gv_decisao_viagem_model->decisao($data);
    //     if ($insert) {
    //         set_alert('success', "Pedido Aprovado");
    //         redirect('gestao_viagens/pedidos/pedido/' . $id);
    //     } else {
    //         set_alert('danger', "Já foi Adicionado");
    //         redirect('gestao_viagens/pedidos/pedido/' . $id);
    //     }
    // }
    // public function rejeitar($id)
    // {
    //     $this->http_method('GET');
    //     $vfPedido = $this->Gv_pedido_model->first($id);

    //     $data = [
    //         'staff_id' => get_staff_user_id(), // ID do Usuario Logado
    //         'decisao' => 'rejeitado',
    //         'pedido_viagem_id' => $id,
    //     ];

    //     $insert = $this->Gv_decisao_viagem_model->decisao($data);
    //     if ($insert) {
    //         set_alert('success', "Pedido Rejeitado");
    //         redirect('gestao_viagens/pedidos/pedido/' . $id);
    //     } else {
    //         set_alert('danger', "Já foi Adicionado");
    //         redirect('gestao_viagens/pedidos/pedido/' . $id);
    //     }
    // }

    // public function definir_orcamento($id)
    // {
    //     $this->http_method('GET');
    //     $vfPedido = $this->Gv_pedido_model->first($id);

    //     $data = [
    //         'staff_id' => get_staff_user_id(), // ID do Usuario Logado
    //         'pedido_viagem_id' => $id,
    //         'orcamento' => 30000,
    //     ];

    //     $insert = $this->Gv_orcamento_viagem_model->create($data);
    //     if ($insert) {
    //         set_alert('success', "Orçamento Adicionado");
    //         redirect('gestao_viagens/pedidos/pedido/' . $id);
    //     } else {
    //         set_alert('danger', "Orçamento já foi Adicionado");
    //         redirect('gestao_viagens/pedidos/pedido/' . $id);
    //     }
    // }
    // public function definir_reembolso($id)
    // {
    //     $this->http_method('GET');
    //     $vfPedido = $this->Gv_pedido_model->first($id);
    //     $vfOrcamento = $this->Gv_orcamento_viagem_model->first_pedido($vfPedido['id']);

    //     $data = [
    //         'staff_id' => get_staff_user_id(), // ID do Usuario Logado
    //         'orcamento_viagem_id' => $vfOrcamento['id'],
    //         'reembolso' => 2000,
    //     ];

    //     $insert = $this->Gv_reembolso_model->create($data);
    //     if ($insert) {
    //         set_alert('success', "Reembolso Adicionado");
    //         redirect('gestao_viagens/pedidos/pedido/' . $id);
    //     } else {
    //         set_alert('danger', "Reembolso já foi Adicionado");
    //         redirect('gestao_viagens/pedidos/pedido/' . $id);
    //     }
    // }
}