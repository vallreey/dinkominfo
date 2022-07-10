<?php

if (!function_exists('getDeptRights')) {
	function getDeptRights($fid, $dept_id) {	
        $db = \Config\Database::connect();
        $builder = $db->table('odm_dept_perms');
        
        $query = $builder->where('fid', $fid)->where('dept_id', $dept_id)->get();
                
        if (count($query->getResult()) > 0)
            return $query->getRow()->rights;
        else 
            return '';
	}
}

if (!function_exists('getUserRights')) {
	function getUserRights($uid, $fid) {	
        $db = \Config\Database::connect();
        $builder = $db->table('odm_user_perms');
        
        $query = $builder->where('uid', $uid)->where('fid', $fid)->get();
        
        if (count($query->getResult()) > 0)
            return $query->getRow()->rights;
        else 
            return '';
	}
}

if (!function_exists('settingVal')) {
	function settingVal($name) {	
        $db = \Config\Database::connect();
        $builder = $db->table('odm_settings');
        
        $query = $builder->where('name', trim($name))->get();
        
        if (count($query->getResult()) > 0)
            return $query->getRow()->value;
        else 
            return '';
	}
}

if (!function_exists('displayFileSize')) {
    function displayFileSize($file) {
        // Does the file exist?
        if (is_file($file)) {

            //Setup some common file size measurements.
            $kb = 1024;
            $mb = 1048576;
            $gb = 1073741824;
            $tb = 1099511627776;

            //Get the file size in bytes.
            $size = filesize($file);

            //Format file size

            if ($size < $kb) {
                return $size . " B";
            } elseif ($size < $mb) {
                return round($size / $kb, 2) . " KB";
            } elseif ($size < $gb) {
                return round($size / $mb, 2) . " MB";
            } elseif ($size < $tb) {
                return round($size / $gb, 2) . " GB";
            } else {
                return round($size / $tb, 2) . " TB";
            }
        } else {
            return "X";
        }
    }
}

if (!function_exists('getFileSizeByFileId')) {
    function getFileSizeByFileId($fid, $dirType = null) {
        $path = WRITEPATH . 'uploads/' . config('MyConfig')->setting('dataDir');
        switch ($dirType) {
            case "archive": $path = $path .= '/archiveDir/' . $fid . '.dat'; break;
            case "revision": $path = $path .= '/revisionDir/' . $fid . '.dat'; break;
            default: $path = $path .= '/' . $fid . '.dat';
        }
        return displayFileSize($path);
    }
}

if (!function_exists('userRights')) {
    function userRights($rights) {
        switch ($rights) {
            case 'none':
                $arrPermission = array('rights'=> 0, 'desc'  => 'NONE_RIGHT', 'code'  => 'x');
                break;
            case 'view':
                $arrPermission = array('rights'=> 1, 'desc'  => 'VIEW_RIGHT', 'code'  => 'v');
                break;
            case 'read':
                $arrPermission = array('rights'=> 2, 'desc'  => 'READ_RIGHT', 'code'  => 'r');
                break;
            case 'write':
                $arrPermission = array('rights'=> 3, 'desc'  => 'WRITE_RIGHT', 'code'  => 'w');
                break;
            case 'admin':
                $arrPermission = array('rights'=> 4, 'desc'  => 'ADMIN_RIGHT', 'code'  => 'a');
                break;
            default:
            # code...
            break;
        }
        return $arrPermission;
    }
}

if (!function_exists('publishableByStatus')) {
    function publishableByStatus($status) {
        switch ($status) {
            case 'approved': $publishable = 1; break;
            case 'onreview': $publishable = 0; break;
            case 'rejected': $publishable = -1; break;
            case 'deleted': $publishable = 2; break;
            default: $publishable = ''; break;
        }
        return $publishable;
    }
}

?>