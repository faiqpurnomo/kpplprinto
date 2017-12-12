<?php
/**
 * Part of ci-phpunit-test
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2015 Kenji Suzuki
 * @link       https://github.com/kenjis/ci-phpunit-test
 */

class view_test extends TestCase
{
	public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->Model('Admin_model');
    }

  public function test_viewdashboardadmin()
  {
    $_SESSION['status'] = 'siap';
    $output = $this->request('GET', 'admin/dashboardadmin');
    $this->assertContains('<title>Print-in - Dashboard</title>',$output);
  }

    public function test_viewdashboardadmin_nologin()
  {
    $output = $this->request('GET', 'admin/dashboardadmin');
    $this->assertRedirect('display');
  }

  public function test_viewdatauser()
  {
    $_SESSION['status'] = 'siap';
    $output = $this->request('GET', 'admin/datauser');
    $this->assertContains('<td><strong>Authentication</strong></td>', $output);
  }

  public function test_viewdatauser_nologin()
  {
    $output = $this->request('GET', 'admin/datauser');
    $this->assertRedirect('display');
  }

  public function test_viewupdateorder()
  {
    $_SESSION['status'] = 'siap';
    $output = $this->request('GET', 'admin/showUpdateorder');
    $this->assertContains('<h3>UPDATE ORDER</h3>', $output);
  }

  public function test_viewupdateorder_nologin()
  {
    $output = $this->request('GET', 'admin/showUpdateorder');
    $this->assertRedirect('display');
  }

  public function test_viewhistoryadmin()
  {
    $_SESSION['status'] = 'siap';
    $output = $this->request('GET', 'admin/historyadmin');
    $this->assertContains('<h2>HISTORI ORDER</h2>', $output);
  }

  public function test_viewhistoryadmin_nologin()
  {
    $output = $this->request('GET', 'admin/historyadmin');
    $this->assertRedirect('display');
  }



//Yang bawah belom
  public function test_viewtambahadmin()
  {
    $_SESSION['status'] = 'siap';
    $output = $this->request('GET', 'admin/tambahAdmin');
    $this->assertContains('<h1>Daftar Baru</h1>', $output);
  }

  public function test_viewdataadmin()
  {
    $_SESSION['status'] = 'siap';
    $output = $this->request('GET', 'admin/dataAdmin');
    $this->assertContains('<h2>DATA ADMIN</h2>', $output);
  }

  public function test_viewdatahistory()
  {
    $_SESSION['status'] = 'siap';
    $output = $this->request('GET', 'admin/dataHistory');
    $this->assertContains('<h2>HISTORI ORDER</h2>', $output);
  }

  public function test_viewreaddata()
  {
    $_SESSION['status'] = 'siap';
    $output = $this->request('GET', 'admin/readData');
    $this->assertContains('<h2>DATA USER</h2>', $output);
  }

  public function test_viewreaddata2()
  {
    $_SESSION['status'] = 'siap';
    $output = $this->request('GET', 'admin/readData2');
    $this->assertContains('<h2>DATA ADMIN</h2>', $output);
  }

  public function test_viewshowDashboard1()
  {
    $_SESSION['status'] = 'siap';
    $output = $this->request('GET', 'user/showDashboard1');
    $this->assertContains('<h3>Apa yang akan anda lakukan hari ini?</h3>', $output);
  }

  public function test_viewshowPrint1()
  {
        $_SESSION['status'] = 'siap';
    $output = $this->request('GET', 'user/showPrint');
    $this->assertContains('<h3>Apa yang ingin anda cetak hari ini ?</h3>', $output);
  }

  public function test_viewshowHistory()
  {
        $_SESSION['status'] = 'siap';
    $output = $this->request('GET', 'user/showHistory');
    $this->assertContains('<h2>HISTORI TRANSAKSI</h2>', $output);
  }
  public function test_viewshowHistory_NoSession()
  {
    $output = $this->request('GET', 'user/showHistory');
    $this->assertRedirect('display');
  }
  public function test_viewreaddatalogin()
  {
      $_SESSION['status'] = 'siap';
      $output = $this->request('GET', 'user/readData');
      $this->assertContains('<h2>HISTORI TRANSAKSI</h2>', $output);
  }
}
