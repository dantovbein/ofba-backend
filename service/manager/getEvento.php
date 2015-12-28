<?php
	header('Access-Control-Allow-Origin: *');
	require_once "../Storage.php";
	
	$uidEvento = (isset($_GET['uidEvento'])) ? $_GET['uidEvento'] : "";

	$data = array(
    	"uidEvento" => $uidEvento
    );

	$storage = new Storage();
	echo $storage->getEvento($data);
?>