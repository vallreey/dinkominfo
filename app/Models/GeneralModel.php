<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class GeneralModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $db = \Config\Database::connect();
        $builder = $db->table('odm_user');
    }

    public function getRowData($table, $wheres = array(), $obj = false, $select = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odm_'.$table);
        
        if (!is_null($select))
            $query = $builder->select($select);

        if (count($wheres) > 0)
            $query = $builder->where($wheres);

        $query = $builder->get();

        if (count($query->getResult()) > 0) {
             if ($obj) return $query->getRow();
             else return $query->getRowArray();
        } else return '';
    }

    public function getResultData($table, $wheres = array(), $obj = false, $select = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odm_'.$table);
        
        if (!is_null($select))
            $query = $builder->select($select);

        if (count($wheres) > 0)
            $query = $builder->where($wheres);

        $query = $builder->get();

        if (count($query->getResult()) > 0) {
            if ($obj) return $query->getResult();
            else return $query->getResultArray();
        } else return '';
    }

    public function insertData($table, $datas, $returnID = false)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odm_'.$table);
        
        $builder->insert($datas);

        if ($db->affectedRows() > 0) {
            if ($returnID) return $db->insertID();
            else return true;
        } else return false;
    }

    public function updateData($table, $wheres, $datas)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odm_'.$table);
        
        $builder->where($wheres)->update($datas);

        if ($db->affectedRows() >= 0)
            return true;
        else 
            return false;
    }
    
    public function deleteData($table, $wheres)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odm_'.$table);
        
        $builder->where($wheres)->delete();

        if ($db->affectedRows() >= 0)
            return true;
        else 
            return false;
    }

    public function insertBatchData($table, $datas)
    {
        $db = \Config\Database::connect();
        
        $db->transBegin();
        $builder = $db->table('odm_'.$table);
        
        $builder->insertBatch($datas);

        if ($db->transStatus() === false) {
            $db->transRollback();
            return false;
        } else {
            $db->transCommit();
            return true;
        }
    }

}   