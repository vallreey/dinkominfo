<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class DashboardModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $db = \Config\Database::connect();
        $builder = $db->table('odm_data');
        // OR $this->db = db_connect();
    }

    public function getData($wheres = array(), $returnData = false)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odm_data d');
        $query = $builder->select('d.*, dept.name as dept_name, c.name as cat_name, u.last_name, u.first_name')
                    ->join('odm_user u', 'd.owner = u.id')
                    ->join('odm_department dept', 'd.department = dept.id')
                    ->join('odm_category c', 'd.category = c.id')
                    ->where('d.publishable', $wheres['publishable']);

        if (isset($wheres['id']) && $wheres['id'] != '') $query = $builder->where('d.id', $wheres['id']);

        if (isset($wheres['searchValue']) && $wheres['searchValue'] != '') {
            // search values  
            if ($wheres['status'] == 'approved') {
                $key = strval(array_key_first($wheres['searchValue']));
                switch ($key) {
                    case 'id':
                        $query = $builder->where('d.id', $wheres['searchValue'][$key]);
                        break;
                    case 'pemilik':
                    case 'bidang':
                    case 'kategori':
                        $as_table = array('pemilik' => 'u', 'bidang' => 'dept', 'kategori' => 'c');
                        $query = $builder->whereIn($as_table[$key].'.id', $wheres['searchValue'][$key]);
                        break;
                    case 'deskripsi':
                    case 'nama_file':
                    case 'comment':
                    case 'file_id':
                        $field_table = array('deskripsi' => 'description', 'nama_file' => 'realname', 'comment' => 'comment', 'file_id' => 'id');
                        $query = $builder->like('d.'.$field_table[$key], $wheres['searchValue'][$key]); 
                        break;
                    default: break;
                }
            } else {
                $query = $builder->groupStart()
                                ->orLike('d.id', $wheres['searchValue'])
                                ->orLike('d.realname', $wheres['searchValue'])
                                ->orLike('d.description', $wheres['searchValue'])
                                ->orLike('d.created', $wheres['searchValue'])
                                ->orLike('u.last_name', $wheres['searchValue'])
                                ->orLike('u.first_name', $wheres['searchValue'])
                                ->orLike('dept.name', $wheres['searchValue'])
                                ->groupEnd();
            }
        }
        
        if (isset($wheres['rowperpage']) && isset($wheres['start'])) {
            $query = $builder->limit($wheres['rowperpage'], $wheres['start']);
        }

        if ($returnData) {
            $query = $builder->get();
            // var_dump($this->db->getLastQuery());exit();
            return $query->getResult();
        } else 
            return $query->countAllResults();
    }

    public function getOptionalList($option)
    {
        $orderBy = 'name';
        switch ($option) {
            case 'pemilik': $table = 'user'; $orderBy = 'last_name'; break;
            case 'kategori': $table = 'category'; break;
            case 'bidang': $table = 'department'; break;
        }

        $db = \Config\Database::connect();
        $builder = $db->table('odm_'.$table);
        $query = $builder->orderBy($orderBy, 'asc')->get();

        return $query->getResult();
    }

    // SELECT d.id FROM odm_data as d, odm_user as u, odm_department dept, odm_category as c WHERE d.owner = u.id AND d.department = dept.id AND d.category = c.id AND ( u.first_name LIKE :author_first_name AND u.last_name LIKE :author_last_name ) ORDER BY d.id ASC
}   