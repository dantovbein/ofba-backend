<?php
	header('Access-Control-Allow-Origin: *');
	require_once "../Storage.php";
	
	$uidEvento = (isset($_GET['uidEvento'])) ? $_GET['uidEvento'] : "";
	
	if($uidEvento==""){
		echo "Se debe setear el uidEvento";
	} else {
		$storage = new Storage();
		echo $storage->deleteEvento($uidEvento);
	}	
?>