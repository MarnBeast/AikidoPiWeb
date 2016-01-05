<?php
class Aikido extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('aikido_model');
	}
	
	public function index()
	{
		$data['title'] = 'AIKIDO';
		
		// $rows[0]['active'] = true;
		// $rows[1]['active'] = false;
		// $rows[2]['active'] = false;
		// $rows[3]['active'] = true;
		// $data['config'] = $rows;
		$data['config'] = $this->aikido_model->get_aikido_config();
		$data['iotypes'] = $this->aikido_model->get_aikido_io();
		$data['actions'] = $this->aikido_model->get_aikido_actions();
		
		$this->load->view('templates/header', $data);
		$this->load->view('aikido/index', $data);
		$this->load->view('templates/footer', $data);
	}
	
	public function view($row = NULL)
	{
		$data['title'] = 'AIKIDO';
		
		$rows[0]['active'] = true;
		$rows[1]['active'] = false;
		$rows[1]['active'] = false;
		$rows[1]['active'] = true;
		//$this->aikido_model->get_aikido_config();
		$data['config_row'] = $rows[$row];
		
		$this->load->view('templates/header', $data);
		$this->load->view('aikido/index', $data);
		$this->load->view('templates/footer', $data);
	}
}
