<?php
	header('Access-Control-Allow-Origin: *');
	require_once "../Storage.php";
	$storage = new Storage();
	echo $storage->getTiposIntegrante();
?>