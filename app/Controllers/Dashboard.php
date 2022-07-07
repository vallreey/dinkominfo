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

        helper(['permission']);
	}

    public function index()
    {
        $header['title'] = 'Dashboard';
        
        return view('partial/header', $header)
            .view('partial/top_menu')
            .view('partial/side_menu')
            .view('dashboard')
            .view('partial/footer');
    }

    public function search()
    {
        $header['title'] = 'Pencarian Dokumen';
        $data['status'] = 'approved';

        return view('partial/header', $header)
            .view('partial/top_menu')
            .view('partial/side_menu')
            .view('data', $data)
            .view('partial/footer');
    }

    public function getDataById($status, $id = null)
    {
        $wheres['id'] = isset($id) && !is_null($id) ? $id : $_GET['id'];
        $wheres['publishable'] = publishableByStatus($status);
        $wheres['status'] = $status;

        $dataById = $this->dashboard->getData($wheres, true);
        
        if (!is_null($id))
            return $dataById;
        else 
            echo json_encode($dataById[0]);
    }

    public function document($status = null, $id = null)
    {
        $header['title'] = !is_null($id) ? 'Update File' : 'Tambah File';

        $data['file_id'] = $id;
        if (!is_null($id)) {
            $data['fileExist'] = $this->getDataById($status, $id);
        }

        $data['status']      = $status;
        $data['listPemilik'] = $this->dashboard->getOptionalList('pemilik');
        $data['listBidang']  = $this->dashboard->getOptionalList('bidang');
        $data['listKategori']= $this->dashboard->getOptionalList('kategori');
        $data['allUsers']    = $this->user->allUsers();

        return view('partial/header', $header)
            .view('partial/top_menu')
            .view('partial/side_menu')
            .view('form_input', $data)
            .view('partial/footer');
    }

    public function add()
    {
        //get mime types
        $mimeType = $this->main->getResultData('filetypes', array('active' => 1));
        $strType = '';
        foreach ($mimeType as $val) $strType .= $val['type'] . ',';
        $strType = substr($strType, 0, -1);
        
        //get settings
        $maxSize = $this->main->getRowData('settings', array('name' => 'max_filesize'))['value'];
        $dataDir = $this->main->getRowData('settings', array('name' => 'dataDir'))['value'];
        $authorization = $this->main->getRowData('settings', array('name' => 'authorization'))['value'];
        // die($authorization);

        //size in kb
        $validationRule = [
            'filename' => [
                'label' => 'Document File',
                'rules' => 'uploaded[filename]'
                    . '|mime_in[filename,'.$strType.']'
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

            //insert ke db log dengan note 'Initial import' dan revision 'current'
            $historyLog = array(
                'id' => $newDocId,
                'modified_on' => date('Y-m-d H:i:s T'),
                'modified_by' => $_SESSION['username'],
                'note' => 'Initial import',
                'revision' => 'current',
            );
            $successInsert = $this->main->insertData("log", $historyLog);
            if (!$successInsert) throw new \Exception('Gagal menyimpan log ke database, mohon coba lagi!');

            //insert ke db dept_perms
            foreach ($_POST['bidang_perms'] as $dept_id=>$dept_perm) {
                $deptPerms = array(
                    'fid' => $newDocId,
                    'rights' => $dept_perm,
                    'dept_id' => $dept_id,
                );
                $successInsert = $this->main->insertData("dept_perms", $deptPerms);
                if (!$successInsert) throw new \Exception('Gagal menyimpan izin bidang ke database, mohon coba lagi!');
            }

            //insert ke db user_perms
            foreach ($_POST['user_perms'] as $user_id=>$permission) {
                $userPerms = array(
                    'fid' => $newDocId,
                    'rights' => $permission,
                    'uid' => $user_id,
                );
                $successInsert = $this->main->insertData("user_perms", $userPerms);
                if (!$successInsert) throw new \Exception('Gagal menyimpan izin user ke database, mohon coba lagi!');
            }

            //ganti nama file jadi id.dat
            $newFileName = $newDocId . '.dat';
            $filepath = WRITEPATH . $file->store($dataDir, $newFileName);
            
            $this->db->transCommit();
            $_SESSION['info_success'] = '<b>Sukses!</b> Dokumen berhasil ditambahkan [Nama dok: '.$_FILES['filename']['name'].']';
            return redirect()->to('dashboard/approval/onreview');
        } catch (\Exception $e) {
            $this->db->transRollback();
            $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
            return redirect()->to('dashboard/document');
        }
    }

    public function edit() {
        
    }

    public function loadAjaxTables($status)
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
        $wheres['publishable']      = $wheresRecordTotal['publishable'] = $publishable;
        $wheres['status']           = $status;
        
        $files = $this->dashboard->getData($wheres, true);
        
        $data = array();

        $arrStatus = array('deleted', 'onreview', 'rejected');

        if (count($files) > 0) {
            $i = 0;
            foreach ($files as $key => $val) {
                $data[$i] = array(
                    'id'        => $val->id,
                    'check'     => in_array($status, $arrStatus) ? '<input type="checkbox" name="ids" value="'.$val->id.'" id="check'.$val->id.'">' : '',
                    'nama_file' => $val->realname,
                    'deskripsi' => $val->description,
                    'hak_akses' => '-',
                    'created'   => $val->created,
                    'changed'   => $val->created,
                    'pemilik'   => $val->last_name.', '.$val->first_name,
                    'bidang'    => $val->dept_name,
                    'ukuran'    => '-',
                    'status'    => $val->status
                );

                $detail = '<div class="btn-group" role="group"><button type="button" class="btn btn-default btn-sm btn-detail" id="'.$val->id.'"><i class="fas fa-folder"></i></button>';

                if ($status == 'deleted') $data[$i]['detail'] = $detail . '</div>';
                else $data[$i]['detail'] = $detail . '<a href="'.site_url('dashboard/document').'/'.$status.'/'.$val->id.'" class="btn btn-default btn-sm"><i class="fas fa-pencil-alt"></i></a><button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-href="'.site_url('dashboard/tempDeleteFile/').$val->id.'" data-target="#confirmDelete"><i class="fas fa-trash"></i></button></div>';
                
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
            $wheresDeleted['publishable'] = publishableByStatus('deleted');
            $dataset['totDeleted'] = $this->dashboard->getData($wheresDeleted);
            // total need to be reviewed
            $wheresReviewed['publishable'] = publishableByStatus('onreview');
            $dataset['totReviewed'] = $this->dashboard->getData($wheresReviewed);
            // total rejected
            $wheresRejected['publishable'] = publishableByStatus('rejected');
            $dataset['totRejected'] = $this->dashboard->getData($wheresRejected);
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

    public function approval($status)
    {
        $header['title'] = '';
        switch ($status) {
            case 'deleted': $header['title'] = 'Dokumen Deleted/Undeleted'; break;
            case 'onreview': $header['title'] = 'Dokumen Waiting to be Reviewed'; break;
            case 'rejected': $header['title'] = 'Dokumen Rejected'; break;
        }
        
        $data['status'] = $status;
        $data['admin_mode'] = false;

        echo view('partial/header', $header);
        echo view('partial/top_menu');
        echo view('partial/side_menu');
        echo view('approval', $data);
        echo view('partial/footer');
    }

    // User has requested a deletion from the file detail page
    public function tempDeleteFile($fid)
    {
        $datas['publishable'] = 2;
        $this->db->transBegin();
        try {
            // update _data
            $updData = $this->main->updateData('data', array('id' => $fid), $datas);
            if (!$updData)
                    throw new \Exception('Status publishable gagal terupdate.');
            
            // PR LANJUTAN MOVE FILE (IVAN) 
            // if (!is_dir($GLOBALS['CONFIG']['archiveDir'])) {
            //     // Make sure directory is writable
            //     if (!mkdir($GLOBALS['CONFIG']['archiveDir'], 0775)) {
            //         $last_message='Could not create ' . $GLOBALS['CONFIG']['archiveDir'];
            //         header('Location:error.php?ec=23&last_message=' . urlencode($last_message));
            //         exit;
            //     }
            // }
            // fmove($GLOBALS['CONFIG']['dataDir'] . $val . '.dat', $GLOBALS['CONFIG']['archiveDir'] . $val . '.dat');

            // audit trail
            $logs['file_id'] = $fid;
            $logs['user_id'] = $_SESSION['username'];
            $logs['timestamp'] = date('Y-m-d H:i:s');
            $logs['action'] = 'X';
            $insLogs = $this->main->insertData('access_log', $logs);
            if (!$insLogs)
                throw new \Exception('Log entry gagal tersimpan.');

            $this->db->transCommit();
            $_SESSION['info_success'] = '<b>Sukses!</b> Dokumen berhasil dipindahkan ke archive.';
            return redirect()->to('dashboard/approval/onreview');   
        } catch (\Exception $e) {
            $this->db->transRollback();
            $_SESSION['info_error'] = '<b>Error!</b> '.$e->getMessage();
            return redirect()->to('dashboard/approval/onreview');   
        }
    }
}