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
			$this->dataBase = "ofba";
		} else {
			$this->host = "localhost";	
			$this->username = "ofba_admin";
			$this->password = "inicial";
			$this->dataBase = "ofba";
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
		//$query = "SELECT *,i.id as idIntegrante,ins.codigoTexto as codigoTexto_instrumento FROM integrantes as i LEFT JOIN instrumentos as ins ON i.idInstrumento=ins.id LEFT JOIN nacionalidades_perfx as nac ON i.idNacionalidad=nac.id LEFT JOIN tipos_integrante as tint ON i.idTipoIntegrante=tint.id LEFT JOIN tipos_director as tdir ON i.idTipoIntegrante=tdir.id ORDER BY i.nombres ASC";		
		$query = "SELECT * FROM integrantes ORDER BY nombres ASC ";
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
		
		$data = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			//$obj->id = $row['idIntegrante'];
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
		mysql_query($query) or die (json_encode([false,mysql_error()]));
		echo mysql_insert_id();
		$this->close();
	}

	public function editIntegrante($data){
		$this->connect();
		$query = 'UPDATE integrantes SET nombres="' . $data['nombres'] . '", apellidos="' . $data['apellidos'] . '", idInstrumento="' . $data['idInstrumento'] . '", idTipoDirector="' . $data['idTipoDirector'] . '", idTipoIntegrante="' . $data['idTipoIntegrante'] . '", idNacionalidad="' . $data['idNacionalidad'] . '", str_nacionalidad="' . $data['strNacionalidad'] . '" WHERE id=' . $data['id'];
		mysql_query($query) or die (json_encode([false,mysql_error()]));
		echo mysql_insert_id();
		$this->close();
	}

	public function deleteIntegrante($data) {
		$this->connect();
		$query = 'DELETE FROM integrantes WHERE id=' . $data['id'];
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
		$this->close();
	}

	public function getInstrumentos() {
		$this->connect();
		$query = "SELECT * FROM instrumentos ORDER BY codigoTexto ASC";
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
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
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
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
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
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
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
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
		mysql_query($query) or die (json_encode([false,mysql_error()]));

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
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
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
		mysql_query($query) or die (json_encode([false,mysql_error()]));
		$this->close();
	}

	public function getTexto($codigo) {
		$this->connect();
		$query = "SELECT * FROM textos WHERE codigo='" . $codigo . "'";
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
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
		mysql_query($query) or die (json_encode([false,mysql_error()]));
		echo mysql_insert_id();
		$this->close();
	}

	public function editTexto($data){
		$this->connect();
		$query = 'UPDATE textos SET texto="' . $data['texto'] . '", codigo="' . $data['codigoTexto'] . '" WHERE codigo="' . $data['codigoTexto'] . '"';
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
		echo mysql_insert_id();
		$this->close();
	}

	public function getObras() {
		$this->connect();
		$query = "SELECT * FROM obras as o LEFT JOIN eventos_perfx as e ON o.idEvento=e.id LEFT JOIN integrantes as i ON o.idCompositor=i.id";
		$result = mysql_query($query) or die ("Error en la consulta de las obras");
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
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
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
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
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
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
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
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
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
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
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
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
		$eventos = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->uidEvento = $row['uidEvento'];
			$obj->titulo = $row['str_titulo'];
			$obj->fechas = array();
			array_push($eventos, $obj);
		}

		$query = "SELECT * FROM eventos_perfx";
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
		while($row = mysql_fetch_array($result)) {
			for($e=0;$e<count($eventos);$e++){
				if($row['uidEvento']==$eventos[$e]->uidEvento) {
					//echo $eventos[$e]->uidEvento;
					$obj = new stdClass;
					$obj->fecha = $row['fecha'];
					$obj->horaInicio = $row['horaInicio'];
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
		
		$query = "SELECT * FROM datos_evento WHERE uidEvento='".$data['uidEvento']."'";
		$result = mysql_fetch_assoc(mysql_query($query)) or die (json_encode([false,mysql_error()]));
		$evento['titulo'] = $result['str_titulo'];
		$evento['link'] = $result['link'];
		$evento['temporada'] = $result['idTemporada'];
		$evento['nacionalidad'] = $result['giras_nacionalidad'];
		$evento['pais'] = $result['idpais'];
		$evento['ciudad'] = $result['idciudad'];
		$evento['ciclo'] = $result['idCiclo'];
		$evento['locacion'] = $result['idLocacion'];

		$query = "SELECT * FROM imagenes_evento WHERE uidEvento='".$data['uidEvento']."'";
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
		$evento['imagen'] = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->idImagen = $row['idImagen'];
			$obj->imagen = $row['imagen'];
			array_push($evento['imagen'], $obj);
		}

		$query = "SELECT * FROM eventos_perfx WHERE uidEvento='".$data['uidEvento']."'";
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
		$evento['fechas'] = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->fecha = $row['fecha'];
			$obj->horaInicio = $row['horaInicio'];
			array_push($evento['fechas'], $obj);
		}
		
		$evento['extras'] = array();
		
		$query = "SELECT * FROM textos_evento WHERE uidEvento='".$data['uidEvento']."'";
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
		$evento['extras']['textos'] = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->idTexto = $row['idTexto'];
			$obj->texto = $row['texto'];
			array_push($evento['extras']['textos'], $obj);
		}	

		$query = "SELECT * FROM directores_evento WHERE uidEvento='".$data['uidEvento']."'";
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
		$evento['extras']['directores'] = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->idDirector = $row['idDirector'];
			array_push($evento['extras']['directores'], $obj);
		}

		$query = "SELECT * FROM compositores_evento WHERE uidEvento='".$data['uidEvento']."'";
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
		$evento['extras']['compositores'] = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->idCompositor = $row['idCompositor'];
			$obj->obras = array();
			array_push($evento['extras']['compositores'], $obj);
		}

		$query = "SELECT * FROM obras_evento WHERE uidEvento='".$data['uidEvento']."'";
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
		$evento['obras'] = array();
		while($row = mysql_fetch_array($result)) {
			for($c=0;$c<count($evento['extras']['compositores']);$c++){
				if($row['idCompositor']==$evento['extras']['compositores'][$c]->idCompositor) {
					array_push($evento['extras']['compositores'][$c]->obras, $row['idObra']);
				}
			}
		}

		$query = "SELECT * FROM solistas_evento WHERE uidEvento='".$data['uidEvento']."'";
		$result = mysql_query($query) or die (json_encode([false,mysql_error()]));
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
			
			// Event Details
			$queryEventDetails = "INSERT INTO ofba_jevents_vevdetail (uidEvento,dtstart,description,summary) VALUES ('".$uidEvento."','".$data['fechas'][$i]."','". $data['desc']."','".""."');";
			mysql_query($queryEventDetails) or die (json_encode([false,mysql_error().', '.$queryEventDetails]));
			$eventDetailId = mysql_insert_id();
			
			$epochDate = $data['fechas'][$i]; 
			$dt = new DateTime("@$epochDate");
			$dt->format('Y-m-d');
			$rawdata = 'a:20:{s:3:"UID";s:32:"'.$uid.'";s:11:"X-EXTRAINFO";s:0:"";s:8:"LOCATION";s:0:"";s:11:"allDayEvent";s:3:"off";s:7:"CONTACT";s:0:"";s:11:"DESCRIPTION";s:'.strlen($data['desc']).':'.$data['desc'].';s:12:"publish_down";s:10:"'.$dt->format('Y-m-d').'";s:10:"publish_up";s:10:"'.$dt->format('Y-m-d').'";s:13:"publish_down2";s:10:"'.$dt->format('Y-m-d').'";s:11:"publish_up2";s:10:"'.$dt->format('Y-m-d').'";s:7:"SUMMARY";s:17:"Giras Extranjeras";s:3:"URL";s:0:"";s:11:"X-CREATEDBY";i:40;s:7:"DTSTART";i:'.$data['fechas'][$i].';s:5:"DTEND";i:'.$data['fechas'][$i].';s:5:"RRULE";a:4:{s:4:"FREQ";s:4:"none";s:5:"COUNT";i:1;s:8:"INTERVAL";s:1:"1";s:5:"BYDAY";s:24:"+1SA,+2SA,+3SA,+4SA,+5SA";}s:8:"MULTIDAY";s:1:"1";s:9:"NOENDTIME";s:1:"1";s:7:"X-COLOR";s:0:"";s:9:"LOCKEVENT";s:1:"0";}';
			
			// Event
			$queryEventData = "INSERT INTO ofba_jevents_vevent (uidEvento,icsid,catid,uid,created_by,modified_by,rawdata,detail_id) VALUES ('".$uidEvento."','"."0"."','"."0"."','". $uid."','"."40"."','"."40"."','".$rawdata."','".$eventDetailId."');";
			mysql_query($queryEventData) or die (json_encode([false,mysql_error().', '.$queryEventData]));
			$eventId = mysql_insert_id();
			
			// Repetition of the event and get the url.
			$uidRepetition = md5(uniqid(rand(), true));
			$queryEventRepetition = "INSERT INTO ofba_jevents_repetition (eventid,uidEvento,eventdetail_id,duplicatecheck,startrepeat,endrepeat) VALUES ('".$eventId."','".$uidEvento."','".$eventDetailId."','".$uidRepetition."','".$dt->format('Y-m-d H:m:s')."','".$dt->format('Y-m-d H:m:s')."');";
			mysql_query($queryEventRepetition) or die (json_encode([false,mysql_error().', '.$queryEventRepetition]));
			$eventRepetitionId = mysql_insert_id();
			$link = "index.php/homepage/listados-completo/icalrepeat.detail/".$dt->format('Y')."/".$dt->format('m')."/".$dt->format('d')."/".$eventRepetitionId;

			// Get last event id
			$queryLastEvento = "SELECT id FROM eventos_perfx ORDER BY id DESC LIMIT 1;";
			$result = mysql_fetch_assoc(mysql_query($queryLastEvento));
			$lastEventPerfxId = $result['id'];
			$newEeventoPerfxId = $lastEventPerfxId+1;
			$queryEventoPerfx = "INSERT INTO eventos_perfx (id,eventid,uidEvento,idTemporada,idCiclo,fecha,horaInicio,link,idLocacion,idpais,giras_nacionalidad,str_titulo) VALUES ('".$newEeventoPerfxId."','".$eventId."','".$uidEvento."','".$data['temporada']."','".$data['ciclo']."','".$dt->format('Y-m-d')."','".$dt->format('H:m:s')."','".$link."','".$data['locacion']."','".$data['pais']."','".$data['nacionalidad']."','".$data['titulo']."');";
			mysql_query($queryEventoPerfx) or die (json_encode([false,mysql_error().', '.$queryEventoPerfx]));
		}

		if($addEvent) {
			$queryDatosEvento = "INSERT INTO datos_evento (uidEvento,link,idTemporada,giras_nacionalidad,idpais,idciudad,idCiclo,idLocacion,str_titulo) VALUES ('".$uidEvento."','".$link."','".$data['temporada']."','".$data['nacionalidad']."','".$data['pais']."','".$data['ciudad']."','".$data['ciclo']."','".$data['locacion']."','".$data['titulo']."');";
			mysql_query($queryDatosEvento) or die (json_encode([false,mysql_error().', '.$queryDatosEvento]));
			// Imagen
			$queryEventImagen = "INSERT INTO imagenes_evento (uidEvento,imagen) VALUES ('".$uidEvento."','". $data['imagen']."');";
			mysql_query($queryEventImagen) or die (json_encode([false,mysql_error().', '.$queryEventImagen]));
			
			// Directores
			for($d=0;$d<count($data['directores']);$d++) {
				$queryEventDirectores = "INSERT INTO directores_evento (idEvento,uidEvento,idDirector) VALUES ('0','".$uidEvento."','". $data['directores'][$d]."');";
				mysql_query($queryEventDirectores) or die (json_encode([false,mysql_error().', '.$queryEventDirectores]));
			}

			// Solistas
			for($s=0;$s<count($data['solistas']);$s++) {
				$queryEventSolistas = "INSERT INTO solistas_evento (idEvento,uidEvento,idSolista) VALUES ('0','".$uidEvento."','". $data['solistas'][$s]."');";
				mysql_query($queryEventSolistas) or die (json_encode([false,mysql_error().', '.$queryEventSolistas]));
			}

			// Compositores
			for($c=0;$c<count($data['compositores']);$c++) {
				$queryEventCompositores = "INSERT INTO compositores_evento (idEvento,uidEvento,idCompositor) VALUES ('0','".$uidEvento."','". $data['compositores'][$c]->id."');";
				$result = mysql_query($queryEventCompositores) or die(json_encode([false,mysql_error().', '.$queryEventCompositores]));
				// Insert obras from each one
				for($o=0;$o<count($data['compositores'][$c]->obras);$o++) {
					$queryObraCompositor = "INSERT INTO obras_evento (idObra,uidEvento,idCompositor) VALUES ('".$data['compositores'][$c]->obras[$o]."','".$uidEvento."','".$data['compositores'][$c]->id."')";
					mysql_query($queryObraCompositor) or die (json_encode([false,mysql_error().', '.$queryObraCompositor]));
				}
			}

			// Textos
			for($t=0;$t<count($data['textos']);$t++) {
				$queryTextosEvento = "INSERT INTO textos_evento (uidEvento,texto,orden) VALUES ('".$uidEvento."','". $data['textos'][$t]."','". ($t+1)."');";
				mysql_query($queryTextosEvento) or die (json_encode([false,mysql_error().', '.$queryTextosEvento]));
			}
		}
			
		$this->close();
	}

	public function deleteEvento($data){
		$this->connect();
		mysql_query('DELETE FROM ofba_jevents_vevent WHERE uidEvento="'.$data['uidEvento'].'"') or die (json_encode([false,mysql_error()]));
		mysql_query('DELETE FROM ofba_jevents_vevdetail WHERE uidEvento="'.$data['uidEvento'].'"') or die (json_encode([false,mysql_error()]));
		mysql_query('DELETE FROM ofba_jevents_repetition WHERE uidEvento="'.$data['uidEvento'].'"') or die (json_encode([false,mysql_error()]));
		mysql_query('DELETE FROM eventos_perfx WHERE uidEvento="'.$data['uidEvento'].'"') or die (json_encode([false,mysql_error()]));
		mysql_query('DELETE FROM datos_evento WHERE uidEvento="'.$data['uidEvento'].'"') or die (json_encode([false,mysql_error()]));
		mysql_query('DELETE FROM textos_evento WHERE uidEvento="'.$data['uidEvento'].'"') or die (json_encode([false,mysql_error()]));
		mysql_query('DELETE FROM imagenes_evento WHERE uidEvento="'.$data['uidEvento'].'"') or die (json_encode([false,mysql_error()]));
		mysql_query('DELETE FROM directores_evento WHERE uidEvento="'.$data['uidEvento'].'"') or die (json_encode([false,mysql_error()]));
		mysql_query('DELETE FROM compositores_evento WHERE uidEvento="'.$data['uidEvento'].'"') or die (json_encode([false,mysql_error()]));
		mysql_query('DELETE FROM obras_evento WHERE uidEvento="'.$data['uidEvento'].'"') or die (json_encode([false,mysql_error()]));
		mysql_query('DELETE FROM solistas_evento WHERE uidEvento="'.$data['uidEvento'].'"') or die (json_encode([false,mysql_error()]));
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

