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

        if ($table == 'accesslog') {
            $builder = $db->table('odm_access_log a');

            $query = $builder->select('a.*, d.realname, u.username')
                            ->join('odm_data d', 'a.file_id = d.id')
                            ->join('odm_user u', 'a.user_id = u.id');
        } elseif ($table == 'filelistexport') {
            $builder = $db->table('odm_data d');

            $query = $builder->select("d.realname, d.description, d.publishable, d.status, d.id, u.username, l.revision,
                                    CASE WHEN d.publishable = -1 THEN 'Rejecteds'
                                         WHEN d.publishable = 0 THEN 'Un-approved'
                                         WHEN d.publishable = 1 THEN 'Active'
                                         WHEN d.publishable = 2 THEN 'Archived'
                                        WHEN d.publishable = -2 THEN 'Deleted'
                                    END AS publishing_status,
                                    CASE WHEN d.status = 1 THEN 'Checked Out'
                                         WHEN d.status = 0 THEN 'Not Checked Out'
                                    END AS checkout_status", false)
                            ->join('odm_user u', 'u.id = d.owner', 'left')
                            ->join('odm_log l', 'l.id = d.id', 'left');
        } else {
            $builder = $db->table('odm_'.$table);
        }

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
                case 'filetypes':
                    $query = $builder->orLike('id', $wheres['searchValue'])
                                    ->orLike('type', $wheres['searchValue']);
                    break;
                case 'accesslog':
                    $query = $builder->orLike('file_id', $wheres['searchValue'])
                                    ->orLike('realname', $wheres['searchValue'])
                                    ->orLike('username', $wheres['searchValue'])
                                    ->orLike('timestamp', $wheres['searchValue'])
                                    ->orLike('action', $wheres['searchValue']);
                    break;
                case 'filelistexport':
                    $query = $builder->orLike('realname', $wheres['searchValue'])
                                    ->orLike('description', $wheres['searchValue'])
                                    ->orLike('publishable', $wheres['searchValue'])
                                    ->orLike('status', $wheres['searchValue'])
                                    ->orLike('d.id', $wheres['searchValue'])
                                    ->orLike('username', $wheres['searchValue'])
                                    ->orLike('revision', $wheres['searchValue']);
                                    // ->orLike('publishing_status', $wheres['searchValue'])
                                    // ->orLike('checkout_status', $wheres['searchValue']);
                    break;
            }
        }

        if (isset($wheres['columnName']) && isset($wheres['columnSortOrder'])) {
            // orderby
            $fieldOrder = array(
                'nama'      => 'last_name',
                'bidang'    => 'name',
                'kategori'  => 'name',
            );
            $field = in_array($wheres['columnName'], $fieldOrder) ? $fieldOrder[$wheres['columnName']] : $wheres['columnName'];
            $query = $builder->orderBy($field, $wheres['columnSortOrder']);
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

}   