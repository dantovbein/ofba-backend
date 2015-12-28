<?php
	header('Access-Control-Allow-Origin: *');
	
	require_once "../Storage.php";	
	
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
	$extra = json_decode($_GET['extra']);
	$textos = $extra->textos;
	$directores = $extra->directores;
	$compositores = $extra->compositores;
	$solistas = $extra->solistas;

	$desc = (isset($_GET['desc'])) ? $_GET['desc'] : "";

	$data = array(
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
    	"desc" => $desc
    );

	$storage = new Storage();
	echo $storage->postEvento($data);
?>
