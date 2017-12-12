<?php
class Admin_model extends CI_Model {

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
	function getDataAdmin($username) {
		$this->db->select('*');
		$this->db->where('username', $username);
		$this->db->from('admin');
		$query = $this->db->get();
		return $query->result_array();
	}

	function getDataAdmin2() {
		$query = $this->db->get('admin');
		return $query->result_array();
		// referensi query result:
		// https://www.codeigniter.com/userguide3/database/results.html
	}

	function login_authenAdmin($username, $pass){
		$this->db->select('*');
		$this->db->where('username', $username);
		$this->db->where('pass', $pass);
		$this->db->from('admin');
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	function authen_admin($username) {
		$this->db->select('authentication');
		$this->db->where('username', $username);
		$this->db->from('admin');
		$query = $this->db->get();
		return $query->result_array();
	}

	/*function wrong_passwordAdmin($username, $value){
		$this->db->set('authentication', $value);
		$this->db->where('username', $username);
		$this->db->update('admin');
	}*/

	function hapus($data){
		$this->db->where('id', $data);
		$this->db->delete('order_masuk');
	}

	function hapusAdmin($data){
		$this->db->where('username', $data);
		$this->db->delete('admin');
	}

	function addAdmindata($data) {
		$this->db->insert('admin', $data);
		//insert $data ke tabel admin
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
			$test = $this->db->get('admin');
			return $test->num_rows();
		}

	public function testing_order(){
			$test = $this->db->get('order_masuk');
			return $test->num_rows();
		}

	public function testing_purpose_find($username){
		$result = $this->db->where('username', $username)
						   ->get('admin');
		return $this->db->affected_rows();
	}

	public function find_testing_order($id){
			$result = $this->db->where('id', $id)
							   ->get('order_masuk');
			return $this->db->affected_rows();
		}


	public function find_testing_akun($username) {
		$result = $this->db->where('username', $username)
						   ->get('admin');
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
        		 ->get('admin');
        if($hasil->num_rows==0){
        	$this->db->insert('admin', $data);
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