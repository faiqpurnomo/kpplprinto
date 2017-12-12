<?php
class Vendor_model extends CI_Model {

	function getData() {
		$query = $this->db->get('userdata');
		return $query->result_array();
		// referensi query result:
		// https://www.codeigniter.com/userguide3/database/results.html
	}

	function getDataHistory() {
		$query = $this->db->get('order_masuk');
		return $query->result_array();
		// referensi query result:
		// https://www.codeigniter.com/userguide3/database/results.html
	}
/*
	function getFile($id){
		$this->db->select('*');
		$this->db->where('id', $id);
		$this->db->from('order_masuk');
		$query = $this->db->get();
		return $query->result_array();
	}
*/
	//Untuk Login
	function getDataVendor($username) {
		$this->db->select('*');
		$this->db->where('username', $username);
		$this->db->from('Vendor');
		$query = $this->db->get();
		return $query->result_array();
	}

	function registerVendor($data){
	
		$this->db->insert('vendor', $data);
		//insert $data ke tabel userdata
	
	}

	//apiz
	function updateOrder($id){
		$this->db->set('status','Confirmed');
		$this->db->where('id', $id);
		$this->db->update('order_masuk');
	}

	//apiz
	function getOrder(){
		$usernamependor = $this->session->userdata('username');
  		$this->db->select('*');
  //$this->db->select('*');
  		$this->db->where('username', $usernamependor);
  		$this->db->from('order_masuk');
  		$query = $this->db->get();
  		return $query->result_array();
	}

	function getOrderHistori(){
		$usernamependor = $this->session->userdata('username');
  		$this->db->select('*');
  //$this->db->select('*');
  		$this->db->where('username', $usernamependor);
  		$this->db->where('status', 'Confirmed');
  		$this->db->from('order_masuk');
  		$query = $this->db->get();
  		return $query->result_array();
	}



	function getDataVendor2() {
		$query = $this->db->get('vendor');
		return $query->result_array();
		// referensi query result:
		// https://www.codeigniter.com/userguide3/database/results.html
	}

	//faiq
	function updatePasswordVendor($pass,$username){
		$this->db->set('pass', $pass);
		$this->db->where('username', $username);
		$this->db->update('vendor');
	}

	function login_authenVendor($username, $pass){
		$this->db->select('*');
		$this->db->where('username', $username);
		$this->db->where('pass', $pass);
		$this->db->from('vendor');
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	function authen_vendor($username) {
		$this->db->select('authentication');
		$this->db->where('username', $username);
		$this->db->from('vendor');
		$query = $this->db->get();
		return $query->result_array();
	}

	/*function wrong_passwordVendor($username, $value){
		$this->db->set('authentication', $value);
		$this->db->where('username', $username);
		$this->db->update('vendor');
	}*/

	function hapus($data){
		$this->db->where('id', $data);
		$this->db->delete('order_masuk');
	}

	function hapusVendor($data){
		$this->db->where('username', $data);
		$this->db->delete('vendor');
	}

	function addVendordata($data) {
		$this->db->insert('vendor', $data);
		//insert $data ke tabel vendor
	}

	function getItem($data) {
		return $this->db->select('*')->from('order_masuk')->where('id', $data)->get()->result_array();
		foreach ($query->result_array() as $row)
{
        echo $row['id'];
        echo $row['tgl_order'];
        echo $row['ukuran_krts'];
        echo $row['warna'];
        echo $row['email'];
        echo $row['jumlah_copy'];
        echo $row['tgl_ambil'];
        echo $row['waktu'];
        echo $row['pesan'];
        echo $row['file'];
        echo $row['status'];
}
	
	}

	function getUser($data) {
		return $this->db->select('*')->from('userdata')->where('email', $data)->get()->result_array();
	}

	function Update($data, $baru){
		$this->db->where('id', $baru);
		$this->db->update('order_masuk', $data);
	}

	function updateUser($data, $baru){
		$this->db->where('email', $baru);
		$this->db->update('userdata', $data);
	}

	//Line below for testing purposes
	public function testing_purpose1(){
			$test = $this->db->get('vendor');
			return $test->num_rows();
		}

	public function testing_order(){
			$test = $this->db->get('order_masuk');
			return $test->num_rows();
		}

	public function testing_purpose_find($username){
		$result = $this->db->where('username', $username)
						   ->get('vendor');
		return $this->db->affected_rows();
	}

	public function find_testing_order($id){
			$result = $this->db->where('id', $id)
							   ->get('order_masuk');
			return $this->db->affected_rows();
		}


	public function find_testing_akun($username) {
		$result = $this->db->where('username', $username)
						   ->get('vendor');
		return $result->row_array();
	}


	//Line below for reset database
	public function testing_reset_purpose_oppose_add_products($id){
		$this->db->where('id', $id)
				 ->delete('produk');
	}

	public function testing_reset_purpose_oppose_delete($username){
		$data = [
        'username' => 'fiko1',
        'pass' => '8787',
        'authentication' => '0',
    ];
        $hasil = $this->db->where('username',$username)
        		 ->get('vendor');
        if($hasil->num_rows==0){
        	$this->db->insert('vendor', $data);
        }
        else return false;
	}
	public function testing_reset_ordermasuk($id){
		$data = [
        'id' => 32,
        'tgl_order' => '24 May 2017',
        'email' => 'boy@gmail.com',
        'ukuran_krts' => 'A4',
        'warna' => 'Ya',
        'jumlah_copy' => '1',
        'tgl_ambil' => '2017-05-29',
        'waktu' => '06.00',
        'pesan' => 'Dijilid',
        'file' => 'ICONIX_Process.docx',
    ];
        $hasil = $this->db->where('id',$id)
        		 ->get('order_masuk');
        if($hasil->num_rows==0){
        	$this->db->insert('order_masuk', $data);
        }
        else return false;
	}
}
?>