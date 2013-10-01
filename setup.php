<?php
include('first.php');

$js_files = array("setup.js");

$tpl_files = array("setup.tpl.php");

set_option_value($conn,"test","1");
$data = array();
$data['pd'] = get_option_value($conn,"photo_directory");
$data['fai'] = get_option_value($conn,"facebook_app_id");

if (strlen($data['pd']) == 0 ) {
	$data['pd'] = 'Multimedia';
}
//$data['fas'] = get_option_value($conn,"facebook_app_secret");

include ('html/html.tpl.php');
include ('db_close.php');
?>
