<?php
	include_once ("cConectaBD.php");
	
	class OrdenDeEstudio {
		# Declaracion de variables
		private $idDocumento;
		private $idOds_EyP;
		// private $folioDocto;
		private $idPrecio;
		private $idCliente;
		private $idEstudio;
		private $cveEstudio;
		private $nombreEstudio;
		private $idPaciente;
		private $edadDelPaciente;
		private $cvePaquete;
		private $nombrePaquete;
		private $tipoExamen;
		private $precio;
		private $observacionDocto;
		private $idUsuario;
		private $idPerfil;
		private $limiteInferiorEstudio;
		private $limiteSuperiorEstudio;
		private $unidadDeMedida;
		private $tipoDeParametro;
		private $valorDeReferencia;
		private $referencia;
		private $resultadoValorDeReferencia;
		private $textoLibre;
		private $publicarResultado;
		
		public $bd;
		private $msj;
		
		#Metodos
		public function __construct(){
			$this->bd = new ConectaBD();
			return $this->bd;
		}
		
		public function ordenesDeEstudios($str1,$str2){
			/* date_default_timezone_set('America/Mexico_City');
			$fechaFinal = date("Y-m-d");
			$fechaInicial = date("Y-m-d", strtotime("-30 days")); */
			
			$filtrarOrdenes = $this->idPerfil == "1" ? "" : "AND o.idUsuario = '$this->idUsuario'";
			
			/* $sql = "SELECT * FROM ordendeestudio 
				JOIN clientes ON clientes.idCliente = ordendeestudio.idCliente 
				JOIN pacientes ON pacientes.idPaciente = ordendeestudio.idPaciente 
				WHERE fechaDocto BETWEEN '$fechaInicial' AND '$fechaFinal'
				$filtrarOrdenes
				ORDER BY ordendeestudio.folioCte ASC, clientes.nombreCte ASC"; */
				
			$sql = "SELECT o.idDocumento, o.folioCte, o.idCliente, o.idPaciente, o.importeDocto, 
				o.fechaDocto, o.idUsuario, p.noIMSS, p.nombreCompletoPaciente, c.idCliente, c.nombreCte
				FROM ordendeestudio o
				JOIN clientes c ON c.idCliente = o.idCliente 
				JOIN pacientes p ON p.idPaciente = o.idPaciente 
				WHERE o.fechaDocto BETWEEN '$str1' AND '$str2'
				$filtrarOrdenes
				ORDER BY c.nombreCte ASC, o.folioCte DESC";
				
			/* $sql = "SELECT o.idDocumento, o.folioCte, o.idCliente, o.idPaciente, o.importeDocto, 
				o.fechaDocto, o.idUsuario, p.noIMSS, p.nombreCompletoPaciente, c.idCliente, c.nombreCte
				FROM ordendeestudio o
				JOIN clientes c ON c.idCliente = o.idCliente 
				JOIN pacientes p ON p.idPaciente = o.idPaciente 
				WHERE o.fechaDocto = '$fechaInicial'
				$filtrarOrdenes
				ORDER BY c.nombreCte ASC, o.folioCte DESC"; */
			
			$data = $this->bd->consulta($sql);
			return $data;
		}
		
		public function rptCobPorCte($idUsr, $idCte, $fInicial, $fFinal){
			$fechaFinal = $fFinal;
			$fechaInicial = $fInicial;
			
			$sql = "SELECT o.idDocumento, o.folioDocto, o.fechaDocto, o.idPaciente, o.edadDelPaciente, o.claveWebDocto, o.idCliente, o.folioCte, o.importeDocto, o.observacionDocto, o.publicarResultado, o.idUsuario, c.idCliente, c.nombreCte, p.noIMSS, p.nombreCompletoPaciente
				FROM ordendeestudio o
				JOIN clientes c ON c.idCliente = o.idCliente 
				JOIN pacientes p ON p.idPaciente = o.idPaciente 
				WHERE o.fechaDocto BETWEEN '$fechaInicial' AND '$fechaFinal'
				AND o.idUsuario = '$idUsr'
				AND o.idCliente = '$idCte'
				AND o.importeDocto != '0'
				ORDER BY o.folioCte DESC";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		
		public function totalRptCobPorCte($idUsr, $idCte, $fInicial, $fFinal){
			$fechaFinal = $fFinal;
			$fechaInicial = $fInicial;

			$sql = "SELECT SUM(importeDocto) as total FROM ordendeestudio 
				WHERE fechaDocto BETWEEN '$fechaInicial' AND '$fechaFinal'
				AND idUsuario = '$idUsr'
				AND ordendeestudio.idCliente = '$idCte'";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		
		public function orden($cte, $folio){
			$sql = "SELECT o.idDocumento, o.folioCte, o.claveWebDocto, o.fechaDocto, o.observacionDocto, 
				o.idPaciente, o.publicarResultado, p.nombreCompletoPaciente, p.noIMSS, p.genero, 
				p.emailPaciente, o.importeDocto, o.edadDelPaciente, o.idCliente, c.nombreCte 
				FROM ordendeestudio o 
				JOIN clientes c ON c.idCliente = o.idCliente 
				JOIN pacientes p ON p.idPaciente = o.idPaciente 
				WHERE o.folioCte = '$folio' AND o.idCliente = '$cte'";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		
		public function ordenEnPDF($str){
			$sql = "SELECT o.idDocumento, o.folioCte, o.claveWebDocto, o.fechaDocto, o.observacionDocto, 
				o.idPaciente, o.publicarResultado, p.nombreCompletoPaciente, p.noIMSS, p.genero, 
				p.emailPaciente, o.importeDocto, o.edadDelPaciente, o.idCliente, c.nombreCte 
				FROM ordendeestudio o 
				JOIN clientes c ON c.idCliente = o.idCliente 
				JOIN pacientes p ON p.idPaciente = o.idPaciente 
				WHERE o.claveWebDocto = '$str'";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		
		public function partidasDeLaOrden($cte, $folio){
			$sql = "SELECT * FROM ods_estudiosypaquetes 
				WHERE folioCte = '$folio' AND idPrecio != '0'
				AND idCliente = '$cte'
				ORDER BY idOds_EyP";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		
		public function ods_estudios($str) {
			$sql = "SELECT * FROM precios
				JOIN estudios ON estudios.idEstudio = precios.idEstudio
				WHERE idCliente = '$str'";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		
		public function ods_paquetes($str) {
			$sql = "SELECT * FROM precios
			JOIN paquetesdeestudios ON paquetesdeestudios.idPaquete = precios.idPaquete
			WHERE precios.idCliente = '$str'";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		
		public function agregarEstudioAOrden(){
			$sql = "SELECT * FROM ods_estudiosypaquetes
				WHERE folioCte = '$this->folioCte' 
				AND idCliente = '$this->idCliente'
				AND idPrecio = '$this->idPrecio'";
			$contador = mysqli_num_rows($this->bd->consulta($sql));
			if ($contador > 0) {
				$this->msj = "El estudio/paquete seleccionado ya esta agregado a la orden.";
			} elseif ($this->tipoExamen == "Estudio") {
				# INSERTA NUEVO ESTUDIO A LA ORDEN (NUEVA PARTIDA)
				$sql = "INSERT INTO ods_estudiosypaquetes (folioCte, idPrecio, idCliente, idEstudio, cveEstudio, nombreEstudio, limiteInferiorEstudio, limiteSuperiorEstudio, unidadDeMedida, tipoDeParametro, valorDeReferencia, tipoExamen, precio)
					VALUES ('$this->folioCte', '$this->idPrecio', '$this->idCliente', '$this->idEstudio', '$this->cveEstudio', '$this->nombreEstudio', '$this->limiteInferiorEstudio', '$this->limiteSuperiorEstudio', '$this->unidadDeMedida', '$this->tipoDeParametro', '$this->valorDeReferencia', '$this->tipoExamen', '$this->precio')";
				$this->bd->consulta($sql);
			} else { # INSERTA NUEVO PAQUETE A LA ORDEN (NUEVA PARTIDA)
				$sql = "INSERT INTO ods_estudiosypaquetes (folioCte, idPrecio, idCliente, idPaquete, cvePaquete, nombrePaquete, tipoExamen, precio)
						VALUES ('$this->folioCte', '$this->idPrecio', '$this->idCliente', '$this->idPaquete', '$this->cvePaquete', '$this->nombrePaquete', '$this->tipoExamen', '$this->precio')";
				$this->bd->consulta($sql);
				
				$sql = "SELECT * FROM paquetesdeestudios_detalle
					JOIN estudios ON estudios.idEstudio = paquetesdeestudios_detalle.idEstudio
					WHERE idPaquete = '$this->idPaquete'";
				$result = $this->bd->consulta($sql);
				while ($row = mysqli_fetch_array($result)) {
					$idEstudio = $row['idEstudio'];
					$cveEstudio = $row['cveEstudio'];
					$nombreEstudio = $row['nombreEstudio'];
					$limiteInferiorEstudio = $row['limiteInferiorEstudio'];
					$limiteSuperiorEstudio = $row['limiteSuperiorEstudio'];
					$unidadDeMedida = $row['unidadDeMedida'];
					$tipoDeParametro = $row['tipoDeParametro'];
					$valorDeReferencia = $row['valorDeReferencia'];
					
					if ($tipoDeParametro == 'limites') {
						$valorDeReferencia = $limiteInferiorEstudio . "-" . $limiteSuperiorEstudio . " " . $unidadDeMedida;
					}
					
					$sql = "INSERT INTO ods_estudiosypaquetes (folioCte, idEstudio, cveEstudio, nombreEstudio, limiteInferiorEstudio, limiteSuperiorEstudio, unidadDeMedida, tipoDeParametro, valorDeReferencia, idPaquete, cvePaquete, idCliente)
						VALUES ('$this->folioCte', '$idEstudio', '$cveEstudio', '$nombreEstudio', '$limiteInferiorEstudio', '$limiteSuperiorEstudio', '$unidadDeMedida', '$tipoDeParametro', '$valorDeReferencia', '$this->idPaquete', '$this->cvePaquete', '$this->idCliente')";
					$this->bd->consulta($sql);
				}
				mysqli_free_result($result);
			}
			$sql = "SELECT SUM(precio) importeTotal FROM ods_estudiosypaquetes 
				WHERE folioCte = '$this->folioCte' AND idCliente = '$this->idCliente'";
			$sumaDeImportes = mysqli_fetch_assoc($this->bd->consulta($sql));
			$sql = "UPDATE ordendeestudio SET importeDocto = '$sumaDeImportes[importeTotal]'
				WHERE folioCte = '$this->folioCte' AND idCliente = '$this->idCliente'";
			$this->bd->consulta($sql);
		}
		
		public function borrarPartidaOrdenDeEstudio($str) {
			# BORRA REGISTROS DE ESTUDIOS DE UN PAQUETE COMO PARTIDA
			if ($this->tipoExamen == 'Paquete') {
				$sql = "DELETE FROM ods_estudiosypaquetes
					WHERE folioCte = '$this->folioCte' AND idPaquete = '$this->idPaquete'
					AND idCliente = '$this->idCliente'";
				$this->bd->consulta($sql);
			}
			
			# BORRA PARTIDAS DE LA ORDEN DE ESTUDIOS
			$sql = "DELETE FROM ods_estudiosypaquetes
				WHERE idOds_EyP='$str'";
			$this->bd->consulta($sql);
			
			# ACTUALIZA EL IMPORTE ($) DE LA ORDEN DE ESTUDIO
			$sql = "SELECT SUM(precio) importeTotal FROM ods_estudiosypaquetes 
				WHERE folioCte = '$this->folioCte'";
			$sumaDeImportes = mysqli_fetch_assoc($this->bd->consulta($sql));
			$sql = "UPDATE ordendeestudio SET importeDocto = '$sumaDeImportes[importeTotal]'
				WHERE folioCte = '$this->folioCte' AND idCliente = '$this->idCliente'";
			$this->bd->consulta($sql);
		}
		
		public function guardarPrecioPartida($str) {
			$sql = "UPDATE ods_estudiosypaquetes SET precio = '$this->precio'
				WHERE idOds_EyP='$str'";
			$this->bd->consulta($sql);
			$sql = "SELECT SUM(precio) importeTotal FROM ods_estudiosypaquetes 
				WHERE folioCte = '$this->folioCte' AND idCliente = '$this->idCliente'";
			$sumaDeImportes = mysqli_fetch_assoc($this->bd->consulta($sql));
			$sql = "UPDATE ordendeestudio SET importeDocto = '$sumaDeImportes[importeTotal]'
				WHERE folioCte = '$this->folioCte' AND idCliente = '$this->idCliente'";
			$this->bd->consulta($sql);
		}
		
		public function guardarObservacionDocto() {
			$sql = "UPDATE ordendeestudio SET observacionDocto = '$this->observacionDocto'
				WHERE folioCte = '$this->folioCte'
				AND idCliente = '$this->idCliente'";
			$this->bd->consulta($sql);
		}
		
		public function nvaOrdenDeEstudio() {
			date_default_timezone_set('America/Mexico_City');
			function randomString($n){
				$caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$randstring = '';
				for ($i = 0; $i < $n; $i++) {
					$randstring .= $caracteres[rand(0, strlen($caracteres))];
				}
				return $randstring;
			}
		
			$sql = "SELECT folioCte FROM ordendeestudio 
				WHERE idCliente = '$this->idCliente' 
				ORDER BY folioCte DESC LIMIT 1";
			$ultimoFolio = mysqli_fetch_assoc($this->bd->consulta($sql));
			$nvoFolioDocto = $ultimoFolio['folioCte'] + 1;
			$fechaActual = date("Y-m-d");
			
			$contador = 1;
			while ($contador != 0) {
				$claveWebDocto = date("Ymd") . "-" . randomString(9);
				$sql = "SELECT claveWebDocto FROM ordendeestudio WHERE claveWebDocto = '$claveWebDocto'";
				$contador = mysqli_num_rows($this->bd->consulta($sql));
			}
			
			$sql = "SELECT publicarResultados FROM clientes
				WHERE idCliente = '$this->idCliente'";
			$resultado = $this->bd->consulta($sql);
			$pubResult = mysqli_fetch_assoc($resultado);
			
			/* $sql = "SELECT (SELECT (DATEDIFF((SELECT CURDATE()),fechaDeNacimiento)/365)) edadActual FROM pacientes
				WHERE idPaciente = '$this->idPaciente'"; */
			$sql = "SELECT edadDelPaciente FROM pacientes
				WHERE idPaciente = '$this->idPaciente'";
			$resultado = $this->bd->consulta($sql);
			$edadDelPaciente = mysqli_fetch_assoc($resultado);
			// $edadActual = explode(".", $edadDelPaciente['edadActual']);
			
			$sql = "INSERT INTO ordendeestudio (folioCte, fechaDocto, idPaciente, edadDelPaciente, claveWebDocto, idCliente, importeDocto, observacionDocto, publicarResultado, idUsuario)
				VALUES ('$nvoFolioDocto', '$fechaActual', '$this->idPaciente', '$edadDelPaciente[edadDelPaciente]', '$claveWebDocto', '$this->idCliente', '0', '', '$pubResult[publicarResultados]', '$this->idUsuario')";
			$this->bd->consulta($sql);
			
			$sql = "UPDATE clientes SET folioCte = '$nvoFolioDocto'
				WHERE idCliente = '$this->idCliente'";
			$this->bd->consulta($sql);
			
			return $nvoFolioDocto;
		}
		
		public function cambiarEdadDelPaciente() {
			$sql = "UPDATE ordendeestudio SET edadDelPaciente = '$this->edadDelPaciente'
				WHERE folioCte = '$this->folioCte'
				AND idCliente = '$this->idCliente'";
			$this->bd->consulta($sql);
		}
		
		public function borrarFolioDocto($folio, $cte) {
			$sql = "DELETE FROM ordendeestudio WHERE folioCte = '$folio'
			AND idCliente = '$cte'";
			$this->bd->consulta($sql);
			$sql = "DELETE FROM ods_estudiosypaquetes WHERE folioCte = '$folio'
			AND idCliente = '$cte'";
			$this->bd->consulta($sql);
		}
		
		public function estudiosParaCapturaDeResultados() {
			$sql = "SELECT * FROM ods_estudiosypaquetes
				WHERE folioCte = '$this->folioCte' AND cvePaquete = '$this->cvePaquete' AND nombrePaquete = ''
				AND idCliente = '$this->idCliente'
				ORDER BY idOds_EyP ASC";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		
		public function paquetesParaCapturaDeResultados() {
			$sql = "SELECT DISTINCT cvePaquete, nombrePaquete 
				FROM ods_estudiosypaquetes 
				WHERE folioCte = '$this->folioCte' 
				AND idCliente = '$this->idCliente'
				AND tipoExamen <> '' ORDER BY idOds_EyP ASC";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		
		public function guardarResultadoEnTextoLibre() {
			$sql = "UPDATE ods_estudiosypaquetes SET textoLibre = '$this->textoLibre'
				WHERE idOds_EyP = '$this->idOds_EyP'";
			$this->bd->consulta($sql);
		}
		
		public function guardarResultadoValorDeReferencia() {
			$sql = "UPDATE ods_estudiosypaquetes SET resultadoValorDeReferencia = '$this->resultadoValorDeReferencia'
				WHERE idOds_EyP = '$this->idOds_EyP'";
			$this->bd->consulta($sql);
		}
		
		public function publicarResultado() {
			$sql = "UPDATE ordendeestudio SET publicarResultado = '$this->publicarResultado'
				WHERE folioCte = '$this->folioCte'
				AND idCliente = '$this->idCliente'";
			$this->bd->consulta($sql);
		}
		
		public function buscarResultadoPorClaveWeb($str) {
			$sql = "SELECT claveWebDocto FROM ordendeestudio
				WHERE claveWebDocto LIKE BINARY '$str'";
			$contador = mysqli_num_rows($this->bd->consulta($sql));
			if ($contador == 0) {
				$this->msj = "
					<span class='ui-icon ui-icon-alert'></span><strong>Error: </strong>
					La ClaveWeb capturada es incorrecta, favor de verificar.
					<br />Se debe respetar MAYUSCULAS y minusculas al teclear la ClaveWeb.
				";
			}
		}
		
		#GET´s
		public function getMsj() { return $this->msj; }
		
		#SET´s Estudios
		public function setIdOds_EyP($str) { $this->idOds_EyP = $str; }
		public function setFolioDocto($str) { $this->folioDocto = $str; }
		public function setIdPrecio($str) { $this->idPrecio = $str; }
		public function setIdCliente($str) { $this->idCliente = $str; }
		public function setFolioCte($str) { $this->folioCte = $str; }
		public function setIdEstudio($str) { $this->idEstudio = $str; }
		public function setCveEstudio($str) { $this->cveEstudio = $str; }
		public function setNombreEstudio($str) { $this->nombreEstudio = $str; }
		public function setLimiteInferiorEstudio($str) { $this->limiteInferiorEstudio = $str; }
		public function setLimiteSuperiorEstudio($str) { $this->limiteSuperiorEstudio = $str; }
		public function setUnidadDeMedida($str) { $this->unidadDeMedida = $str; }
		public function setTipoDeParametro($str) { $this->tipoDeParametro = $str; }
		public function setValorDeReferencia($str) { $this->valorDeReferencia = $str; }
		public function setPublicarResultado($str) { $this->publicarResultado = $str; }
		
		#SET´s Paquetes
		public function setIdPaquete($str) { $this->idPaquete = $str; }
		public function setCvePaquete($str) { $this->cvePaquete = $str; }
		public function setNombrePaquete($str) { $this->nombrePaquete = $str; }
		
		#SET´s Generales Orden de estudio
		public function setTipoExamen($str) { $this->tipoExamen = $str; }
		public function setPrecio($str) { $this->precio = $str; }
		public function setObservacionDocto($str) { $this->observacionDocto = $str; }
		public function setIdPaciente($str) { $this->idPaciente = $str; }
		public function setEdadDelPaciente($str) { $this->edadDelPaciente = $str; }
		public function setIdUsuario($str) { $this->idUsuario = $str; }
		public function setIdPerfil($str) { $this->idPerfil = $str; }
		
		#SET´s resultados de estudios
		public function setReferencia($str) { $this->referencia = $str; }
		public function setResultadoValorDeReferencia($str) { $this->resultadoValorDeReferencia = $str; }
		public function setTextoLibre($str) { $this->textoLibre = $str; }
	}
?>