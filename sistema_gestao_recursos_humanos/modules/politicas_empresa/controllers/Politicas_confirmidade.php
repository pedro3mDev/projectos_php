<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Politicas Empresa Controller
 */
class Politicas_confirmidade extends AdminController {
	public function __construct() {
		parent::__construct();
		$this->load->model('Pe_politica_model');
	}
	private function http_method ($vfMethod) {
        if ($_SERVER['REQUEST_METHOD'] !== $vfMethod) {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['status' => false, 'message' => 'Metodo não permitido']);
            exit;
        }
    }

	public function index() {
		$data['title'] = _l('pe_politicas_confirmidade');

		$this->load->view('politicas_confirmidade/index', $data);
	}
}