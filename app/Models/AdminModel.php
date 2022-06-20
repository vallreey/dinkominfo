<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class AdminModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $db = \Config\Database::connect();
        $builder = $db->table('odm_user');
    }

    public function getAdminData($wheres = array(), $table, $returnData = false)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odm_'.$table);

        if (isset($wheres['searchValue']) && $wheres['searchValue'] != '') {
            switch ($table) {
                case 'user':
                  $query = $builder->orLike('id', $wheres['searchValue'])
                                ->orLike('username', $wheres['searchValue'])
                                ->orLike('last_name', $wheres['searchValue'])
                                ->orLike('first_name', $wheres['searchValue']);
                  break;
                case 'department':
                case 'category':
                  $query = $builder->orLike('id', $wheres['searchValue'])
                                ->orLike('name', $wheres['searchValue']);
                  break;
            }
        }

        if (isset($wheres['columnName']) && isset($wheres['columnSortOrder'])) {
            // orderby
            $fieldOrder = array(
                'id'        => 'id',
                'nama'      => 'last_name',
                'username'  => 'username',
                'bidang'    => 'name',
                'kategori'  => 'name'
            );
            $query = $builder->orderBy($fieldOrder[$wheres['columnName']], $wheres['columnSortOrder']);
        }
        
        if (isset($wheres['rowperpage']) && isset($wheres['start'])) {
            $query = $builder->limit($wheres['rowperpage'], $wheres['start']);
        }

        if ($returnData) {
            $query = $builder->get();
            // var_dump($this->db->getLastQuery());exit();
            return $query->getResult();
        } else 
            return $builder->countAllResults();
    }

    public function getUserById($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odm_user');
        
        $query = $builder->where('id', $id)->get();
        // var_dump($this->db->getLastQuery());exit();
        if (count($query->getResult()) > 0)
            return $query->getRowArray();
        else 
            return '';
           
    }

    public function getUserInDept($dept_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odm_user');
        
        $query = $builder->select('id, username, last_name, first_name')
                         ->where('department', $dept_id)->get();
        
        if (count($query->getResult()) > 0)
            return $query->getResultArray();
        else 
            return '';
           
    }

    public function getBidangById($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odm_department');
        
        $query = $builder->where('id', $id)->get();

        if (count($query->getResult()) > 0)
            return $query->getRowArray();
        else 
            return '';
           
    }

    public function getKategoriById($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odm_category');
        
        $query = $builder->where('id', $id)->get();
        
        if (count($query->getResult()) > 0)
            return $query->getRowArray();
        else 
            return '';
           
    }

    public function getDataByKategoriId($cat_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odm_data');
        
        $query = $builder->select('id, realname')
                         ->where('category', $cat_id)->get();
        
        if (count($query->getResult()) > 0)
            return $query->getResultArray();
        else 
            return '';
           
    }

}   