<?php
namespace App\Controllers;
use App\Models\DashboardModel;
use App\Models\UserModel;
use App\Models\GeneralModel;
use CodeIgniter\Files\File;

class Dashboard extends BaseController
{
    public function __construct()
	{
        $this->session = \Config\Services::session();
        if (!isset($_SESSION['login_state'])) {
			$message = 'Session Anda telah Habis';
			echo "<SCRIPT>alert('$message');window.location='" . site_url('logon') . "';</SCRIPT>";
		}

        $this->db = \Config\Database::connect();

		$this->dashboard = new DashboardModel();
		$this->user = new UserModel();
		$this->main = new GeneralModel();

        helper(['user', 'permission']);
	}

    public function index()
    {
        $header['title'] = 'Dashboard';
        $side['active']  = 'dashboard';
        
        return view('partial/header', $header)
            .view('partial/top_menu')
            .view('partial/side_menu', $side)
            .view('dashboard')
            .view('partial/footer');
    }
    
    public function search()
    {
        $header['title'] = 'Pencarian Dokumen';
        $data['status'] = 'approved';
        $side['active']  = 'search';

        return view('partial/header', $header)
            .view('partial/top_menu')
            .view('partial/side_menu', $side)
            .view('data', $data)
            .view('partial/footer');
    }

    public function getDataById($status, $id = null)
    {
        $wheres['id'] = isset($id) && !is_null($id) ? $id : $_GET['id'];
        $wheres['publishable'] = publishableByStatus($status);
        $wheres['status'] = $status;
        
        $dataById = $this->dashboard->getData($wheres, true);
        $history  = $this->dashboard->getLogModification($wheres['id']);
        $logs     = $this->dashboard->getLatestLog($wheres['id'], 5);
        
        $accesslog = array();
        if (count($logs) > 0) {
            for ($i=0; $i < count($logs); $i++) { 
                $accesslog[$i]['date_modified'] = $logs[$i]['date_modified'];
                $accesslog[$i]['time_modified'] = $logs[$i]['time_modified'];
                $accesslog[$i]['username'] = $logs[$i]['username'];
                $accesslog[$i]['action'] = actionParam($logs[$i]['action']);
            }
        }
       
        // data tidak ditemukan
        if(!$dataById) return false;

        $return = array('data' => $dataById[0], 'history' => $history, 'accesslog' => $accesslog);
        
        foreach ($dataById as $d) {
            $d->file_size = getFileSizeByFileId($d->id, $status == 'deleted' ? 'archiveDir' : 'dataDir');
        }
        
        if (!is_null($id))
            return $dataById;
        else 
            echo json_encode($return);
    }

    private function getAllowedMimeTypes() {
        //get mime types
        $mimeType = $this->main->getResultData('filetypes', array('active' => 1));
        $strType = '';
        foreach ($mimeType as $val) $strType .= $val['type'] . ',';
        $strType = substr($strType, 0, -1);
        return $strType;
    }

    public function document($status = null, $id = null)
    {
        $allowedMimes = $this->getAllowedMimeTypes();
        
        $header['title'] = !is_null($id) ? 'Update File' : 'Tambah File';

        $data['file_id'] = $id;
        if (!is_null($id)) {
            $data['fileExist'] = $this->getDataById($status, $id);
            if(!$data['fileExist']) {
                $_SESSION['info_error'] = '<b>Gagal!</b> Data tidak ditemukan.';
                return redirect()->to('dashboard/approval/onreview');
            }
        }

        $data['status']      = $status;
        $data['listPemilik'] = $this->dashboard->getOptionalList('pemilik');
        $data['listBidang']  = $this->dashboard->getOptionalList('bidang');
        $data['listKategori']= $this->dashboard->getOptionalList('kategori');
        $data['allUsers']    = $this->user->allUsers();
        $data['AllowedMimeTypes'] = $allowedMimes;
        $data['docUrl'] = site_url('dashboard/file').'/'.$id.'/view"';

        $side['active']  = 'document';

        return view('partial/header', $header)
            .view('partial/top_menu')
            .view('partial/side_menu', $side)
            .view('form_input', $data)
            .view('partial/footer');
    }

    public function file($id = null, $action = "download")
    {
        if($id == null) {
            $_SESSION['info_error'] = '<b>Gagal!</b> Request tidak valid!';
            return redirect()->to('dashboard/approval/onreview');
        }

        $doc = $this->main->getRowData('data', array('id' => $id));
    
        if($doc == null) {
            $_SESSION['info_error'] = '<b>Gagal!</b> Data tidak ditemukan.';
            return redirect()->to('dashboard/approval/onreview');
        }

        //TODO: check permission

        $filename = getFilePathByFileId($doc['id']);

        if (!file_exists($filename)) {
            $_SESSION['info_error'] = '<b>Gagal!</b> File tidak ditemukan.';
            return redirect()->to('dashboard/approval/onreview');
        }

        //TODO: handle revision
        if (isset($revision_id)) $filename = getFilePathByFileId($doc['id'], "revisionDir");
        else if($doc['publishable'] == publishableByStatus('deleted')) $filename = getFilePathByFileId($doc['id'], "archiveDir");
    
        $realname = $doc["realname"];
        $filemime = getMimeTypeByFileRealName($realname);
        // return $this->response->download($path, $realname);
        
        if($action == "view") {
            // $_SESSION['mimetype'] = $filemime;
            // send headers to browser to initiate file download
            header('Content-Length: '.filesize($filename));
            // Pass the mimetype so the browser can open it
            header('Cache-control: private');
            header('Content-Type: ' . $filemime);
            header('Content-Disposition: inline; filename="' . rawurlencode($realname) . '"');
            // Apache is sending Last Modified header, so we'll do it, too
            $modified=filemtime($filename);
            header('Last-Modified: '. date('D, j M Y G:i:s T', $modified));   // something like Thu, 03 Oct 2002 18:01:08 GMT
            readfile($filename);
            // AccessLog::addLogEntry($_REQUEST['id'], 'V', $pdo);
        }
        else {
            // send headers to browser to initiate file download
            header('Cache-control: private');
            header('Content-Type: ' . $filemime);
            header('Content-Disposition: attachment; filename="' . $realname . '"');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            readfile($filename);
            // AccessLog::addLogEntry($_REQUEST['id'], 'D', $pdo);
        }
    }

    public function add()
    {
        $allowedMimes = $this->getAllowedMimeTypes();
        
        //get settings
        $maxSize = config('MyConfig')->settings['max_filesize'];
        $dataDir = config('MyConfig')->settings['dataDir'];
        $authorization = config('MyConfig')->settings['authorization'];

        //size in kb
        $validationRule = [
            'filename' => [
                'label' => 'Document File',
                'rules' => 'uploaded[filename]'
                    . '|mime_in[filename,'.$allowedMimes.']'
                    . '|max_size[filename,'.$maxSize.']'
            ],
        ];

        //validate
        if (!$this->validate($validationRule)) {
            $_SESSION['info_error'] = '<b>Gagal!</b> '.$this->validator->getErrors()["filename"];
            return redirect()->to('dashboard/document');
        }

        $file = $this->request->getFile('filename');
        //check is file has been moved
        if ($file->hasMoved()) {
            $_SESSION['info_error'] = '<b>Gagal!</b> The file has already been moved.';
            return redirect()->to('dashboard/document');
        }

        $this->db->transBegin();
        try {   
            // init user nya, cek usernya admin ato ngga, kalo admin save datanya pake departement & owner yang dipilih di form
            // kalo ngga, pake data sesuai dengan usernya.
            $newDoc = array(
                'status' => 0,
                'category' => $_POST['kategori'],
                'owner' => $_SESSION['is_admin'] ? $_POST['pemilik'] : $_SESSION['id'],
                'realname' => $_FILES['filename']['name'],
                'created' => date('Y-m-d H:i:s T'),
                'description' => $_POST['deskripsi'],
                'department' => $_SESSION['is_admin'] ? $_POST['bidang'] : $_SESSION['department'],
                'comment' => $_POST['komentar'],
                'default_rights' => 0,
                'publishable' => $authorization == "True" ? '0' : '1',
            );

            //insert data ke tabel data dan get id nya
            $newDocId = $this->main->insertData("data", $newDoc, true);
            if (!$newDocId) throw new \Exception('Gagal menyimpan data ke database, mohon coba lagi!');

            //TODO
            // udf_add_file_insert($fileId);

            //insert ke db log dengan note 'Initial import' dan revision 'current'
            $historyLog = array(
                'id' => $newDocId,
                'modified_on' => date('Y-m-d H:i:s T'),
                'modified_by' => $_SESSION['username'],
                'note' => 'Initial import',
                'revision' => 'current',
            );
            $successAddHistoryLog = $this->main->insertData("log", $historyLog);
            if (!$successAddHistoryLog) throw new \Exception('Gagal menyimpan log ke database, mohon coba lagi!');

            //insert ke db dept_perms
            foreach ($_POST['bidang_perms'] as $dept_id=>$dept_perm) {
                $deptPerms = array(
                    'fid' => $newDocId,
                    'rights' => $dept_perm,
                    'dept_id' => $dept_id,
                );
                $successAddDeptPerms = $this->main->insertData("dept_perms", $deptPerms);
                if (!$successAddDeptPerms) throw new \Exception('Gagal menyimpan izin bidang ke database, mohon coba lagi!');
            }

            //insert ke db user_perms
            foreach ($_POST['user_perms'] as $user_id=>$permission) {
                $userPerms = array(
                    'fid' => $newDocId,
                    'rights' => $permission,
                    'uid' => $user_id,
                );
                $successAddUserPerms = $this->main->insertData("user_perms", $userPerms);
                if (!$successAddUserPerms) throw new \Exception('Gagal menyimpan izin user ke database, mohon coba lagi!');
            }

            //set nama file jadi id.dat
            $newFileName = $newDocId . '.dat';
            $file->move($dataDir, $newFileName);
            
            $this->addLogEntry($newDocId, 'A');
            
            $this->db->transCommit();
            $_SESSION['info_success'] = '<b>Sukses!</b> Dokumen berhasil ditambahkan [Nama dok: '.$_FILES['filename']['name'].']';
            return redirect()->to('dashboard/approval/onreview');
        } catch (\Exception $e) {
            $this->db->transRollback();
            $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
            return redirect()->to('dashboard/document');
        }
    }

    private function addLogEntry($fileId, $action) {
        $logs['file_id'] = $fileId;
        $logs['user_id'] = $_SESSION['id'];
        $logs['timestamp'] = date('Y-m-d H:i:s');
        $logs['action'] = $action;
    }

    public function edit($id = null) {
        if ($id == null || $_POST == null) {
            $_SESSION['info_error'] = '<b>Gagal!</b> Request tidak valid.';
            return redirect()->to('dashboard/document');
        }

        if (!isset($_POST['user_perms'])) {
            $_SESSION['info_error'] = '<b>Gagal!</b> Minimal harus ada 1 permission user';
            return redirect()->to('dashboard/document/onreview/'.$id);
        }

        $doc = $this->main->getRowData('data', array('id' => $id));
    
        if ($doc == null) {
            $_SESSION['info_error'] = '<b>Gagal!</b> Data tidak ditemukan.';
            return redirect()->to('dashboard/document');
        }

        // minimal harus ada 1 user dengan perms lihat atau edit
        $permsOk = false;
        foreach ($_POST['user_perms'] as $permission) {
            if ($permission > 2) {
                $permsOk = true;
                break;
            }
        }
        if(!$permsOk) {
            $_SESSION['info_error'] = '<b>Gagal!</b> Harus ada minimal 1 user dengan permission lihat atau edit';
            return redirect()->to('dashboard/document/onreview/'.$id);
        }

        // Check to make sure the file is available
        if ($doc['status'] != 0) {
            $_SESSION['info_error'] = '<b>Gagal!</b> Status file tidak available';
            return redirect()->to('dashboard/document/approved/'.$id);
        }

        $this->db->transBegin();
        try {  
            // update category
            $doc['category'] = $_POST['kategori'];
            $doc['description'] = $_POST['deskripsi'];
            $doc['comment'] = $_POST['komentar'];
            if (isset($_POST['pemilik'])) $doc['owner'] = $_POST['pemilik'];
            if (isset($_POST['bidang'])) $doc['department'] = $_POST['bidang'];

            // Update the file with the new values
            $isSuccess = $this->main->updateData('data', array('id' => $id), $doc);

            //TODO
            //udf_edit_file_update();

            // clean out old permissions
            $delUserPerms = $this->main->deleteData('user_perms', array('fid' => $doc['id']));
            if (!$delUserPerms) throw new \Exception('Gagal hapus permission user');

            // clean out old permissions
            $delDeptPerms = $this->main->deleteData('dept_perms', array('fid' => $doc['id']));
            if (!$delDeptPerms) throw new \Exception('Gagal hapus permission bidang');
            
            //insert ke db dept_perms
            foreach ($_POST['bidang_perms'] as $dept_id=>$dept_perm) {
                $deptPerms = array(
                    'fid' => $doc['id'],
                    'rights' => $dept_perm,
                    'dept_id' => $dept_id,
                );
                $successAddDeptPerms = $this->main->insertData("dept_perms", $deptPerms);
                if (!$successAddDeptPerms) throw new \Exception('Gagal menyimpan izin bidang ke database, mohon coba lagi!');
            }

            //insert ke db user_perms
            foreach ($_POST['user_perms'] as $user_id=>$permission) {
                $userPerms = array(
                    'fid' => $doc['id'],
                    'rights' => $permission,
                    'uid' => $user_id,
                );
                $successAddUserPerms = $this->main->insertData("user_perms", $userPerms);
                if (!$successAddUserPerms) throw new \Exception('Gagal menyimpan izin user ke database, mohon coba lagi!');
            }

            $this->addLogEntry($id, 'M');

            $this->db->transCommit();
            $_SESSION['info_success'] = '<b>Sukses!</b> Dokumen berhasil diubah [Nama dok: '.$doc['realname'].']';
            return redirect()->to('dashboard/approval/onreview');
        
        } catch (\Exception $e) {
            $this->db->transRollback();
            $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
            return redirect()->to('dashboard/document');
        }
    }

    public function loadAjaxTables($status, $adminMode = 0)
    {   
        $publishable = publishableByStatus($status);

        $wheres['start']            = $_POST['start'];
        $wheres['rowperpage']       = $_POST['length']; // Rows display per page
        $wheres['columnIndex']      = $_POST['order'][0]['column']; // Column index
        $wheres['columnName']       = $_POST['columns'][$wheres['columnIndex']]['data']; // Column name
        $wheres['columnSortOrder']  = $_POST['order'][0]['dir']; // asc or desc
        if ($status == 'approved')
            $wheres['searchValue'] = isset($_POST['filterParam']) ? $_POST['filterParam'][0] : '';
        else
            $wheres['searchValue'] = $_POST['search']['value'];
        $wheres['publishable']  = $wheresRecordTotal['publishable'] = $publishable;
        $wheres['status']       = $wheresRecordTotal['status'] = $status;
        $wheres['adminMode']    = $wheresRecordTotal['adminMode'] = $wheresRejected['adminMode'] = $adminMode;
        
        $files = $this->dashboard->getData($wheres, true);

        $data = array();

        $arrStatus = array('deleted', 'onreview', 'rejected');

        if (count($files) > 0) {
            $i = 0;
            foreach ($files as $key => $val) {
                $userAccessLevel = getAuthority($_SESSION['id'], $val->id, $_SESSION['department'])['rights'];

                $lock = true;
                $VIEW_RIGHT = 1;
                if ($val->status == 0 and $userAccessLevel >= $VIEW_RIGHT) $lock = false;
                
                $latestLog = $this->dashboard->getLatestLog($val->id, 1);
                $data[$i] = array(
                    'id'        => $val->id,
                    'check'     => in_array($status, $arrStatus) ? '<input type="checkbox" name="ids" value="'.$val->id.'" id="check'.$val->id.'">' : '',
                    'nama_file' => '<a target="_blank" href="'.site_url('dashboard/file').'/'.$val->id.'/view">'.$val->realname.'</a>' ,
                    'deskripsi' => $val->description == null ? '-' : $val->description,
                    'hak_akses' => $this->getRights($userAccessLevel),
                    'created'   => $val->created,
                    'changed'   => $latestLog == null ? $val->created : $latestLog['timestamp'],
                    'pemilik'   => $val->last_name.', '.$val->first_name,
                    'bidang'    => $val->dept_name,
                    'ukuran'    => getFileSizeByFileId($val->id),
                    'status'    => $lock ? '<i class="text-danger fa fa-times"></i>' : '<i class="text-success fa fa-check"></i>',
                );
                
                $detail = '<div class="btn-group" role="group"><button type="button" class="btn btn-default btn-sm btn-detail" id="'.$val->id.'"><i class="fas fa-folder"></i></button>';

                if (!$_SESSION['is_admin'] && !$_SESSION['is_reviewer']) {
                    if ($status == 'onreview') {
                        $data[$i]['detail'] = $detail . '</div>';
                    } else {
                        $data[$i]['detail'] = $detail . '<a href="'.site_url('dashboard/document').'/'.$status.'/'.$val->id.'" class="btn btn-default btn-sm"><i class="fas fa-pencil-alt"></i></a><button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-href="'.site_url('dashboard/tempDeleteFile/').$val->id.'" data-target="#confirmDelete"><i class="fas fa-trash"></i></button></div>';
                    }
                } else {
                    if ($status == 'deleted') {
                        $data[$i]['detail'] = $detail . '</div>';
                    } else {
                        $data[$i]['detail'] = $detail . '<a href="'.site_url('dashboard/document').'/'.$status.'/'.$val->id.'" class="btn btn-default btn-sm"><i class="fas fa-pencil-alt"></i></a><button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-href="'.site_url('dashboard/tempDeleteFile/').$val->id.'" data-target="#confirmDelete"><i class="fas fa-trash"></i></button></div>';
                    }
                }

                $i++;
            }
        }

        $dataset = array(
                        'draw'          => intval($_POST['draw']),
                        'recordsTotal'  => $this->dashboard->getData($wheresRecordTotal),
                        'recordsFiltered'=> $this->dashboard->getData($wheres),
                        'data'          => $data
                    );

        if (in_array($status, $arrStatus)) {
            // total need to be deleted
            $wheresDeleted['status'] = 'deleted';
            $wheresDeleted['publishable'] = publishableByStatus('deleted');
            $dataset['totDeleted'] = $this->dashboard->getData($wheresDeleted);
            // total need to be reviewed
            $wheresReviewed['status'] = 'onreview';
            $wheresReviewed['publishable'] = publishableByStatus('onreview');
            $dataset['totReviewed'] = $this->dashboard->getData($wheresReviewed);
            if ($adminMode == 0) {
                unset($_SESSION['notif_review']);
                $_SESSION['notif_review'] = $dataset['totReviewed'];
            }
            // total rejected
            $wheresRejected['status'] = 'rejected';
            $wheresRejected['publishable'] = publishableByStatus('rejected');
            $dataset['totRejected'] = $this->dashboard->getData($wheresRejected);
            if ($adminMode == 0) { 
                unset($_SESSION['notif_rejected']);
                $_SESSION['notif_rejected'] = $dataset['totRejected'];
            }
        }

        echo json_encode($dataset);
    }

    public function searchField()
    {
        $id = $_POST['id'];
        if (in_array($id, array('pemilik', 'bidang', 'kategori'))) {
            $list_option = $this->dashboard->getOptionalList($id);
            $html_opt = '';
            foreach ($list_option as $key => $val) {
                $placeholder = 'Nama ' . ucwords($id);
                if ($id == 'pemilik') {
                    $name = $val->last_name.', '.$val->first_name;
                    $placeholder = 'Nama Pemilik (Nama Belakang, Nama Depan)';
                } else $name = $val->name;
                
                $html_opt .= '<option value="'.$val->id.'">'.$name.'</option>';
            }
        }

        $title = ucwords(str_replace('_', ' ', $id));

        switch ($id) {
            case 'pemilik':
            case 'bidang':
            case 'kategori':
                $html = '<label>'.$title.':</label>
                        <select class="select2 filter" id="'.$id.'" name="'.$id.'[]" multiple="multiple" data-placeholder="Pilih '.$placeholder.'" style="width: 100%;">';
                $html .= $html_opt . '</select>';
                break;
            case 'deskripsi':
            case 'nama_file':
            case 'comment':
            case 'file_id':
                $html = '<label>'.$title.':</label>
                        <input type="text" id="'.$id.'" class="form-control filter" placeholder="Ketik '.$title.'" name="'.$id.'">';
                break;
            default:
                $html = '<label>Keyword:</label>
                        <input type="text" class="form-control" placeholder="Keyword" disabled>';
                break;
        }
        return $html;
    } 

    private function getRights($userAccessLevel){
        $READ_RIGHT = 2;
        $WRITE_RIGHT = 3;
        $ADMIN_RIGHT = 4;

        $read = array($READ_RIGHT, 'r');
        $write = array($WRITE_RIGHT, 'w');
        $admin = array($ADMIN_RIGHT, 'a');
        $rights = array($read, $write, $admin);
        $index_found = -1;
        //$rights[max][0] = admin, $rights[max-1][0]=write, ..., $right[min][0]=view
        //if $userright matches with $rights[max][0], then this user has all the rights of $rights[max][0]
        //and everything below it.
        for ($i = sizeof($rights) - 1; $i >= 0; $i--) {
            if ($userAccessLevel == $rights[$i][0]) {
                $index_found = $i;
                $i = 0;
            }
        }
        //Found the user right, now bold every below it.  For those that matches, make them different.
        
        //For everything above it, blank out
        for ($i = $index_found + 1; $i < sizeof($rights); $i++) {
            $rights[$i][1] = '-';
            log_message('error', $rights[$i][1]);
        }

        $rightsString = $rights[0][1] . ' | ' . $rights[1][1] . ' | ' . $rights[2][1];
        
        return $rightsString;
    }

    public function approval($status)
    {
        $header['title'] = '';
        switch ($status) {
            case 'deleted': $header['title'] = 'Dokumen Deleted/Undeleted'; break;
            case 'onreview': $header['title'] = 'Dokumen Waiting to be Reviewed'; break;
            case 'rejected': $header['title'] = 'Dokumen Rejected'; break;
        }
        
        $data['listUsers'] = $this->main->getResultData('user', array(), false, 'id, first_name, last_name');
        $data['status'] = $side['active'] = $status;
        $data['admin_mode'] = false;

        echo view('partial/header', $header);
        echo view('partial/top_menu');
        echo view('partial/side_menu', $side);
        echo view('approval', $data);
        echo view('partial/footer');
    }

    // User has requested a deletion from the file detail page or rejected page
    public function tempDeleteFile($fid, $rejected = false)
    {
        $datas['publishable'] = 2;
        $this->db->transBegin();
        try {
            // update _data
            $updData = $this->main->updateData('data', array('id' => $fid), $datas);
            if (!$updData)
                    throw new \Exception('Status publishable gagal terupdate.');
            
            // aceess log
            $logs['file_id'] = $fid;
            $logs['user_id'] = $_SESSION['id'];
            $logs['timestamp'] = date('Y-m-d H:i:s');
            $logs['action'] = 'X';
            $insLogs = $this->main->insertData('access_log', $logs);
            if (!$insLogs)
                throw new \Exception('Log entry gagal tersimpan.');

            // PR LANJUTAN MOVE FILE
            if (!is_dir(config('MyConfig')->settings['archiveDir'])) {
                // Make sure directory is writable
                if (!mkdir(config('MyConfig')->settings['archiveDir'], 0775)) {
                    $last_message='Could not create ' . config('MyConfig')->settings['archiveDir'];
                    header('Location:error.php?ec=23&last_message=' . urlencode($last_message));
                    exit;
                }
            }
            fmove(config('MyConfig')->settings['dataDir'] . $fid . '.dat', config('MyConfig')->settings['archiveDir'] . $fid . '.dat');

            $this->db->transCommit();
            $_SESSION['info_success'] = '<b>Sukses!</b> Dokumen berhasil dipindahkan ke archive.';
            
            if ($rejected)
                return redirect()->to('dashboard/approval/onreview');   
            else 
                return redirect()->to('dashboard/approval/rejected');   
        } catch (\Exception $e) {
            $this->db->transRollback();
            $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
            
            if ($rejected)
                return redirect()->to('dashboard/approval/onreview');   
            else 
                return redirect()->to('dashboard/approval/rejected');  
        }
    }

    public function resubmit()
    {
        $ids = $_POST['ids'];

        if (!$ids) {
            $_SESSION['info_error'] = '<b>Error!</b> File ID tidak dikenal.';
        } else {
            $this->db->transBegin();
            try {
                $datas['publishable'] = 0;
                $datas['reviewer']    = $_SESSION['id'];

                foreach ($ids as $val) {
                    // update _data
                    $updData = $this->main->updateData('data', array('id' => $val), $datas);
                    if (!$updData)
                        throw new \Exception('Dokumen gagal di-submit ulang. [ID: '.$val.']');
                }
                    
                $this->db->transCommit();
                $_SESSION['info_success'] = '<b>Sukses!</b> Dokumen berhasil di-submit ulang.';
            } catch (\Exception $e) {
                $this->db->transRollback();
                $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
            }
        }
    }

    public function tempDeleteRejectedFile()
    {
        $ids = $_POST['ids'];

        if (!$ids) {
            $_SESSION['info_error'] = '<b>Error!</b> File ID tidak dikenal.';
        } else {
            foreach ($ids as $val) {
                $this->tempDeleteFile($val, true);
            }
        }
    }

    public function reject()
    {
        $ids = json_decode($_POST['ids']);
        $url = isset($_POST['admin_mode']) && $_POST['admin_mode'] == 0 ? 'dashboard/approval/onreview' : 'admin/documents/onreview';
        
        if (!$ids) {
            $_SESSION['info_error'] = '<b>Error!</b> File ID tidak dikenal.';
            return redirect()->to($url);
        } else {
            $uid = $_SESSION['id'];

            $to      = isset($_POST['to']) ? trim($_POST['to']) : '';
            $subject = isset($_POST['subject']) ? trim($_POST['subject']) : 'Review status for document';
            $comments= isset($_REQUEST['comments']) ? stripslashes($_REQUEST['comments']) : '';
            
            $mail_break = '--------------------------------------------------'.PHP_EOL;
            $reviewer_comments = "To=$to;Subject=$subject;Comments=$comments;";
            $user_obj = $this->main->getRowData('user', array('id' => $uid));
            $date = date('Y-m-d H:i:s T'); //locale insensitive
            $full_name = $user_obj['first_name'] . ' ' . $user_obj['last_name'];
            $mail_from= $full_name.' <'.$user_obj['Email'].'>';
            $mail_headers = "From: " . $mail_from . PHP_EOL;
            $mail_headers .="Content-Type: text/plain; charset=UTF-8".PHP_EOL;
            $mail_subject= $subject;
            $mail_greeting='Yth Pemilik file'. ":" . PHP_EOL . "\t" . 'Saya ingin menyampaikan bahwa';
            $mail_body = $comments . PHP_EOL . PHP_EOL;
            $mail_body .= 'telah ditolak untuk publish pada tanggal ' .$date. ' karena alasan berikut :'. PHP_EOL . PHP_EOL . $mail_break . $comments . PHP_EOL . $mail_break;
            $mail_salute=PHP_EOL . PHP_EOL . "Terima kasih, ". PHP_EOL . $full_name;

            if (isAdmin($uid)) {
                $arr = $this->main->getResultData('data', array('publishable' => 0), false, 'id');
            } else if (isReviewer($_SESSION['id'])) {
                $arr = $this->dashboard->getRevieweeIds($uid);
            }

            $id_array = array();
            foreach($arr as $val) {
                array_push($id_array, $val['id']);
            }
            
            foreach ($ids as $val) {
                if (in_array($val, $id_array)) {
                    $fileid = $val;
                    $file_obj = $this->main->getRowData('data', array('id' => $fileid));
                    $u_obj = $this->main->getRowData('user', array('id' => $file_obj['owner']));
                    $mail_to = $u_obj['Email'];
                    $dept_id = $file_obj['department'];
                    // Build email for author notification
                    if (isset($_POST['send_to_users'][0]) && in_array('owner', $_POST['send_to_users'])) {
                        // Lets unset this now so the new array will just be user_id's
                        $_POST['send_to_users'] = array_slice($_POST['send_to_users'], 1);
                        $mail_body1 = $comments . PHP_EOL . PHP_EOL;
                        $mail_body1.="Telah di tolak dari repository" . PHP_EOL . PHP_EOL;
                        $mail_body1.='Nama File :  ' . $file_obj['realname'] . PHP_EOL . PHP_EOL;
                        $mail_body1.='Status    : Rejected'. PHP_EOL . PHP_EOL;
                        $mail_body1.='Tanggal   : ' . $date . PHP_EOL . PHP_EOL;
                        $mail_body1.='Reviewer  : ' . $full_name . PHP_EOL . PHP_EOL;
                        $mail_body1.='Terima Kasih,' . PHP_EOL . PHP_EOL;
                        $mail_body1.='Automated Document Messenger' . PHP_EOL . PHP_EOL;
                        $mail_body1.=site_url() . PHP_EOL . PHP_EOL;

                        if (config('MyConfig')->settings['demo'] == 'False') {
                            $this->sendEmail($mail_to, $mail_subject . ' ' . $file_obj['realname'], $mail_greeting . $file_obj['realname'] . ' ' . $mail_body1 . $mail_salute);
                        }
                    }

                    $this->db->transBegin();
                    try {
                        $datas['publishable'] = '-1';
                        $datas['reviewer']    = $uid;
                        $datas['reviewer_comments'] = $reviewer_comments;
                        $updateData = $this->main->updateData('data', array('id' => $val), $datas);
                        if (!$updateData)
                            throw new \Exception('Status dokumen gagal terupdate.');
                        
                        // access log
                        $logs['file_id'] = $val;
                        $logs['user_id'] = $uid;
                        $logs['timestamp'] = date('Y-m-d H:i:s');
                        $logs['action'] = 'R';
                        $insLogs = $this->main->insertData('access_log', $logs);
                        if (!$insLogs)
                            throw new \Exception('Log entry gagal tersimpan.');
                            
                        $this->db->transCommit();
                        $_SESSION['info_success'] = '<b>Sukses!</b> Dokumen berhasil di-reject.';
                    } catch (\Exception $e) {
                        $this->db->transRollback();
                        $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
                        return redirect()->to($url);
                    }

                    // Set up rejected email message to sent out
                    $mail_subject = (!empty($_REQUEST['subject']) ? stripslashes($_REQUEST['subject']) : "File telah ditolak");
                    $mail_body = $comments . PHP_EOL . PHP_EOL;
                    $mail_body.='File telah ditolak'.PHP_EOL . PHP_EOL;
                    $mail_body.='Nama File :  ' .$file_obj['realname'] . PHP_EOL . PHP_EOL;
                    $mail_body.='Status    : Rejected'. PHP_EOL . PHP_EOL;
                    $mail_body.='Tanggal   : ' .$date. PHP_EOL . PHP_EOL;
                    $mail_body.='Reviewer  : ' . $full_name . PHP_EOL . PHP_EOL;
                    $mail_body.='Terima Kasih,'. PHP_EOL . PHP_EOL;
                    $mail_body.='Automated Document Messenger'. PHP_EOL . PHP_EOL;
                    $mail_body.=site_url() . PHP_EOL . PHP_EOL;

                    if (isset($_POST['send_to_all'])) {
                        $emails = $this->main->getResultData('user', array(), false, 'Email', true);
                        foreach ($emails as $e) $this->sendEmail( 
                            $e['Email'], 
                            $mail_subject . ' ' . $file_obj['realname'], 
                            $mail_greeting . $file_obj['realname'] . ' ' . $mail_body . $mail_salute);
                    }

                    if (isset($_POST['send_to_dept'])) {
                        $emails = $this->main->getResultData('user', array('department' => $file_obj['department']), false, 'Email', true);
                        foreach ($emails as $e) $this->sendEmail(
                            $e['Email'], 
                            $mail_subject . ' ' . $file_obj['realname'], 
                            $mail_greeting . $file_obj['realname'] . ' ' . $mail_body . $mail_salute);
                    }

                    if (isset($_POST['send_to_users']) && is_array($_POST['send_to_users']) && isset($_POST['send_to_users'][0])) {
                        $this->emailUserIds($_POST['send_to_users'], $mail_subject, $mail_body);
                    }
                } else {
                    $_SESSION['info_error'] = '<b>Error!</b> You are not authorized to reject this file [File ID: '.$val.']';
                }
            }
            return redirect()->to($url);
        }
    }
    
    private function emailUserIds($user_ID_array, $mail_subject, $mail_body) {
        for ($i = 0; $i < sizeof($user_ID_array); $i++) {
            if ($user_ID_array[$i] > 0) {
                $user = $this->main->getRowData('user', array('id' => $user_ID_array[$i]));
                $this->sendEmail($user['Email'], $mail_subject, $mail_body);
            }
        }
    }

    private function sendEmail($to, $subject, $message) {
        if (config('MyConfig')->settings['demo'] == 'False') {
            $email = \Config\Services::email();
            $email->setFrom($email->SMTPUser, $_SESSION["first_name"] . ' ' . $_SESSION["last_name"]);
            $email->setTo($to);
            $email->setSubject($subject);
            $email->setMessage($message);
            $email->send();
        }
    }

    public function authorize()
    {
        $ids = json_decode($_POST['ids']);
        $url = isset($_POST['admin_mode']) && $_POST['admin_mode'] == 0 ? 'dashboard/approval/onreview' : 'admin/documents/onreview';
        
        if (!$ids) {
            $_SESSION['info_error'] = '<b>Error!</b> File ID tidak dikenal.';
            return redirect()->to($url);
        } else {
            $to      = isset($_POST['to']) ? trim($_POST['to']) : '';
            $subject = isset($_POST['subject']) ? trim($_POST['subject']) : 'Review status for document ';
            $comments= isset($_POST['comments']) ? stripslashes($_POST['comments']) : '';

            $reviewer_comments = "To=$to;Subject=$subject;Comments=$comments;";
            $user_obj = $this->main->getRowData('user', array('id' => $_SESSION['id']));
            $date = date('Y-m-d H:i:s T'); //locale insensitive
            $full_name = $user_obj['first_name'] . ' ' . $user_obj['last_name'];
            $mail_subject = $subject;

            $uid = $_SESSION['id'];
            if (isAdmin($uid)) {
                $arr = $this->main->getResultData('data', array('publishable' => 0), false, 'id');
            } else if (isReviewer($_SESSION['id'])) {
                $arr = $this->dashboard->getRevieweeIds($uid);
            }

            $id_array = array();
            foreach($arr as $val) {
                array_push($id_array, $val['id']);
            }
            
            foreach ($ids as $val) {
                if (in_array($val, $id_array)) {
                    $fileid = $val;
                    $file_obj = $this->main->getRowData('data', array('id' => $fileid));
                    $u_obj = $this->main->getRowData('user', array('id' => $file_obj['owner']));
                    $mail_to = $u_obj['Email'];
                    $dept_id = $file_obj['department'];
                    // Build email for author notification
                    if (isset($_POST['send_to_users'][0]) && in_array('owner', $_POST['send_to_users'])) {
                        // Lets unset this now so the new array will just be user_id's
                        $_POST['send_to_users'] = array_slice($_POST['send_to_users'], 1);
                        $mail_body1 = $comments . PHP_EOL . PHP_EOL;
                        $mail_body1.="File anda telah di authorize untuk dipublikasi" . PHP_EOL . PHP_EOL;
                        $mail_body1.='Nama File :  ' . $file_obj['realname'] . PHP_EOL . PHP_EOL;
                        $mail_body1.='Status    : Authorized' . PHP_EOL . PHP_EOL;
                        $mail_body1.='Tanggal   : ' . $date . PHP_EOL . PHP_EOL;
                        $mail_body1.='Reviewer  : ' . $full_name . PHP_EOL . PHP_EOL;
                        $mail_body1.='Terima Kasih,' . PHP_EOL . PHP_EOL;
                        $mail_body1.='Automated Document Messenger' . PHP_EOL . PHP_EOL;
                        $mail_body1.=site_url() . PHP_EOL . PHP_EOL;

                        if (config('MyConfig')->settings['demo'] == 'False') {
                            $this->sendEmail($mail_to, $mail_subject . ' ' . $file_obj['realname'], $mail_body1);
                        }
                    }
                    
                    $this->db->transBegin();
                    try {
                        $datas['publishable'] = '1';
                        $datas['reviewer']    = $uid;
                        $datas['reviewer_comments'] = $reviewer_comments;
                        $updateData = $this->main->updateData('data', array('id' => $val), $datas);
                        if (!$updateData)
                            throw new \Exception('Status dokumen gagal terupdate.');
                        
                        // access log
                        $logs['file_id'] = $val;
                        $logs['user_id'] = $uid;
                        $logs['timestamp'] = date('Y-m-d H:i:s');
                        $logs['action'] = 'Y';
                        $insLogs = $this->main->insertData('access_log', $logs);
                        if (!$insLogs)
                            throw new \Exception('Log entry gagal tersimpan.');
                            
                        $this->db->transCommit();
                        $_SESSION['info_success'] = '<b>Sukses!</b> Dokumen berhasil di-authorize.';
                    } catch (\Exception $e) {
                        $this->db->transRollback();
                        $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
                        return redirect()->to($url);
                    }

                    
                    // Build email for general notices
                    $mail_subject = (!empty($_REQUEST['subject']) ? stripslashes($_REQUEST['subject']) : "Telah ditambah di repository");
                    $mail_body2 = $comments . PHP_EOL . PHP_EOL;
                    $mail_body2.='File baru telah di authorize'.PHP_EOL . PHP_EOL;
                    $mail_body2.='Nama File :  ' .$file_obj['realname'] . PHP_EOL . PHP_EOL;
                    $mail_body2.='Status    : New'. PHP_EOL . PHP_EOL;
                    $mail_body2.='Tanggal   : ' .$date. PHP_EOL . PHP_EOL;
                    $mail_body2.='Reviewer  : ' . $full_name . PHP_EOL . PHP_EOL;
                    $mail_body2.='Terima Kasih,'. PHP_EOL . PHP_EOL;
                    $mail_body2.='Automated Document Messenger'. PHP_EOL . PHP_EOL;
                    $mail_body2.=site_url() . PHP_EOL . PHP_EOL;

                    if (isset($_POST['send_to_all'])) {
                        $emails = $this->main->getResultData('user', array(), false, 'Email', true);
                        foreach ($emails as $e) $this->sendEmail($e['Email'], $mail_subject . ' ' . $file_obj['realname'], $mail_body2);
                    }

                    if (isset($_POST['send_to_dept'])) {
                        $emails = $this->main->getResultData('user', array('department' => $file_obj['department']), false, 'Email', true);
                        foreach ($emails as $e) $this->sendEmail($e['Email'], $mail_subject . ' ' . $file_obj['realname'],  $mail_body2);
                    }

                    if (isset($_POST['send_to_users']) && is_array($_POST['send_to_users']) && isset($_POST['send_to_users'][0])) {
                        $this->emailUserIds($_POST['send_to_users'], $mail_subject, $mail_body2);
                    }
                } else {
                    $_SESSION['info_error'] = '<b>Error!</b> You are not authorized to authorize this file [File ID: '.$val.']';
                }
            }
            return redirect()->to($url);
        }
    }
}