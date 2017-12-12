<?php
class Vendor extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Vendor_model');
		$this->load->library('session');
		$this->load->helper('download');
		$this->load->library('form_validation');
		$this->load->helper('security');
	}

	function session() {
		if ($this->session->userdata('status') != 'siap') {
			redirect('display');
		}
	}
	//faiq
	function showSetting(){
		$this->session();
		$this->load->view('vendor/settingvendor');
		$data['err_message'] = "";
	}

	//hafizh
	function register(){
		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('rekening', 'Nomor rekening', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('password2', 'Password2', 'required');

		if($this->form_validation->run() == false){
			redirect('Display/registervendor');
		}
		else{
		$pass = html_escape($this->input->post('password', TRUE));
		$pass2 = html_escape($this->input->post('password2', TRUE));

		if ($pass != $pass2) {
			$data['err_message'] = "Password tidak cocok!";
			$this->load->view('user/register');
		} else {	

		$data = array(
			'username' => html_escape($this->input->post('username', TRUE)),
			'pass' => html_escape($this->input->post('password', TRUE)),
			'rekening' => html_escape($this->input->post('rekening', TRUE)),
		);
		
		$this->Vendor_model->registerVendor($data);
		$this->load->view('display/loginvendor');
		}}

	}

	//apiz
	function lihatOrder(){
		$this->session();
		$data = $this->Vendor_model->getOrder();
		$this->load->view('vendor/seeOrder', array('data' => $data));
	}

	function cekHistori(){
		$this->session();
		$data = $this->Vendor_model->getOrderHistori();
		$this->load->view('vendor/seeOrder', array('data' => $data));
	}

	//apiz
	function konfirmasi($id){
		$this->session();
		$this->Vendor_model->updateOrder($id);
		$this->lihatOrder();
		//$this->load->view('vendor/seeOrder');
	}

	function login() {
		$this->form_validation->set_rules('username', 'username', 'required');
		$this->form_validation->set_rules('pass', 'pass', 'required');

		if($this->form_validation->run()==false)
		{
			redirect('display/loginvendor');
		}
		else
		{

		$username = html_escape($this->input->post('username', TRUE));
		$pass = html_escape($this->input->post('pass', TRUE));
		$isLogin = $this->Vendor_model->login_authenVendor($username, $pass);
		$read = $this->Vendor_model->getDataVendor($username);

		$i = $this->Vendor_model->authen_vendor($username);
		}

		if ($isLogin == true) {
			$this->session->set_userdata('username', $username);
			$this->session->set_userdata('status', 'siap');
			$this->load->view('vendor/dashboardvendor');
		}
		else {
			$error = 'error_message';
			$this->load->view('vendor/loginvendor', $error);
		}
		$this->session();
	}

	function addVendor() {
		$this->form_validation->set_rules('username', 'username', 'required');
		$this->form_validation->set_rules('password', 'pass', 'required');
		$this->form_validation->set_rules('password2', 'pass', 'required');
		$this->session();
		

		if($this->form_validation->run() == false){
			redirect('Vendor/tambahVendor');
		}
		else{
			$pass = html_escape(sha1($this->input->post('password', TRUE)));
			$pass2 = html_escape(sha1($this->input->post('password2', TRUE)));
			if ($pass != $pass2) {
			$data['err_message'] = "Password tidak cocok!";
			redirect('Vendor/tambahVendor');
		} else {

		$data = array(
			'username' => html_escape($this->input->post('username', TRUE)),
			'pass' => html_escape(sha1($this->input->post('password', TRUE)))
			);
		
		$this->Vendor_model->addVendordata($data);
		$this->load->view('vendor/dashboardvendor');
		}
		}
	}

	function logout(){
		$this->session->sess_destroy();
		//redirect();}
		$this->load->view('vendor/loginvendor');
	}
		// $this->session->unset_userdata('status');
		// $this->session->sess_destroy();
		// redirect(); }

	function readData() {
		$this->session();
		$data = $this->Vendor_model->getData();
		$this->load->view('vendor/datauser', array('data' => $data));
	}

	function readData2() {
		$this->session();
		$data = $this->Vendor_model->getDataVendor2();
		$this->load->view('vendor/datavendor', array('data' => $data));
	}
/*
	function downloadFile(){
		$data = $this->Vendor_model->getFile($id);
		foreach ($data as $r) {
			$file = $r['file'];
		}

		$files = file_get_contents('./uploads/');

		force_download($files, 'file');
	}
*/
	function hapus($delete){
		$this->session();
		$this->Vendor_model->hapus($delete);
		$this->dataHistory();
	}

	function hapusVendor($delete){
		$this->session();
		$this->Vendor_model->hapusVendor($delete);
		$this->readData2();
	}

	// function delete_vendor($item){
	// 	$this->session();
	// 	$this->db->where_in('username', $item);
	// 	$this->db->delete('vendor');
	// }

	function dataHistory() {
		$this->session();
		$data = $this->Vendor_model->getDataHistory();
		$this->load->view('vendor/historyvendor', array('data' => $data));
	}

	function dataVendor() {
		$this->session();
		$data = $this->Vendor_model->getDataVendor2();
		$this->load->view('vendor/datavendor', array('data' => $data));
	}

	function dashboardvendor(){
		$this->session();
		$this->load->view('vendor/dashboardvendor');
		$data['err_message'] = "";
	}

	function datauser(){
		$this->session();
		$this->load->view('vendor/datauser');
		$data['err_message'] = "";
	}

	function showUpdateorder(){
		$this->session();
		$this->load->view('vendor/updateorder');
		$data['err_message'] = "";
	}

	function historyvendor(){
		$this->session();
		$this->load->view('vendor/historyvendor', array('data'=>$data));
		$data['err_message']="";
	}

	function tambahVendor(){
		$this->session();
		$this->load->view('vendor/addvendor');
		$data['err_message'] = "";
	}
	//faiq
	function settingVendor() {

		$this->session();

		$this->form_validation->set_rules('passwordlama', 'Nama', 'required');
		$this->form_validation->set_rules('passwordbaru1', 'Password Baru', 'required');
		$this->form_validation->set_rules('passwordbaru2', 'Password Baru 2', 'required');

		if($this->form_validation->run() == false){
			redirect('vendor/showSetting');
		}
		else{
		$username = $this->session->userdata('username');
		$passlama =  $this->input->post('passwordlama', TRUE);
		$pass = $this->input->post('passwordbaru1', TRUE);
		$pass2 = $this->input->post('passwordbaru2', TRUE);
		$isLogin = $this->Vendor_model->login_authenVendor($username, $passlama);

		if($isLogin == false){
			redirect('vendor/showSetting');
		}
		else if ($pass != $pass2 ) {
			redirect('vendor/showSetting');
		} 
		else if ($pass == $pass2 && $isLogin == TRUE){
		
		$this->Vendor_model->updatePasswordVendor($pass,$username);
		$this->load->view('vendor/dashboardvendor');
		}}
	}

	function update($baru) {
		$this->session();
		$data = $this->Vendor_model->getItem($baru);
		$item = array (
			'id' => $data[0]['id'],
			'email' => $data[0]['email'],
			'tgl_order' => $data[0]['tgl_ambil'],
			'waktu' => $data[0]['waktu'],
			'jumlah_copy' => $data[0]['jumlah_copy'],
			'file' => $data[0]['file'],
			'status' => $data[0]['status']
		);		
		$this->load->view('vendor/updateorder', $item);
	}


	function updateOrder() {
		$this->session();
		$status = html_escape($this->input->post('status', TRUE));		
		$id = html_escape($this->input->post('id', TRUE));
		$data = $this->Vendor_model->getItem($id);

		$update = array(
			'status' => 'hatma'
		);
		
		$this->Vendor_model->Update($update, $id);
		$this->dataHistory();
	}

	// function userupdate() {
	// 	$this->session();
	// 	$authentication = html_escape($this->input->post('authentication'));		
	// 	$email = html_escape($this->input->post('email'));
	// 	$data = $this->Vendor_model->getUser($email);
		
	// 	$update = array(
	// 		'authentication' => html_escape($this->input->post('authentication'))
	// 	);
		
	// 	$this->Vendor_model->updateUser($update, $email);
	// 	$this->readData();
	// }

	function updateDataUser($baru) {
		$this->session();
		$data = $this->Vendor_model->getUser($baru);
		$item = array (
			'nama' => $data[0]['nama'],
			'nohandphone' => $data[0]['nohandphone'],
			'email' => $data[0]['email'],
			'password' => $data[0]['password'],
			'authentication' => $data[0]['authentication']
		);		
		$this->load->view('vendor/updatedatauser', $item);
	}
}
?>