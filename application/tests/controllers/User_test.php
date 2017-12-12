<?php
/**
 * Part of ci-phpunit-test
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2015 Kenji Suzuki
 * @link       https://github.com/kenjis/ci-phpunit-test
 */

class User_test extends TestCase
{
    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->Model('User_Model');
    }

    public function test_login_berhasil(){
        //$this->assertFalse( isset($_SESSION['email']) );
        $this->request('POST', 'user/login',
            [
                'email' => 'boy@gmail.com',
                'pass' => '123',
            ]);
        //$this->assertRedirect('');
        $this->assertEquals('boy@gmail.com', $_SESSION['email']);
    }
        public function test_login_masuk_salah(){
        //$this->assertFalse( isset($_SESSION['email']) );
            $this->request('POST', 'user/login',
                [
                    'email' => 'boy@gmail.com',
                    'pass' => 'aaaa',
                ]);
    }
    public function test_login_emailkosong(){
         //$this->assertFalse( isset($_SESSION['email']) );
            $this->request('POST', 'user/login',
                [
                    'email' => '',
                    'pass' => 'aaa',
                ]);
        //$this->assertRedirect('');
        $this->assertRedirect('Display/login');
    }
    public function test_login_passwordkosong(){
         //$this->assertFalse( isset($_SESSION['email']) );
            $this->request('POST', 'user/login',
                [
                    'email' => 'boy@gmail.com',
                    'pass' => '',
                ]);
        //$this->assertRedirect('');
        $this->assertRedirect('Display/login');
    }

    public function test_logoutuser()
    {
        $this->assertFalse( isset($_SESSION['email']) );
        $this->request('GET', 'user/logout');
        $this->assertRedirect('');
        $this->assertFalse( isset($_SESSION['email']) );}

    
	//ganti email karena primary key jika ingin testing
	// public function test_addUser_berhasil() {
 //        $this->request('POST', 'user/register',
 //            [
 //                'email' => 'Fdaar@0.com',
 //                'password' => '8787',
 //                'password2'    => '8787',
 //                'nohandphone' => '082114009415',
 //                'nama' => 'Faiq Purnomo',
 //            ]);
       
 //    }
    public function test_addUser_kosong() {
        $this->request('POST', 'user/register',
            [
                'email' => '',
                'password' => '',
                'password2'    => '',
                'nohandphone' => '',
                'nama' => '',
            ]);
        $this->assertRedirect('Display/register');
       
    }
    public function test_addUser_berhasil() {
        $expected = $this->CI->User_Model->testing_purpose()+1;
        $this->request('POST', 'user/register',
            [
                'email' => 'der@haha.com',
                'password' => '1234',
                'password2'    => '1234',
                'nohandphone' => '082116009415',
                'nama' => 'Derol waw',
            ]);
        $actual = $this->CI->User_Model->testing_purpose();

        $this->assertEquals($expected, $actual);
       //cek user
        $expecteduser = array('nama' => 'Derol waw',
                                'nohandphone' => '082116009415',
                                'email' => 'derolz@haha.com',
                                'password' => '7110eda4d09e062aa5e4a390b0a572ac0d2c0220',
                                'authentication' => '0');
        $actualuser = $this->CI->User_Model->find_testing_akun('derolz@haha.com');
        $this->assertEquals($expecteduser, $actualuser);
        $this->CI->User_Model->hapusUser('der@haha.com');
        


    }

    public function test_addUser_gagal() {
        $this->request('POST', 'user/register',
            [
                'email' => '3d3@i.com',
                'password' => '8787',
                'password2'    => '8786',
                'nohandphone' => '082114009415',
                'nama' => 'Faiq Purnomo',
            ]);
        
    }

}
