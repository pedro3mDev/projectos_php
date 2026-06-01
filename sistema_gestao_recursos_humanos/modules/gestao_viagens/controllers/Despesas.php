<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Despesas extends AdminController
{
    public function __construct()
    {
        parent::__construct();

		$this->load->model('Gv_gestao_viagem_model');
		$this->load->model('Gv_pedido_model');

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
	public function data ($data) {
        $da = DateTime::createFromFormat('Y-m-d', $data);
        if ($da && $da->format('Y-m-d') == $data) {
            return true;
        }
        $this->form_validation->set_message('data', 'Preencha o campo {field} corretamente');
        return false;
    }

    public function index()
    {
        $data['title'] = _l('despesas');
		$data['pedidos_viagem'] = $this->Gv_gestao_viagem_model->get_orcamento(2);
		$data['categorias'] = $this->Gv_gestao_viagem_model->get_categorias_despesas();

		$data['despesas'] = $this->Gv_gestao_viagem_model->get_despesa();
        $this->load->view('despesas/index', $data);
    }

	public function adicionar () {
		$this->http_method('POST');

        $this->form_validation->set_rules('orcamento', 'Orçamento', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('categoria', 'Categoria', 'required', ['required' => 'Preencha o campo {field}']);
        // $this->form_validation->set_rules('arquivo', 'Comprovativo', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('valor', 'Valor', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('descricao', 'Descrição', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('data_despesa', 'Data Despesa', 'required|callback_data', ['required' => 'Preencha o campo {field}']);

		if (empty($_FILES['arquivo']['name'])) {
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('gestao_viagens/despesas');
		}
        if (!$this->form_validation->run()) {
            echo validation_errors();
            return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('gestao_viagens/despesas');
        }
		else {
            $file_upload = false;
			$conf_u['upload_path'] = FCPATH. 'modules/gestao_viagens/uploads/';
			$conf_u['allowed_types'] = 'jpg|png|jpeg|pdf|docx|doc';
			$conf_u['encrypt_name'] = TRUE;

			$this->upload->initialize($conf_u);
			if (!$this->upload->do_upload('arquivo')) {
				// $dataView['title'] = _l('pe_nova_politica');
				// $dataView['error'] = $this->upload->display_errors();
				set_alert('danger',"Houve algum erro, ao carregar o arquivo. Selecione um formato valíddo");
				return redirect('gestao_viagens/despesas');
			}
			else {
				$file_upload = TRUE;
				$upload_data = $this->upload->data();
			}

            $data = [
                'status_id' => 1,
                'orcamento_viagem_id' => $this->input->post('orcamento') ?? '',
                'categoria_despesa_id' => $this->input->post('categoria') ?? '',
                'arquivo' => $file_upload ? $upload_data['file_name'] : null,
                'valor' => $this->input->post('valor') ?? '',
				'descricao' => $this->input->post('descricao') ?? '',
				'data_despesa' => $this->input->post('data_despesa') ?? '',
            ];

			$insert = $this->Gv_gestao_viagem_model->create_despesa($data);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_viagens/despesas');
		}
	}
	public function delete ($id) {
		$this->Gv_gestao_viagem_model->first_despesa($id);
		$this->Gv_gestao_viagem_model->delete_despesa($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_viagens/despesas');
	}
	public function editar ($id) {
		$this->http_method('POST');
		$this->Gv_gestao_viagem_model->first_despesa($id);

        $this->form_validation->set_rules('e_orcamento', 'Orçamento', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_categoria', 'Categoria', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_valor', 'Valor', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_descricao', 'Descrição', 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_data_despesa', 'Data Despesa', 'required|callback_data', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            // echo validation_errors();
            // return;
			set_alert('danger', 'Preenchas os campos correctamente');
			redirect('gestao_viagens/despesas');
        }
		else {

            $data = [
                'orcamento_viagem_id' => $this->input->post('e_orcamento') ?? '',
                'categoria_despesa_id' => $this->input->post('e_categoria') ?? '',
                'valor' => $this->input->post('e_valor') ?? '',
				'descricao' => $this->input->post('e_descricao') ?? '',
				'data_despesa' => $this->input->post('e_data_despesa') ?? '',
            ];
			if (!empty($_FILES['arquivo']['name'])) {
				$conf_u['upload_path'] = FCPATH. 'modules/gestao_viagens/uploads/';
				$conf_u['allowed_types'] = 'jpg|png|jpeg|pdf|docx|doc';
				$conf_u['encrypt_name'] = TRUE;
				$this->upload->initialize($conf_u);
				if (!$this->upload->do_upload('arquivo')) {
					// $dataView['title'] = _l('pe_nova_politica');
					// $dataView['error'] = $this->upload->display_errors();
					set_alert('danger',"Houve algum erro, ao carregar o arquivo. Selecione um formato valíddo");
					return redirect('gestao_viagens/despesas');
				}
				else {
					$file_upload = TRUE;
					$upload_data = $this->upload->data();

					$data['arquivo'] = $file_upload ? $upload_data['file_name'] : null;
				}
			}

			$insert = $this->Gv_gestao_viagem_model->update_despesa($data, $id);
			set_alert('success',"Actualizado com sucesso");
			redirect('gestao_viagens/despesas');
		}
	}

	public function despesa($id) {
        $vf = $this->Gv_gestao_viagem_model->first_despesa($id);;
		$data['title'] = _l('despesas') . ' - '. $vf['objetivo'];
		$data['despesa'] = $vf;

		$this->load->view('despesas/despesa', $data);
	}
	public function status_despesa_aprovar($id) {
        $vf = $this->Gv_gestao_viagem_model->first_despesa($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_viagens/despesas/despesa/'.$id);
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_viagens/despesas/despesa/'.$id);
		}
		$this->Gv_gestao_viagem_model->update_despesa_status(['status_id' => 2], $id);
		set_alert('success',"Aprovado com sucesso.");
		return redirect('gestao_viagens/despesas/despesa/'.$id);
    }
    public function status_despesa_rejeitar($id) {
        $vf = $this->Gv_gestao_viagem_model->first_despesa($id);
		$aprovadores = json_decode($vf['aprovadores']) ?? [];
		$user = get_staff_user_id();
		if (!in_array($user, $aprovadores)) {
			set_alert('danger',"Erro, você não faz parte da lista dos aprovadores.");
			return redirect('gestao_viagens/despesas/despesa/'.$id);
		}
		if ($vf['status_id'] != 1) {
			set_alert('danger',"Erro, tente novamente.");
			return redirect('gestao_viagens/despesas/despesa/'.$id);
		}
		$this->Gv_gestao_viagem_model->update_despesa_status(['status_id' => 3], $id);
		set_alert('success',"Rejeitado com sucesso.");
		return redirect('gestao_viagens/despesas/despesa/'.$id);
    }













	// Lista todos os Despesass
	// public function get()
	// {
	// 	$data = $this->Despesas_model->get_all();
	// 	echo json_encode($data);
	// }

	// Exibe detalhes de um Despesas
	public function view($id)
	{
		/*
		$data['Despesas'] = $this->Despesas_model->get_by_id($id);

		// Verificando se o Despesas foi encontrado
		if (empty($data['Despesas'])) {
			// Retornando um erro 404 em formato JSON
			echo json_encode(['status' => false, 'message' => 'Despesas não encontrado']);
			return;
		}

		// Retornando os dados do Despesas em JSON
		echo json_encode(['status' => 'success', 'data' => $data['Despesas']]);
		*/
	}

	// Exibe formulário para criar um novo Despesas
	public function create()
	{
		/*
		// Verifica se há dados no POST
		if (!empty($_POST)) {
			// Valida os campos obrigatórios
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_pedido_viagem', 'Pedido de Viagem', 'required|integer');
			$this->form_validation->set_rules('id_funcionario', 'ID do Funcionário', 'required|integer');
			$this->form_validation->set_rules('Despesas', 'Despesas', 'required');

			// Se a validação falhar, retorna os erros em JSON
			if ($this->form_validation->run() === FALSE) {
				echo json_encode([
					'status' => 'error',
					'message' => 'Validação falhou',
					'errors' => $this->form_validation->error_array(),
				]);
				return;
			}

			// Captura os dados válidos
			$data = [
				'id_pedido_viagem' => $this->input->post('id_pedido_viagem'),
				'id_funcionario'   => $this->input->post('id_funcionario'),
				'Despesas'         => $this->input->post('Despesas'),
			];

			// Insere os dados no banco
			if ($this->Despesas_model->insert($data)) {
				// Retorna sucesso
				echo json_encode([
					'status' => 'success',
					'message' => 'Despesas salvo com sucesso!',
				]);
			} else {
				// Retorna erro ao salvar no banco
				echo json_encode([
					'status' => 'error',
					'message' => 'Erro ao salvar o Despesas no banco de dados.',
				]);
			}
		} else {
			// Caso $_POST esteja vazio
			echo json_encode([
				'status' => 'error',
				'message' => 'Nenhum dado foi enviado.',
			]);
		}
		*/
	}

	// Exibe formulário para editar um Despesas
	public function edit($id)
	{
		/*
		// Recupera o Despesas a ser editado pelo ID
		$data['Despesas'] = $this->Despesas_model->get_by_id($id);

		if (empty($data['Despesas'])) {
			show_404(); // Se não encontrar, exibe erro 404
		}

		// Verifica se a requisição é POST (edição)
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Valida os campos
			$this->load->library('form_validation');
			$this->form_validation->set_rules('id_pedido_viagem', 'Pedido de Viagem', 'required|integer');
			$this->form_validation->set_rules('id_funcionario', 'ID do Funcionário', 'required|integer');
			$this->form_validation->set_rules('Despesas', 'Despesas', 'required');

			// Se a validação falhar, retorna os erros em JSON
			if ($this->form_validation->run() === FALSE) {
				header('Content-Type: application/json');
				echo json_encode([
					'status' => 'error',
					'message' => 'Validação falhou',
					'errors' => $this->form_validation->error_array(),
				]);
				return;
			}

			// Dados a serem atualizados
			$update_data = [
				'id_pedido_viagem' => $this->input->post('id_pedido_viagem'),
				'id_funcionario'   => $this->input->post('id_funcionario'),
				'Despesas'         => $this->input->post('Despesas')
			];

			// Atualiza o Despesas no banco de dados
			if ($this->Despesas_model->update($id, $update_data)) {
				// Se atualizado com sucesso
				header('Content-Type: application/json');
				echo json_encode([
					'status' => 'success',
					'message' => 'Despesas atualizado com sucesso!',
				]);
			} else {
				// Se falhar ao atualizar
				header('Content-Type: application/json');
				echo json_encode([
					'status' => 'error',
					'message' => 'Erro ao atualizar o Despesas.',
				]);
			}
		} else {
			// Caso a requisição não seja POST, retorna os dados para edição
			$this->load->view('Despesas/edit', $data);
		}
		*/
	}
}