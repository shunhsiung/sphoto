<?php
/**
 * @file
 * 初始環境
 * @brief 初始環境建立
 * @author Eric Shih <shunhsiung@gmail.com>
*/

session_start();
require_once('inc/myset.php');
require_once('inc/sqlite.php');
require_once('inc/myfunc.php');
require_once('inc/sql.php');

hsql_query($conn,$db_option_table);

/// @cond
//if ($config['debug']) {
    ini_set('display_errors','1');
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_STRICT );
//} else {
//	ini_set('display_errors','0');
//}

//hsql_query($conn,$db_option_table);

date_default_timezone_set('Asia/Taipei');

$actfile = end(preg_split('/\//',$_SERVER['SCRIPT_NAME']));

$debug = array();
?>
