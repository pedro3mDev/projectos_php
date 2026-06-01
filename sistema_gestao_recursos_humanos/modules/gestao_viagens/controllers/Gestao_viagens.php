<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Recruitment Controller
 */
class Gestao_viagens extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Gv_gestao_viagem_model');
		$this->load->model('Gv_pedido_model');

		$this->load->library(['form_validation', 'upload']);

		// $this->load->model('Gv_pedido_model');
		// $this->load->model('Gv_equipa_model');
		// $this->load->model('Gv_orcamento_viagem_model');
		// $this->load->model('Gv_reembolso_model');
		// $this->load->model('Gv_reserva_hotel_model');
		// $this->load->model('Gv_reserva_voo_model');
		// $this->load->model('Gv_reserva_transporte_model');
		// $this->load->model('Gv_decisao_viagem_model');
		// $this->load->model('Gv_status_model');
		// $this->load->model('despesas_model');

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
		$data['title'] = _l('gv_painel');
		$data['tabs']['view'] = '/gestao_viagens';

		$data['total_planejamento'] = $this->Gv_pedido_model->total();
		$data['total_planejamento_penedntes'] = $this->Gv_pedido_model->total(1);
		$data['total_planejamento_rejeitados'] = $this->Gv_pedido_model->total(3);
		$data['total_planejamento_aprovados'] = $this->Gv_pedido_model->total(2);

		$data['tipo_viagem_dashboard'] = $this->Gv_gestao_viagem_model->get_tipo_viagem_dashboard();

		$data['dashboard_gasto_hotel'] = $this->Gv_gestao_viagem_model->get_orcamento_hotel();
		$data['dashboard_gasto_transporte'] = $this->Gv_gestao_viagem_model->get_orcamento_transporte();
		$data['dashboard_gasto_voo'] = $this->Gv_gestao_viagem_model->get_orcamento_voo();

		$data['top_destinos'] = $this->Gv_pedido_model->get_top_destino();
        $data['orcamentos'] = $this->Gv_gestao_viagem_model->get_orcamento();


		$data['reserva']["total"] = 0;
		$data["reserva"]['total_reserva_hotel'] = 0;
		$data["reserva"]['total_reserva_voo'] = 0;
		$data["reserva"]['total_reserva_transporte'] = 0;


		$data["reserva"]['mais_visitados_reserva_voo'] = 0;
		$data["reserva"]['mais_visitados_reserva_transporte'] = 0;

		$mesAtual = date('m'); // Retorna o mês atual em formato numérico (01 a 12)
		$anoAtual = date('Y'); // Retorna o ano atual em formato numérico completo (ex.: 2025)
		$data["despesas"]['total_despesas_mes'] = 0;
		$data["despesas"]['total_despesas_ano'] = 0;

		$data['pedido']['total'] = 0;
		$data['pedido']['total_nacional'] = 0;
		$data['pedido']['total_internacional'] = 0;
		$data['pedido']['total_pendente'] = 0;
		$data['pedido']['total_aprovado'] = 0;
		$data['pedido']['total_rejeitado'] = 0;

		$this->load->view('index', $data);
	}
	public function relatorios()
	{
		$data['title'] = _l('gv_relatorio');
		$data['tabs']['view'] = '/gestao_viagens';

		$this->load->view('relatorios', $data);
	}
	public function configuracoes()
	{
		$data['title'] = _l('gv_configuracoes');
		$data['group'] = $this->input->get('group');
		$data['tab'][] = 'categorias';
		$data['tab'][] = 'tipo_viagem';
		// $data['tab'][] = 'status';
		$data['tab'][] = 'estimativa_viagem';
		$data['tab'][] = 'classificacoes';
		$data['tab'][] = 'categorias_despesas';
		$data['tab'][] = 'tipo_comunicacao';

		if ($data['group'] == '') {
			$data['title'] = _l('categorias');
			$data['group'] = 'categorias';
			$data['categorias'] = $this->Gv_gestao_viagem_model->get_categorias();
		} elseif ($data['group'] == 'categorias') {
			$data['title'] = _l('categorias');
			$data['categorias'] = $this->Gv_gestao_viagem_model->get_categorias();
		} elseif ($data['group'] == 'tipo_viagem') {
			$data['title'] = _l('tipo_viagem');
			$data['tipo_viagens'] = $this->Gv_gestao_viagem_model->get_tipo_viagem();
		}
		// elseif ($data['group'] == 'status') {
		// 	$data['title'] = _l('status');
		// 	$data['sget_tipo_viagemtatus'] = $this->Gv_gestao_viagem_model->get_status();
		// }
		elseif ($data['group'] == 'estimativa_viagem') {
			$data['title'] = _l('estimativa_viagem');
			$data['estimativa_viagem'] = $this->Gv_gestao_viagem_model->get_estimativa();
			$data['tipo_viagen'] = $this->Gv_gestao_viagem_model->get_tipo_viagem();
		}
		elseif ($data['group'] == 'classificacoes') {
			$data['title'] = _l('classificacoes');
			$data['classificacoes'] = $this->Gv_gestao_viagem_model->get_classificacoes();
		}
		elseif ($data['group'] == 'categorias_despesas') {
			$data['title'] = _l('categorias_despesas');
			$data['categorias'] = $this->Gv_gestao_viagem_model->get_categorias_despesas();
		} elseif ($data['group'] == 'tipo_comunicacao') {
			$data['title'] = _l('tipo_comunicacao');
			$data['tipo_comunicacao'] = $this->Gv_gestao_viagem_model->get_tipo_comunicacao();
		} else {
			set_alert('danger',"Definições não encontrada");
			redirect('gestao_viagens/configuracoes?group=categorias');
		}

		$data['tabs']['view'] = 'includes/' . $data['group'];

		$this->load->view('configuracoes', $data);
	}

	// Categoria
	public function add_categoria () {
		$this->http_method('POST');

		$data = [
            'categoria' => $this->input->post('categoria') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
        ];
		$this->form_validation->set_rules('categoria', _l('categoria'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_viagens/configuracoes?group=categorias');
        }
		else {
			$insert = $this->Gv_gestao_viagem_model->create_categoria($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_viagens/configuracoes?group=categorias');
		}
	}
	public function editar_categoria ($id) {
		$this->http_method('POST');
		$this->Gv_gestao_viagem_model->first_categoria($id);

		$data = [
            'categoria' => $this->input->post('e_categoria') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
        ];
		$this->form_validation->set_rules('e_categoria', _l('categoria'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_viagens/configuracoes?group=categorias');
        }
		else {
			$this->Gv_gestao_viagem_model->update_categoria($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_viagens/configuracoes?group=categorias');
		}
	}
	public function delete_categoria ($id) {
		$this->Gv_gestao_viagem_model->first_categoria($id);
		$this->Gv_gestao_viagem_model->delete_categoria($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_viagens/configuracoes?group=categorias');
	}

	// tipo_viagem
	public function add_tipo_viagem () {
		$this->http_method('POST');

		$data = [
            'tipo_viagem' => $this->input->post('tipo_viagem') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
        ];
		$this->form_validation->set_rules('tipo_viagem', _l('tipo_viagem'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_viagens/configuracoes?group=tipo_viagem');
        }
		else {
			$insert = $this->Gv_gestao_viagem_model->create_tipo_viagem($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_viagens/configuracoes?group=tipo_viagem');
		}
	}
	public function editar_tipo_viagem ($id) {
		$this->http_method('POST');
		$this->Gv_gestao_viagem_model->first_tipo_viagem($id);

		$data = [
            'tipo_viagem' => $this->input->post('e_tipo_viagem') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
        ];
		$this->form_validation->set_rules('e_tipo_viagem', _l('tipo_viagem'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_viagens/configuracoes?group=tipo_viagem');
        }
		else {
			$this->Gv_gestao_viagem_model->update_tipo_viagem($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_viagens/configuracoes?group=tipo_viagem');
		}
	}
	public function delete_tipo_viagem ($id) {
		$this->Gv_gestao_viagem_model->first_tipo_viagem($id);
		$this->Gv_gestao_viagem_model->delete_tipo_viagem($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_viagens/configuracoes?group=tipo_viagem');
	}

	// status
	public function add_status () {
		$this->http_method('POST');

		$data = [
            'status' => $this->input->post('status') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
        ];
		$this->form_validation->set_rules('status', _l('status'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_viagens/configuracoes?group=status');
        }
		else {
			$insert = $this->Gv_gestao_viagem_model->create_status($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_viagens/configuracoes?group=status');
		}
	}
	public function editar_status ($id) {
		$this->http_method('POST');
		$this->Gv_gestao_viagem_model->first_status($id);

		$data = [
            'status' => $this->input->post('e_status') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
        ];
		$this->form_validation->set_rules('e_status', _l('status'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_viagens/configuracoes?group=status');
        }
		else {
			$this->Gv_gestao_viagem_model->update_status($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_viagens/configuracoes?group=status');
		}
	}
	public function delete_status ($id) {
		$this->Gv_gestao_viagem_model->first_status($id);
		$this->Gv_gestao_viagem_model->delete_status($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_viagens/configuracoes?group=status');
	}

	// Estimativa de Viagem
	public function add_estimativa () {
		$this->http_method('POST');

		$data = [
            'tipo_viagem_id' => $this->input->post('tipo_viagem') ?? '',
            'valor' => $this->input->post('valor') ?? '',
        ];
		$this->form_validation->set_rules('tipo_viagem', _l('tipo_viagem'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('valor', _l('valor'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_viagens/configuracoes?group=estimativa_viagem');
        }
		else {
			$insert = $this->Gv_gestao_viagem_model->create_estimativa($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_viagens/configuracoes?group=estimativa_viagem');
		}
	}
	public function editar_estimativa ($id) {
		$this->http_method('POST');
		$this->Gv_gestao_viagem_model->first_estimativa($id);

		$data = [
            'tipo_viagem_id' => $this->input->post('e_tipo_viagem') ?? '',
            'valor' => $this->input->post('e_valor') ?? '',
        ];
		$this->form_validation->set_rules('e_tipo_viagem', _l('tipo_viagem'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_valor', _l('valor'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_viagens/configuracoes?group=estimativa_viagem');
        }
		else {
			$insert = $this->Gv_gestao_viagem_model->update_estimativa($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_viagens/configuracoes?group=estimativa_viagem');
		}
	}
	public function delete_estimativa ($id) {
		$this->Gv_gestao_viagem_model->first_estimativa($id);
		$this->Gv_gestao_viagem_model->delete_estimativa($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_viagens/configuracoes?group=estimativa_viagem');
	}

	// Classificacao de Feedback
	public function add_classificacao () {
		$this->http_method('POST');

		$data = [
            'nome' => $this->input->post('classificacao') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
        ];
		$this->form_validation->set_rules('classificacao', _l('classificacao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_viagens/configuracoes?group=classificacoes');
        }
		else {
			$insert = $this->Gv_gestao_viagem_model->create_classificacoes($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_viagens/configuracoes?group=classificacoes');
		}
	}
	public function editar_classificacao ($id) {
		$this->http_method('POST');
		$this->Gv_gestao_viagem_model->first_classificacoes($id);

		$data = [
            'nome' => $this->input->post('e_classificacao') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
        ];
		$this->form_validation->set_rules('e_classificacao', _l('classificacao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_viagens/configuracoes?group=classificacoes');
        }
		else {
			$this->Gv_gestao_viagem_model->update_classificacoes($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_viagens/configuracoes?group=classificacoes');
		}
	}
	public function delete_classificacao ($id) {
		$this->Gv_gestao_viagem_model->first_classificacoes($id);
		$this->Gv_gestao_viagem_model->delete_classificacoes($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_viagens/configuracoes?group=classificacoes');
	}

	// tipo_comunicacao
	public function add_tipo_comunicacao () {
		$this->http_method('POST');

		$data = [
            'nome' => $this->input->post('tipo_comunicacao') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
        ];
		$this->form_validation->set_rules('tipo_comunicacao', _l('tipo_comunicacao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_viagens/configuracoes?group=tipo_comunicacao');
        }
		else {
			$insert = $this->Gv_gestao_viagem_model->create_tipo_comunicacao($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_viagens/configuracoes?group=tipo_comunicacao');
		}
	}
	public function editar_tipo_comunicacao ($id) {
		$this->http_method('POST');
		$this->Gv_gestao_viagem_model->first_tipo_comunicacao($id);

		$data = [
            'nome' => $this->input->post('e_tipo_comunicacao') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
        ];
		$this->form_validation->set_rules('e_tipo_comunicacao', _l('tipo_comunicacao'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_viagens/configuracoes?group=tipo_comunicacao');
        }
		else {
			$this->Gv_gestao_viagem_model->update_tipo_comunicacao($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_viagens/configuracoes?group=tipo_comunicacao');
		}
	}
	public function delete_tipo_comunicacao ($id) {
		$this->Gv_gestao_viagem_model->first_tipo_comunicacao($id);
		$this->Gv_gestao_viagem_model->delete_tipo_comunicacao($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_viagens/configuracoes?group=tipo_comunicacao');
	}

	// Categoria Despesas
	public function add_categoria_despesa () {
		$this->http_method('POST');

		$data = [
            'categoria' => $this->input->post('categoria') ?? '',
            'descricao' => $this->input->post('descricao') ?? '',
        ];
		$this->form_validation->set_rules('categoria', _l('categoria'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_viagens/configuracoes?group=categorias_despesas');
        }
		else {
			$insert = $this->Gv_gestao_viagem_model->create_categoria_despesas($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_viagens/configuracoes?group=categorias_despesas');
		}
	}
	public function editar_categoria_despesa ($id) {
		$this->http_method('POST');
		$this->Gv_gestao_viagem_model->first_categoria_despesas($id);

		$data = [
            'categoria' => $this->input->post('e_categoria') ?? '',
            'descricao' => $this->input->post('e_descricao') ?? '',
        ];
		$this->form_validation->set_rules('e_categoria', _l('categoria'), 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_viagens/configuracoes?group=categorias_despesas');
        }
		else {
			$this->Gv_gestao_viagem_model->update_categoria_despesas($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_viagens/configuracoes?group=categorias_despesas');
		}
	}
	public function delete_categoria_despesa ($id) {
		$this->Gv_gestao_viagem_model->first_categoria_despesas($id);
		$this->Gv_gestao_viagem_model->delete_categoria_despesas($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_viagens/configuracoes?group=categorias_despesas');
	}



















	public function politica_viagem()
	{
		// $this->load->view('manage_mapeamento', $data);
	}
}