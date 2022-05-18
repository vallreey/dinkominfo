<?php
namespace App\Controllers;
use App\Models\UserModel;

class Account extends BaseController
{
    protected $session;

    public function __construct()
	{
        $this->session = \Config\Services::session();

		helper(['user', 'url', 'form']);
	}

    public function logon()
	{   
        $data['title'] = 'Login Primbon Dinkominfo';
        if (!$_POST) {
            return view('account/logon', $data);
        } else {
            $request = \Config\Services::request();
            $account = $request->getPost();

            $user = new UserModel();
            $isUser = $user->checkAccount($account);

            if (count($isUser) < 1) {
                $data['alertLogin'] = 'Login gagal! Username & Password tidak sesuai.';
                return view('account/logon', $data);
            } else {
                $_SESSION['login_state'] = true;

                foreach ($isUser[0] as $key => $val) {
                    $_SESSION[$key] = $val;
                }
                unset($_SESSION['password']);

                $_SESSION['is_admin'] = isAdmin($_SESSION['id']);
                if ($_SESSION['is_admin']) {
                    $_SESSION['is_reviewer'] = $_SESSION['can_add'] = $_SESSION['can_checkin'] = true;
                } else {
                    $_SESSION['is_reviewer'] = isReviewer($_SESSION['id']);
                    $_SESSION['can_add']     = canAdd($_SESSION['id']);
                    $_SESSION['can_checkin'] = canCheckIn($_SESSION['id']);
                }
                $_SESSION['dept_name'] = getDeptName($_SESSION['id']);
                    
                return redirect()->to('dashboard');
            }
        }
	}

    public function logout()
	{   
        $this->session->destroy();
        return redirect()->to('logon'); 
	}
}