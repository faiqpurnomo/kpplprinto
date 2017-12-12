<?php
/**
 * Part of ci-phpunit-test
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2015 Kenji Suzuki
 * @link       https://github.com/kenjis/ci-phpunit-test
 */

class Login_Admin_test extends TestCase
{
	public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->Model('Admin_model');
    }

  public function test_submit_masuk(){
      //$this->assertFalse( isset($_SESSION['email']) );
      $this->request('POST', 'admin/login',
          [
              'username' => 'admin',
              'pass' => 'admin123',
          ]);
      //$this->assertRedirect('');
      //$this->assertEquals('admin', $_SESSION['username']);
  }
  public function test_submit_masuk_kosong(){
      //$this->assertFalse( isset($_SESSION['email']) );
      $this->request('POST', 'admin/login',
          [
              'username' => '',
              'pass' => '',
          ]);
      //$this->assertRedirect('');
      //$this->assertEquals('admin', $_SESSION['username']);
  }

   public function test_submit_masuk_salah(){
      //$this->assertFalse( isset($_SESSION['email']) );
      $this->request('POST', 'admin/login',
          [
              'username' => 'aa',
              'pass' => 'ddd',
          ]);
      //$this->assertRedirect('');
      //$this->assertEquals('admin', $_SESSION['username']);
  }

}
