<?php
function gen_ng_info ( $conn, $pd , $root = "/share/HDA_DATA/" ) {
	
	$basedir = sprintf("%s%s",$root, $pd);

	if (preg_match("/\.\.$/",$basedir)) {
		$b_a = preg_split("/\//",$basedir);
		array_pop($b_a);
		array_pop($b_a);
		$basedir = implode("/",$b_a);
	}

	$image_base_dir = str_replace("/share/HDA_DATA/","",$basedir);

	$dir_a = scan_directory($basedir , true);

	$file_list = gen_dir_list($dir_a);

	$image_list = get_image_list($file_list['files'],$basedir);

	$ng_dir_list = gen_nglist($file_list['directorys']);	

//	$ng_file_list = gen_nglist_object($image_list);
	$ng_file_list = gen_nglist($image_list);

	$root_dir = sprintf("%s/%s$",$root,get_option_value($conn,"photo_directory"));

	$up_show = (strcmp($root_dir,$basedir)) ? true : false;

	return array($image_base_dir , $ng_dir_list , $ng_file_list, $up_show);	
}

function gen_nglist_object ( $f_a ) {
	$f1 = array();
	foreach ($f_a as $f) {
		$f2 = array();
		foreach ($f as $k => $v) {
			array_push($f2 , sprintf("%s : '%s'",$k , $v));
		}				
		array_push($f1 , sprintf("{%s}", implode(",",$f2)));	
	}	

	return sprintf("[%s]",implode(",",$f1));
}

function gen_dir_list ( $dir_a ) {
	$f_a = array();
	$d_a = array();

	foreach ($dir_a as $d) {
		if (is_array($d)) {
			$f_a = $d;
		} else {
			array_push($d_a,$d);
		}
	}

	return array('directorys' => $d_a, 'files' => $f_a);
}

function get_image_list ( $file_a , $base_dir) {
	$image_a = array();

	foreach ($file_a as $a) {
		$t_f = sprintf("%s/%s",$base_dir,$a);
		$info = get_image_file($t_f, false);
//		if (is_array($info)) {
		if ($info) {
			array_push($image_a ,$info);
		}
	}

	return $image_a;
}

function get_image_file ( $file , $multi = true) {
	$t = getimagesize($file);
	if ($t) {
		$size = filesize($file);

		if ($multi) {
			$info = array(
				'name' => basename($file),
				'size' => $size,
				'mine' => $t['mime'],
				'width' => $t[0],
				'height' => $t[1],
			);			
		} else {
			$info = basename($file);
		}
	}

	return $info;
}

function get_image_info ( $file ) {

	$atime = fileatime($file);
	$ctime = filectime($file);
	$mtime = filemtime($file);

	if (function_exists('exif_read_data')) {
		$t = @exif_read_data($file);
		if ($t) {
			$info = array(
				'name' => $t['FileName'],
				'size' => $t['FileSize'],
				'ctime' => $ctime,
				'atime' => $atime,
				'mtime' => $mtime,
				'mine' => $t['MimeType'],
				'comment' => $t['COMMENT'],
				'width' => $t['COMPUTED']['Width'],
				'height' => $t['COMPUTED']['Height'],
					);			
		}	
	} 

	if (!$t) {
		$t = getimagesize($file);
		if ($t) {
			$size = filesize($file);

			$info = array(
				'name' => basename($file),
				'size' => $size,
				'ctime' => $ctime,
				'atime' => $atime,
				'mtime' => $mtime,
				'mine' => $t['mime'],
				'comment' => '',
				'width' => $t[0],
				'height' => $t[1],
					);			
		}
	}

	return $info;
}

function isactive ( $this_actfile ) 
{
	global $actfile;	
	return (preg_match("/$this_actfile/",$actfile)) ? "active" : "";
}

function gen_ins_sql( $tb_name , $f_a )
{

    $t1 = implode(",",$f_a);
    $t2 = substr(str_repeat(" ? ,",sizeof($f_a)),0,sizeof($f_a)*4-1);

    $sql = sprintf("INSERT INTO %s ( %s ) VALUES ( %s )",$tb_name , $t1 , $t2);

    return $sql;
}

function gen_update_sql( $tb_name , $f_a , $f_a2 = "")
{
    $t1 = "";
    foreach ($f_a as $item) {
        $t1 .= sprintf(" %s = ? ," , $item);
    }

    $t1 = substr($t1 , 0 , strlen($t1) -1 );

    foreach ($f_a2 as $item ) {
        $t2 .= sprintf(" %s = ? and", $item);
    }

    $t2 = substr($t2, 0, strlen($t2) -3 );
    $where_ = (strlen($t2) > 0 ) ? sprintf("WHERE %s",$t2) : "";

    $sql = sprintf("UPDATE %s SET %s %s" , $tb_name , $t1 , $where_);
    return $sql;
}

function set_option_value ( $conn, $key , $value , $value2 = "" ) {
	$tb_name = "option";
	$f_a = array("value","value2");
	$f_a2 = array("key_");
	$params = array($value, $value2,$key);

	$update_sql = gen_update_sql($tb_name,$f_a,$f_a2);

	$res = hsql_fetch_data(hsql_query($conn,$update_sql,$params));

	if (!$res) {
		$insert_sql = gen_ins_sql ($tb_name, array_merge($f_a,$f_a2));
		hsql_query($conn,$insert_sql, $params);
	}
}

function get_option_value ($conn, $key, $arr = false) {
	$sql = "select * from option where key_ = '$key'";	
	$res = hsql_fetch_data(hsql_query($conn,$sql));	

	if ($array) {
		return array($res['value'],$res['value2']);
	} else {
		return $res['value'];
	}
	
}

function add_debug ( $v ) {
	global $debug;
	array_push($debug,var_export($v,true));	
}

function debug_print ($d_a ) {
	foreach ($d_a as $d) {
		printf("<div class='alert alert-danger small'>%s</div>",$d);
	}
}

function gen_nglist ($n_a ) {
	$str = "";
	foreach ($n_a as $n) {
		$str .= sprintf("'%s',",$n); 
	}
	$str = sprintf("[%s]",substr($str,0,-1));

	return $str;
}

function scan_directory ( $bdir , $sfile = false , $recursive = false ) {
	$d_r = array();

	$dir = scandir($bdir);

	foreach ($dir as $d) {
		if (!preg_match("/^\./",$d)) {

			if (is_dir(sprintf("%s/%s",$bdir,$d))) {
				array_push($d_r,$d );	
				if ( $recursive ) {
					array_push($d_r,scan_directory( sprintf("%s/%s",$bdir,$d)));
				}
			} 

			if ($sfile) { 
				if (is_file(sprintf("%s/%s",$bdir,$d))) {
					if (!is_array($d_r["files"])) {
						$d_r['files'] = array();
					}
					array_push($d_r["files"],$d);
				}
			}

		}
	}

	return $d_r;
}

function file2str ( $file_name )
{
    $fp = fopen($file_name, "r");
    $contents = fread($fp,filesize($file_name));
    fclose($fp);
    return $contents;
}

function myrequest ( $str_ , $max_ = -1)
{
    $t = isset($_POST[$str_]) ? $_POST[$str_] : $_GET[$str_];

    $t = (!get_magic_quotes_gpc()) ? addslashes($t) : $t;

    $t = trim($t);

    if (strlen($t) > 0 ) {
        $t = htmlspecialchars($t);
        if ( $max_ > 0 ) {
            $t = substr($t,0,$max_);
        }
    }

    return $t;
}

function myrequestm ( $str_ )
{
    return isset($_POST[$str_]) ? $_POST[$str_] : $_GET[$str_];
}

function myrequestma ( $str_ )
{
    $t = myrequestm ($str_);
    return is_array($t) ? implode(",", $t) : $t;
}

function mynumeric ( $str_ )
{
    return (is_numeric($str_)) ? intval($str_) : 0;
}

function mydate ( $str_ )
{
    $str_ = preg_replace("/\//","-",$str_);

    $date_t = preg_split("/-/",$str_);

    if (sizeof($date_t) == 3) {
        list($yyyy,$mm,$dd) = $date_t;
        if (checkdate($mm,$dd,$yyyy) ) {
            return strftime("%Y-%m-%d", strtotime($str_));
        }
    }

    return date("Y-m-d");
}

function iszero( $str_ )
{
	return (strlen(trim($str_)) > 0) ? false : true;
}

function isempty( $str_ ) 
{
	return isset($str_) ? false : true;
}
?>
