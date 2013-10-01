<body ng-app='myapp'>
<?php
	include('tpl/menu.tpl.php');
?>
<div class='container-fluid'>
<?php 
	debug_print($debug);
	foreach ($tpl_files as $k) {
		include(sprintf("tpl/%s",$k));
	}
?>
</div>
<!--
<div class='navbar navbar-fixed-bottom'>
	<span class='pull-right'><?php echo $_SERVER['REMOTE_ADDR']; ?></span>
</div>
-->
<?php include('html/js.tpl.php'); ?>
</body>
