<?php
namespace App\Controllers;
use App\Models\UserModel;
use App\Models\DashboardModel;

class Account extends BaseController
{
    protected $session;

    public function __construct()
	{
        $this->session = \Config\Services::session();

        $this->user = new UserModel();
        $this->dashboard = new DashboardModel();

		helper(['user', 'permission', 'url', 'form']);
	}

    public function profile()
    {
        $header['title'] = 'Profile';

        $id = $_SESSION['id'];
        $data = $this->user->getUserDetail($id);
        $data['listBidang'] = $this->dashboard->getOptionalList('bidang');

        echo view('partial/header', $header);
        echo view('partial/top_menu');
        echo view('partial/side_menu');
        echo view('profile', $data);
        echo view('partial/footer');
    }

    public function logon()
	{   
        $data['title'] = 'Login Primbon Dinkominfo';
        if (!$_POST) {
            return view('account/logon', $data);
        } else {
            $request = \Config\Services::request();
            $account = $request->getPost();

            $isUser = $this->user->checkAccount($account);

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

   
    public function getAuthority($uid, $fid, $dept_id) {
        if (isAdmin($uid) || isReviewer($uid))
        return userRights('admin');
        
        if (isOwner($uid, $fid) && isLockedFile($fid))
        return userRights('write');

        $userPermission = getUserRights($uid, $fid);
        $deptPermission = getDeptRights($fid, $dept_id);
        if ($userPermission >= 0 && $userPermission <= 4)
            return $userPermission;
        else 
            return $deptPermission;
    }
}