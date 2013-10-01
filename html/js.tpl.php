<?php
/**
 * @file
 * @brief Javascript 載入
 * @author Eric Shih <shunhsiung@gmail.com>
 */

/// @cond
?>
    <!--[if lt IE 7]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <!--[if lt IE 9]>
      <script src="bower_components/es5-shim/es5-shim.js"></script>
      <script src="bower_components/json3/lib/json3.min.js"></script>
    <![endif]-->
	<script src="bower_components/jquery/jquery.js"></script>
	<script src="bower_components/angular/angular.js"></script>
	<script src='bower_components/angular-bootstrap/ui-bootstrap-tpls.js'></script>	
	<script src="scripts/comm.js"></script>
<!--
	<script src='scripts/lib.js' type="text/javascript"></script>
-->
<?php
foreach($js_files as $js_item )
    {
?>
	<script src='scripts/<?php echo $js_item ?>' type="text/javascript"></script>
<?php
}
?>
	<div id="fb-root"></div>
	<script >(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/zh_TW/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
