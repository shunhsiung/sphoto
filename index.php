<?php
include('first.php');

$js_files = array("index.js");

$pd = get_option_value($conn,"photo_directory");
$fai = get_option_value($conn,"facebook_app_id");

if (strlen($pd) < 1 or strlen($fai)  < 15 ) {
	header('Location: setup.php');
}

list($image_base_dir , $ng_dir_list , $ng_file_list, $up_show ) = gen_ng_info( $conn , $pd );

/*
$pd = get_option_value($conn,"photo_directory");

$basedir = sprintf("/share/HDA_DATA/%s",$pd);

$image_base_dir = str_replace("/share/HDA_DATA/","",$basedir);

$dir_a = scan_directory($basedir, true );

$file_list = gen_dir_list ($dir_a);

$image_list = get_image_list($file_list['files'], $basedir);

$ng_dir_list = gen_nglist($dir_list);

$ng_file_list = gen_nglist_object($image_list);

*/

$ng_init_data = sprintf("image_base_dir='%s'",$image_base_dir);

$tpl_files = array("index.tpl.php");

include ('html/html.tpl.php');
?>
