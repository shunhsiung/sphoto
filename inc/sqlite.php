<?php
	$dsn = sprintf("%s:%s",$database['type'],$database['host']);
	try {
		$conn = new PDO($dsn);
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo $e->getMessage();
		die();
	}


function hsql_query($conn,$sql , $params = array()) {
	$sql = preg_replace("/\?/","__DATA__",$sql);
	
	foreach( $params as $p) {
		$p = preg_replace("/'/","&#39;",$p);
		$sql = preg_replace("/__DATA__/","'$p'",$sql,1);
	}
	
	return $conn->query($sql);
}

function hsql_fetch_data($res) {
	return $res->fetch( PDO::FETCH_ASSOC);
}
?>
