<?php
/**
 * Part of ci-phpunit-test
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2015 Kenji Suzuki
 * @link       https://github.com/kenjis/ci-phpunit-test
 */

class Welcome_test extends TestCase
{
	/*    public function setUp()
    {
        $this->resetInstance();
    }
    */
    
    public function test_welcome()
	{
		$output = $this->request('GET', 'welcome/index');
		$this->assertContains('<title>Welcome to CodeIgniter</title>', $output);
	}
	public function test_index()
	{
		$output = $this->request('GET', 'display/index');
		$this->assertContains('<h2>tidak punya waktu untuk mencetak? cetak bersama kami</h2>', $output);
	}


	/*public function test_index()
	{
		$output = $this->request('GET', 'display/index');
		$this->assertContains(' <h2>tidak punya waktu untuk mencetak? cetak bersama kami</h2>', $output);
	}*/
	
	public function test_indexlogin()
	{
		$output = $this->request('GET', 'display/login');
		$this->assertContains('<label class="control-label " for="exampleInputEmail1">Email address</label>', $output);
	}

	public function test_indexregister()
	{
		$output = $this->request('GET', 'display/register');
		$this->assertContains('<input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Masukkan email Anda">', $output);
	}

	public function test_indexloginadmin()
	{
		$output = $this->request('GET', 'display/loginadmin');
		$this->assertContains('<h1>Log In Admin</h1>', $output);
	}

	/*public function test_submit_masuk(){
        //$this->assertFalse( isset($_SESSION['email']) );
        $this->request('POST', 'admin/login',
            [
                'username' => 'admin',
                'pass' => 'admin123',
            ]);
        //$this->assertRedirect('');
        $this->assertEquals('admin', $_SESSION['username']);
    }*/



	public function test_method_404()
	{
		$this->request('GET', 'welcome/method_not_exist');
		$this->assertResponseCode(404);
	}

	public function test_APPPATH()
	{
		$actual = realpath(APPPATH);
		$expected = realpath(__DIR__ . '/../..');
		$this->assertEquals(
			$expected,
			$actual,
			'Your APPPATH seems to be wrong. Check your $application_folder in tests/Bootstrap.php'
		);
	}
}
