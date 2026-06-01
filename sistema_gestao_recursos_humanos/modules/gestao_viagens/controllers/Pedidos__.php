<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Recruitment Controller
 */
class Pedidos extends AdminController {
	public function __construct() {
		parent::__construct();
        $this->load->model('Gv_gestao_viagem_model');
		$this->load->model('Gv_pedido_model');

        // $this->load->model('Gv_decisao_viagem_model');
        // $this->load->model('Gv_staff_model');
        // $this->load->model('Gv_status_model');
        // $this->load->model('Gv_reserva_hotel_model');
        // $this->load->model('Gv_reserva_voo_model');
        // $this->load->model('Gv_reserva_transporte_model');
        // $this->load->model('Gv_orcamento_viagem_model');
        // $this->load->model('Gv_reembolso_model');

		$this->load->library('form_validation');
	}
	private function http_method ($vfMethod) {
        if ($_SERVER['REQUEST_METHOD'] !== $vfMethod) {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['status' => false, 'message' => 'Metodo não permitido']);
            exit;
        }
    }
	public function enum_valido ($dado) {
        $enum_valido = ['nacional', 'internacional'];

        if (in_array($dado, $enum_valido)) {
            return true;
        }
        return false;
    }
    public function data ($data) {
        $da = DateTime::createFromFormat('Y-m-d', $data);
        if ($da && $da->format('Y-m-d') == $data) {
            return true;
        }
        $this->form_validation->set_message('data', 'Preencha o campo {field} corretamente');
        return false;
    }
    public function datainicio($data) {
        $data_actual = date('Y-m-d');
        if (strtotime($data) <  strtotime($data_actual)) {
            $this->form_validation->set_message('datainicio', 'A {field} não pode ser menor que a data actual');
            return false;
        }
        return true;
    }
    public function  datafim ($data) {
        $data_inicio = $this->input->post('data_inicio');
        if (strtotime($data) < strtotime($data_inicio)) {
            $this->form_validation->set_message('datafim', 'A {field} não pode ser menor que a data inicial');
            return false;
        }
        return true;
    }
    public function  datafim_e ($data) {
        $data_inicio = $this->input->post('data_inicio_e');
        if (strtotime($data) < strtotime($data_inicio)) {
            $this->form_validation->set_message('datafim', 'A {field} não pode ser menor que a data inicial');
            return false;
        }
        return true;
    }

    public function  datafim_c ($data) {
        $data_inicio = $this->input->post('data_checkin');
        if (strtotime($data) < strtotime($data_inicio)) {
            $this->form_validation->set_message('datafim', 'A {field} não pode ser menor que a data inicial');
            return false;
        }
        return true;
    }
    public function  datafim_ce ($data) {
        $data_inicio = $this->input->post('data_checkin_e');
        if (strtotime($data) < strtotime($data_inicio)) {
            $this->form_validation->set_message('datafim', 'A {field} não pode ser menor que a data inicial');
            return false;
        }
        return true;
    }

	public function index() {
		$data['title'] = _l('gestao_viagens');

        $data['total'] = 0;
		$data['total_nacional'] = 1;
		$data['total_internacional'] = 2;

		$data['total_pendente'] = 1;
		$data['total_aprovado'] = 2;
		$data['total_rejeitado'] = 0;

        $data['dados'] = [];

        $data['tipos'] = $this->Gv_gestao_viagem_model->get_tipo_viagem();
        $data['categorias'] = $this->Gv_gestao_viagem_model->get_categorias();
        $data['status'] = $this->Gv_gestao_viagem_model->get_status();

        $data['staff_list'] = $this->Gv_gestao_viagem_model->staffs_admin();
        $data['staffs'] = $this->Gv_gestao_viagem_model->staffs();

        $data['plenejadas'] = $this->Gv_pedido_model->get();
		$this->load->view('pedidos/pedidos', $data);
	}

    public function pedido($id) {
        $vfPedido = $this->Gv_pedido_model->first($id);
		$data['title'] = _l('pedidos_viagens') . ' - '. $vfPedido['objetivo'];
		$data['pedido'] = $vfPedido;
		$data['staffs'] = $this->Gv_pedido_model->get_staff($vfPedido['id']);

		$this->load->view('pedidos/pedido', $data);
	}
    public function delete ($id) {
		$this->Gv_pedido_model->first($id);
		$this->Gv_pedido_model->delete($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_viagens/pedidos');
	}

    public function adicionar () {
        $this->http_method('POST');

        $data = [
            'staff_id' => get_staff_user_id(), // ID do Usuario Logado
            'tipo_viagem_id' => $this->input->post('tipo_viagem') ?? '',
            'status_id' => 1,
            'categoria_id' => $this->input->post('categoria') ?? '',
            'objetivo' => $this->input->post('objetivo') ?? '',
            // 'funcionarios' => $this->input->post('funcionarios[]') ?? '',
            'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
            'destino' => $this->input->post('destino') ?? '',
            'data_inicio' => $this->input->post('data_inicio') ?? '',
            'data_fim' => $this->input->post('data_fim') ?? '',
        ];

        $funcionarios = $this->input->post('funcionarios[]') ?? '';

        $this->form_validation->set_rules('funcionarios[]', 'funcionarios', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('tipo_viagem', 'tipo_viagem', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('categoria', 'categoria', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('objetivo', 'Objetivo', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('destino', 'Destino', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('data_inicio', 'Data Início', 'required|callback_data|callback_datainicio', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('data_fim', 'Data Fim', 'required|callback_data|callback_datafim', ['required' => 'Preencha o campo {field}']);
        // $this->form_validation->set_rules('data_inicio', 'Data Início', 'required', ['required' => 'Preencha o campo {field}']);
        // $this->form_validation->set_rules('data_fim', 'Data Fim', 'required', ['required' => 'Preencha o campo {field}']);

        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('gestao_viagens/pedidos/');
        }
		else {
			$insert = $this->Gv_pedido_model->create($data, $funcionarios);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_viagens/pedidos/');
		}
    }
	public function editar_pedido ($id) {
        $this->http_method('POST');
		$vfPedido = $this->Gv_pedido_model->first($id);

        $data = [
            'tipo_viagem_id' => $this->input->post('tipo_viagem_e') ?? '',
            // 'status_id' => $this->input->post('status_e') ?? '',
            'categoria_id' => $this->input->post('categoria_e') ?? '',
            'objetivo' => $this->input->post('objetivo_e') ?? '',
            'aprovadores' => json_encode($this->input->post('aprovadores_e[]')) ?? '[]',
            'destino' => $this->input->post('destino_e') ?? '',
            'data_inicio' => $this->input->post('data_inicio_e') ?? '',
            'data_fim' => $this->input->post('data_fim_e') ?? '',
        ];

        $funcionarios = $this->input->post('funcionarios_e[]') ?? '';

        $this->form_validation->set_rules('funcionarios_e[]', 'funcionarios', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('tipo_viagem_e', 'tipo_viagem', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('categoria_e', 'categoria', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('objetivo_e', 'Objetivo', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('destino_e', 'Destino', 'required', ['required' => 'Preencha o campo {field}']);
        // $this->form_validation->set_rules('data_inicio_e', 'Data Inicio', 'required', ['required' => 'Preencha o campo {field}']);
        // $this->form_validation->set_rules('data_fim_e', 'Data Fim', 'required', ['required' => 'Preencha o campo {field}']);

        $this->form_validation->set_rules('data_inicio_e', 'Data Início', 'required|callback_data|callback_datainicio', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('data_fim_e', 'Data Fim', 'required|callback_data|callback_datafim_e', ['required' => 'Preencha o campo {field}']);

        $this->form_validation->set_rules('aprovadores_e[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('gestao_viagens/pedidos/');
        }
		else {
			$insert = $this->Gv_pedido_model->update($data, $funcionarios, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_viagens/pedidos/');
		}

    }
    public function status_pedido_aprovar($id) {
        $vf = $this->Gv_pedido_model->first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_viagens/pedidos/pedido/'.$id);
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_viagens/pedidos/pedido/'.$id);
		}
		$this->Gv_pedido_model->update_status(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('gestao_viagens/pedidos/pedido/'.$id);
    }
    public function status_pedido_rejeitar($id) {
        $vf = $this->Gv_pedido_model->first($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_viagens/pedidos/pedido/'.$id);
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_viagens/pedidos/pedido/'.$id);
		}
		$this->Gv_pedido_model->update_status(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('gestao_viagens/pedidos/pedido/'.$id);
    }

    public function reservas() {
		$data['title'] = _l('gestao_viagens');

        $data['total'] = 0;
		$data['total_nacional'] = 1;
		$data['total_internacional'] = 2;

		$data['total_pendente'] = 1;
		$data['total_aprovado'] = 2;
		$data['total_rejeitado'] = 0;

        $data['dados'] = [];

        $data['tipos'] = $this->Gv_gestao_viagem_model->get_tipo_viagem();
        $data['categorias'] = $this->Gv_gestao_viagem_model->get_categorias();
        $data['status'] = $this->Gv_gestao_viagem_model->get_status();

        $data['staff_list'] = $this->Gv_gestao_viagem_model->staffs_admin();
        $data['staffs'] = $this->Gv_gestao_viagem_model->staffs();

        $data['group'] = $this->input->get('group');
		$data['title'] = _l('Reservas');
		$data['tab'][] = 'reservas';
		$data['tab'][] = 'voo';
		$data['tab'][] = 'hotel';
		$data['tab'][] = 'transporte';

        if ($data['group'] == '') {
			$data['group'] = 'reservas';
            $data['reservas'] = $this->Gv_gestao_viagem_model->get_reserva();

            $data['pedidos'] = $this->Gv_pedido_model->get_status(2);
            $data['hotel'] = $this->Gv_gestao_viagem_model->get_hotel(2);
            $data['voo'] = $this->Gv_gestao_viagem_model->get_voos(2);
            $data['transporte'] = $this->Gv_gestao_viagem_model->get_transporte(2);
		}
        elseif ($data['group'] == 'reservas') {
            $data['group'] = 'reservas';
            $data['reservas'] = $this->Gv_gestao_viagem_model->get_reserva();

            $data['pedidos'] = $this->Gv_pedido_model->get_status(2);
            $data['hotel'] = $this->Gv_gestao_viagem_model->get_hotel(2);
            $data['voo'] = $this->Gv_gestao_viagem_model->get_voos(2);
            $data['transporte'] = $this->Gv_gestao_viagem_model->get_transporte(2);
        }
        elseif ($data['group'] == 'voo') {
            $data['group'] = 'voo';
            $data['voos'] = $this->Gv_gestao_viagem_model->get_voos();
            $data['viagens'] = $this->Gv_pedido_model->get();
        }
        elseif ($data['group'] == 'hotel') {
            $data['group'] = 'hotel';
            $data['hotel'] = $this->Gv_gestao_viagem_model->get_hotel();
        }
        elseif ($data['group'] == 'transporte') {
            $data['group'] = 'transporte';
            $data['transporte'] = $this->Gv_gestao_viagem_model->get_transporte();
        }

        $data['tabs']['view'] = 'includes/' . $data['group'];
		$this->load->view('pedidos/reservas', $data);
	}

    // Fora de uso
	// public function novo() {
	// 	$data['title'] = _l('gv_novo_pedido');
    //     $data['tabs']['view'] = '/gestao_viagens' ;

    //     $data['tipos'] = $this->Gv_gestao_viagem_model->get_tipo_viagem();
    //     $data['categorias'] = $this->Gv_gestao_viagem_model->get_categorias();
    //     $data['status'] = $this->Gv_gestao_viagem_model->get_status();

    //     $data['staff_list'] = $this->Gv_gestao_viagem_model->staffs_admin();
    //     $data['staffs'] = $this->Gv_gestao_viagem_model->staffs();

	// 	$this->load->view('pedidos/novo', $data);
	// }

    public function add_voo () {
        $this->http_method('POST');

        $data = [
            'status_id' => 1,
            'nome' => $this->input->post('nome') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
            'local_partida' => $this->input->post('local_partida') ?? '',
            'local_destino' => $this->input->post('local_destino') ?? '',
            'data_partida' => $this->input->post('data_partida') ?? '',
            'preco' => $this->input->post('preco') ?? '',
            'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('nome', 'nome', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('descricao', 'descricao', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('preco', 'preco', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('local_partida', 'local_partida', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('local_destino', 'local_destino', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('data_partida', 'data_partida', 'required', ['required' => 'Preencha o campo {field}']);

        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('gestao_viagens/pedidos/reservas/?group=voo');
        }
		else {
			$insert = $this->Gv_gestao_viagem_model->create_voo($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_viagens/pedidos/reservas/?group=voo');
		}
    }
    public function editar_voo ($id) {
        $this->http_method('POST');
		$vfVoo = $this->Gv_gestao_viagem_model->first_voo($id);

        $data = [
            'nome' => $this->input->post('nome_e') ?? '',
            'descricao' => $this->input->post('descricao_e') ?? '',
            'local_partida' => $this->input->post('local_partida_e') ?? '',
            'local_destino' => $this->input->post('local_destino_e') ?? '',
            'data_partida' => $this->input->post('data_partida_e') ?? '',
            'preco' => $this->input->post('preco_e') ?? '',
            'aprovadores' => json_encode($this->input->post('aprovadores_e[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('nome_e', 'nome', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('descricao_e', 'descricao', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('preco_e', 'preco', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('local_partida_e', 'local_partida', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('local_destino_e', 'local_destino', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('data_partida_e', 'data_partida', 'required', ['required' => 'Preencha o campo {field}']);

        $this->form_validation->set_rules('aprovadores_e[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('gestao_viagens/pedidos/reservas/?group=voo');
        }
		else {
			$insert = $this->Gv_gestao_viagem_model->update_voo($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_viagens/pedidos/reservas/?group=voo');
		}
    }
    public function delete_voo ($id) {
		$this->Gv_gestao_viagem_model->first_voo($id);
		$this->Gv_gestao_viagem_model->delete_voo($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_viagens/pedidos/reservas/?group=voo');
	}
    public function status_voo_aprovar($id) {
        $vf = $this->Gv_gestao_viagem_model->first_voo($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_viagens/pedidos/reservas/?group=voo');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_viagens/pedidos/reservas/?group=voo');
		}
		$this->Gv_gestao_viagem_model->update_voo(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('gestao_viagens/pedidos/reservas/?group=voo');
    }
    public function status_voo_rejeitar($id) {
        $vf = $this->Gv_gestao_viagem_model->first_voo($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_viagens/pedidos/reservas/?group=voo');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_viagens/pedidos/reservas/?group=voo');
		}
		$this->Gv_gestao_viagem_model->update_voo(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('gestao_viagens/pedidos/reservas/?group=voo');
    }

    public function add_hotel () {
        $this->http_method('POST');

        $data = [
            'status_id' => 1,
            'nome' => $this->input->post('nome') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
            'preco' => $this->input->post('preco') ?? '',
            'endereco' => $this->input->post('endereco') ?? '',
            'data_checkin' => $this->input->post('data_checkin') ?? '',
            'data_checkout' => $this->input->post('data_checkout') ?? '',
            'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('nome', 'nome', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('descricao', 'descricao', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('preco', 'preco', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('endereco', 'endereco', 'required', ['required' => 'Preencha o campo {field}']);
        // $this->form_validation->set_rules('data_checkin', 'data_checkin', 'required', ['required' => 'Preencha o campo {field}']);
        // $this->form_validation->set_rules('data_checkout', 'data_checkout', 'required', ['required' => 'Preencha o campo {field}']);

        $this->form_validation->set_rules('data_checkin', 'data_checkin', 'required|callback_data|callback_datainicio', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('data_checkout', 'data_checkout', 'required|callback_data|callback_datafim_c', ['required' => 'Preencha o campo {field}']);

        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('gestao_viagens/pedidos/reservas/?group=hotel');
        }
		else {
			$insert = $this->Gv_gestao_viagem_model->create_hotel($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_viagens/pedidos/reservas/?group=hotel');
		}
    }
    public function editar_hotel ($id) {
        $this->http_method('POST');
		$vf = $this->Gv_gestao_viagem_model->first_hotel($id);

        $data = [
            'nome' => $this->input->post('nome_e') ?? '',
            'descricao' => $this->input->post('descricao_e') ?? '',
            'preco' => $this->input->post('preco_e') ?? '',
            'endereco' => $this->input->post('endereco_e') ?? '',
            'data_checkin' => $this->input->post('data_checkin_e') ?? '',
            'data_checkout' => $this->input->post('data_checkout_e') ?? '',
            'aprovadores' => json_encode($this->input->post('aprovadores_e[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('nome_e', 'nome', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('descricao_e', 'descricao', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('preco_e', 'preco', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('endereco_e', 'endereco', 'required', ['required' => 'Preencha o campo {field}']);
        // $this->form_validation->set_rules('data_checkin_e', 'data_checkin', 'required', ['required' => 'Preencha o campo {field}']);
        // $this->form_validation->set_rules('data_checkout_e', 'data_checkout', 'required', ['required' => 'Preencha o campo {field}']);

        $this->form_validation->set_rules('data_checkin_e', 'data_checkin', 'required|callback_data|callback_datainicio', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('data_checkout_e', 'data_checkout', 'required|callback_data|callback_datafim_ce', ['required' => 'Preencha o campo {field}']);

        $this->form_validation->set_rules('aprovadores_e[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('gestao_viagens/pedidos/reservas/?group=hotel');
        }
		else {
			$insert = $this->Gv_gestao_viagem_model->update_hotel($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_viagens/pedidos/reservas/?group=hotel');
		}
    }
    public function delete_hotel($id) {
		$this->Gv_gestao_viagem_model->first_hotel($id);
		$this->Gv_gestao_viagem_model->delete_hotel($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_viagens/pedidos/reservas/?group=hotel');
	}
    public function status_hotel_aprovar($id) {
        $vf = $this->Gv_gestao_viagem_model->first_hotel($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_viagens/pedidos/reservas/?group=hotel');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_viagens/pedidos/reservas/?group=hotel');
		}
		$this->Gv_gestao_viagem_model->update_hotel(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('gestao_viagens/pedidos/reservas/?group=hotel');
    }
    public function status_hotel_rejeitar($id) {
        $vf = $this->Gv_gestao_viagem_model->first_hotel($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_viagens/pedidos/reservas/?group=hotel');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_viagens/pedidos/reservas/?group=hotel');
		}
		$this->Gv_gestao_viagem_model->update_hotel(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('gestao_viagens/pedidos/reservas/?group=hotel');
    }

    public function add_transporte () {
        $this->http_method('POST');

        $data = [
            'status_id' => 1,
            'nome' => $this->input->post('nome') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
            'preco' => $this->input->post('preco') ?? '',
            'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('nome', 'nome', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('descricao', 'descricao', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('preco', 'preco', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('gestao_viagens/pedidos/reservas/?group=transporte');
        }
		else {
			$insert = $this->Gv_gestao_viagem_model->create_transporte($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_viagens/pedidos/reservas/?group=transporte');
		}
    }
    public function editar_transporte ($id) {
        $vf = $this->Gv_gestao_viagem_model->first_transporte($id);
        $this->http_method('POST');

        $data = [
            'nome' => $this->input->post('nome_e') ?? '',
            'descricao' => $this->input->post('descricao_e') ?? '',
            'preco' => $this->input->post('preco_e') ?? '',
            'aprovadores' => json_encode($this->input->post('aprovadores_e[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('nome_e', 'nome', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('descricao_e', 'descricao', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('preco_e', 'preco', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('aprovadores_e[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('gestao_viagens/pedidos/reservas/?group=transporte');
        }
		else {
			$insert = $this->Gv_gestao_viagem_model->update_transporte($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_viagens/pedidos/reservas/?group=transporte');
		}
    }
    public function delete_transporte($id) {
		$this->Gv_gestao_viagem_model->first_transporte($id);
		$this->Gv_gestao_viagem_model->delete_transporte($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_viagens/pedidos/reservas/?group=transporte');
	}
    public function status_transporte_aprovar($id) {
        $vf = $this->Gv_gestao_viagem_model->first_transporte($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_viagens/pedidos/reservas/?group=transporte');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_viagens/pedidos/reservas/?group=transporte');
		}
		$this->Gv_gestao_viagem_model->update_transporte(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('gestao_viagens/pedidos/reservas/?group=transporte');
    }
    public function status_transporte_rejeitar($id) {
        $vf = $this->Gv_gestao_viagem_model->first_transporte($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_viagens/pedidos/reservas/?group=transporte');
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_viagens/pedidos/reservas/?group=transporte');
		}
		$this->Gv_gestao_viagem_model->update_transporte(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('gestao_viagens/pedidos/reservas/?group=transporte');
    }

    public function add_reserva () {
        $this->http_method('POST');

        $data = [
            'status_id' => 1,
            'pedido_viagem_id' => $this->input->post('pedido') ?? '',
            'voo_id' => $this->input->post('voo') ?? '',
            'hotel_id' => $this->input->post('hotel') ?? '',
            'transporte_id' => $this->input->post('transporte') ?? '',
            'aprovadores' => json_encode($this->input->post('aprovadores[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('pedido', 'pedido de viagem', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('aprovadores[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('gestao_viagens/pedidos/reservas/?group=reservas');
        }
		else {
			$insert = $this->Gv_gestao_viagem_model->create_reserva($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_viagens/pedidos/reservas/?group=reservas');
		}
    }
    public function editar_reserva ($id) {
        $vf = $this->Gv_gestao_viagem_model->first_reserva($id);
        $this->http_method('POST');

        $data = [
            'pedido_viagem_id' => $this->input->post('pedido_e') ?? '',
            'voo_id' => $this->input->post('voo_e') ?? '',
            'hotel_id' => $this->input->post('hotel_e') ?? '',
            'transporte_id' => $this->input->post('transporte_e') ?? '',
            'aprovadores' => json_encode($this->input->post('aprovadores_e[]')) ?? '[]',
        ];

        $this->form_validation->set_rules('pedido_e', 'pedido de viagem', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('aprovadores_e[]', 'aprovadores', 'required', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('gestao_viagens/pedidos/reservas/?group=reservas');
        }
		else {
			$insert = $this->Gv_gestao_viagem_model->update_reserva($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_viagens/pedidos/reservas/?group=reservas');
		}
    }
    public function delete_reserva($id) {
		$this->Gv_gestao_viagem_model->first_reserva($id);
		$this->Gv_gestao_viagem_model->delete_reserva($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_viagens/pedidos/reservas/?group=reservas');
	}
    public function reserva($id) {
        $vf = $this->Gv_gestao_viagem_model->first_reserva($id);
		$data['title'] = _l('pedidos_viagens') . ' - '. $vf['objetivo'];
		$data['reserva'] = $vf;
		$data['pedido'] = $this->Gv_pedido_model->first($vf['pedido_viagem_id']);
        $data['staffs'] = $this->Gv_pedido_model->get_staff($vf['pedido_viagem_id']);


		$data['hotel'] = $this->Gv_gestao_viagem_model->first_hotel_b($vf['hotel_id']);
		$data['voo'] = $this->Gv_gestao_viagem_model->first_voo_b($vf['voo_id']);
		$data['transporte'] = $this->Gv_gestao_viagem_model->first_transporte_b($vf['transporte_id']);

		$this->load->view('pedidos/reserva', $data);
	}
    public function status_reserva_aprovar($id) {
        $vf = $this->Gv_gestao_viagem_model->first_reserva($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_viagens/pedidos/reserva/'. $id);
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_viagens/pedidos/reserva/'. $id);
		}
		$this->Gv_gestao_viagem_model->update_reserva(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('gestao_viagens/pedidos/reserva/'. $id);
    }
    public function status_reserva_rejeitar($id) {
        $vf = $this->Gv_gestao_viagem_model->first_reserva($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_viagens/pedidos/reserva/'. $id);
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_viagens/pedidos/reserva/'. $id);
		}
		$this->Gv_gestao_viagem_model->update_reserva(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('gestao_viagens/pedidos/reserva/'. $id);
    }























	public function adicionar_membro($id) {
		$this->http_method('POST');
		$vfPedido = $this->Gv_pedido_model->first($id);

        $data = [
            'staff_id' => get_staff_user_id(), // ID do Usuario Logado
            'staff_id_viagem' => $this->input->post('staff') ?? '',
            'pedido_viagem_id' => $id,
        ];
        $this->form_validation->set_rules('staff', '', 'required', ['required' => 'Selecione alguem.']);
        if (!$this->form_validation->run()) {
			set_alert('warning', 'Selecione alguem.');
			redirect('gestao_viagens/pedidos/pedido/'.$id);
        }
		else {
			$insert = $this->Gv_staff_model->create($data);
            if ($insert) {
                set_alert('success',"Adicionado com sucesso");
                redirect('gestao_viagens/pedidos/pedido/'.$id);
            }
            else {
                set_alert('danger',"Já foi Adicionado");
                redirect('gestao_viagens/pedidos/pedido/'.$id);
            }
		}

	}
    public function eliminar_membro($id_pedido, $id) {
        $this->http_method('GET');
		$vfPedido = $this->Gv_pedido_model->first($id_pedido);

        $data = [
            'pedido_viagem_id' => $id_pedido,
            'id' => $id,
        ];
        $this->Gv_staff_model->delete($data);
        set_alert('success',"Removido com sucesso");
        redirect('gestao_viagens/pedidos/pedido/'.$id_pedido);
    }

    public function aprovar($id) {
        $this->http_method('GET');
		$vfPedido = $this->Gv_pedido_model->first($id);

        $data = [
            'staff_id' => get_staff_user_id(), // ID do Usuario Logado
            'decisao' => 'aprovado',
            'pedido_viagem_id' => $id,
        ];

		$insert = $this->Gv_decisao_viagem_model->decisao($data);
        if ($insert) {
            set_alert('success',"Pedido Aprovado");
            redirect('gestao_viagens/pedidos/pedido/'.$id);
        }
        else {
            set_alert('danger',"Já foi Adicionado");
            redirect('gestao_viagens/pedidos/pedido/'.$id);
        }
    }
    public function rejeitar($id) {
        $this->http_method('GET');
		$vfPedido = $this->Gv_pedido_model->first($id);

        $data = [
            'staff_id' => get_staff_user_id(), // ID do Usuario Logado
            'decisao' => 'rejeitado',
            'pedido_viagem_id' => $id,
        ];

		$insert = $this->Gv_decisao_viagem_model->decisao($data);
        if ($insert) {
            set_alert('success',"Pedido Rejeitado");
            redirect('gestao_viagens/pedidos/pedido/'.$id);
        }
        else {
            set_alert('danger',"Já foi Adicionado");
            redirect('gestao_viagens/pedidos/pedido/'.$id);
        }
    }

    public function definir_orcamento ($id) {
        $this->http_method('GET');
		$vfPedido = $this->Gv_pedido_model->first($id);

        $data = [
            'staff_id' => get_staff_user_id(), // ID do Usuario Logado
            'pedido_viagem_id' => $id,
            'orcamento' => 30000,
        ];

        $insert = $this->Gv_orcamento_viagem_model->create($data);
        if ($insert) {
            set_alert('success',"Orçamento Adicionado");
            redirect('gestao_viagens/pedidos/pedido/'.$id);
        }
        else {
            set_alert('danger',"Orçamento já foi Adicionado");
            redirect('gestao_viagens/pedidos/pedido/'.$id);
        }
    }
    public function definir_reembolso ($id) {
        $this->http_method('GET');
		$vfPedido = $this->Gv_pedido_model->first($id);
        $vfOrcamento = $this->Gv_orcamento_viagem_model->first_pedido($vfPedido['id']);

        $data = [
            'staff_id' => get_staff_user_id(), // ID do Usuario Logado
            'orcamento_viagem_id' => $vfOrcamento['id'],
            'reembolso' => 2000,
        ];

        $insert = $this->Gv_reembolso_model->create($data);
        if ($insert) {
            set_alert('success',"Reembolso Adicionado");
            redirect('gestao_viagens/pedidos/pedido/'.$id);
        }
        else {
            set_alert('danger',"Reembolso já foi Adicionado");
            redirect('gestao_viagens/pedidos/pedido/'.$id);
        }
    }

    // Algoritmo de Bellman Ford
    public function bellmanFord_transporte($id) {
        $this->http_method('POST');

		$vfPedido = $this->Gv_pedido_model->first($id);
		$bellman = $this->Gv_reserva_transporte_model->get_alg_bellman($vfPedido['id']);
		$graph = $bellman['grafico'];
		$vertices = $bellman['vertices'];

        $this->form_validation->set_rules('inicio', 'Inicio', 'required', ['required' => 'Preencha o campo {field}']);
		$start = $this->input->post('inicio') ?? ''; // Cidade de partida

        if (!$this->form_validation->run()) {
			set_alert('warning', 'Selecione o ponto inicial.');
			redirect('gestao_viagens/pedidos/pedido/'.$id);
        }
        else {
            $result = bellmanFord($graph, $vertices, $start);
            list($distances, $predecessors) = bellmanFord($graph, $vertices, $start);

            if (is_string($distances)) {
                echo $distances; // Exibe se houver um ciclo negativo
            } else {
                echo "Menor custo e percurso de $start para as outras cidades:\n";
                echo "<br>";
                foreach ($distances as $vertex => $distance) {
                    if ($distance === INF) {
                        echo "$start -> $vertex: Infinito (sem caminho)\n";
                    } else {
                        $path = reconstruirPercurso($predecessors, $vertex);
                        echo "<br>";
                        echo "$start -> $vertex: Custo = $distance, Percurso = " . implode(" -> ", $path) . "\n";
                        echo "<br>";
                        echo "<hr>";
                    }
                }
            }
        }
	}
    public function bellmanFord_voo($id) {
        $this->http_method('POST');

		$vfPedido = $this->Gv_pedido_model->first($id);
		$bellman = $this->Gv_reserva_voo_model->get_alg_bellman($vfPedido['id']);
		$graph = $bellman['grafico'];
		$vertices = $bellman['vertices'];

		$this->form_validation->set_rules('inicio', 'Inicio', 'required', ['required' => 'Preencha o campo {field}']);
		$start = $this->input->post('inicio') ?? ''; // Cidade de partida

        if (!$this->form_validation->run()) {
			set_alert('warning', 'Selecione o ponto inicial.');
			redirect('gestao_viagens/pedidos/pedido/'.$id);
        }
        else {
            $result = bellmanFord($graph, $vertices, $start);
            list($distances, $predecessors) = bellmanFord($graph, $vertices, $start);

            if (is_string($distances)) {
                echo $distances; // Exibe se houver um ciclo negativo
            } else {
                echo "Menor custo e percurso de $start para as outras cidades:\n";
                echo "<br>";
                foreach ($distances as $vertex => $distance) {
                    if ($distance === INF) {
                        echo "$start -> $vertex: Infinito (sem caminho)\n";
                    } else {
                        $path = reconstruirPercurso($predecessors, $vertex);
                        echo "<br>";
                        echo "$start -> $vertex: Custo = $distance, Percurso = " . implode(" -> ", $path) . "\n";
                        echo "<br>";
                        echo "<hr>";
                    }
                }
            }
        }
	}
}