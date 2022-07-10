<?php

if (!function_exists('isAdmin')) {
	function isAdmin($uid) {	
		$db = \Config\Database::connect();
    $builder = $db->table('odm_admin');
    
    $query = $builder->where('id', $uid)->where('admin', 1);
            
    if ($query->countAllResults() > 0)
      return true;
    else
      return false;
	}
}

if (!function_exists('canAdd')) {
	function canAdd($uid) {	
    if (isAdmin($uid))
      return true;

		$db = \Config\Database::connect();
    $builder = $db->table('odm_user');
    
    $query = $builder->where('id', $uid)->where('can_add', 1);
            
    if ($query->countAllResults() > 0)
      return true;
    else 
      return false;
	}
}

if (!function_exists('canCheckIn')) {
	function canCheckIn($uid) {	
    if (isAdmin($uid))
      return true;

		$db = \Config\Database::connect();
    $builder = $db->table('odm_user');
    
    $query = $builder->where('id', $uid)->where('can_checkin', 1);
            
    if ($query->countAllResults() > 0)
      return true;
    else 
      return false;
	}
}

if (!function_exists('isReviewer')) {
	function isReviewer($uid) {	
    if (isAdmin($uid))
      return true;

		$db = \Config\Database::connect();
    $builder = $db->table('odm_dept_reviewer');
    
    $query = $builder->where('user_id', $uid);
            
    if ($query->countAllResults() > 0)
      return true;
    else 
      return false;
	}
}

if (!function_exists('isOwner')) {
	function isOwner($uid, $fid) {	
		$db = \Config\Database::connect();
    $builder = $db->table('odm_data');
    
    $query = $builder->where('id', $fid)->where('owner', $uid);
            
    if ($query->countAllResults() > 0)
      return true;
    else
      return false;
	}
}

if (!function_exists('isLockedFile')) {
	function isLockedFile($fid) {	
		$db = \Config\Database::connect();
    $builder = $db->table('odm_data');
    
    $query = $builder->where('id', $fid)->where('status', '-1');
            
    if ($query->countAllResults() > 0)
      return true;
    else
      return false;
	}
}

if (!function_exists('getDeptName')) {
	function getDeptName($uid) {	
    $db = \Config\Database::connect();
    $builder = $db->table('odm_user u');
    
    $query = $builder->select('d.name as dept_name')
                    ->join('odm_department d', 'u.department = d.id')
                    ->where('u.id', $uid)->get();
            
    return $query->getRow()->dept_name;
	}
}

if (!function_exists('isReviewerForFile')) {
  function isReviewerForFile($fid, $uid) {
    $db = \Config\Database::connect();
    $builder = $db->table('odm_data d');
    
    $query = $builder->join('odm_dept_reviewer d', 'r.dept_id = d.department')
                    ->where('d.id', $fid)
                    ->where('r.user_id', $uid);
            
    if ($query->countAllResults() > 0)
      return true;
    else 
      return false;
  }
}

if (!function_exists('actionParam')) {
  function actionParam($action) {
      switch ($action) {
          case 'A': $accesslog = 'File Added'; break;
          case 'B': 
          case 'C': $accesslog = 'Reserved'; break;
          case 'V': $accesslog = 'File Viewed'; break;
          case 'D': $accesslog = 'File Downloaded'; break;
          case 'M': $accesslog = 'File Modified'; break;
          case 'I': $accesslog = 'File Checked-in'; break;
          case 'O': $accesslog = 'File Checked-out'; break;
          case 'X': $accesslog = 'File Temporary Deleted'; break;
          case 'P': $accesslog = 'File Permanently Deleted'; break;
          case 'U': $accesslog = 'File Undeleted'; break;
          case 'Y': $accesslog = 'File Authorized'; break;
          case 'R': $accesslog = 'File Rejected'; break;
          default: $accesslog = ''; break;
      }
      return $accesslog;
  }
}

?>