<?php
	header('Access-Control-Allow-Origin: *');
	
	require_once "../Storage.php";	
	
	$uidEvento = (isset($_GET['uidEvento'])) ? $_GET['uidEvento'] : "";
	$titulo = (isset($_GET['titulo'])) ? $_GET['titulo'] : "";
	$imagen = (isset($_GET['imagen'])) ? $_GET['imagen'] : "";
	$ciclo = (isset($_GET['ciclo'])) ? $_GET['ciclo'] : "";
	$locacion = (isset($_GET['locacion'])) ? $_GET['locacion'] : "";
	$ciudad = (isset($_GET['ciudad'])) ? $_GET['ciudad'] : "";
	$pais = (isset($_GET['pais'])) ? $_GET['pais'] : "";
	$nacionalidad = (isset($_GET['nacionalidad'])) ? $_GET['nacionalidad'] : "";
	$temporada = (isset($_GET['temporada'])) ? $_GET['temporada'] : "";
	$fechas = (isset($_GET['fechas'])) ? json_decode($_GET['fechas']) : array();
	$director = (isset($_GET['director'])) ? $_GET['director'] : "";
	$extras = json_decode($_GET['extras']);
	$textos = $extras->textos;
	$directores = $extras->directores;
	$compositores = $extras->compositores;
	$solistas = $extras->solistas;
	$desc = (isset($_GET['desc'])) ? $_GET['desc'] : "";
	$strTemporada = (isset($_GET['strTemporada'])) ? $_GET['strTemporada'] : "";
	$strCiclo = (isset($_GET['strCiclo'])) ? $_GET['strCiclo'] : "";
	$strLocacion = (isset($_GET['strLocacion'])) ? $_GET['strLocacion'] : "";
	$strCiudad = (isset($_GET['strCiudad'])) ? $_GET['strCiudad'] : "";

	$data = array(
    	"uidEvento" => $uidEvento,
    	"titulo" => $titulo,
    	"imagen" => $imagen,
    	"ciclo" => $ciclo,
    	"locacion" => $locacion,
    	"ciudad" => $ciudad,
    	"pais" => $pais,
    	"nacionalidad" => $nacionalidad,
    	"temporada" => $temporada,
    	"fechas" => $fechas,
    	"director" => $director,
    	"textos" => $textos,
    	"directores" => $directores,
    	"compositores" => $compositores,
    	"solistas" => $solistas,
    	"desc" => $desc,
    	"strTemporada" => $strTemporada,
    	"strCiclo" => $strCiclo,
    	"strLocacion" => $strLocacion,
    	"strCiudad" => $strCiudad
    );

	$storage = new Storage();
	echo $storage->editEvento($data);
?>
