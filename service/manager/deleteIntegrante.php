<?php
	header('Access-Control-Allow-Origin: *');
	require_once "../Storage.php";
	if(isset($_GET['id'])) { $id = $_GET['id']; }
	$data = array(
    	"id" => $id
    );
	$storage = new Storage();
	echo $storage->deleteIntegrante($data);
?>