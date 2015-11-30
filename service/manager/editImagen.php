<?php
	header('Access-Control-Allow-Origin: *');

	require_once "../Storage.php";
	
	if(isset($_GET['id'])) { $id = $_GET['id']; }
	if(isset($_GET['orden'])) { $orden = $_GET['orden']; }
	if(isset($_GET['path'])) { $path = $_GET['path']; }
	if(isset($_GET['texto'])) { $texto = $_GET['texto']; }
	if(isset($_GET['codigoTexto'])) { $codigoTexto = $_GET['codigoTexto']; }
	
	$data = array(
    	"id" => $id,
    	"orden" => $orden,
    	"path" => $path,
    	"texto" => $texto,
    	"codigoTexto" => $codigoTexto 
    );
	
	$storage = new Storage();
	echo $storage->editImagen($data);
?>