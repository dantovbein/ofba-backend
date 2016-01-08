<?
class Storage {
	public $host = "";	
	public $username = "";
	public $password = "";
	public $dataBase = "";
	private $sql;

	public function Storage() {
		
		$debug = true;
		if($debug) {
			$this->host = "localhost";	
			$this->username = "root";
			$this->password = "";
			$this->dataBase = "ofba6452_db";
		} else {
			$this->host = "localhost";	
			$this->username = "ofba6452_db";
			$this->password = "po76ZEfo28sa";
			$this->dataBase = "ofba6452_db";
		}
	}

	private function connect() {
		$this->sql = mysql_connect($this->host , $this->username , $this->password) or die ('Error al conectarse a sql');
		mysql_select_db($this->dataBase) or die ("Error al conectarse a la Base de Datos");
	}

	private function close() {
		mysql_close($this->sql);
	}

	public function getIntegrantes() {

		$this->connect();
		$query = "SELECT * FROM integrantes ORDER BY nombres ASC ";
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		
		$data = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->id = $row['id'];
			$obj->nombres = $this->utf8ize($row['nombres']);
			$obj->apellidos = $this->utf8ize($row['apellidos']);
			$obj->idTipoIntegrante = $row['idTipoIntegrante'];
			$obj->idInstrumento = $row['idInstrumento'];
			$obj->idNacionalidad = $row['idNacionalidad'];
			$obj->idTipoDirector = $row['idTipoDirector'];
			$obj->strNacionalidad = $row['str_nacionalidad'];
			//$obj->codigoTextoInstrumento = $this->utf8ize($row['codigoTexto_instrumento']);
			//$obj->codigoNacionalidad = $row['codigoNacionalidad'];
			//$obj->codigoTextoTipoIntegrante = $this->utf8ize($row['codigoTexto']);
			//$obj->codigoTipoDirector = $row['codigoTipo'];
			array_push($data, $obj);
		}
		echo json_encode($data);
		$this->close();
	}

	public function postIntegrante($data){
		$this->connect();
		$query = 'INSERT INTO integrantes (nombres,apellidos,idInstrumento,idTipoDirector,idTipoIntegrante,idNacionalidad,str_nacionalidad) VALUES ("' . $data['nombres'] . '","' . $data['apellidos'] . '","' . $data['idInstrumento'] . '","' . $data['idTipoDirector'] . '","' . $data['idTipoIntegrante'] . '","' . $data['idNacionalidad'] . '","' . $data['strNacionalidad'] . '");';
		mysql_query($query) or die ("Error en la consulta " . $query);
		echo mysql_insert_id();
		$this->close();
	}

	public function editIntegrante($data){
		$this->connect();
		$query = 'UPDATE integrantes SET nombres="' . $data['nombres'] . '", apellidos="' . $data['apellidos'] . '", idInstrumento="' . $data['idInstrumento'] . '", idTipoDirector="' . $data['idTipoDirector'] . '", idTipoIntegrante="' . $data['idTipoIntegrante'] . '", idNacionalidad="' . $data['idNacionalidad'] . '", str_nacionalidad="' . $data['strNacionalidad'] . '" WHERE id=' . $data['id'];
		mysql_query($query) or die ("Error en la consulta " . $query);
		echo mysql_insert_id();
		$this->close();
	}

	public function deleteIntegrante($data) {
		$this->connect();
		$query = 'DELETE FROM integrantes WHERE id=' . $data['id'];
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		$this->close();
	}

	public function getInstrumentos() {
		$this->connect();
		$query = "SELECT * FROM instrumentos ORDER BY codigoTexto ASC";
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		$data = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->id = $row['id'];
			$obj->codigoTexto = $this->utf8ize($row['codigoTexto']);
			array_push($data, $obj);
		}
		echo json_encode($data);
		$this->close();
	}

	public function getTiposDirector() {
		$this->connect();
		$query = "SELECT * FROM tipos_director ORDER BY codigoTipo ASC";
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		$data = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->id = $row['id'];
			$obj->codigoTipo = $this->utf8ize($row['codigoTipo']);
			array_push($data, $obj);
		}
		echo json_encode($data);
		$this->close();
	}	

	public function getTiposIntegrante() {
		$this->connect();
		$query = "SELECT * FROM tipos_integrante ORDER BY codigoTexto ASC";
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		$data = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->id = $row['id'];
			$obj->codigoTexto = $this->utf8ize($row['codigoTexto']);
			array_push($data, $obj);
		}
		echo json_encode($data);
		$this->close();
	}

	public function getImagenes() {
		$this->connect();
		$query = "SELECT * FROM imagenes LEFT JOIN textos ON imagenes.codigoTexto=textos.codigo ORDER BY orden ASC";
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		$data = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->id = $row['id'];
			$obj->path = $row['path'];
			$obj->codigoTexto = $row['codigoTexto'];
			$obj->texto = $this->utf8ize($row['texto']);
			$obj->orden = $row['orden'];
			array_push($data, $obj);
		}
		echo json_encode($data);
		$this->close();
	}

	public function postImagen($data){
		$this->connect();
		//$fullpath = '/ofba/images/ofba/imageGallery/thumbs/';
		$fullpath = '/projects/ofba/images/uploads/';
		
		$query = 'INSERT INTO imagenes (path,orden) VALUES ("' . $fullpath . $data['path'] . '","' . $data['orden'] . '");';
		mysql_query($query) or die('Error en la consulta -> ' .  $query);
		$idImagen = mysql_insert_id();

		$query = 'UPDATE imagenes SET codigoTexto="' . 'IMG_GALLERY_IMG_' . $idImagen . '" WHERE id="' . $idImagen . '"';
		mysql_query($query) or die ("Error en la consulta " . $query);

		if($idImagen > 0) {
			$this->postTextoImagen($data,$idImagen);
		} else {
			$this->close();	
		}
	}

	public function editImagen($data){
		$this->connect();
		$this->editTexto($data);
	}

	public function getTextos() {
		$this->connect();
		$query = "SELECT * FROM textos";
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		$data = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->idIdioma = $row['idIdioma'];
			$obj->codigo = $row['codigo'];
			$obj->texto = $this->utf8ize($row['texto']);
			array_push($data, $obj);
		}
		echo json_encode($data);
		$this->close();
	}

	public function deleteImagen($data) {
		$this->connect();
		$query = 'DELETE FROM imagenes WHERE id=' . $data['id'];
		mysql_query($query) or die ("Error en la consulta " . $query);
		$this->close();
	}

	public function getTexto($codigo) {
		$this->connect();
		$query = "SELECT * FROM textos WHERE codigo='" . $codigo . "'";
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		$data = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->idIdioma = $row['idIdioma'];
			$obj->codigo = $row['codigo'];
			$obj->texto = $this->utf8ize($row['texto']);
			array_push($data, $obj);
		}
		echo json_encode($data);
		$this->close();
	}

	public function postTextoImagen($data,$idImagen){
		$this->connect();
		$query = 'INSERT INTO textos (idIdioma,texto,codigo) VALUES (1,"' . $this->utf8ize($data['texto']) . '","' . 'IMG_GALLERY_IMG_' . $idImagen . '");';
		mysql_query($query) or die ("Error en la consulta " . $query);
		echo mysql_insert_id();
		$this->close();
	}

	public function editTexto($data){
		$this->connect();
		$query = 'UPDATE textos SET texto="' . $data['texto'] . '", codigo="' . $data['codigoTexto'] . '" WHERE codigo="' . $data['codigoTexto'] . '"';
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		echo mysql_insert_id();
		$this->close();
	}

	public function getObras() {
		$this->connect();
		$query = "SELECT * FROM obras as o LEFT JOIN eventos_perfx as e ON o.idEvento=e.id LEFT JOIN integrantes as i ON o.idCompositor=i.id";
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		$data = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->idObra = $row['idObra'];
			$obj->idEvento = $row['idEvento'];
			$obj->idCompositor = $row['idCompositor'];
			$obj->strObra = $this->utf8ize($row['str_Obra']);
			$obj->strAtributos = $this->utf8ize($row['str_atributos']);
			$obj->strCompositor = $this->utf8ize($row['str_Compositor']);
			$obj->idOrden = $this->utf8ize($row['idOrden']);
			/*$obj->idTemporada = $row['idTemporada'];
			$obj->idCiclo = $row['idCiclo'];
			$obj->codigoTitulo = $row['codigoTitulo'];
			$obj->fecha = $row['fecha'];
			$obj->horaInicio = $row['horaInicio'];
			$obj->horaFin = $row['horaFin'];
			$obj->codigoTexto = $this->utf8ize($row['codigoTexto']);
			$obj->link = $row['link'];
			$obj->idLocacion = $row['idLocacion'];
			$obj->strTitulo = $this->utf8ize($row['str_titulo']);
			$obj->strTemporada = $this->utf8ize($row['str_temporada']);
			$obj->strCiclo = $this->utf8ize($row['str_ciclo']);
			$obj->strLocacion = $this->utf8ize($row['str_locacion']);
			$obj->idPais = $row['idpais'];
			$obj->strCiudad = $this->utf8ize($row['str_ciudad']);
			$obj->girasNacionalidad = $row['giras_nacionalidad'];
			$obj->idIntegrante = $row['id'];
			$obj->nombres = $this->utf8ize($row['nombres']);
			$obj->apellidos = $this->utf8ize($row['apellidos']);
			$obj->idTipoIntegrante = $row['idTipoIntegrante'];
			$obj->idInstrumento = $row['idInstrumento'];
			$obj->idNacionalidad = $row['idNacionalidad'];
			$obj->idTipoDirector = $row['idTipoDirector'];
			$obj->strNacionalidad = $row['str_nacionalidad'];*/
			array_push($data, $obj);
		}
		echo json_encode($data);
		$this->close();
	}

	public function getNacionalidades() {
		$this->connect();
		$query = "SELECT * FROM nacionalidades_perfx";
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		$data = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->id = $row['id'];
			$obj->codigoNacionalidad = $row['codigoNacionalidad'];
			array_push($data, $obj);
		}
		echo json_encode($data);
		$this->close();
	}

	public function getLocaciones() {
		$this->connect();
		$query = "SELECT * FROM locaciones";
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		$data = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->id = $row['id'];
			$obj->codigoTexto = $row['codigoTexto'];
			array_push($data, $obj);
		}
		echo json_encode($data);
		$this->close();
	}

	public function getTemporadas() {
		$this->connect();
		//$query = "SELECT * FROM temporadas as tem LEFT JOIN textos as txt ON tem.codigoNombre=txt.codigo";
		$query = "SELECT * FROM temporadas";
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		$data = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->id = $row['id'];
			$obj->codigoNombre = $row['codigoNombre'];
			//$obj->texto = $row['texto'];
			array_push($data, $obj);
		}
		echo json_encode($data);
		$this->close();
	}

	public function getGiras() {
		$this->connect();
		//$query = "SELECT * FROM giras as g LEFT JOIN temporadas as t ON g.idTemporada=t.id LEFT JOIN nacionalidades_perfx as n ON g.idnacionalidad=n.id";
		$query = "SELECT * FROM giras";
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		$data = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			// Guardar columnas
			array_push($data, $obj);
		}
		echo json_encode($data);
		$this->close();
	}

	public function getCiclos() {
		$this->connect();
		//$query = "SELECT * FROM ciclos as c LEFT JOIN textos as txt ON c.codigoCiclo=txt.codigo LEFT JOIN temporadas as tem ON c.idTemporada=tem.id";
		$query = "SELECT * FROM ciclos";
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		$data = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->id = $row['id'];
			$obj->codigoCiclo = $row['codigoCiclo'];
			$obj->idTemporada = $row['idTemporada'];
			//$obj->texto = $this->utf8ize($row['texto']);
			array_push($data, $obj);
		}
		echo json_encode($data);
		$this->close();
	}

	public function getEventos() {
		$this->connect();
		$query = "SELECT * FROM datos_evento ORDER BY id DESC";
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		$eventos = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->uidEvento = $row['uidEvento'];
			$obj->titulo = $row['str_titulo'];
			//$obj->link = $row['link'];
			$obj->fechas = array();
			array_push($eventos, $obj);
		}

		//$query = "SELECT * FROM eventos_perfx";
		$query = "SELECT * FROM fechas_evento";
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		while($row = mysql_fetch_array($result)) {
			for($e=0;$e<count($eventos);$e++){
				if($row['uidEvento']==$eventos[$e]->uidEvento) {
					//echo $eventos[$e]->uidEvento;
					$obj = new stdClass;
					$obj->fecha = $row['fecha'];
					//$obj->horaInicio = $row['horaInicio'];
					array_push($eventos[$e]->fechas,$obj);
				}
			}
			
		}

		echo json_encode($eventos);
		$this->close();
	}

	public function getEvento($data) {
		$this->connect();
		// Calendar
		$evento = array();
		$evento['uidEvento'] = $data['uidEvento'];
		$query = "SELECT * FROM datos_evento WHERE uidEvento='".$data['uidEvento']."'";
		$result = mysql_fetch_assoc(mysql_query($query)) or die ("Error en la consulta " . $query);
		$evento['titulo'] = $result['str_titulo'];
		//$evento['link'] = $result['link'];
		$evento['temporada'] = $result['idTemporada'];
		$evento['nacionalidad'] = $result['giras_nacionalidad'];
		$evento['pais'] = $result['idpais'];
		$evento['ciudad'] = ($result['idciudad']==0) ? "" : $result['idciudad'];
		$evento['ciclo'] = $result['idCiclo'];
		$evento['locacion'] = $result['idLocacion'];
		$evento['director'] = $result['idDirector'];

		$query = "SELECT * FROM imagenes_evento WHERE uidEvento='".$data['uidEvento']."'";
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		$evento['imagen'] = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->idImagen = $row['idImagen'];
			$obj->imagen = $row['imagen'];
			array_push($evento['imagen'], $obj);
		}

		//$query = "SELECT * FROM eventos_perfx WHERE uidEvento='".$data['uidEvento']."'";
		$query = "SELECT * FROM fechas_evento WHERE uidEvento='".$data['uidEvento']."'";
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		$evento['fechas'] = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->fecha = $row['fecha'];
			//$obj->horaInicio = $row['horaInicio'];
			array_push($evento['fechas'], $obj);
		}
		
		$evento['extras'] = array();
		
		$query = "SELECT * FROM textos_evento WHERE uidEvento='".$data['uidEvento']."'";
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		$evento['extras']['textos'] = array();
		while($row = mysql_fetch_array($result)) {
			switch ((int)$row['tipo']) {
				case 1:
					$evento['textoFunciones'] = $row['texto'];
					break;
				default:
					$obj = new stdClass;
					$obj->idTexto = $row['idTexto'];
					$obj->texto = $row['texto'];
					array_push($evento['extras']['textos'], $obj);
					break;
			}
		}	

		$query = "SELECT * FROM directores_evento WHERE uidEvento='".$data['uidEvento']."'";
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		$evento['extras']['directores'] = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->idDirector = $row['idDirector'];
			array_push($evento['extras']['directores'], $obj);
		}

		$query = "SELECT * FROM compositores_evento WHERE uidEvento='".$data['uidEvento']."'";
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		$evento['extras']['compositores'] = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->idCompositor = $row['idCompositor'];
			$obj->obras = array();
			array_push($evento['extras']['compositores'], $obj);
		}

		$query = "SELECT * FROM obras_evento WHERE uidEvento='".$data['uidEvento']."'";
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		$evento['obras'] = array();
		while($row = mysql_fetch_array($result)) {
			for($c=0;$c<count($evento['extras']['compositores']);$c++){
				if($row['idCompositor']==$evento['extras']['compositores'][$c]->idCompositor) {
					array_push($evento['extras']['compositores'][$c]->obras, $row['idObra']);
				}
			}
		}

		$query = "SELECT * FROM solistas_evento WHERE uidEvento='".$data['uidEvento']."'";
		$result = mysql_query($query) or die ("Error en la consulta " . $query);
		$evento['extras']['solistas'] = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->idSolista = $row['idSolista'];
			array_push($evento['extras']['solistas'], $obj);
		}

		echo json_encode($evento);
		$this->close();
	}

	public function postEvento($data) {
		$this->connect();
		
		$addEvent = false;
		$uidEvento = md5(uniqid(rand(), true));

		for($i=0;$i<count($data['fechas']);$i++){
			$addEvent = true;
			$uid = md5(uniqid(rand(), true));
			
			$epoch = (int)$data['fechas'][$i]->fecha / 1000; 
			$fecha = new DateTime("@$epoch");

			// Event Details
			$queryEventDetails = "INSERT INTO ofba_jevents_vevdetail (uidEvento,dtstart,description,summary) VALUES ('".$uidEvento."','".$epoch."','". $data['desc']."','".""."');";
			mysql_query($queryEventDetails) or die ("Error en la consulta " . $queryEventDetails);
			$eventDetailId = mysql_insert_id();
			
			$rawdata = 'a:20:{s:3:"UID";s:32:"'.$uid.'";s:11:"X-EXTRAINFO";s:0:"";s:8:"LOCATION";s:0:"";s:11:"allDayEvent";s:3:"off";s:7:"CONTACT";s:0:"";s:11:"DESCRIPTION";s:'.strlen($data['desc']).':'.$data['desc'].';s:12:"publish_down";s:10:"'.$fecha->format('d/m/Y').'";s:10:"publish_up";s:10:"'.$fecha->format('d/m/Y').'";s:13:"publish_down2";s:10:"'.$fecha->format('d/m/Y').'";s:11:"publish_up2";s:10:"'.$fecha->format('d/m/Y').'";s:7:"SUMMARY";s:17:"Giras Extranjeras";s:3:"URL";s:0:"";s:11:"X-CREATEDBY";i:40;s:7:"DTSTART";i:'.$epoch.';s:5:"DTEND";i:'.$epoch.';s:5:"RRULE";a:4:{s:4:"FREQ";s:4:"none";s:5:"COUNT";i:1;s:8:"INTERVAL";s:1:"1";s:5:"BYDAY";s:24:"+1SA,+2SA,+3SA,+4SA,+5SA";}s:8:"MULTIDAY";s:1:"1";s:9:"NOENDTIME";s:1:"1";s:7:"X-COLOR";s:0:"";s:9:"LOCKEVENT";s:1:"0";}';
			
			// Event
			$queryEventData = "INSERT INTO ofba_jevents_vevent (uidEvento,icsid,catid,uid,created_by,modified_by,rawdata,detail_id) VALUES ('".$uidEvento."','"."0"."','"."0"."','". $uid."','"."40"."','"."40"."','".$rawdata."','".$eventDetailId."');";
			mysql_query($queryEventData) or die ("Error en la consulta " . $queryEventData);
			$eventId = mysql_insert_id();
			
			// Repetition of the event and get the url.
			$uidRepetition = md5(uniqid(rand(), true));
			$queryEventRepetition = "INSERT INTO ofba_jevents_repetition (eventid,uidEvento,eventdetail_id,duplicatecheck,startrepeat,endrepeat) VALUES ('".$eventId."','".$uidEvento."','".$eventDetailId."','".$uidRepetition."','".$fecha->format('d/m/Y H:i:s')."','".$fecha->format('d/m/Y H:i:s')."');";
			mysql_query($queryEventRepetition) or die ("Error en la consulta " . $queryEventRepetition);
			$eventRepetitionId = mysql_insert_id();
			$link = "index.php/homepage/listados-completo/icalrepeat.detail/".$fecha->format('d/m/Y')."/".$eventRepetitionId;

			$queryEventoPerfx = "INSERT INTO eventos_perfx (eventid,uidEvento,idTemporada,idCiclo,fecha,horaInicio,link,idLocacion,idpais,giras_nacionalidad,str_titulo,str_temporada,str_ciclo,str_locacion,str_ciudad) VALUES ('".$eventId."','".$uidEvento."','".$data['temporada']."','".$data['ciclo']."','".$fecha->format('Y/m/d')."','".$fecha->format('H:i:s')."','".$link."','".$data['locacion']."','".$data['pais']."','".$data['nacionalidad']."','".$data['titulo']."','".$data['strTemporada']."','".$data['strCiclo']."','".$data['strLocacion']."','".$data['strCiudad']."');";
			mysql_query($queryEventoPerfx) or die ("Error en la consulta " . $queryEventoPerfx);
			
			$queryEventoFecha = "INSERT INTO fechas_evento (uidEvento,fecha) VALUES ('".$uidEvento."','".$data['fechas'][$i]->fecha."');";
			mysql_query($queryEventoFecha) or die ("Error en la consulta " . $queryEventoFecha);

		}

		if($addEvent) {
			$queryDatosEvento = "INSERT INTO datos_evento (uidEvento,idTemporada,giras_nacionalidad,idpais,idciudad,idCiclo,idLocacion,str_titulo,idDirector) VALUES ('".$uidEvento."','".$data['temporada']."','".$data['nacionalidad']."','".$data['pais']."','".$data['ciudad']."','".$data['ciclo']."','".$data['locacion']."','".$data['titulo']."','".$data['director']."');";
			mysql_query($queryDatosEvento) or die ("Error en la consulta " . $queryDatosEvento);
			
			$queryEventImagen = "INSERT INTO imagenes_evento (uidEvento,imagen) VALUES ('".$uidEvento."','". $data['imagen']."');";
			mysql_query($queryEventImagen) or die ("Error en la consulta " . $queryEventImagen);
			
			for($d=0;$d<count($data['directores']);$d++) {
				$queryEventDirectores = "INSERT INTO directores_evento (idEvento,uidEvento,idDirector) VALUES ('0','".$uidEvento."','". $data['directores'][$d]->idDirector."');";
				mysql_query($queryEventDirectores) or die ("Error en la consulta " . $queryEventDirectores);
			}

			for($s=0;$s<count($data['solistas']);$s++) {
				$queryEventSolistas = "INSERT INTO solistas_evento (idEvento,uidEvento,idSolista) VALUES ('0','".$uidEvento."','". $data['solistas'][$s]->idSolista."');";
				mysql_query($queryEventSolistas) or die ("Error en la consulta " . $queryEventSolistas);
			}

			for($c=0;$c<count($data['compositores']);$c++) {
				$queryEventCompositores = "INSERT INTO compositores_evento (idEvento,uidEvento,idCompositor) VALUES ('0','".$uidEvento."','". $data['compositores'][$c]->idCompositor."');";
				$result = mysql_query($queryEventCompositores) or die ("Error en la consulta " . $queryEventCompositores);
				// Insert obras from each one
				for($o=0;$o<count($data['compositores'][$c]->obras);$o++) {
					$queryObraCompositor = "INSERT INTO obras_evento (idObra,uidEvento,idCompositor) VALUES ('".$data['compositores'][$c]->obras[$o]."','".$uidEvento."','".$data['compositores'][$c]->idCompositor."')";
					mysql_query($queryObraCompositor) or die ("Error en la consulta " . $queryObraCompositor);
				}
			}

			if($data['textoFunciones'] != "") {
				$queryTextoFunciones = "INSERT INTO textos_evento (uidEvento,texto,tipo) VALUES ('".$uidEvento."','". $data['textoFunciones']."',1);";
				mysql_query($queryTextoFunciones) or die ("Error en la consulta " . $queryTextoFunciones);
			}

			for($t=0;$t<count($data['textos']);$t++) {
				$queryTextosEvento = "INSERT INTO textos_evento (uidEvento,texto,orden) VALUES ('".$uidEvento."','". $data['textos'][$t]->texto."','". ($t+1)."');";
				mysql_query($queryTextosEvento) or die ("Error en la consulta " . $queryTextosEvento);
			}
		}
			
		$this->close();
	}

	public function editEvento($data) {
		$this->connect();
		
		$addEvent = false;
		$uidEvento = $data['uidEvento'];

		$queryRemoveFechas = "DELETE FROM fechas_evento WHERE uidEvento='".$uidEvento."'";
		mysql_query($queryRemoveFechas) or die ("Error en la consulta " . $queryRemoveFechas);

		$queryRemoveEventDetails = "DELETE FROM ofba_jevents_vevdetail WHERE uidEvento='".$uidEvento."'";
		mysql_query($queryRemoveEventDetails) or die ("Error en la consulta " . $queryRemoveEventDetails);

		$queryRemoveEventData = "DELETE FROM ofba_jevents_vevent WHERE uidEvento='".$uidEvento."'";
		mysql_query($queryRemoveEventData) or die ("Error en la consulta " . $queryRemoveEventData);

		$queryRemoveEventRepetition = "DELETE FROM ofba_jevents_repetition WHERE uidEvento='".$uidEvento."'";
		mysql_query($queryRemoveEventRepetition) or die ("Error en la consulta " . $queryRemoveEventRepetition);
		

		$queryRemoveEventoPerfx = "DELETE FROM eventos_perfx WHERE uidEvento='".$uidEvento."'";
		mysql_query($queryRemoveEventoPerfx) or die ("Error en la consulta " . $queryRemoveEventoPerfx);

		$queryRemoveEventImagen = "DELETE FROM imagenes_evento WHERE uidEvento='".$uidEvento."'";
			mysql_query($queryRemoveEventImagen) or die ("Error en la consulta " . $queryRemoveEventImagen);

		for($i=0;$i<count($data['fechas']);$i++){
			$addEvent = true;
			$uid = md5(uniqid(rand(), true));

			$epoch = (int)$data['fechas'][$i]->fecha / 1000; 
			$fecha = new DateTime("@$epoch");
			
			// Event Details
			$queryEventDetails = "INSERT INTO ofba_jevents_vevdetail (uidEvento,dtstart,description,summary) VALUES ('".$uidEvento."','".$epoch."','". $data['desc']."','".""."');";
			mysql_query($queryEventDetails) or die ("Error en la consulta " . $queryEventDetails);
			$eventDetailId = mysql_insert_id();
			
			$rawdata = 'a:20:{s:3:"UID";s:32:"'.$uid.'";s:11:"X-EXTRAINFO";s:0:"";s:8:"LOCATION";s:0:"";s:11:"allDayEvent";s:3:"off";s:7:"CONTACT";s:0:"";s:11:"DESCRIPTION";s:'.strlen($data['desc']).':'.$data['desc'].';s:12:"publish_down";s:10:"'.$fecha->format('d/m/Y').'";s:10:"publish_up";s:10:"'.$fecha->format('d/m/Y').'";s:13:"publish_down2";s:10:"'.$fecha->format('d/m/Y').'";s:11:"publish_up2";s:10:"'.$fecha->format('d/m/Y').'";s:7:"SUMMARY";s:17:"Giras Extranjeras";s:3:"URL";s:0:"";s:11:"X-CREATEDBY";i:40;s:7:"DTSTART";i:'.$epoch.';s:5:"DTEND";i:'.$epoch.';s:5:"RRULE";a:4:{s:4:"FREQ";s:4:"none";s:5:"COUNT";i:1;s:8:"INTERVAL";s:1:"1";s:5:"BYDAY";s:24:"+1SA,+2SA,+3SA,+4SA,+5SA";}s:8:"MULTIDAY";s:1:"1";s:9:"NOENDTIME";s:1:"1";s:7:"X-COLOR";s:0:"";s:9:"LOCKEVENT";s:1:"0";}';
			
			// Event
			$queryEventData = "INSERT INTO ofba_jevents_vevent (uidEvento,icsid,catid,uid,created_by,modified_by,rawdata,detail_id) VALUES ('".$uidEvento."','"."0"."','"."0"."','". $uid."','"."40"."','"."40"."','".$rawdata."','".$eventDetailId."');";
			mysql_query($queryEventData) or die ("Error en la consulta " . $queryEventData);
			$eventId = mysql_insert_id();
			
			
			// Repetition of the event and get the url.
			$uidRepetition = md5(uniqid(rand(), true));
			$queryEventRepetition = "INSERT INTO ofba_jevents_repetition (eventid,uidEvento,eventdetail_id,duplicatecheck,startrepeat,endrepeat) VALUES ('".$eventId."','".$uidEvento."','".$eventDetailId."','".$uidRepetition."','".$fecha->format('d/m/Y H:i:s')."','".$fecha->format('d/m/Y H:i:s')."');";
			mysql_query($queryEventRepetition) or die ("Error en la consulta " . $queryEventRepetition);
			$eventRepetitionId = mysql_insert_id();
			$link = "index.php/homepage/listados-completo/icalrepeat.detail/".$fecha->format('d/m/Y')."/".$eventRepetitionId;

			$queryEventoPerfx = "INSERT INTO eventos_perfx (eventid,uidEvento,idTemporada,idCiclo,fecha,horaInicio,link,idLocacion,idpais,giras_nacionalidad,str_titulo,str_temporada,str_ciclo,str_locacion,str_ciudad) VALUES ('".$eventId."','".$uidEvento."','".$data['temporada']."','".$data['ciclo']."','".$fecha->format('Y/m/d')."','".$fecha->format('H:i:s')."','".$link."','".$data['locacion']."','".$data['pais']."','".$data['nacionalidad']."','".$data['titulo']."','".$data['strTemporada']."','".$data['strCiclo']."','".$data['strLocacion']."','".$data['strCiudad']."');";
			mysql_query($queryEventoPerfx) or die ("Error en la consulta " . $queryEventoPerfx);
			
			$queryEventoFecha = "INSERT INTO fechas_evento (uidEvento,fecha) VALUES ('".$uidEvento."','".$data['fechas'][$i]->fecha."');";
			mysql_query($queryEventoFecha) or die ("Error en la consulta " . $queryEventoFecha);
		}

		if($addEvent) {
			// Datos evento
			$queryUpdateDatosEvento = 'UPDATE datos_evento SET idTemporada="' . $data['temporada'] . '", giras_nacionalidad="' . $data['nacionalidad'] . '", idpais="' . $data['pais'] . '", idciudad="' . $data['ciudad'] . '", idCiclo="' . $data['ciclo'] . '", idLocacion="' . $data['locacion'] . '", str_titulo="' . $data['titulo'] . '", idDirector="' . $data['director'] . '" WHERE uidEvento="' . $uidEvento .'"';
			
			mysql_query($queryUpdateDatosEvento) or die ("Error en la consulta " . $queryUpdateDatosEvento);
			
			// Imagen
			$queryEventImagen = "INSERT INTO imagenes_evento (uidEvento,imagen) VALUES ('".$uidEvento."','". $data['imagen']."');";
			mysql_query($queryEventImagen) or die ("Error en la consulta " . $query);
			
			
			// Directores
			$queryRemoveEventDirectores = "DELETE FROM directores_evento WHERE uidEvento='".$uidEvento."'";
			mysql_query($queryRemoveEventDirectores) or die ("Error en la consulta " . $queryRemoveEventDirectores);
			for($d=0;$d<count($data['directores']);$d++) {
				$queryEventDirectores = "INSERT INTO directores_evento (idEvento,uidEvento,idDirector) VALUES ('0','".$uidEvento."','". $data['directores'][$d]->idDirector."');";
				mysql_query($queryEventDirectores) or die ("Error en la consulta " . $queryEventDirectores);
			}

			
			// Solistas
			$queryRemoveEventSolistas = "DELETE FROM solistas_evento WHERE uidEvento='".$uidEvento."'";
			mysql_query($queryRemoveEventSolistas) or die ("Error en la consulta " . $queryRemoveEventSolistas);
			for($s=0;$s<count($data['solistas']);$s++) {
				$queryEventSolistas = "INSERT INTO solistas_evento (idEvento,uidEvento,idSolista) VALUES ('0','".$uidEvento."','". $data['solistas'][$s]->idSolista."');";
				mysql_query($queryEventSolistas) or die ("Error en la consulta " . $queryEventSolistas);
			}

			// Compositores
			$queryRemoveEventCompositores = "DELETE FROM compositores_evento WHERE uidEvento='".$uidEvento."'";
			mysql_query($queryRemoveEventCompositores) or die ("Error en la consulta " . $queryRemoveEventCompositores);
			$queryRemoveObrasCompositor = "DELETE FROM obras_evento WHERE uidEvento='".$uidEvento."'";
			mysql_query($queryRemoveObrasCompositor) or die ("Error en la consulta " . $queryRemoveObrasCompositor);
			for($c=0;$c<count($data['compositores']);$c++) {
				$queryEventCompositores = "INSERT INTO compositores_evento (idEvento,uidEvento,idCompositor) VALUES ('0','".$uidEvento."','". $data['compositores'][$c]->idCompositor."');";
				$result = mysql_query($queryEventCompositores) or die ("Error en la consulta " . $queryEventCompositores);
				// Insert obras from each one
				for($o=0;$o<count($data['compositores'][$c]->obras);$o++) {
					$queryObraCompositor = "INSERT INTO obras_evento (idObra,uidEvento,idCompositor) VALUES ('".$data['compositores'][$c]->obras[$o]."','".$uidEvento."','".$data['compositores'][$c]->idCompositor."')";
					mysql_query($queryObraCompositor) or die ("Error en la consulta " . $queryObraCompositor);
				}
			}

			// Textos
			$queryRemoveTextosEvento = "DELETE FROM textos_evento WHERE uidEvento='".$uidEvento."'";
			mysql_query($queryRemoveTextosEvento) or die ("Error en la consulta " . $queryRemoveTextosEvento);

			if($data['textoFunciones'] != "") {
				$queryTextoFunciones = "INSERT INTO textos_evento (uidEvento,texto,tipo) VALUES ('".$uidEvento."','". $data['textoFunciones']."',1);";
				mysql_query($queryTextoFunciones) or die ("Error en la consulta " . $queryTextoFunciones);
			}

			for($t=0;$t<count($data['textos']);$t++) {
				$queryTextosEvento = "INSERT INTO textos_evento (uidEvento,texto,orden) VALUES ('".$uidEvento."','". $data['textos'][$t]->texto."','". ($t+1)."');";
				mysql_query($queryTextosEvento) or die ("Error en la consulta " . $queryTextosEvento);
			}
		}
			
		$this->close();
	}

	public function deleteEvento($data){
		$this->connect();
		mysql_query('DELETE FROM ofba_jevents_vevent WHERE uidEvento="'.$data['uidEvento'].'"') or die ("Error en la consulta");
		mysql_query('DELETE FROM ofba_jevents_vevdetail WHERE uidEvento="'.$data['uidEvento'].'"') or die ("Error en la consulta");
		mysql_query('DELETE FROM ofba_jevents_repetition WHERE uidEvento="'.$data['uidEvento'].'"') or die ("Error en la consulta");
		mysql_query('DELETE FROM eventos_perfx WHERE uidEvento="'.$data['uidEvento'].'"') or die ("Error en la consulta");
		mysql_query('DELETE FROM datos_evento WHERE uidEvento="'.$data['uidEvento'].'"') or die ("Error en la consulta");
		mysql_query('DELETE FROM textos_evento WHERE uidEvento="'.$data['uidEvento'].'"') or die ("Error en la consulta");
		mysql_query('DELETE FROM imagenes_evento WHERE uidEvento="'.$data['uidEvento'].'"') or die ("Error en la consulta");
		mysql_query('DELETE FROM directores_evento WHERE uidEvento="'.$data['uidEvento'].'"') or die ("Error en la consulta");
		mysql_query('DELETE FROM compositores_evento WHERE uidEvento="'.$data['uidEvento'].'"') or die ("Error en la consulta");
		mysql_query('DELETE FROM obras_evento WHERE uidEvento="'.$data['uidEvento'].'"') or die ("Error en la consulta");
		mysql_query('DELETE FROM solistas_evento WHERE uidEvento="'.$data['uidEvento'].'"') or die ("Error en la consulta");
		mysql_query('DELETE FROM fechas_evento WHERE uidEvento="'.$data['uidEvento'].'"') or die ("Error en la consulta");
		$this->close();
	}

	private function utf8ize($d) {
        if (is_array($d)) {
            foreach ($d as $k => $v) {
                $d[$k] = $this->utf8ize($v);
            }
        } else if (is_string ($d)) {
            return utf8_encode($d);
        }
        return $d;
    }
}
?>

