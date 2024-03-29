<?php


include_once('mimetypes.php');

if(!function_exists('getFileSuffix')){
    function getFileSufix($realname) {
        // Get the suffix of the file so we can look it up
        // in the $mimetypes array
        if (strchr($realname, '.')) {
            // Fix by blackwes
            $prefix = (substr($realname, 0, (strrpos($realname, "."))));
            $suffix = strtolower((substr($realname, ((strrpos($realname, ".")+1)))));
            return $suffix;
        }
        return '';
    } 
}

if(!function_exists('getMimeTypeByFileRealName')){
    function getMimeTypeByFileRealName($realname) {
        return $GLOBALS['mimetypes'][getFileSufix($realname)][0];
    } 
}

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
            return "0 B";
        }
    }
}

if (!function_exists('getFilePathByFileId')) {
    function getFilePathByFileId($fid, $dir = "dataDir") {
        if(!in_array($dir, array("dataDir", "archiveDir", "revisionDir"))) return '';

        return config('MyConfig')->settings[$dir] . $fid . '.dat';
    }
}

if (!function_exists('getFileSizeByFileId')) {
    function getFileSizeByFileId($fid, $dir = "dataDir") {
        return displayFileSize(getFilePathByFileId($fid, $dir));
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

if (!function_exists('fmove')) {
    function fmove($source_file, $destination_file)
    {
        //read and close
        $fhandler = fopen($source_file, "r");
        $fcontent = fread($fhandler, filesize($source_file));
        fclose($fhandler);
        //write and close
        $fhandler = fopen($destination_file, "w");
        fwrite($fhandler, $fcontent);
        fclose($fhandler);
        //delete source file
        unlink($source_file);
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

if (!function_exists('getAuthority')) {
    function getAuthority($uid, $fid, $dept_id) {
        if (isAdmin($uid) || isReviewer($uid))
        return userRights('admin');
        
        if (isOwner($uid, $fid) && isLockedFile($fid))
        return userRights('write');

        $userPermission = getUserRights($uid, $fid);
        $deptPermission = getDeptRights($fid, $dept_id);
        if ($userPermission >= 0 && $userPermission <= 4)
            return $userPermission;
        else 
            return $deptPermission;
    }
}

?>