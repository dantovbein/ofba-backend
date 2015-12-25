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

	//$textos = (isset($_GET['textos'])) ? json_decode($_GET['textos']) : array();
	//$compositores = (isset($_GET['compositores'])) ? json_decode($_GET['compositores']) : array();
	
	//for($i=0;$i<count($compositores);$i++){
		//echo $compositores[$i];
	//	var_dump($compositores);
	//}

	//var_dump($extra);

	//for($i=0;$i<count($textos);$i++){
	//	echo $textos[$i] . '</br>';
	//}
	//var_dump($compositores);

	//for($i=0;$i<count($compositores);$i++){
		//var_dump($compositores[$i]);
		//var_dump($compositores[$i]->obras);
		//echo count($compositores[$i]->obras) . '</br>';
	//}

	//echo count($compositores[3]->obras);
	//echo gettype($textos);
	//echo isset($_GET['textos']);
	//echo gettype($textos);
	//echo $_GET['textos'];
	//$textos = json_decode($_GET['fechas']);
	
	//$extra = $_GET['extra'];
	//$extra = stripcslashes($extra);
	//$extra = json_decode($extra);
	//echo gettype($extra);
	//echo $textos;
	

	//$textos = json_decode($extra->textos);
	//echo mysql_fetch_object($extra);
	//if(count($extra)==0) {
		//$extra->textos = [];
	//}
	
	
	//echo $extra;

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
    	"textos" => $textos,
    	"directores" => $directores,
    	"compositores" => $compositores,
    	"solistas" => $solistas,
    	"desc" => $desc
    );

	$storage = new Storage();
	echo $storage->postEvento($data);
?>
