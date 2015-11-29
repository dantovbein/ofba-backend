<?php
	header('Access-Control-Allow-Origin: *');
	require_once "../Storage.php";
	
	if(isset($_GET['codigo'])) { $codigo = $_GET['codigo']; }

	$storage = new Storage();
	echo $storage->getTexto($codigo);
?>