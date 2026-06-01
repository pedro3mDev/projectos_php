<?php

defined('BASEPATH') or exit('No direct script access allowed');
 
defined('BASEPATH') or exit('No direct script access allowed');

class Comunicacao extends AdminController
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
        $data['title'] = _l('Comunicacao');
		$data['tipo_comunicacao'] = $this->Gv_gestao_viagem_model->get_tipo_comunicacao();
		$data['pedidos_viagem'] = $this->Gv_gestao_viagem_model->get_orcamento(2);

		$data['comunicacao'] = $this->Gv_gestao_viagem_model->get_comunicacao();
		$data['staffs'] = $this->Gv_gestao_viagem_model->staffs();

        $this->load->view('comunicacao/index', $data);
    }

	public function adicionar () {
		$this->http_method('POST');

		$data = [
			'orcamento_viagem_id' => $this->input->post('orcamento') ?? '',
            'tipo_comunicacao_id' => $this->input->post('tipo_comunicacao') ?? '',
            'mensagem' => $this->input->post('mensagem') ?? '',
            'data_envio' => $this->input->post('data_comunicacao') ?? '',
        ];

		$funcionarios = $this->input->post('funcionarios[]') ?? '';

        $this->form_validation->set_rules('funcionarios[]', 'funcionarios', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('orcamento', _l('orcamento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('tipo_comunicacao', _l('tipo_comunicacao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('mensagem', _l('Mensagem'), 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('data_comunicacao', 'Data Comunicação', 'required|callback_data', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_viagens/comunicacao');
        }
		else {
			$insert = $this->Gv_gestao_viagem_model->create_comunicacao($data, $funcionarios);
			set_alert('success',"Cadastrado com sucesso");
			redirect('gestao_viagens/comunicacao');
		}
	}
	public function delete ($id) {
		$this->Gv_gestao_viagem_model->first_comunicacao($id);
		$this->Gv_gestao_viagem_model->delete_comunicacao($id);
		set_alert('success',"Eliminado com sucesso");
		redirect('gestao_viagens/comunicacao');
	}
	public function editar ($id) {
		$this->http_method('POST');
		$this->Gv_gestao_viagem_model->first_comunicacao($id);

		$data = [
			'orcamento_viagem_id' => $this->input->post('e_orcamento') ?? '',
            'tipo_comunicacao_id' => $this->input->post('e_tipo_comunicacao') ?? '',
            'mensagem' => $this->input->post('e_mensagem') ?? '',
            'data_envio' => $this->input->post('e_data_comunicacao') ?? '',
        ];
        $funcionarios = $this->input->post('funcionarios_e[]') ?? '';

        $this->form_validation->set_rules('funcionarios_e[]', 'funcionarios', 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_orcamento', _l('orcamento'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_tipo_comunicacao', _l('tipo_comunicacao'), 'required', ['required' => 'Preencha o campo {field}']);
		$this->form_validation->set_rules('e_mensagem', _l('Mensagem'), 'required', ['required' => 'Preencha o campo {field}']);
        $this->form_validation->set_rules('e_data_comunicacao', 'Data Comunicação', 'required|callback_data', ['required' => 'Preencha o campo {field}']);
		if (!$this->form_validation->run()) {
			set_alert('danger',"Preenchas os campos correctamente");
			redirect('gestao_viagens/comunicacao');
        }
		else {
			$insert = $this->Gv_gestao_viagem_model->update_comunicacao($data, $funcionarios, $id);
			set_alert('success',"Actuallizado com sucesso");
			redirect('gestao_viagens/comunicacao');
		}
	}
	public function comunicacao($id) {
        $vf = $this->Gv_gestao_viagem_model->first_comunicacao($id);;
		$data['title'] = _l('comunicacao') . ' - '. $vf['objetivo'];
		$data['comunicacao'] = $vf;

		$this->load->view('comunicacao/comunicacao', $data);
	}

	public function enviar_email($id) {
        $vf = $this->Gv_gestao_viagem_model->first_comunicacao($id);;
		$staffs = $this->Gv_gestao_viagem_model->get_comunicacao_staff($id);
		$assunto = "[VIAGEM] " . $vf['objetivo'] . '('. $vf['destino'] .')';
		$mensagem = $vf['mensagem'];
		if ($staffs) {
			foreach ($staffs as $s) {
				if (!empty($s['email'])) {
					send_email_gestao_viagem($s['email'],$assunto, $mensagem);
				}
			}
			set_alert('success',"Email enviado com sucesso");
			redirect('gestao_viagens/comunicacao/comunicacao/'.$id);
		}
		else {
			set_alert('danger',"Não foi possivel selecionar algum funcionário.");
			redirect('gestao_viagens/comunicacao/comunicacao/'.$id);
		}
	}
}