<?php
	header('Access-Control-Allow-Origin: *');
	
	require_once "../Storage.php";	
	
	if(isset($_GET['path'])) { $path = $_GET['path']; }
	if(isset($_GET['texto'])) { $texto = $_GET['texto']; }
	//if(isset($_GET['codigoTexto'])) { $codigoTexto = $_GET['codigoTexto']; }
	if(isset($_GET['orden'])) { $orden = $_GET['orden']; }
	
	$data = array(
    	"path" => $path,
    	"texto" => $texto,
    	//"codigoTexto" => $codigoTexto,
    	"orden" => $orden
    );

	$storage = new Storage();
	echo $storage->postImagen($data);
?>