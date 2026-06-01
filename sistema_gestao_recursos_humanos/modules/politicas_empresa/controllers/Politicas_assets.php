<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Politicas Empresa Controller
 */
class Politicas_assets extends AdminController {
	public function __construct() {
		parent::__construct();
		$this->load->model('Pe_categoria_assets_model');
		$this->load->model('Pe_fornecedor_model');
		$this->load->model('Pe_localizacao_model');
		$this->load->model('Pe_assets_model');
		$this->load->model('Pe_ciclo_vida_model');
		$this->load->model('Pe_movimentacao_model');
		$this->load->model('Pe_manutencao_model');

		$this->load->library(['form_validation', 'upload']);
	}
	private function http_method ($vfMethod) {
        if ($_SERVER['REQUEST_METHOD'] !== $vfMethod) {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['status' => false, 'message' => 'Metodo não permitido']);
            exit;
        }
    }

	public function index() {
		$data['title'] = _l('pe_politicas_assets');
		$data['categorias'] = $this->Pe_categoria_assets_model->get();
		$data['fornecedores'] = $this->Pe_fornecedor_model->get();
		$data['localizacoes'] = $this->Pe_localizacao_model->get();
		$data['assets'] = $this->Pe_assets_model->get();

		$this->load->view('politicas_assets/index', $data);
	}

	public function nova_categoria() {
		$data['title'] = _l('pe_nova_categoria');
		$this->load->view('politicas_assets/nova_categoria', $data);
	}
	public function adicionar_categoria() {
		$this->http_method('POST');

		$data = [
            'staff_id' => get_staff_user_id(), // ID do Usuario Logado
            'categoria' => $this->input->post('categoria') ?? '',
        ];
		$this->form_validation->set_rules('categoria', 'Categoria', 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			$dataView['title'] = _l('pe_nova_categoria');
			$this->load->view('politicas_assets/nova_categoria', $dataView);
        }
		else {
			$insert = $this->Pe_categoria_assets_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/politicas_assets/nova_categoria');
		}
	}
	public function categoria($id) {
		$vfCategoria = $this->Pe_categoria_assets_model->first($id);
		$data['title'] = _l('pe_categoria');
		$data['categoria'] = $vfCategoria;

		$this->load->view('politicas_assets/categoria', $data);
	}
	public function editar_categoria($id) {
		$this->http_method('POST');
		$vfCategoria = $this->Pe_categoria_assets_model->first($id);

		$data = [
            'categoria' => $this->input->post('categoria') ?? '',
        ];

		if ($data['categoria'] == $vfCategoria['categoria']) {
			set_alert('warning',"Não houve nenhuma informação actualizada");
			redirect('politicas_empresa/politicas_assets/categoria/'.$vfCategoria['id']);
		}
		else {
			$this->form_validation->set_rules('categoria', 'Categoria', 'required', ['required' => 'Preencha o campo {field}']);
			if (!$this->form_validation->run()) {
				$dataView['title'] = _l('pe_categoria');
				$dataView['categoria'] = $vfCategoria;

				$this->load->view('politicas_assets/categoria', $dataView);
			}
			else {
				$insert = $this->Pe_categoria_assets_model->update($data, $id);
				set_alert('success',"Actualizado com sucesso");
				redirect('politicas_empresa/politicas_assets/categoria/'.$id);
			}
		}
	}
	public function categoria_eliminar($id) {
		$vfCategoria = $this->Pe_categoria_assets_model->first($id);
		$this->Pe_categoria_assets_model->delete($id);

		set_alert('success',"Categoria eliminada com sucesso");
		redirect('politicas_empresa/politicas_assets');
	}

	public function novo_fornecedor() {
		$data['title'] = _l('pe_novo_fornecedor');
		$this->load->view('politicas_assets/novo_fornecedor', $data);
	}
	public function adicionar_fornecedor (){
		$this->http_method('POST');

		$data = [
            'staff_id' => get_staff_user_id(), // ID do Usuario Logado
            'nome' => $this->input->post('nome') ?? '',
            'nif' => $this->input->post('nif') ?? '',
            'localizacao' => $this->input->post('localizacao') ?? '',
        ];
		$this->form_validation->set_rules('nome', 'Nome', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('localizacao', 'Localização', 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			$dataView['title'] = _l('pe_novo_fornecedor');
			$this->load->view('politicas_assets/novo_fornecedor', $dataView);
        }
		else {
			$insert = $this->Pe_fornecedor_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/politicas_assets/novo_fornecedor');
		}
	}
	public function fornecedor_editar($id) {
		$vfFornecedor = $this->Pe_fornecedor_model->first($id);

		$data['title'] = _l('pe_editar_fornecedor');
		$data['fornecedor'] = $vfFornecedor;
		$this->load->view('politicas_assets/fornecedor_editar', $data);
	}
	public function atualizar_fornecedor ($id){
		$this->http_method('POST');
		$vfFornecedor = $this->Pe_fornecedor_model->first($id);

		$data = [
            'nome' => $this->input->post('nome') ?? '',
            'nif' => $this->input->post('nif') ?? '',
            'localizacao' => $this->input->post('localizacao') ?? '',
        ];
		$this->form_validation->set_rules('nome', 'Nome', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('localizacao', 'Localização', 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			$dataView['title'] = _l('pe_editar_fornecedor');
			$dataView['fornecedor'] = $vfFornecedor;

			$this->load->view('politicas_assets/fornecedor_editar', $dataView);
        }
		else {
			$update = $this->Pe_fornecedor_model->update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/politicas_assets/fornecedor_editar/'.$id);
		}
	}
	public function fornecedor_eliminar($id) {
		$vfCategoria = $this->Pe_fornecedor_model->first($id);
		$this->Pe_fornecedor_model->delete($id);

		set_alert('success',"Fornecedor eliminada com sucesso");
		redirect('politicas_empresa/politicas_assets');
	}

	public function nova_localizacao() {
		$data['title'] = _l('pe_nova_localizacao');
		$this->load->view('politicas_assets/nova_localizacao', $data);
	}
	public function adicionar_localizacao (){
		$this->http_method('POST');

		$data = [
            'staff_id' => get_staff_user_id(), // ID do Usuario Logado
            'descricao' => $this->input->post('descricao') ?? '',
            'localizacao' => $this->input->post('localizacao') ?? '',
        ];
		$this->form_validation->set_rules('descricao', 'Descrição', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('localizacao', 'Localização', 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			$dataView['title'] = _l('pe_nova_localizacao');
			$this->load->view('politicas_assets/nova_localizacao', $dataView);
        }
		else {
			$insert = $this->Pe_localizacao_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/politicas_assets/nova_localizacao');
		}
	}
	public function localizacao_eliminar($id) {
		$vfLocalizacao = $this->Pe_localizacao_model->first($id);
		$this->Pe_localizacao_model->delete($id);

		set_alert('success',"Localização eliminada com sucesso");
		redirect('politicas_empresa/politicas_assets');
	}
	public function localizacao_editar($id) {
		$vfLocalizacao = $this->Pe_localizacao_model->first($id);

		$data['title'] = _l('pe_editar_localizacao');
		$data['localizacao'] = $vfLocalizacao;
		$this->load->view('politicas_assets/editar_localizacao', $data);
	}
	public function atualizar_localizacao ($id){
		$this->http_method('POST');
		$vfLocalizacao = $this->Pe_localizacao_model->first($id);

		$data = [
            'descricao' => $this->input->post('descricao') ?? '',
            'localizacao' => $this->input->post('localizacao') ?? '',
        ];
		$this->form_validation->set_rules('descricao', 'Descrição', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('localizacao', 'Localização', 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			$data['localizacao'] = $vfLocalizacao;
			$dataView['title'] = _l('pe_editar_localizacao');
			$this->load->view('politicas_assets/editar_localizacao', $dataView);
        }
		else {
			$this->Pe_localizacao_model->update($data, $id);
			set_alert('success',"Atualizado com sucesso");
			redirect('politicas_empresa/politicas_assets/localizacao_editar/'.$id);
		}
	}
	public function localizacao($id) {
		$vfLocalizacao = $this->Pe_localizacao_model->first($id);
		$data['title'] = _l('pe_localizacao');
		$data['localizacao'] = $vfLocalizacao;

		$this->load->view('politicas_assets/localizacao', $data);
	}

	public function novo_assets() {
		$data['title'] = _l('pe_novo_assets');
		$data['categorias'] = $this->Pe_categoria_assets_model->get();
		$data['fornecedores'] = $this->Pe_fornecedor_model->get();

		$this->load->view('politicas_assets/novo_assets', $data);
	}
	public function adicionar_assets () {
		$this->http_method('POST');

		$this->form_validation->set_rules('categoria', 'Categoria', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('fornecedor', 'Fornecedor', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('nome', 'Nome', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_aquisicao', 'Data Aquisição', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('valor_aquisicao', 'valor Aquisição', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('estado', 'Estado do Assets', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('vida_util', 'Vida Util', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_uso', 'Data Inicial de Uso ', 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			$dataView['title'] = _l('pe_nova_politica');
			$this->load->view('seguranca_escritorio/nova_politica', $dataView);
        }
		else {
			$data = [
				'staff_id' => get_staff_user_id(), // ID do Usuario Logado
				'categoria_assets_id' => $this->input->post('categoria') ?? '',
				'fornecedor_id' => $this->input->post('fornecedor') ?? '',
				'nome' => $this->input->post('nome') ?? '',
				'data_aquisicao' => $this->input->post('data_aquisicao') ?? '',
				'valor_aquisicao' => $this->input->post('valor_aquisicao') ?? '',
				'status' => $this->input->post('estado') ?? '',
				'vida_util' => $this->input->post('vida_util') ?? '',
				'data_inicial_uso' => $this->input->post('data_uso') ?? '',
			];

			$insert = $this->Pe_assets_model->create($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('politicas_empresa/politicas_assets/novo_assets');
		}
	}
	public function assets_editar($id) {
		$vfAssets = $this->Pe_assets_model->first($id);

		$data['title'] = _l('pe_editar_assets');
		$data['categorias'] = $this->Pe_categoria_assets_model->get();
		$data['fornecedores'] = $this->Pe_fornecedor_model->get();
		$data['assets'] = $vfAssets;

		$this->load->view('politicas_assets/editar_assets', $data);
	}
	public function actualizar_assets ($id) {
		$this->http_method('POST');
		$vfAssets = $this->Pe_assets_model->first($id);

		$this->form_validation->set_rules('categoria', 'Categoria', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('fornecedor', 'Fornecedor', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('nome', 'Nome', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_aquisicao', 'Data Aquisição', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('valor_aquisicao', 'valor Aquisição', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('estado', 'Estado do Assets', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('vida_util', 'Vida Util', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_uso', 'Data Inicial de Uso ', 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			$dataView['title'] = _l('pe_editar_assets');
			$dataView['categorias'] = $this->Pe_categoria_assets_model->get();
			$dataView['fornecedores'] = $this->Pe_fornecedor_model->get();
			$dataView['assets'] = $vfAssets;

			$this->load->view('politicas_assets/editar_assets', $dataView);
        }
		else {
			$data = [
				'categoria_assets_id' => $this->input->post('categoria') ?? '',
				'fornecedor_id' => $this->input->post('fornecedor') ?? '',
				'nome' => $this->input->post('nome') ?? '',
				'data_aquisicao' => $this->input->post('data_aquisicao') ?? '',
				'valor_aquisicao' => $this->input->post('valor_aquisicao') ?? '',
				'status' => $this->input->post('estado') ?? '',
				'vida_util' => $this->input->post('vida_util') ?? '',
				'data_inicial_uso' => $this->input->post('data_uso') ?? '',
			];

			$this->Pe_assets_model->update($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('politicas_empresa/politicas_assets/assets_editar/'.$id);
		}
	}
	public function assets_eliminar($id) {
		$this->Pe_assets_model->first($id);
		$this->Pe_assets_model->delete($id);

		set_alert('success',"Assets eliminada com sucesso");
		redirect('politicas_empresa/politicas_assets');
	}
	public function assets($id) {
		$vfAssets = $this->Pe_assets_model->first($id);
		$data['title'] = _l('pe_assets');
		$data['assets'] = $vfAssets;
		$data['ciclo_vida'] = $this->Pe_ciclo_vida_model->get_assets($id);

		$this->load->view('politicas_assets/assets', $data);
	}
	public function assets_add_localizacao($id) {
		$vfAssets = $this->Pe_assets_model->first($id);

		$data['title'] = _l('pe_assets_novo_localizacao');
		$data['categorias'] = $this->Pe_categoria_assets_model->get();
		$data['fornecedores'] = $this->Pe_fornecedor_model->get();
		$data['localizacoes'] = $this->Pe_localizacao_model->get();
		$data['assets'] = $vfAssets;
		$data['ultimo_movimento'] = $this->Pe_movimentacao_model->ultimo_movimento($id);

		$this->load->view('politicas_assets/assets_add_localizacao', $data);
	}
	public function assets_adicionar_localizacao($id) {
		$this->http_method('POST');
		$vfAssets = $this->Pe_assets_model->first($id);
		$vfUlMovimento = $this->Pe_movimentacao_model->ultimo_movimento($id);

		if (!$vfUlMovimento) {
			$this->form_validation->set_rules('localizacao_origem', 'Localização de Origem', 'required', ['required' => 'Preencha o campo {field}']);
		}
		$this->form_validation->set_rules('localizacao_destino', 'Localização de Destino', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_movimento', 'Data Movimento', 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			$dataView['title'] = _l('pe_assets_novo_localizacao');
			$dataView['categorias'] = $this->Pe_categoria_assets_model->get();
			$dataView['fornecedores'] = $this->Pe_fornecedor_model->get();
			$dataView['localizacoes'] = $this->Pe_localizacao_model->get();
			$dataView['assets'] = $vfAssets;
			$dataView['ultimo_movimento'] = $this->Pe_movimentacao_model->ultimo_movimento($id);

			$this->load->view('politicas_assets/assets_add_localizacao', $dataView);
        }
		else {
			$data = [
				'staff_id' => get_staff_user_id(), // ID do Usuario Logado
				'assets_id' => $id,
				'localizacao_assets_origem_id' => $this->input->post('localizacao_origem') ?? '',
				'localizacao_assets_destino_id' => $this->input->post('localizacao_destino') ?? '',
				'data_movimento' => $this->input->post('data_movimento') ?? '',
			];

			$insert = $this->Pe_movimentacao_model->create($data);
			set_alert('success',"Nova Localização com sucesso");
			redirect('politicas_empresa/politicas_assets/assets/'.$id);
		}
	}

	public function assets_add_manutencao($id) {
		$vfAssets = $this->Pe_assets_model->first($id);

		$data['title'] = _l('pe_assets_add_manutencao');
		$data['assets'] = $vfAssets;
		$data['ultima_manutencao'] = $this->Pe_manutencao_model->ultima_manutencao($id);

		$this->load->view('politicas_assets/assets_add_manutencao', $data);
	}
	public function assets_adicionar_manutencao($id) {
		$this->http_method('POST');
		$vfAssets = $this->Pe_assets_model->first($id);

		$enum_valido = ['preventiva', 'correctiva'];
		$this->form_validation->set_rules('tipo_manutencao', 'Tipo de Manutenção', ['required', [
            'enum', function ($value) use ($enum_valido) {
                return in_array($value, $enum_valido);
            }
        ]], ['required' => 'Selecione um {field}', 'enum' => 'O campo {field} deve ter os seguintes valores: ' . implode(', ', $enum_valido)]);
		$this->form_validation->set_rules('descricao', 'Descrição', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('data_manutencao', 'Data de Manutenção', 'required', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			$dataView['title'] = _l('pe_assets_add_manutencao');
			$dataView['assets'] = $vfAssets;
			$dataView['ultima_manutencao'] = $this->Pe_manutencao_model->ultima_manutencao($id);

			$this->load->view('politicas_assets/assets_add_manutencao', $dataView);
        }
		else {
			$data = [
				'staff_id' => get_staff_user_id(), // ID do Usuario Logado
				'assets_id' => $id,
				'tipo' => $this->input->post('tipo_manutencao') ?? '',
				'descricao' => $this->input->post('descricao') ?? '',
				'data_manutencao' => $this->input->post('data_manutencao') ?? '',
			];

			$insert = $this->Pe_manutencao_model->create($data);
			set_alert('success',"Nova Manutenção Adicionada com sucesso");
			redirect('politicas_empresa/politicas_assets/assets/'.$id);
		}
	}
}