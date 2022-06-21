<?php
namespace App\Controllers;
use App\Models\AdminModel;
use App\Models\DashboardModel;

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

        $this->admin = new AdminModel();
        $this->dashboard = new DashboardModel();

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
                        'action'   => '<div class="btn-group btn-group-sm"><button type="button" class="btn btn-info btn-edit" id="'.$val->id.'"><i class="fas fa-pencil-alt"></i></button><button type="button" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></button></div>',
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
        $detail = $this->admin->getUserById($id);
        echo json_encode($detail);
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
        $detail = $this->admin->getUserInDept($dept_id);
        echo json_encode($detail);
    }

    public function getBidangById($id)
    {
        $detail = $this->admin->getBidangById($id);
        echo json_encode($detail);
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
        $detail = $this->admin->getKategoriById($id);
        echo json_encode($detail);
    }

    public function getDataByKategoriId($cat_id)
    {
        $detail = $this->admin->getDataByKategoriId($cat_id);
        echo json_encode($detail);
    }

}