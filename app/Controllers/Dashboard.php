<?php
namespace App\Controllers;
use App\Models\DashboardModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function __construct()
	{
        $this->session = \Config\Services::session();
        if (!isset($_SESSION['login_state'])) {
			$message = 'Session Anda telah Habis';
			echo "<SCRIPT>alert('$message');window.location='" . site_url('logon') . "';</SCRIPT>";
		}

		$this->dashboard = new DashboardModel();
		$this->user = new UserModel();

        helper(['permission']);
	}

    public function index()
    {
        $header['title'] = 'Dashboard';
        
        echo view('partial/header', $header);
        echo view('partial/top_menu');
        echo view('partial/side_menu');
        echo view('dashboard');
        echo view('partial/footer');
    }

    public function search()
    {
        $header['title'] = 'Pencarian Dokumen';
        $data = array();

        echo view('partial/header', $header);
        echo view('partial/top_menu');
        echo view('partial/side_menu');
        echo view('data', $data);
        echo view('partial/footer');
    }

    public function getDataById($id = null)
    {
        $dataId = isset($id) && !is_null($id) ? $id : $_GET['id'];
        $wheres['searchValue']['id'] = $dataId;
        $wheres['publishable'] = 1;
        $dataById = $this->dashboard->getData($wheres, true);
        
        if (!is_null($id))
            return $dataById;
        else 
            echo json_encode($dataById[0]);
    }

    public function add($id = null)
    {
        // echo '<pre>';
        // var_dump($_SESSION);exit();
        $header['title'] = !is_null($id) ? 'Update File' : 'Tambah File';

        $data['file_id'] = $id;
        if (!is_null($id)) {
            $data['fileExist'] = $this->getDataById($id);
        }

        $data['listPemilik'] = $this->dashboard->getOptionalList('pemilik');
        $data['listBidang']  = $this->dashboard->getOptionalList('bidang');
        $data['listKategori']= $this->dashboard->getOptionalList('kategori');
        $data['allUsers']    = $this->user->allUsers();

        echo view('partial/header', $header);
        echo view('partial/top_menu');
        echo view('partial/side_menu');
        echo view('form_input', $data);
        echo view('partial/footer');
    }

    public function searchAjaxTables()
    {   
        $wheres['start']            = $_POST['start'];
        $wheres['rowperpage']       = $_POST['length']; // Rows display per page
        $wheres['columnIndex']      = $_POST['order'][0]['column']; // Column index
        $wheres['columnName']       = $_POST['columns'][$wheres['columnIndex']]['data']; // Column name
        $wheres['columnSortOrder']  = $_POST['order'][0]['dir']; // asc or desc
        $wheres['searchValue']      = isset($_POST['filterParam']) ? $_POST['filterParam'][0] : '';
        $wheres['publishable']      = $wheresRecordTotal['publishable'] = 1;
        
        $files = $this->dashboard->getData($wheres, true);
        
        $data = array();

        if (count($files) > 0) {
            foreach ($files as $key => $val) {
                $data[] = array(
                    'id'        => $val->id,
                    'detail'   => '<div class="btn-group" role="group"><button type="button" class="btn btn-default btn-sm btn-detail" id="'.$val->id.'"><i class="fas fa-folder"></i></button><a href="add/'.$val->id.'" class="btn btn-default btn-sm"><i class="fas fa-pencil-alt"></i></a><button type="button" class="btn btn-default btn-sm btn-delete" data-toogle="modal" data-target="#confirmDelete" data-record-id="'.$val->id.'"><i class="fas fa-trash"></i></button></div>',
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
            }
        }

        $dataset = array(
                        'draw'          => intval($_POST['draw']),
                        'recordsTotal'  => $this->dashboard->getData($wheresRecordTotal),
                        'recordsFiltered'=> $this->dashboard->getData($wheres),
                        'data'          => $data
                    );

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
}