<?php
include('first.php');

//date_default_timezone_set('Asia/Taipei');
header('Content-type: text/html; charset=utf-8');

//if ( $config['debug'] ) {
//    ini_set('display_errors',1);
//    error_reporting(E_ALL ^ E_NOTICE);
//}

$op = myrequest("op");
$json_m = array("success" => false, "json" => true , "func" => "", "msg" => "", "url" => "");

switch($op) {
	case "upload_facebook":
		$json_m = upload_facebook ($conn,$json_m);
		break;
	case "get_image":
		$json_m = get_image($conn,$json_m);
		break;
	case "change_dir":
		$json_m = change_dir ($conn, $json_m );
		break;
	case "save_option":
		$json_m = save_option ($conn,$json_m);
		break;
}

if ($json_m['json']) {
    echo json_encode($json_m);
} else {
    showmessage ($json_m['msg'] , $json_m['url']);
}

require_once('db_close.php');

function upload_facebook($conn,$j_m , $root = "/share/HDA_DATA/") {
	$access_token = myrequest('access_token');
	$image = myrequest("image");
	$fid = myrequest("fid");
	$message = myrequest("message");
	
	$post_url = sprintf("https://graph.facebook.com/%s/photos",$fid);

	$data = array(
		"access_token" => $access_token,
        "source" => "@".realpath($image),
        "message"=> $message 
    );

	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $post_url );
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 

    $response = curl_exec($ch);

	$j_m['success'] = $response;

	return $j_m;
}

function get_image ( $conn, $j_m, $root = "/share/HDA_DATA/") {
	$basedir = myrequest("basedir");
	$image = myrequest("image");

	$file_path = sprintf("%s/%s/%s",$root,$basedir,$image);

	$info = get_image_info( $file_path );	

	$show_info = "";
	if ($info) {
		$show_info = sprintf("檔名：%s::大小：%s KB::圖寬：%spx::圖高：%spx::建立時間：%s",$info['name'],number_format($info['size']/1024),$info['width'],$info['height'],strftime("%Y-%m-%d",$info['ctime']));
		
	}	

	$j_m['show_info'] = $show_info;

	$j_m['success'] = true;


	return $j_m;
}
function change_dir ($conn, $j_m ) {

	$up_dir = myrequest("up_dir");

	$dir = myrequest("basedir");

	list($image_base_dir , $ng_dir_list , $ng_file_list , $up_show) = gen_ng_info($conn, sprintf("%s/%s",$up_dir,$dir) );

	$ndl = preg_replace('/\'/',"",substr($ng_dir_list,1,-1));
	$nfl = preg_replace('/\'/',"",substr($ng_file_list,1,-1));

	
	$j_m['ibd'] = $image_base_dir;
	$j_m['ndl'] = $ndl;
	$j_m['nfl'] = $nfl;
	$j_m['up_show'] = $up_show;

	$j_m['success'] = true;

	return $j_m;
}

function save_option ( $conn , $j_m) {
	$pd = myrequest("pd");
	$fai = myrequest("fai");
//	$fas = myrequest("fas");

	$err_msg = "";	

	$err_msg .= (iszero($pd)) ? "請輸入相片目錄!!\n" : "";
	$err_msg .= (iszero($fai)) ? "請輸入Facebook App ID!!\n" : "";
//	$err_msg .= (iszero($fas)) ? "請輸入Facebook App Secret!!\n" : "";

	$j_m['err_msg'] = $err_msg;

	if (!iszero($err_msg)) {
		$j_m['msg'] = $err_msg;
		return $j_m;
	}

	set_option_value($conn,"photo_directory", $pd);
	set_option_value($conn,"facebook_app_id", $fai);
//	set_option_value($conn,"facebook_app_secret", $fas);

	$j_m['success'] = true;
	$j_m['msg'] = '資料儲存成功';
	$j_m['url'] = 'index.php';

	return $j_m;
}
?>
