<?php
	header('Access-Control-Allow-Origin: *');

	require_once "../Storage.php";
	
	if(isset($_GET['texto'])) { $texto = $_GET['texto']; }
	if(isset($_GET['codigoTexto'])) { $codigoTexto = $_GET['codigoTexto']; }
	
	$data = array(
    	"texto" => $texto,
    	"codigoTexto" => $codigoTexto 
    );
	
	$storage = new Storage();
	echo $storage->editTexto($data);
?>