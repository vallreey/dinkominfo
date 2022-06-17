<?php
namespace App\Controllers;

class Admin extends BaseController
{
    public function __construct()
	  {
        $this->session = \Config\Services::session();
        if (!isset($_SESSION['login_state'])) {
          $message = 'Session Anda telah Habis';
          echo "<SCRIPT>alert('$message');window.location='" . site_url('logon') . "';</SCRIPT>";
        }
	  }

    public function index()
    {
        $header['title'] = 'Administrasi';
        
        echo view('partial/header', $header);
        echo view('partial/top_menu');
        echo view('partial/side_menu');
        echo view('administrasi');
        echo view('partial/footer');
    }


}