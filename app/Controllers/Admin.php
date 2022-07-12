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

        helper(['user', 'permission']);
    }

    public function user()
    {
        $header['title'] = 'Administrasi User';

        $data['listBidang'] = $this->dashboard->getOptionalList('bidang');
        $data['submenu']    = array('active' => 'user');

        $side['active'] = 'user';
        
        echo view('partial/header', $header);
        echo view('partial/top_menu');
        echo view('partial/side_menu', $side);
        echo view('admin/manage_user', $data);
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
                        'action'   => '<div class="btn-group btn-group-sm"><button type="button" class="btn btn-info btn-edit" id="'.$val->id.'"><i class="fas fa-pencil-alt"></i></button><button type="button" class="btn btn-danger" data-toggle="modal" data-href="'.site_url('admin/deleteUser/').$val->id.'" data-target="#confirmDelete"><i class="fas fa-trash"></i></button></div>',
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
                        'action'   => '<div class="btn-group btn-group-sm"><button type="button" class="btn btn-info btn-edit" id="'.$val->id.'"><i class="fas fa-pencil-alt"></i></button><button type="button" id="'.$val->id.'" class="btn btn-danger" data-toggle="modal" data-href="'.site_url('admin/deleteBidang/').$val->id.'" data-target="#confirmDelete"><i class="fas fa-trash"></i></button></div>'
                    );
                }
            } elseif ($table == 'category') {
              foreach ($files as $key => $val) {
                  $data[] = array(
                      'id'       => $val->id,
                      'kategori' => $val->name,
                      'action'   => '<div class="btn-group btn-group-sm"><button type="button" class="btn btn-info btn-edit" id="'.$val->id.'"><i class="fas fa-pencil-alt"></i></button><button type="button" id="'.$val->id.'" class="btn btn-danger" data-toggle="modal" data-href="'.site_url('admin/deleteKategori/').$val->id.'" data-target="#confirmDelete"><i class="fas fa-trash"></i></button></div>'
                  );
                }
            } elseif ($table == 'filetypes') {
                foreach ($files as $key => $val) {
                    $status = $val->active == 1 ? 'checked' : '';

                    $data[] = array(
                        'id'      => $val->id,
                        'type'    => $val->type,
                        'active'  => '<div class="form-check"><input class="form-check-input status-active" id="'.$val->id.'" type="checkbox" '.$status.'></div>',
                        'action'  => '<button type="button" id="'.$val->id.'" class="btn btn-xs btn-danger" data-toggle="modal" data-href="'.site_url('admin/deleteFileType/').$val->id.'" data-target="#confirmDelete"><i class="fas fa-trash"></i></button>'
                    );
                }
            } elseif ($table == 'accesslog') {
                foreach ($files as $key => $val) {
                    $data[] = array(
                        'file_id'   => $val->file_id,
                        'realname'  => $val->realname == '' ? '<i>Undefined (File ID <b>'.$val->file_id.'</b> has been deleted)</i>' : $val->realname,
                        'username'  => $val->username,
                        'action'    => actionParam($val->action),
                        'date'      => $val->timestamp
                    );
                }
            } elseif ($table == 'filelistexport') {
                foreach ($files as $key => $val) {
                    $data[] = array(
                        'realname'      => $val->realname,
                        'description'   => $val->description,
                        'publishable'   => $val->publishable,
                        'status'        => $val->status,
                        'username'      => $val->username,
                        'id'            => $val->id,
                        'revision'      => $val->revision,
                        'publishing_status' => $val->publishing_status,
                        'checkout_status'   => $val->checkout_status
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
        $password   = isset($_POST['password']) && $_POST['password'] !== '' ? md5(trim($_POST['password'])) : '';
        $dept_rev   = isset($_POST['deptreviewer']) && count($_POST['deptreviewer']) > 0 ? $_POST['deptreviewer'] : '';
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
                    if ($dept_rev !== '') {
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
                    // $mail_body .= config('MyConfig')->settings['base_url'] . PHP_EOL . PHP_EOL;
                    // $mail_body .= msg('username') . ': ' . $new_user_obj->getName() . PHP_EOL . PHP_EOL;
                    // if (config('MyConfig')->settings['authen'] == 'mysql') {
                    //     $mail_body .= msg('password') . ': ' . e::h($_POST['password']) . PHP_EOL . PHP_EOL;
                    // }
                    // $mail_salute =  msg('email_salute') . ",". PHP_EOL . e::h($full_name);
                    // $mail_to = $new_user_obj->getEmailAddress();
                    // $mail_flags = "-f".$user_obj->getEmailAddress();
                    // if (config('MyConfig')->settings['demo'] == 'False') {
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
            $this->db->transBegin();
            try {
                // UPDATE EXISTING USER
                $updateUser = $this->main->updateData('user', array('id' => $uid), $users);
                if (!$updateUser)
                    throw new \Exception('User data gagal terupdate.');

                // update _admin
                $insertAdmin = $this->main->updateData('admin', array('id' => $uid), $admins);
                if (!$insertAdmin)
                    throw new \Exception('User admin gagal terupdate.');

                // delete exist _dept_reviewer
                $deleteDeptReviewer = $this->main->deleteData('dept_reviewer', array('user_id' => $uid));
                if (!$deleteDeptReviewer)
                    throw new \Exception('Department reviewer gagal diupdate. [act: delete]');

                // update _dept_reviewer
                if ($dept_rev !== '') {
                    $deptr = array();
                    foreach ($dept_rev as $key => $val) {
                        $deptr[$key]['dept_id'] = $val;
                        $deptr[$key]['user_id'] = $uid;
                    }

                    // insert new data
                    $insertDeptReviewer = $this->main->insertBatchData('dept_reviewer', $deptr);
                    if (!$insertDeptReviewer)
                        throw new \Exception('Department reviewer gagal diupdate. [act: insert]');
                }

                $this->db->transCommit();
                $_SESSION['info_success'] = '<b>Sukses!</b> Data user berhasil terupdate [Username: '.$username.']';
                return redirect()->to('admin/user');   
            } catch (\Exception $e) {
                $this->db->transRollback();
                $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
                return redirect()->to('admin/user');
            }
        }
    }

    public function deleteUser($uid)
    {
        $this->db->transBegin();
        try {
            // delete from _user
            $delUser = $this->main->deleteData('user', array('id' => $uid));
            if (!$delUser)
                throw new \Exception('User data gagal dihapus.');

            // delete from _admin
            $delUser = $this->main->deleteData('admin', array('id' => $uid));
            if (!$delUser)
                throw new \Exception('User admin gagal dihapus.');

            // delete from _user_perms
            $delPerms = $this->main->deleteData('user_perms', array('uid' => $uid));
            if (!$delPerms)
                throw new \Exception('User permission gagal dihapus.');

            // delete from _dept_reviewer
            $delUser = $this->main->deleteData('dept_reviewer', array('user_id' => $uid));
            if (!$delUser)
                throw new \Exception('Department reviewer gagal dihapus.');

            // change owner to root user
            $newdata['owner'] = $_SESSION['root_id'];
            $updOwner = $this->main->updateData('data', array('owner' => $uid), $newdata);
            if (!$updOwner)
                throw new \Exception('Data root owner gagal terupdate.');

            $this->db->transCommit();
            $_SESSION['info_success'] = '<b>Sukses!</b> Data user berhasil terhapus.';
            return redirect()->to('admin/user');   
        } catch (\Exception $e) {
            $this->db->transRollback();
            $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
            return redirect()->to('admin/user');
        }
    }

    public function bidang()
    {
        $header['title'] = 'Administrasi Bidang';

        $data['listBidang'] = $this->dashboard->getOptionalList('bidang');
        $data['submenu']    = array('active' => 'bidang');

        $side['active'] = 'bidang';
        
        echo view('partial/header', $header);
        echo view('partial/top_menu');
        echo view('partial/side_menu', $side);
        echo view('admin/manage_bidang', $data);
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
                    $updDept = $this->main->updateData('department', array('id' => $bid), $dept);
                    if (!$updDept)
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

    public function deleteBidang($bid)
    {
        $assignBid = trim($_POST['new_dept']);
        if (is_null($assignBid) || $assignBid == '') {
            $_SESSION['info_error'] = '<b>Error!</b> Undefined re-assign department.';
            return redirect()->to('admin/bidang');
        }

        // check new dept <> deleted dept
        if ($bid == $assignBid) {
            $_SESSION['info_error'] = '<b>Error!</b> Tidak diperkenankan re-asign ke departement yang sama.';
            return redirect()->to('admin/bidang');
        } else {
            $this->db->transBegin();
            try {
                // update _data
                $depts['department'] = $assignBid;
                $updDept = $this->main->updateData('data', array('department' => $bid), $depts);
                if (!$updDept)
                    throw new \Exception('Re-asign data department gagal terupdate.');

                // update _user
                $updUser = $this->main->updateData('user', array('department' => $bid), $depts);
                if (!$updUser)
                    throw new \Exception('Re-asign user department gagal terupdate.');

                // update _dept_perms
                $perms['dept_id'] = $assignBid;
                $updPerms = $this->main->updateData('dept_perms', array('dept_id' => $bid), $perms);
                if (!$updPerms)
                    throw new \Exception('Re-asign department permission gagal terupdate.');

                // update _dept_reviewer
                $revs['dept_id'] = $assignBid;
                $updRevs = $this->main->updateData('dept_reviewer', array('dept_id' => $bid), $revs);
                if (!$updRevs)
                    throw new \Exception('Re-asign department reviewer gagal terupdate.');

                // delete _department
                $delDept = $this->main->deleteData('department', array('id' => $bid));
                if (!$delDept)
                    throw new \Exception('Department gagal dihapus.');

                $this->db->transCommit();
                $_SESSION['info_success'] = '<b>Sukses!</b> Data department berhasil terhapus.';
                return redirect()->to('admin/bidang');   
            } catch (\Exception $e) {
                $this->db->transRollback();
                $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
                return redirect()->to('admin/bidang');
            }
        }
    }

    public function kategori()
    {
        $header['title'] = 'Administrasi Kategori';
        
        $data['listKategori']= $this->dashboard->getOptionalList('kategori');
        $data['submenu']     = array('active' => 'kategori');

        $side['active'] = 'kategori';
        
        echo view('partial/header', $header);
        echo view('partial/top_menu');
        echo view('partial/side_menu', $side);
        echo view('admin/manage_kategori', $data);
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

    public function updateKategori()
    {
        if (!$_POST) {
            $_SESSION['info_error'] = '<b>Error!</b> Tidak ada data yang terinput.';
            return redirect()->to('admin/kategori');
        }

        $cid      = trim($_POST['id']);
        $cat_name = ucwords(trim($_POST['cat_name']));
        
        // data kategori
        $cat['name'] = $cat_name;
        
        // ADD NEW CATEGORY
        if ($cid == '') {
            // check existing category
            $existingCat = $this->main->getRowData('category', array('name' => $cat_name), true);
            
            if ($existingCat !== '') {
                $_SESSION['info_error'] = '<b>Error!</b> Data kategori duplikat.';
                return redirect()->to('admin/kategori');
            } else {
                $this->db->transBegin();
                try {   
                    // insert into _category
                    $catID = $this->main->insertData('category', $cat, true);
                    if (!$catID)
                        throw new \Exception('Data kategori gagal disimpan.');

                    $this->db->transCommit();
                    $_SESSION['info_success'] = '<b>Sukses!</b> Data kategori berhasil terbentuk [Kat: '.$cat_name.']';
                    return redirect()->to('admin/kategori');
                } catch (\Exception $e) {
                    $this->db->transRollback();
                    $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
                    return redirect()->to('admin/kategori');
                }
            }
        } else {
            // check existing category
            $existingCat = $this->main->getRowData('category', array('name' => $cat_name, 'id <>' => $cid), true);
            
            if ($existingCat !== '') {
                $_SESSION['info_error'] = '<b>Error!</b> Data kategori duplikat.';
                return redirect()->to('admin/kategori');
            } else {
                $this->db->transBegin();
                try {   
                    // update info _category
                    $updCat = $this->main->updateData('category', array('id' => $cid), $cat);
                    if (!$updCat)
                        throw new \Exception('Data kategori gagal terupdate.');

                    $this->db->transCommit();
                    $_SESSION['info_success'] = '<b>Sukses!</b> Data kategori berhasil terupdate. [Kat: '.$cat_name.']';
                    return redirect()->to('admin/kategori');
                } catch (\Exception $e) {
                    $this->db->transRollback();
                    $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
                    return redirect()->to('admin/kategori');
                }
            }
        }
    }

    public function deleteKategori($cid)
    {
        $assignCid = trim($_POST['new_cat']);
        if (is_null($assignCid) || $assignCid == '') {
            $_SESSION['info_error'] = '<b>Error!</b> Undefined re-assign category.';
            return redirect()->to('admin/kategori');
        }

        // check new cat <> deleted cat
        if ($cid == $assignCid) {
            $_SESSION['info_error'] = '<b>Error!</b> Tidak diperkenankan re-asign ke kategori yang sama.';
            return redirect()->to('admin/kategori');
        } else {
            $this->db->transBegin();
            try {
                // update _data
                $cats['category'] = $assignCid;
                $updCat = $this->main->updateData('data', array('category' => $cid), $cats);
                if (!$updCat)
                    throw new \Exception('Re-asign data kategori gagal terupdate.');

                // delete _category
                $delCat = $this->main->deleteData('category', array('id' => $cid));
                if (!$delCat)
                    throw new \Exception('Kategori gagal dihapus.');

                $this->db->transCommit();
                $_SESSION['info_success'] = '<b>Sukses!</b> Data kategori berhasil terhapus.';
                return redirect()->to('admin/kategori');   
            } catch (\Exception $e) {
                $this->db->transRollback();
                $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
                return redirect()->to('admin/kategori');
            }
        }
    }

    public function file()
    {
        $header['title'] = 'Administrasi File';

        $data['submenu'] = array('active' => 'file');
        $side['active'] = 'file';
        
        echo view('partial/header', $header);
        echo view('partial/top_menu');
        echo view('partial/side_menu', $side);
        echo view('admin/manage_file', $data);
        echo view('partial/footer');
    }

    public function filetypes()
    {
        $header['title'] = 'Setting File Types';

        $data['submenu'] = array('active' => 'filetypes');
        $side['active'] = 'filetypes';
        
        echo view('partial/header', $header);
        echo view('partial/top_menu');
        echo view('partial/side_menu', $side);
        echo view('admin/manage_filetypes', $data);
        echo view('partial/footer');
    }

    public function getFileTypeById($id)
    {
        $wheres['id'] = $id;
        $detail = $this->main->getRowData('filetypes', $wheres);
        echo json_encode($detail);
    }

    public function updateFileType($tid, $active)
    {   
        // check existing filetypes
        $existingType = $this->main->getRowData('filetypes', array('id' => $tid));
        
        if ($existingType == '') {
            $_SESSION['info_error'] = '<b>Error!</b> Undefined filetype.';
            return redirect()->to('admin/filetypes');
        } else {
            $this->db->transBegin();
            try {   
                $type = $existingType['type'];

                // update _filetypes
                $ftp['active'] = $active;
                $updType = $this->main->updateData('filetypes', array('id' => $tid), $ftp);
                if (!$updType)
                    throw new \Exception('Status '.$type.' gagal terupdate.');

                $this->db->transCommit();

                $statusdesc = $active == 1 ? 'AKTIF' : 'NON AKTIF';
                $_SESSION['info_success'] = '<b>Sukses!</b> Status '.$type.' berhasil terupdate. [Status: <b>'.$statusdesc.'</b>]';
            } catch (\Exception $e) {
                $this->db->transRollback();
                $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
            }
        }
    }

    public function addFileType()
    {
        if (!$_POST) {
            $_SESSION['info_error'] = '<b>Error!</b> Tidak ada data yang terinput.';
            return redirect()->to('admin/filetypes');
        }

        $type   = strtolower(trim($_POST['type']));
        $active = isset($_POST['active']) && $_POST['active'] !== '' ? trim($_POST['active']) : 0;
        
        // data kategori
        $ftp['type']    = $type;
        $ftp['active']  = $active;
        
        // check existing filetypes
        $existingType = $this->main->getRowData('filetypes', array('type' => $type), true);
        
        if ($existingType !== '') {
            $_SESSION['info_error'] = '<b>Error!</b> Data file type duplikat.';
            return redirect()->to('admin/filetypes');
        } else {
            $this->db->transBegin();
            try {   
                // insert into _filetypes
                $typeID = $this->main->insertData('filetypes', $ftp, true);
                if (!$typeID)
                    throw new \Exception('Data file type gagal disimpan.');

                $this->db->transCommit();
                $_SESSION['info_success'] = '<b>Sukses!</b> Data file type berhasil terbentuk [Filetype: '.$type.']';
                return redirect()->to('admin/filetypes');
            } catch (\Exception $e) {
                $this->db->transRollback();
                $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
                return redirect()->to('admin/filetypes');
            }
        }
    }

    public function deleteFileType($tid)
    {
        $this->db->transBegin();
        try {
            // delete _filetypes
            $delCat = $this->main->deleteData('filetypes', array('id' => $tid));
            if (!$delCat)
                throw new \Exception('Filetype gagal dihapus.');

            $this->db->transCommit();
            $_SESSION['info_success'] = '<b>Sukses!</b> Data filetype berhasil terhapus.';
            return redirect()->to('admin/filetypes');   
        } catch (\Exception $e) {
            $this->db->transRollback();
            $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
            return redirect()->to('admin/filetypes');
        }
    }

    public function accesslog()
    {
        $header['title'] = 'Access Log';

        $data['submenu'] = array('active' => 'accesslog');
        $side['active'] = 'accesslog';
        
        echo view('partial/header', $header);
        echo view('partial/top_menu');
        echo view('partial/side_menu', $side);
        echo view('admin/manage_access_log', $data);
        echo view('partial/footer');
    }

    public function filelistexport()
    {
        $header['title'] = 'File List Export';

        $data['submenu'] = array('active' => 'filelistexport');
        $side['active'] = 'filelistexport';
        
        echo view('partial/header', $header);
        echo view('partial/top_menu');
        echo view('partial/side_menu', $side);
        echo view('admin/manage_filelist_export', $data);
        echo view('partial/footer');
    }

    public function documents($status)
    {
        $header['title'] = '';
        switch ($status) {
            case 'deleted': $header['title'] = 'Dokumen Deleted/Undeleted'; break;
            case 'onreview': $header['title'] = 'Dokumen Waiting to be Reviewed'; break;
            case 'rejected': $header['title'] = 'Dokumen Rejected'; break;
        }
        
        $data['listUsers'] = $this->main->getResultData('user', array(), false, 'id, first_name, last_name');
        $data['status'] = $status;
        $data['admin_mode'] = true;

        $side['active'] = 'admin-'.$status;

        echo view('partial/header', $header);
        echo view('partial/top_menu');
        echo view('partial/side_menu', $side);
        echo view('approval', $data);
        echo view('partial/footer');
    }

    public function undeleteFile()
    {
        $ids = $_POST['ids'];

        if (!$ids) {
            $_SESSION['info_error'] = '<b>Error!</b> File ID tidak dikenal.';
        } else {
            $datas['publishable'] = 0;
            $this->db->transBegin();
            try {
                foreach ($ids as $val) {
                    // update _data
                    $updData = $this->main->updateData('data', array('id' => $val), $datas);
                    if (!$updData)
                            throw new \Exception('Status publishable gagal terupdate.');

                    // aceess log
                    $logs['file_id'] = $val;
                    $logs['user_id'] = $_SESSION['id'];
                    $logs['timestamp'] = date('Y-m-d H:i:s');
                    $logs['action'] = 'U';
                    $insLogs = $this->main->insertData('access_log', $logs);
                    if (!$insLogs)
                        throw new \Exception('Log entry gagal tersimpan.');

                    // PR LANJUTAN MOVE FILE
                    fmove(config('MyConfig')->settings['archiveDir'] . $val . '.dat', config('MyConfig')->settings['dataDir'] . $val . '.dat');
                }
                $this->db->transCommit();
                $_SESSION['info_success'] = '<b>Sukses!</b> Dokumen berhasil tersubmit ulang.';
            } catch (\Exception $e) {
                $this->db->transRollback();
                $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
            }
        }
    }

    public function permDeleteFile()
    {
        $ids = $_POST['ids'];

        if (!$ids) {
            $_SESSION['info_error'] = '<b>Error!</b> File ID tidak dikenal.';
        } else {
            $this->db->transBegin();
            try {
                foreach ($ids as $val) {
                    // delete from _data
                    $delData = $this->main->deleteData('data', array('id' => $val));
                    if (!$delData)
                        throw new \Exception('Data dokumen gagal dihapus.');

                    // delete from _dept_perms
                    $delDept = $this->main->deleteData('dept_perms', array('fid' => $val));
                    if (!$delDept)
                        throw new \Exception('Data department permission gagal dihapus.');
                    
                    // delete from _user_perms
                    $delUser = $this->main->deleteData('user_perms', array('fid' => $val));
                    if (!$delUser)
                        throw new \Exception('Data user permission gagal dihapus.');
                    
                    // delete from _log
                    $delLog = $this->main->deleteData('log', array('id' => $val));
                    if (!$delLog)
                        throw new \Exception('Data log dokumen gagal dihapus.');

                    // access log
                    $logs['file_id'] = $val;
                    $logs['user_id'] = $_SESSION['id'];
                    $logs['timestamp'] = date('Y-m-d H:i:s');
                    $logs['action'] = 'P';
                    $insLogs = $this->main->insertData('access_log', $logs);
                    if (!$insLogs)
                        throw new \Exception('Log entry gagal tersimpan.');

                    // PR LANJUTAN MOVE FILE
                    $filename = $val . ".dat";
                    unlink(config('MyConfig')->settings['archiveDir'] . $filename);
                    if (config('MyConfig')->settings['revisionDir'] . $val . '/') {
                        $dir = opendir(config('MyConfig')->settings['revisionDir'] . $val . '/');
                        if (is_dir(config('MyConfig')->settings['revisionDir'] . $val . '/')) {
                            $dir = opendir(config('MyConfig')->settings['revisionDir'] . $val . '/');
                            while ($lreadfile = readdir($dir)) {
                                if (is_file(config('MyConfig')->settings['revisionDir'] . "$val/$lreadfile")) {
                                    unlink(config('MyConfig')->settings['revisionDir'] . "$val/$lreadfile");
                                }
                            }
                            rmdir(config('MyConfig')->settings['revisionDir'] . $val);
                        }
                    }
                }
                    
                $this->db->transCommit();
                $_SESSION['info_success'] = '<b>Sukses!</b> Dokumen berhasil terhapus secara permanen.';
            } catch (\Exception $e) {
                $this->db->transRollback();
                $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
            }
        }
    }

    public function settings()
    {
        $header['title'] = 'General Setting';

        $data['submenu'] = array('active' => 'settings');
        $data['settings']= $this->main->getResultData('settings');

        $side['active'] = 'settings';
        
        echo view('partial/header', $header);
        echo view('partial/top_menu');
        echo view('partial/side_menu', $side);
        echo view('admin/manage_setting', $data);
        echo view('partial/footer');
    }

}