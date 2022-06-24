<?php
namespace App\Controllers;
use App\Models\AdminModel;
use App\Models\DashboardModel;
use App\Models\GeneralModel;

class Admin extends BaseController
{
    public function __construct()
	  {
        $this->session = \Config\Services::session();
        if (!isset($_SESSION['login_state'])) {
            $message = 'Session Anda telah Habis';
            echo "<SCRIPT>alert('$message');window.location='" . site_url('logon') . "';</SCRIPT>";
        }

        if (!$_SESSION['is_admin']) {
            $message = 'Anda tidak terdaftar sebagai user Admin';
            echo "<SCRIPT>alert('$message');window.location='" . site_url('dashboard') . "';</SCRIPT>";
        }   

        $this->db = \Config\Database::connect();

        $this->admin = new AdminModel();
        $this->dashboard = new DashboardModel();
        $this->main = new GeneralModel;

        helper(['user']);
	  }

    public function user()
    {
        $header['title'] = 'Administrasi User';

        $data['listBidang'] = $this->dashboard->getOptionalList('bidang');
        
        echo view('partial/header', $header);
        echo view('partial/top_menu');
        echo view('partial/side_menu');
        echo view('manage_user', $data);
        echo view('partial/footer');
    }

    public function loadData($table)
    {   
        $wheres['start']            = $_POST['start'];
        $wheres['rowperpage']       = $_POST['length']; // Rows display per page
        $wheres['columnIndex']      = $_POST['order'][0]['column']; // Column index
        $wheres['columnName']       = $_POST['columns'][$wheres['columnIndex']]['data']; // Column name
        $wheres['columnSortOrder']  = $_POST['order'][0]['dir']; // asc or desc
        $wheres['searchValue']      = $_POST['search']['value']; // Search value

        $files = $this->admin->getAdminData($wheres, $table, true);
        // var_dump($files);exit();
        $data = array();

        if (count($files) > 0) {
            if ($table == 'user') {
                foreach ($files as $key => $val) {
                    $isAdmin    = isAdmin($val->id) ? 'fa-check' : 'fa-times';
                    $isReviewer = isReviewer($val->id) ? 'fa-check' : 'fa-times';

                    $data[] = array(
                        'id'       => $val->id,
                        'nama'     => $val->last_name.', '.$val->first_name,
                        'username' => $val->username,
                        'is_admin' => '<i class="fa '.$isAdmin.'" aria-hidden="true"></i>',
                        'is_reviewer'=> '<i class="fa '.$isReviewer.'" aria-hidden="true"></i>',
                        'action'   => '<div class="btn-group btn-group-sm"><button type="button" class="btn btn-info btn-edit" id="'.$val->id.'"><i class="fas fa-pencil-alt"></i></button><a href="'.site_url('admin/deleteUser/').$val->id.'" type="button" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></a></div>',
                        'dept_name'=> getDeptName($val->id),
                        'email'    => $val->Email,
                        'phone'    => $val->phone
                    );
                }
            } elseif ($table == 'department') {
                foreach ($files as $key => $val) {
                    $data[] = array(
                        'id'       => $val->id,
                        'bidang'   => $val->name,
                        'action'   => '<div class="btn-group btn-group-sm"><button type="button" class="btn btn-info btn-edit" id="'.$val->id.'"><i class="fas fa-pencil-alt"></i></button><button type="button" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></button></div>'
                    );
                }
            } elseif ($table == 'category') {
              foreach ($files as $key => $val) {
                  $data[] = array(
                      'id'       => $val->id,
                      'kategori' => $val->name,
                      'action'   => '<div class="btn-group btn-group-sm"><button type="button" class="btn btn-info btn-edit" id="'.$val->id.'"><i class="fas fa-pencil-alt"></i></button><button type="button" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></button></div>'
                  );
              }
          }
        }

        $dataset = array(
                        'draw'          => intval($_POST['draw']),
                        'recordsTotal'  => $this->admin->getAdminData(array(), $table),
                        'recordsFiltered'=> $this->admin->getAdminData($wheres, $table),
                        'data'          => $data
                    );

        echo json_encode($dataset);
    }

    public function getUserById($id)
    {
        $detail = $this->main->getRowData('user', array('id' => $id));
        // check is admin
        $detail['is_admin'] = isAdmin($id);
        // dept reviewer for
        $deptrev = $this->main->getResultData('dept_reviewer', array('user_id' => $id));
        
        $detail['dept_rev'] = array();
        if ($deptrev !== '') {
            foreach ($deptrev as $val) {
                $detail['dept_rev'][] = $val['dept_id'];
            }   
        }

        echo json_encode($detail);
    }

    public function updateUser()
    {
        if (!$_POST) {
            $_SESSION['info_error'] = '<b>Error!</b> Tidak ada data yang terinput.';
            return redirect()->to('admin/user');
        }

        $uid        = trim($_POST['id']);
        $username   = strtolower(trim($_POST['username']));
        $dept_rev   = isset($_POST['deptreviewer']) && count($_POST['deptreviewer']) > 0 ? $_POST['deptreviewer'] : '';
        // data user
        $users = array(
            'username'  => $username,
            'password'  => md5(trim($_POST['password'])),
            'department'=> trim($_POST['department']),
            'first_name'=> ucwords(trim($_POST['first_name'])),
            'last_name' => ucwords(trim($_POST['last_name'])),
            'phone'     => trim($_POST['phone']),
            'Email'     => strtolower(trim($_POST['email'])),
            'can_add'   => isset($_POST['can_add']) && $_POST['can_add'] != '' ? trim($_POST['can_add']) : 0,
            'can_checkin'=> isset($_POST['can_checkin']) && $_POST['can_checkin'] != '' ? trim($_POST['can_checkin']) : 0,
        );
        // data admin
        $admins['admin']= isset($_POST['is_admin']) && $_POST['is_admin'] != '' ? trim($_POST['is_admin']) : 0;

        // ADD NEW USER
        if ($uid == '') {
            // check existing username
            $existingUsername = $this->main->getRowData('user', array('username' => $username), true);
            
            if ($existingUsername !== '') {
                $_SESSION['info_error'] = '<b>Error!</b> Username duplikat.';
                return redirect()->to('admin/user');
            } else {
                $this->db->transBegin();
                try {   
                    // insert into _user
                    $userID = $this->main->insertData('user', $users, true);
                    if (!$userID) {
                        throw new \Exception('User ID gagal terbentuk.');
                        // $_SESSION['info_error'] = '<b>Error!</b> User ID gagal terbentuk.';
                        // return redirect()->to('admin/user');
                    } 

                    // insert into _admin
                    $admins['id']= $userID;
                    $insertAdmin = $this->main->insertData('admin', $admins);
                    if (!$insertAdmin) {
                        throw new \Exception('User admin gagal tersimpan.');
                        // $_SESSION['info_error'] = '<b>Error!</b> User admin gagal tersimpan.';
                        // return redirect()->to('admin/user');
                    }

                    // insert into _dept_reviewer
                    if ($dept_rev != '') {
                        $deptr = array();
                        foreach ($dept_rev as $key => $val) {
                            $deptr[$key]['dept_id'] = $val;
                            $deptr[$key]['user_id'] = $userID;
                        }
                        $insertDeptReviewer = $this->main->insertBatchData('dept_reviewer', $deptr);

                        if (!$insertDeptReviewer) {
                            throw new \Exception('Department reviewer gagal disimpan.');
                            // $_SESSION['info_error'] = '<b>Error!</b> Department reviewer gagal disimpan.';
                            // return redirect()->to('admin/user');
                        }
                    }

                    $this->db->transCommit();
                    $_SESSION['info_success'] = '<b>Sukses!</b> Data user berhasil terbentuk [Username: '.$username.']';
                    return redirect()->to('admin/user');

                    // mail user telling him/her that his/her account has been created.
                    // $user_obj = new user($_SESSION['uid'], $pdo);
                    // $new_user_obj = new User($user_id, $pdo);
                    // $date = date('Y-m-d H:i:s T'); //locale insensitive
                    // $get_full_name = $user_obj->getFullName();
                    // $full_name = $get_full_name[0] . ' ' . $get_full_name[1];
                    // $get_full_name = $new_user_obj->getFullName();
                    // $new_user_full_name = $get_full_name[0] . ' ' . $get_full_name[1];
                    // $mail_from = e::h($full_name) . ' <' . $user_obj->getEmailAddress() . '>';
                    // $mail_headers = "From: " . e::h($mail_from)  . PHP_EOL;
                    // $mail_headers .= "Content-Type: text/plain; charset=UTF-8" . PHP_EOL;
                    // $mail_subject = msg('message_account_created_add_user');
                    // $mail_greeting = e::h($new_user_full_name) . ":" . PHP_EOL . msg('email_i_would_like_to_inform');
                    // $mail_body = msg('email_your_account_created') . ' ' . $date . '.  ' . msg('email_you_can_now_login') . ':' . PHP_EOL . PHP_EOL;
                    // $mail_body .= $GLOBALS['CONFIG']['base_url'] . PHP_EOL . PHP_EOL;
                    // $mail_body .= msg('username') . ': ' . $new_user_obj->getName() . PHP_EOL . PHP_EOL;
                    // if ($GLOBALS['CONFIG']['authen'] == 'mysql') {
                    //     $mail_body .= msg('password') . ': ' . e::h($_POST['password']) . PHP_EOL . PHP_EOL;
                    // }
                    // $mail_salute =  msg('email_salute') . ",". PHP_EOL . e::h($full_name);
                    // $mail_to = $new_user_obj->getEmailAddress();
                    // $mail_flags = "-f".$user_obj->getEmailAddress();
                    // if ($GLOBALS['CONFIG']['demo'] == 'False') {
                    //     mail($mail_to, $mail_subject, ($mail_greeting . ' ' . $mail_body . $mail_salute), $mail_headers,
                    //         $mail_flags);
                    // }
                    // $last_message = urlencode(msg('message_user_successfully_added'));
                } catch (\Exception $e) {
                    $this->db->transRollback();
                    $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
                    return redirect()->to('admin/user');
                }
            }
        } else {
            $this->main->transBegin();
            try {
                // UPDATE EXISTING USER
                $updateUser = $this->main->updateData('user', array('id' => $uid), $users);
                if (!$updateUser) {
                    $_SESSION['info_error'] = '<b>Error!</b> User data gagal terupdate.';
                    return redirect()->to('admin/user');
                }

                // update _admin
                $insertAdmin = $this->main->updateData('admin', array('id' => $uid), $admins);
                if (!$insertAdmin) {
                    $_SESSION['info_error'] = '<b>Error!</b> User admin gagal terupdate.';
                    return redirect()->to('admin/user');
                }

                // update _dept_reviewer
                if ($dept_rev != '') {
                    $deptr = array();
                    foreach ($dept_rev as $key => $val) {
                        $deptr[$key]['dept_id'] = $val;
                        $deptr[$key]['user_id'] = $uid;
                    }

                    // delete exist data
                    $deleteDeptReviewer = $this->main->deleteData('dept_reviewer', array('user_id' => $uid));
                    if (!$deleteDeptReviewer) {
                        $_SESSION['info_error'] = '<b>Error!</b> Department reviewer gagal diupdate. [act: delete]';
                        return redirect()->to('admin/user');
                    }

                    // insert new data
                    $insertDeptReviewer = $this->main->insertBatchData('dept_reviewer', $deptr);
                    if (!$insertDeptReviewer) {
                        $_SESSION['info_error'] = '<b>Error!</b> Department reviewer gagal diupdate. [act: insert]';
                        return redirect()->to('admin/user');
                    }
                }

                $this->main->transCommit();
                $_SESSION['info_success'] = '<b>Sukses!</b> Data user berhasil terupdate [Username: '.$username.']';
                return redirect()->to('admin/user');   
            } catch (\Exception $e) {
                $this->main->transRollback();
                $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
                return redirect()->to('admin/user');
            }
        }
    }

    public function deleteUser($uid)
    {
        $this->main->db->transBegin();
        try {
            // delete from _user
            $delUser = $this->main->deleteData('user', array('id' => $uid));
            if (!$delUser) {
                $_SESSION['info_error'] = '<b>Error!</b> User data gagal dihapus.';
                return redirect()->to('admin/user');
            }

            // delete from _admin
            $delUser = $this->main->deleteData('admin', array('id' => $uid));
            if (!$delUser) {
                $_SESSION['info_error'] = '<b>Error!</b> User admin gagal dihapus.';
                return redirect()->to('admin/user');
            }

            // delete from _user_perms
            $delPerms = $this->main->deleteData('user_perms', array('uid' => $uid));
            if (!$delPerms) {
                $_SESSION['info_error'] = '<b>Error!</b> User permission gagal dihapus.';
                return redirect()->to('admin/user');
            }

            // delete from _dept_reviewer
            $delUser = $this->main->deleteData('dept_reviewer', array('user_id' => $uid));
            if (!$delUser) {
                $_SESSION['info_error'] = '<b>Error!</b> Department reviewer gagal dihapus.';
                return redirect()->to('admin/user');
            }

            // change owner to root user
            $newdata['owner'] = $_SESSION['root_id'];
            $updOwner = $this->main->updateData('data', array('owner' => $uid), $newdata);
            if (!$updOwner) {
                $_SESSION['info_error'] = '<b>Error!</b> Data root owner gagal terupdate.';
                return redirect()->to('admin/user');
            }

            $this->main->db->transCommit();
            $_SESSION['info_success'] = '<b>Sukses!</b> Data user berhasil terhapus.';
            return redirect()->to('admin/user');   
        } catch (\Exception $e) {
            $this->main->db->transRollback();
            $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
            return redirect()->to('admin/user');
        }
    }

    public function bidang()
    {
        $header['title'] = 'Administrasi Bidang';
        
        echo view('partial/header', $header);
        echo view('partial/top_menu');
        echo view('partial/side_menu');
        echo view('manage_bidang');
        echo view('partial/footer');
    }

    public function getUserInDept($dept_id)
    {
        $wheres['department'] = $dept_id;
        $detail = $this->main->getResultData('user', $wheres, false, 'id, username, last_name, first_name');
        echo json_encode($detail);
    }

    public function getBidangById($id)
    {
        $wheres['id'] = $id;
        $detail = $this->main->getRowData('department', $wheres);
        echo json_encode($detail);
    }

    public function updateBidang()
    {
        if (!$_POST) {
            $_SESSION['info_error'] = '<b>Error!</b> Tidak ada data yang terinput.';
            return redirect()->to('admin/bidang');
        }

        $bid      = trim($_POST['id']);
        $dept_name= ucwords(trim($_POST['dept_name']));
        
        // data bidang
        $dept['name'] = $dept_name;
        
        // ADD NEW DEPARTMENT
        if ($bid == '') {
            // check existing department
            $existingDept = $this->main->getRowData('department', array('name' => $dept_name), true);
            
            if ($existingDept !== '') {
                $_SESSION['info_error'] = '<b>Error!</b> Data department duplikat.';
                return redirect()->to('admin/bidang');
            } else {
                $this->db->transBegin();
                try {   
                    // insert into _department
                    $deptID = $this->main->insertData('department', $dept, true);
                    if (!$deptID)
                        throw new \Exception('Department ID gagal terbentuk.');

                    // insert into _dept_perms
                    $allPerms = $this->main->getResultData('data', array(), false, 'id, default_rights');
                    $i = 0;
                    foreach ($allPerms as $val) {
                        $arrPerms[$i]['fid']      = (int) $val['id'];
                        $arrPerms[$i]['rights']   = (int) $val['default_rights'];
                        $arrPerms[$i]['dept_id']  = $deptID;
                        $i++;
                    }
                    
                    $insertPerms = $this->main->insertBatchData('dept_perms', $arrPerms);
                    if (!$insertPerms)
                        throw new \Exception('Data department permission gagal disimpan.');

                    $this->db->transCommit();
                    $_SESSION['info_success'] = '<b>Sukses!</b> Data department berhasil terbentuk [Dept: '.$dept_name.']';
                    return redirect()->to('admin/bidang');
                } catch (\Exception $e) {
                    $this->db->transRollback();
                    $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
                    return redirect()->to('admin/bidang');
                }
            }
        } else {
            // check existing department
            $existingDept = $this->main->getRowData('department', array('name' => $dept_name, 'id <>' => $bid), true);
            
            if ($existingDept !== '') {
                $_SESSION['info_error'] = '<b>Error!</b> Data department duplikat.';
                return redirect()->to('admin/bidang');
            } else {
                $this->db->transBegin();
                try {   
                    // update info _department
                    $deptID = $this->main->updateData('department', array('id' => $bid), $dept);
                    if (!$deptID)
                        throw new \Exception('Data department gagal terupdate.');

                    $this->db->transCommit();
                    $_SESSION['info_success'] = '<b>Sukses!</b> Data department berhasil terupdate. [Dept: '.$dept_name.']';
                    return redirect()->to('admin/bidang');
                } catch (\Exception $e) {
                    $this->db->transRollback();
                    $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
                    return redirect()->to('admin/bidang');
                }
            }
        }
    }

    public function kategori()
    {
        $header['title'] = 'Administrasi Kategori';
        
        echo view('partial/header', $header);
        echo view('partial/top_menu');
        echo view('partial/side_menu');
        echo view('manage_kategori');
        echo view('partial/footer');
    }

    public function getKategoriById($id)
    {
        $wheres['id'] = $id;
        $detail = $this->main->getRowData('category', $wheres);
        echo json_encode($detail);
    }

    public function getDataByKategoriId($cat_id)
    {
        $wheres['id'] = $cat_id;
        $detail = $this->main->getResultData('data', $wheres, false, 'id, realname');
        echo json_encode($detail);
    }

}