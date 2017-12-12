<?php
class User extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('User_Model');
		$this->load->library('upload');
		$this->load->library('session');
		$this->load->helper('security');
		$this->load->helper('form');
		$this->load->library('form_validation');
		//$this->load->library('email');
		//$this = get_instance();
	}

	public function index(){
		$data = $this->data->read('vendor')->result_array();
		$vendor['vendor'] = $data;
		$this->load->view('index');
	}



	function session() {
		if ($this->session->userdata('status') != 'siap') {
			//var_dump($this->session->userdata('status'));die();
			redirect('display');
		}
	}


	function login() {
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('pass', 'Password', 'required');

		if($this->form_validation->run() == false){
			redirect('Display/login');
		}
		else
		{
		$email = html_escape($this->input->post('email', TRUE));
		$password = html_escape($this->input->post('pass', TRUE));
		$isLogin = $this->User_Model->login_authen($email, $password);
		$read = $this->User_Model->getData($email);
		//$nama = $read['nama'];
		foreach ($read as $r) {
			$nama = $r['nama'];
		}

			if ($isLogin == true) {
				$this->session->set_userdata('email', $email);
				$this->session->set_userdata('nama', $nama);
				$this->session->set_userdata('status', 'siap');
				$this->load->view('user/dashboard1');
			}
			else
			{
				$this->load->view('user/gagallogin');
			}
		}
	}

	function register() {

		$this->form_validation->set_rules('nama', 'Nama', 'required');
		$this->form_validation->set_rules('nohandphone', 'No Handphone', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('password2', 'Password2', 'required');

		if($this->form_validation->run() == false){
			redirect('Display/register');
		}
		else{
		$pass = html_escape($this->input->post('password', TRUE));
		$pass2 = sha1($this->input->post('password2', TRUE));

		if ($pass != $pass2) {
			$data['err_message'] = "Password tidak cocok!";
			$this->load->view('user/register');
		} else {

		$data = array(
			'nama' => html_escape($this->input->post('nama', TRUE)),
			'nohandphone' => html_escape($this->input->post('nohandphone', TRUE)),
			'email' => html_escape($this->input->post('email', TRUE)),
			'password' => html_escape(sha1($this->input->post('password', TRUE)))
		);
		
		$this->User_Model->addUserdata($data);
		$this->load->view('user/registersuccess');
		}}
	}
	//faiq
	function setting() {

		$this->session();

		$this->form_validation->set_rules('passwordlama', 'Nama', 'required');
		$this->form_validation->set_rules('passwordbaru1', 'Password Baru', 'required');
		$this->form_validation->set_rules('passwordbaru2', 'Password Baru 2', 'required');

		if($this->form_validation->run() == false){
			redirect('user/showSetting');
		}
		else{
		$email = $this->session->userdata('email');
		$passlama =  $this->input->post('passwordlama', TRUE);
		$pass = $this->input->post('passwordbaru1', TRUE);
		$pass2 = $this->input->post('passwordbaru2', TRUE);
		$isLogin = $this->User_Model->login_authen($email, $passlama);

		if ($isLogin == false){
			redirect('user/showSetting');
		}
		else if ($pass != $pass2 ) {
			redirect('user/showSetting');
		} 
		else if ($pass == $pass2 && $isLogin == TRUE){
		
		$this->User_Model->updatePassword($pass,$email);
		$this->load->view('user/dashboard1');
		}}
	}

	//history
	function readData() {
		$this->session();
		$data = $this->User_Model->getHistory();
		$this->load->view('user/history', array('data' => $data));
	}

	//pesanan
	 function readPesanan() {
		$this->session();
		$data = $this->User_Model->getPesanan();
		$this->load->view('user/pesanan', array('data' => $data));
	}
	
	function showDashboard1(){
		$this->session();
		$this->load->view('user/dashboard1');
		$data['err_message'] = "";
	}

	function showSetting(){
		$this->session();
		$this->load->view('user/setting');
		$data['err_message'] = "";
	}

	function showPrint(){
		$this->session();
		$this->load->view('user/print');
		$data['err_message'] = "";
		
	}

    function batal($order){
        $this->User_Model->updateBatal($order);
        redirect('user/readPesanan');
    }
    
	function showHistory(){
		$this->session();
		$this->load->view('user/history', array('data' => $data));
		$data['err_message'] = "";
	}

	function logout(){
		$this->session->sess_destroy();
		redirect();}
//vidi
    function printbukti($id){
        $is_submit = $this->input->post('is_submit');
        $this->id = $id;
        if($is_submit == 1){
            $fileUpload = array();
            $isUpload = FALSE;
            $config = array(
                'upload_path' => './uploads/',
                'allowed_types' => 'doc|docx|pdf',
                'max_size' => 15000
            );
        
	        $this->upload->initialize($config);
	        
	        if($this->upload->do_upload('uploadBukti')){
					$fileUpload = $this->upload->data();
				 	$isUpload = TRUE;
				}

	        if($isUpload){
	           $data = array(
	                    'upload_Bukti' => $fileUpload['file_name']);
	                    $this->User_Model->confirm_payment($data, $id);
	                    echo "berhasil";
	    			 	redirect('user/readPesanan');
	                    //$this->load->view('user/showDashboard1');
	                }
            }
        else {
	 	         $this->load->view('user/readPesanan');
            }
    }
//vidi
	public function printt(){
		$is_submit = $this->input->post('is_submit');
		
		if(isset($is_submit) && $is_submit == 1){
			$fileUpload = array();
		 	$isUpload = FALSE;
		 	$config = array(
		 		'upload_path' => './uploads/',
		 		'allowed_types' => 'doc|docx|pdf',
		 		'max_size' => 15000
		 	);

			$this->upload->initialize($config);
		
			if($this->upload->do_upload('userfile')){
				$fileUpload = $this->upload->data();
			 	$isUpload = TRUE;
			}

			if($isUpload){
			 	$data =array(
			 		'tgl_order' => date('j F Y'),
					'email' => $this->session->userdata('email'),
					'ukuran_krts' => $this->input->post('ukuran_krts'),
					'warna' => $this->input->post('warna'),
					'jumlah_copy' => $this->input->post('jumlah_copy'),
					'tgl_ambil' => $this->input->post('tgl_ambil'),
					'waktu' => $this->input->post('waktu'),
					'pesan' => $this->input->post('pesan'),
					'file' => $fileUpload['file_name'],
					'status'=> 'Proses'
			 	);
				
				$this->User_Model->addOrder($data);
			 	redirect('user/showDashboard1');
			 	//$this->load->view('user/showDashboard1');
			}
		} else {
		 	$this->load->view('user/print');
		}
	}
}
?>