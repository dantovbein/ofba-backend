<?php
	header('Access-Control-Allow-Origin: *');
	
	require_once "../Storage.php";	
	
	$uid = md5(uniqid(rand(), true));

	$titulo = (isset($_GET['titulo'])) ? $_GET['titulo'] : "";
	$imagen = (isset($_GET['imagen'])) ? $_GET['imagen'] : "";
	$ciclo = (isset($_GET['ciclo'])) ? $_GET['ciclo'] : "";
	$locacion = (isset($_GET['locacion'])) ? $_GET['locacion'] : "";
	$ciudad = (isset($_GET['ciudad'])) ? $_GET['ciudad'] : "";
	$pais = (isset($_GET['pais'])) ? $_GET['pais'] : "";
	$nacionalidad = (isset($_GET['nacionalidad'])) ? $_GET['nacionalidad'] : "";
	$temporada = (isset($_GET['temporada'])) ? $_GET['temporada'] : "";
	$fechas = (isset($_GET['fechas'])) ? $_GET['fechas'] : "";
	$director = (isset($_GET['director'])) ? $_GET['director'] : "";
	$extra = (isset($_GET['extra'])) ? json_decode($_GET['extra']) : [];
	if(count($extra)==0) {
		//$extra->textos = [];
	}
	$desc = (isset($_GET['desc'])) ? $_GET['desc'] : "";
	
	/* start test */
	//$test = '{"titulo":"Titulo de mi evento","imagen":"","ciclo":"1","locacion":"2","ciudad":"2","pais":"0","nacionalidad":"1","temporada":"4","fechas":["1449799860","1449163320"],"director":"70","extra":{"textos":["Este es el texto 1","Este es el texto 2","Este es el texto 3","Este es el texto 4 adicional"],"directores":["61","60","5"],"compositores":[{"id":"120","obras":["62"]},{"id":"113","obras":["3","2","1"]},{"id":"95","obras":["36"]}],"solistas":["55","29","85"]},"desc":"<p>{source}[[div class=\"row-fluid\"]][[div class=\"span12\"]][[img class=\"pull-right img-ofba\" src=\"images/ofba/events/thumbs/\" alt=\"\" /]][[h4]]Temporada 2011[[/h4]][[h5]]Ciclo abono[[/h5]][[h5]]Locacion usina arte[[/h5]][[h5]]Rosario, Argentina[[/h5]][[/br]][[p]][[strong]]Director: [[a href=\"\"]]Julio Fainguersch[[/a]][[/strong]][[/p]][[/br]][[p]][[h4]]Directores:[[/h4]][[span]]César Bustamante[[/span]], [[span]]Miguel Ángel Pesce[[/span]], [[span]]Maximiliano Valdés[[/span]][[/p]][[/br]][[p]][[h4]]Solistas:[[/h4]][[span]]Conjunto Instrumental 2[[/span]], [[span]]Karin Lechner[[/span]], [[span]]Algirdas Janutas[[/span]][[/p]][[/br]][[p]][[h4]]Compositores:[[/h4]][[strong]]Carlos Chavez[[/strong]]: [[ul]][[li]]Concierto para violín[[/li]][[/ul]][[strong]]Wolfgang Amadeus Mozart[[/strong]]: [[ul]][[li]]Concierto Nº 20 para piano y orquesta en Re menor, K. 466[[/li]][[li]]Obertura de La flauta mágica, K. 620[[/li]][[li]]Concierto Nº 14 para piano y orquesta en Mi bemol Mayor, K. 449[[/li]][[/ul]][[strong]]George Bizet[[/strong]]: [[ul]][[li]]Les dragons dAlcala y La garde montante, de las Suites No 1 y 2 de Carmen[[/li]][[/ul]][[/p]][[/br]][[p]]Este es el texto 1[[/p]][[/br]][[p]]Este es el texto 2[[/p]][[/br]][[p]]Este es el texto 3[[/p]][[/br]][[p]]Este es el texto 4 adicional[[/p]][[/br]][[/div]][[/div]]{/source}</p>"}';
	//$titulo = "Titulo de mi evento";
	//$imagen = "";
	//$ciclo = "1";
	//$locacion = "2";
	//$ciudad = "2";
	//$pais = "0";
	//$nacionalidad = "1";
	//$temporada = "4";
	//$fechas = ["1449799860","1449163320"];
	//$director = "70";
	//$extra = json_decode('{"textos":["Este es el texto 1","Este es el texto 2","Este es el texto 3","Este es el texto 4 adicional"],"directores":["61","60","5"],"compositores":[{"id":"120","obras":["62"]},{"id":"113","obras":["3","2","1"]},{"id":"95","obras":["36"]}],"solistas":["55","29","85"]}');
	//$desc = '<p>{source}[[div class=\"row-fluid\"]][[div class=\"span12\"]][[img class=\"pull-right img-ofba\" src=\"images/ofba/events/thumbs/\" alt=\"\" /]][[h4]]Temporada 2011[[/h4]][[h5]]Ciclo abono[[/h5]][[h5]]Locacion usina arte[[/h5]][[h5]]Rosario, Argentina[[/h5]][[/br]][[p]][[strong]]Director: [[a href=\"\"]]Julio Fainguersch[[/a]][[/strong]][[/p]][[/br]][[p]][[h4]]Directores:[[/h4]][[span]]César Bustamante[[/span]], [[span]]Miguel Ángel Pesce[[/span]], [[span]]Maximiliano Valdés[[/span]][[/p]][[/br]][[p]][[h4]]Solistas:[[/h4]][[span]]Conjunto Instrumental 2[[/span]], [[span]]Karin Lechner[[/span]], [[span]]Algirdas Janutas[[/span]][[/p]][[/br]][[p]][[h4]]Compositores:[[/h4]][[strong]]Carlos Chavez[[/strong]]: [[ul]][[li]]Concierto para violín[[/li]][[/ul]][[strong]]Wolfgang Amadeus Mozart[[/strong]]: [[ul]][[li]]Concierto Nº 20 para piano y orquesta en Re menor, K. 466[[/li]][[li]]Obertura de La flauta mágica, K. 620[[/li]][[li]]Concierto Nº 14 para piano y orquesta en Mi bemol Mayor, K. 449[[/li]][[/ul]][[strong]]George Bizet[[/strong]]: [[ul]][[li]]Les dragons dAlcala y La garde montante, de las Suites No 1 y 2 de Carmen[[/li]][[/ul]][[/p]][[/br]][[p]]Este es el texto 1[[/p]][[/br]][[p]]Este es el texto 2[[/p]][[/br]][[p]]Este es el texto 3[[/p]][[/br]][[p]]Este es el texto 4 adicional[[/p]][[/br]][[/div]][[/div]]{/source}</p>';
	/* end test */


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
    	"extra" => $extra,
    	"desc" => $desc
    );

	//echo print_r($extra);
	//echo $desc;
	//echo print_r($extra->textos[1]);
	//echo print_r(count($extra->directores));
	//echo $desc;

	$storage = new Storage();
	echo $storage->postEvento($data);
?>
