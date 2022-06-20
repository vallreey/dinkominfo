<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class UserModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $db = \Config\Database::connect();
        $builder = $db->table('odm_user');
        // OR $this->db = db_connect();
    }

    public function checkAccount($data = array())
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odm_user');
        $query = $builder->where('username', $data['username'])
                ->where('password', md5($data['password']))        
                ->limit(1)->get();

        return $query->getResult();
    }

    public function allUsers()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odm_user');
        $query = $builder->orderBy('last_name', 'asc')->get();

        return $query->getResult();
    }

    public function getUserDetail($uid)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odm_user u');
        
        $query = $builder->select('u.*, d.name as dept_name')
                        ->join('odm_department d', 'u.department = d.id')
                        ->where('u.id', $uid)->get();
        
        if (count($query->getResult()) > 0)
            return $query->getRowArray();
        else 
            return '';
    }
}   