<?php

if (!function_exists('isAdmin')) {
	function isAdmin($id) {	
		$db = \Config\Database::connect();
    $builder = $db->table('odm_admin');
    
    $query = $builder->where('id', $id)->where('admin', 1);
            
    if ($query->countAllResults() > 0)
      return true;
    else
      return false;
	}
}

if (!function_exists('canAdd')) {
	function canAdd($id) {	
    if (isAdmin($id))
      return true;

		$db = \Config\Database::connect();
    $builder = $db->table('odm_user');
    
    $query = $builder->where('id', $id)->where('can_add', 1);
            
    if ($query->countAllResults() > 0)
      return true;
    else 
      return false;
	}
}

if (!function_exists('canCheckIn')) {
	function canCheckIn($id) {	
    if (isAdmin($id))
      return true;

		$db = \Config\Database::connect();
    $builder = $db->table('odm_user');
    
    $query = $builder->where('id', $id)->where('can_checkin', 1);
            
    if ($query->countAllResults() > 0)
      return true;
    else 
      return false;
	}
}

if (!function_exists('isReviewer')) {
	function isReviewer($id) {	
    if (isAdmin($id))
      return true;

		$db = \Config\Database::connect();
    $builder = $db->table('odm_dept_reviewer');
    
    $query = $builder->where('user_id', $id);
            
    if ($query->countAllResults() > 0)
      return true;
    else 
      return false;
	}
}

if (!function_exists('getDeptName')) {
	function getDeptName($id) {	
    $db = \Config\Database::connect();
    $builder = $db->table('odm_user u');
    
    $query = $builder->select('d.name as dept_name')
                    ->join('odm_department d', 'u.department = d.id')
                    ->where('u.id', $id)->get();
            
    return $query->getRow()->dept_name;
	}
}

?>