<?php
	header('Access-Control-Allow-Origin: *');
	require_once "../Storage.php";
	
	if(isset($_GET['id'])) { $id = $_GET['id']; }

	if($id == "") {
		echo "Se debe setear el id";
	} else {
		$data = array(
    		"id" => $id
    	);
	
		$storage = new Storage();
		echo $storage->deleteImagen($data);
	}	
?>