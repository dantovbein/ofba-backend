<?
class Storage {
	public $host = "";	
	public $username = "";
	public $password = "";
	public $dataBase = "";
	private $sql;

	public function Storage() {
		$debug = !true;
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
		$query = "SELECT *,i.id as idIntegrante,ins.codigoTexto as codigoTexto_instrumento FROM integrantes as i LEFT JOIN instrumentos as ins ON i.idInstrumento=ins.id LEFT JOIN nacionalidades_perfx as nac ON i.idNacionalidad=nac.id LEFT JOIN tipos_integrante as tint ON i.idTipoIntegrante=tint.id LEFT JOIN tipos_director as tdir ON i.idTipoIntegrante=tdir.id ORDER BY i.nombres ASC";		
		$result = mysql_query($query) or die ("Error en la consulta de los integrantes");
		
		$data = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			$obj->id = $row['idIntegrante'];
			$obj->nombres = $this->utf8ize($row['nombres']);
			$obj->apellidos = $this->utf8ize($row['apellidos']);
			$obj->idTipoIntegrante = $row['idTipoIntegrante'];
			$obj->idInstrumento = $row['idInstrumento'];
			$obj->idNacionalidad = $row['idNacionalidad'];
			$obj->idTipoDirector = $row['idTipoDirector'];
			$obj->strNacionalidad = $row['str_nacionalidad'];
			$obj->codigoTextoInstrumento = $this->utf8ize($row['codigoTexto_instrumento']);
			$obj->codigoNacionalidad = $row['codigoNacionalidad'];
			$obj->codigoTextoTipoIntegrante = $this->utf8ize($row['codigoTexto']);
			$obj->codigoTipoDirector = $row['codigoTipo'];
			array_push($data, $obj);
		}
		echo json_encode($data);
		$this->close();
	}

	public function postIntegrante($data){
		$this->connect();
		$query = 'INSERT INTO integrantes (nombres,apellidos,idInstrumento,idTipoDirector,idTipoIntegrante,idNacionalidad,str_nacionalidad) VALUES ("' . $data['nombres'] . '","' . $data['apellidos'] . '","' . $data['idInstrumento'] . '","' . $data['idTipoDirector'] . '","' . $data['idTipoIntegrante'] . '","' . $data['idNacionalidad'] . '","' . $data['strNacionalidad'] . '");';
		$result = mysql_query($query) or die('Error en la consulta -> ' .  $query);
		echo mysql_insert_id();
		$this->close();
	}

	public function editIntegrante($data){
		$this->connect();
		$query = 'UPDATE integrantes SET nombres="' . $data['nombres'] . '", apellidos="' . $data['apellidos'] . '", idInstrumento="' . $data['idInstrumento'] . '", idTipoDirector="' . $data['idTipoDirector'] . '", idTipoIntegrante="' . $data['idTipoIntegrante'] . '", idNacionalidad="' . $data['idNacionalidad'] . '", str_nacionalidad="' . $data['strNacionalidad'] . '" WHERE id=' . $data['id'];
		$result = mysql_query($query) or die('Error en la consulta -> ' .  $query);
		echo mysql_insert_id();
		$this->close();
	}

	public function deleteIntegrante($data) {
		$this->connect();
		$query = 'DELETE FROM integrantes WHERE id=' . $data['id'];
		$result = mysql_query($query) or die('Error en la consulta -> ' .  $query);
		$this->close();
	}

	public function getInstrumentos() {
		$this->connect();
		$query = "SELECT * FROM instrumentos ORDER BY codigoTexto ASC";
		$result = mysql_query($query) or die ("Error en la consulta de los instrumentos");
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
		$result = mysql_query($query) or die ("Error en la consulta de los directores");
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
		$result = mysql_query($query) or die ("Error en la consulta de los integrantes");
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
		$result = mysql_query($query) or die ("Error en la consulta de las imagenes");
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
		$result = mysql_query($query) or die('Error en la consulta -> ' .  $query);

		$idImagen = mysql_insert_id();

		$query = 'UPDATE imagenes SET codigoTexto="' . 'IMG_GALLERY_IMG_' . $idImagen . '" WHERE id="' . $idImagen . '"';
		$result = mysql_query($query) or die('Error en la consulta -> ' .  $query);

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
		$result = mysql_query($query) or die ("Error en la consulta de los textos");
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
		$result = mysql_query($query) or die('Error en la consulta -> ' .  $query);
		$this->close();
	}

	public function getTexto($codigo) {
		$this->connect();
		$query = "SELECT * FROM textos WHERE codigo='" . $codigo . "'";
		$result = mysql_query($query) or die ("Error en la consulta del texto");
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
		$result = mysql_query($query) or die('Error en la consulta -> ' .  $query);
		echo mysql_insert_id();
		$this->close();
	}

	public function editTexto($data){
		$this->connect();
		$query = 'UPDATE textos SET texto="' . $data['texto'] . '", codigo="' . $data['codigoTexto'] . '" WHERE codigo="' . $data['codigoTexto'] . '"';
		$result = mysql_query($query) or die('Error en la consulta -> ' .  $query);
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
			$obj->strAtributos = $row['str_atributos'];
			$obj->strConpositor = $row['str_Compositor'];
			$obj->idOrden = $row['idOrden'];
			$obj->idTemporada = $row['idTemporada'];
			$obj->idCiclo = $row['idCiclo'];
			$obj->codigoTitulo = $row['codigoTitulo'];
			$obj->fecha = $row['fecha'];
			$obj->horaInicio = $row['horaInicio'];
			$obj->horaFin = $row['horaFin'];
			$obj->codigoTexto = $row['codigoTexto'];
			$obj->link = $row['link'];
			$obj->idLocacion = $row['idLocacion'];
			$obj->strTitulo = $row['str_titulo'];
			$obj->strTemporada = $row['str_temporada'];
			$obj->strCiclo = $row['str_ciclo'];
			$obj->strLocacion = $row['str_locacion'];
			$obj->idPais = $row['idpais'];
			$obj->strCiudad = $row['str_ciudad'];
			$obj->girasNacionalidad = $row['giras_nacionalidad'];
			$obj->idIntegrante = $row['id'];
			$obj->nombres = $row['nombres'];
			$obj->apellidos = $row['apellidos'];
			$obj->idTipoIntegrante = $row['idTipoIntegrante'];
			$obj->idInstrumento = $row['idInstrumento'];
			$obj->idNacionalidad = $row['idNacionalidad'];
			$obj->idTipoDirector = $row['idTipoDirector'];
			$obj->strNacionalidad = $row['str_nacionalidad'];
			array_push($data, $obj);
		}
		echo json_encode($data);
		$this->close();
	}

	public function getGiras() {
		$this->connect();
		$query = "SELECT * FROM giras as g LEFT JOIN temporadas as t ON g.idTemporada=t.id LEFT JOIN nacionalidades_perfx as n ON g.idnacionalidad=n.id";
		$result = mysql_query($query) or die ("Error en la consulta de las giras");
		$data = array();
		while($row = mysql_fetch_array($result)) {
			$obj = new stdClass;
			// Guardar columnas
			array_push($data, $obj);
		}
		echo json_encode($data);
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

