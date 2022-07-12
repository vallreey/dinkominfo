<?php
namespace App\Controllers;
use App\Models\UserModel;
use App\Models\DashboardModel;
use App\Models\GeneralModel;

class Account extends BaseController
{
    protected $session;

    public function __construct()
	{
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();

        $this->user = new UserModel();
        $this->main = new GeneralModel();
        $this->dashboard = new DashboardModel();

		helper(['user', 'permission', 'url', 'form']);
	}

    public function profile()
    {
        $header['title'] = 'Profile';

        $id = $_SESSION['id'];
        $data = $this->user->getUserDetail($id);
        $data['listBidang'] = $this->dashboard->getOptionalList('bidang');

        $side['active'] = 'profile';

        echo view('partial/header', $header);
        echo view('partial/top_menu');
        echo view('partial/side_menu', $side);
        echo view('profile', $data);
        echo view('partial/footer');
    }

    public function logon()
	{   
        $_SESSION['title'] = config('MyConfig')->settings['title'];
        if (!$_POST) {
            return view('account/logon');
        } else {
            $request = \Config\Services::request();
            $account = $request->getPost();

            $isUser = $this->user->checkAccount($account);

            if (count($isUser) < 1) {
                $_SESSION['info_error'] = '<b>Login gagal!</b> Username & Password tidak sesuai.';
                return redirect()->to('account/logon');
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
                $_SESSION['root_id']   = config('MyConfig')->settings['root_id'];

                // add notification for pending approval
                // total need to be reviewed
                $wheresReviewed['status'] = 'onreview';
                $wheresReviewed['publishable'] = publishableByStatus('onreview');
                $_SESSION['notif_review'] = $this->dashboard->getData($wheresReviewed);
                // total rejected
                $wheresRejected['status'] = 'rejected';
                $wheresRejected['adminMode'] = 0;
                $wheresRejected['publishable'] = publishableByStatus('rejected');
                $_SESSION['notif_rejected'] = $this->dashboard->getData($wheresRejected);
                    
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

    public function updateProfile()
    {
        if (!$_POST) {
            $_SESSION['info_error'] = '<b>Error!</b> Tidak ada data yang terupdate.';
            return redirect()->to('account/profile');
        }

        $uid        = trim($_POST['uid']);
        $username   = strtolower(trim($_POST['username']));
        $password   = isset($_POST['password']) && $_POST['password'] !== '' ? md5(trim($_POST['password'])) : '';
        
        // data user
        $users = array(
            'username'  => $username,
            'department'=> trim($_POST['department']),
            'first_name'=> ucwords(trim($_POST['first_name'])),
            'last_name' => ucwords(trim($_POST['last_name'])),
            'phone'     => trim($_POST['phone']),
            'Email'     => strtolower(trim($_POST['email'])),
            'can_add'   => isset($_POST['can_add']) && $_POST['can_add'] !== '' ? trim($_POST['can_add']) : 0,
            'can_checkin'=> isset($_POST['can_checkin']) && $_POST['can_checkin'] !== '' ? trim($_POST['can_checkin']) : 0,
        );

        if ($password !== '') $users['password'] = $password;
        
        // data admin
        $admins['admin']= isset($_POST['is_admin']) && $_POST['is_admin'] !== '' ? trim($_POST['is_admin']) : 0;

        $this->db->transBegin();
        try {
            // UPDATE EXISTING USER
            $updateUser = $this->main->updateData('user', array('id' => $uid), $users);
            if (!$updateUser)
                throw new \Exception('User profile gagal terupdate.');

            // update _admin
            $insertAdmin = $this->main->updateData('admin', array('id' => $uid), $admins);
            if (!$insertAdmin)
                throw new \Exception('User admin gagal terupdate.');

            $this->db->transCommit();
            $_SESSION['info_success'] = '<b>Sukses!</b> User profile berhasil terupdate [Username: '.$username.']';
            return redirect()->to('account/profile');   
        } catch (\Exception $e) {
            $this->db->transRollback();
            $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
            return redirect()->to('account/profile');
        }
    }
}