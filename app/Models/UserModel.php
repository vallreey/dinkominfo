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
}   