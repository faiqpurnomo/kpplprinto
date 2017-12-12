<?php
/**
 * Part of ci-phpunit-test
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2015 Kenji Suzuki
 * @link       https://github.com/kenjis/ci-phpunit-test
 */

class Admin_test extends TestCase
{
	public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->Model('Admin_model');
    }
  
    public function test_updateDataUser(){
            $_SESSION['status'] = 'siap';
	        $output = $this->request('GET', 'admin/updateDataUser/a@gmail.com');
            $this->assertContains('<h3>Apa yang ingin anda cetak hari ini ?</h3>', $output);

    }

    public function test_updateDataProduk(){
            $_SESSION['status'] = 'siap';
            $output = $this->request('GET', 'admin/updateOrder/28');
            $this->assertContains('<h2>HISTORI ORDER</h2>', $output);

    }

    public function test_updateTransaksi(){
            $_SESSION['status'] = 'siap';
	        $output = $this->request('POST', 'admin/update/28');
            $this->assertContains('<title>Print-in - Halaman Cetak</title>', $output);

    }
    public function test_updateOrder(){
        //$this->assertFalse( isset($_SESSION['email']) );
	        $this->request('POST', 'admin/updateOrder/29');
    }
    public function test_userupdate(){
        //$this->assertFalse( isset($_SESSION['email']) );
	        $this->request('POST', 'admin/userupdate/a@gmail.com');
    }
    public function test_hapusData(){
        //$this->assertFalse( isset($_SESSION['email']) );
	        $this->request('POST', 'admin/hapus/25');
        //$this->assertRedirect('');
    }

    public function test_logout()
	{
        $_SESSION['status'] = 'siap';
        $this->request('GET', 'admin/logout');
        $this->assertFalse( isset($_SESSION['status']) );
	}

    public function test_Delete_admin(){
        $_SESSION['status'] = 'siap';
        $expectedGet = $this->CI->Admin_model->testing_purpose1()-1;

        $output = $this->request('GET', 'admin/hapusAdmin/fiko1');

        $actualGet = $this->CI->Admin_model->testing_purpose1();
        $this->assertEquals($expectedGet, $actualGet);

        $actualFind = $this->CI->Admin_model->testing_purpose_find('fiko1');
        $expectedFind = 0;
        $this->assertEquals($expectedFind, $actualFind);
        $this->CI->Admin_model->testing_reset_purpose_oppose_delete('fiko1');
    }

    public function test_Delete_ordermasuk(){
        $_SESSION['status'] = 'siap';
        $expectedGet = $this->CI->Admin_model->testing_order()-1;

        $output = $this->request('GET', 'admin/hapus/32');

        $actualGet = $this->CI->Admin_model->testing_order();
        $this->assertEquals($expectedGet, $actualGet);

        $actualFind = $this->CI->Admin_model->find_testing_order(32);
        $expectedFind = 0;
        $this->assertEquals($expectedFind, $actualFind);

        $this->CI->Admin_model->testing_reset_ordermasuk(32);
    }

    public function test_Delete_userdata(){
        $_SESSION['status'] = 'siap';
        $expectedGet = $this->CI->Admin_model->testing_order()-1;

        $output = $this->request('GET', 'admin/hapus/32');

        $actualGet = $this->CI->Admin_model->testing_order();
        $this->assertEquals($expectedGet, $actualGet);

        $actualFind = $this->CI->Admin_model->find_testing_order(32);
        $expectedFind = 0;
        $this->assertEquals($expectedFind, $actualFind);
        //$this->CI->Admin_model->testing_reset_purpose_oppose_delete('fiko1');
        $this->CI->Admin_model->testing_reset_ordermasuk(32);
    }

    public function test_addAdmin_berhasil() {
        $_SESSION['status'] = 'siap';
        $expected = $this->CI->Admin_model->testing_purpose1()+1;
        $this->request('POST', 'admin/addAdmin',
            [
                'username' => 'fafaiq',
                'password' => '1234',
                'password2'    => '1234',
            ]);
        $actual = $this->CI->Admin_model->testing_purpose1();
        $this->assertEquals($expected, $actual);


        $expectedAdmin = array('username' => 'fafaiq',
                                'pass' => '7110eda4d09e062aa5e4a390b0a572ac0d2c0220',
                                'authentication' => '0');
        $actualAdmin = $this->CI->Admin_model->find_testing_akun('fafaiq');
        $this->assertEquals($expectedAdmin, $actualAdmin);
        $this->CI->Admin_model->hapusAdmin('fafaiq');
        
    }
    public function test_addAdmin_gagal() {
        $_SESSION['status'] = 'siap';

        $this->request('POST', 'admin/addAdmin',
            [
                'username' => 'fafaiq',
                'password' => '123',
                'password2'    => '1234',
            ]);
        $this->assertRedirect('Admin/tambahAdmin');
        
    }


    public function test_edit_produk(){
        $_SESSION['status'] = 'siap';
        $output = $this->request('POST', 'admin/updateOrder/',
            [
                'id' => 29,
                'status' => 'Selesai'
            ]);
        $updated = $this->CI->Admin_model->find_testing_order(29);
        $actual1 = 1;
        
        $actual2 = $this->CI->Admin_model->getItem(29);
        $output2 = $this->request('GET', 'admin/dataHistory');
        $this->assertContains('
                                <td>Selesai</td>',$output2);

        // $expected2= array (
        //     'id' => 29,
        //     'tgl_order' => '24 May 2017',
        //     'ukuran_krts' => 'A4',
        //     'warna' => 'Ya',
        //     'email' => 'atmosumarto1@gmail.com',
        //     'jumlah_copy' => 1,
        //     'tgl_ambil' => '2017-05-24',
        //     'waktu' => '06.00',
        //     'pesan' => 'A',
        //     'file' => 'ICONIX_Process1.docx',
        //     'status' => 'Selesai',
        // );
        //$this->assertEquals($actual2, $expected2);
        $this->request('POST', 'admin/updateOrder/',
            [
                'id' => 29,
                'status' => 'Proses'
            ]);
    }
}
