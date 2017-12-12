<?php
class Display extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('email');
	}

	function index() {
		// $vendor = $this->vendor->read('vendor')->result_array();
		// $vendor['vendor'] = $vendor;
		// $this->load->view('index');
		$this->load->view('index');
		$data['err_message'] = "";
	}

	function login(){
		$this->load->view('user/login');
		$data['err_message'] = "";
	}

	function register(){
		$this->load->view('user/register');
		$data['err_message'] = "";
	}

	function register_success(){
		$this->load->view('user/registersuccess');
	}

	function loginvendor(){
		$this->load->view('vendor/loginvendor');
		$data['err_message'] = "";
	}

	function registervendor(){
		$this->load->view('vendor/registervendor');
		$data['err_message'] = "";
	}

}
?>

