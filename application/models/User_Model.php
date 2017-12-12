<?php
class User_Model extends CI_Model {

	function getData($email) {
		$this->db->select('*');
		$this->db->where('email', $email);
		$this->db->from('userdata');
		$query = $this->db->get();
		return $query->result_array();
	}

	function getHistory() {
		$email = $this->session->userdata('email');

		$this->db->select('*');
		$this->db->where('status', 'selesai');
		$this->db->from('order_masuk');
		$query = $this->db->get();
		return $query->result_array();
	}


	//faiq
	function updatePassword($pass,$email){
		$this->db->set('password', $pass);
		$this->db->where('email', $email);
		$this->db->update('userdata');
	}
//vidi
	function getPesanan() {
		$email = $this->session->userdata('email');

		$this->db->select('*');
		$this->db->where('status', 'Proses');
		$this->db->from('order_masuk');
		$query = $this->db->get();
		return $query->result_array();
	}    
    
    function updateBatal($id){
        $this->db->set('status', 'Batal');
        $this->db->where('id', $id);
        $this->db->update('order_masuk');
    }
    
//vidi
	function addUserdata($data) {
		$this->db->insert('userdata', $data);
		//insert $data ke tabel userdata
	}

	function addOrder($data) {
		$this->db->insert('order_masuk', $data);
		//insert $data ke tabel order
	}

	//baru ditambah ijul
	function confirm_payment($data, $id){ 
		$this->db->where('id', $id);
		$this->db->update('order_masuk', $data);
	}


	function login_authen($email, $password){
		$this->db->select('*');
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		$this->db->from('userdata');
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}
	
	function authen_user($email) {
		$this->db->select('authentication');
		$this->db->where('email', $email);
		$this->db->from('userdata');
		$query = $this->db->get();
		return $query->result_array();
	}
	public function testing_purpose(){
			$test = $this->db->get('userdata');
			return $test->num_rows();
		}

	public function find_testing_akun($email) {
		$result = $this->db->where('email', $email)
						   ->get('userdata');
		return $result->row_array();
	}

	function hapusUser($email){
		$this->db->where('email', $email);
		$this->db->delete('userdata');
	}

	
	/*function wrong_password($email, $value){
		$this->db->set('authentication', $value);
		$this->db->where('email', $email);
		$this->db->update('userdata');
	}*/

}
?>