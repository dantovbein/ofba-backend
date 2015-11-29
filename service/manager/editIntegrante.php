<?php
	header('Access-Control-Allow-Origin: *');

	require_once "../Storage.php";
	
	if(isset($_GET['id'])) { $id = $_GET['id']; }
	if(isset($_GET['nombres'])) { $nombres = $_GET['nombres']; }
	if(isset($_GET['apellidos'])) { $apellidos = $_GET['apellidos']; }
	if(isset($_GET['idInstrumento'])) { $idInstrumento = $_GET['idInstrumento']; }
	if(isset($_GET['idNacionalidad'])) { $idNacionalidad = $_GET['idNacionalidad']; }
	if(isset($_GET['idTipoDirector'])) { $idTipoDirector = $_GET['idTipoDirector']; }
	if(isset($_GET['idTipoIntegrante'])) { $idTipoIntegrante = $_GET['idTipoIntegrante']; }
	if(isset($_GET['idNacionalidad'])) { $idNacionalidad = $_GET['idNacionalidad']; }
	if(isset($_GET['strNacionalidad'])) { $strNacionalidad = $_GET['strNacionalidad']; }

	$data = array(
    	"id" => $id, 
    	"nombres" => $nombres,
    	"apellidos" => $apellidos,
    	"idInstrumento" => $idInstrumento,
    	"idNacionalidad" => $idNacionalidad,
    	"idTipoDirector" => $idTipoDirector,
    	"idTipoIntegrante" => $idTipoIntegrante,
    	"idNacionalidad" => $idNacionalidad,
    	"strNacionalidad" => $strNacionalidad
    );
	
	$storage = new Storage;
	echo $storage->editIntegrante($data);
?>