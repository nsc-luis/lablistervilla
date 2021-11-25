<?php
	include_once ("cConectaBD.php");
	
	class Clientes {
		# Declaracion de variables
		private $idCliente;
		private $nombreCte;
		private $rfcCte;
		private $direccionCte;
		private $serieCte;
		private $folioCte;
		private $tel1Cte;
		private $tel2Cte;
		private $emailCte;
		private $idEstudio;
		private $idPaquete;
		private $precio;
		private $tipoExamen;
		private $publicarResultados;
		private $logoCte;
		private $logoEnOrden;
		private $logoEnResultado;
		private $logoEnReporte;
		private $cveWebCte;
		private $passWebCte;
		public $bd;
		private $msj;
		
		#Metodos
		public function __construct(){
			$this->bd = new ConectaBD();
			return $this->bd;
		}
		public function listaClientes(){
			$sql = "SELECT idCliente, nombreCte, rfcCte, direccionCte, serieCte, publicarResultados, 
				tel1Cte, tel2Cte, emailCte, folioCte, logoEnOrden, logoEnResultado, logoEnReporte, cveWebCte, passWebCte
				FROM clientes
				ORDER BY nombreCte";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		public function getInfoCte($str){
			$sql = "SELECT idCliente, nombreCte, rfcCte, direccionCte, serieCte, publicarResultados, 
				tel1Cte, tel2Cte, emailCte, folioCte, logoEnOrden, logoEnResultado, logoEnReporte, cveWebCte, passWebCte
				FROM clientes 
				WHERE idCliente = '$str'";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		public function editaCliente($str){
			$sql = "UPDATE clientes SET nombreCte = '$this->nombreCte'
				,rfcCte = '$this->rfcCte'
				,direccionCte = '$this->direccionCte'
				,serieCte = '$this->serieCte'
				,tel1Cte = '$this->tel1Cte'
				,tel2Cte = '$this->tel2Cte'
				,emailCte = '$this->emailCte'
				,publicarResultados = '$this->publicarResultados'
				,logoEnOrden = '$this->logoEnOrden'
				,logoEnResultado = '$this->logoEnResultado'
				,logoEnReporte = '$this->logoEnReporte'
				,cveWebCte = '$this->cveWebCte'
				,passWebCte = '$this->passWebCte'
				WHERE idCliente = '$str'";
			$this->bd->consulta($sql);
		}
		public function borraCliente($str){
			$sql = "SELECT * FROM ordendeestudio WHERE idCliente = '$str'";
			$contador = mysqli_num_rows($this->bd->consulta($sql));
			if ($contador > 0) {
				$this->msj = "No se puede eliminar el producto porque tiene movimientos.";
			} else {
				$sql = "DELETE FROM clientes WHERE idCliente = '$str'";
				$this->bd->consulta($sql);
			}
		}
		public function nuevoCliente(){
			date_default_timezone_set('America/Mexico_City');
			function randomString($n){
				$caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$randstring = '';
				for ($i = 0; $i < $n; $i++) {
					$randstring .= $caracteres[rand(0, strlen($caracteres))];
				}
				return $randstring;
			}
			
			$contador = 1;
			
			while ($contador != 0) {
				$cveWebCte = date("Ym") . "-" . randomString(5);
				$sql = "SELECT cveWebCte FROM clientes WHERE cveWebCte = '$cveWebCte'";
				$contador = mysqli_num_rows($this->bd->consulta($sql));
			}
			$passWebCte = randomString(10);
			
			$sql = "SELECT * FROM clientes WHERE nombreCte = '$this->nombreCte'";
			$contador = mysqli_num_rows($this->bd->consulta($sql));
			if ($contador > 0) {
				$this->msj = "El nombre del cliente ya existe, intente otro diferente.";
			} else {
				$sql = "INSERT INTO clientes (nombreCte,rfcCte,
				direccionCte,serieCte,tel1Cte,tel2Cte,emailCte,publicarResultados,logoEnOrden,logoEnResultado,logoEnReporte,logoCte,cveWebCte,passWebCte) 
				VALUES ('$this->nombreCte'
				,'$this->rfcCte'
				,'$this->direccionCte'
				,'$this->serieCte'
				,'$this->tel1Cte'
				,'$this->tel2Cte'
				,'$this->emailCte'
				,'$this->publicarResultados'
				,'$this->logoEnOrden'
				,'$this->logoEnResultado'
				,'$this->logoEnReporte'
				,'$this->logoCte'
				,'$cveWebCte'
				,'$passWebCte')";
				$this->bd->consulta($sql);
			}
			/* $sql = "SELECT * FROM clientes WHERE nombreCte = '$this->nombreCte'";
			$resultado = $this->bd->consulta($sql);
			$datos = mysqli_fetch_assoc($resultado);
			$sql = "INSERT INTO foliosporcliente (idCliente, folioCte)
				VALUES ('$datos[idCliente]', '0')";
			$this->bd->consulta($sql); */
		}
		
		public function relacionCteEstudioPaquetePrecio($str){
			$sql = "SELECT idPrecio, idCliente, idPaquete, tipoExamen, precio, 
				(SELECT cveEstudio FROM estudios WHERE estudios.idEstudio = precios.idEstudio) cveEstudio, 
				(SELECT nombreEstudio FROM estudios WHERE estudios.idEstudio = precios.idEstudio) nombreEstudio, 
				(SELECT cvePaquete FROM paquetesdeestudios WHERE paquetesdeestudios.idPaquete = precios.idPaquete) cvePaquete,
				(SELECT nombrePaquete FROM paquetesdeestudios WHERE paquetesdeestudios.idPaquete = precios.idPaquete) nombrePaquete 
				FROM precios WHERE idCliente = '$str'";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		
		public function agregarEstudioAlCliente () {
			$sql = "INSERT INTO precios (idCliente, idEstudio, idPaquete, tipoExamen, precio)
				VALUES ('$this->idCliente', '$this->idEstudio', '$this->idPaquete', '$this->tipoExamen', '$this->precio')";
			$this->bd->consulta($sql);
		}
		
		public function agregarPaqueteAlCliente () {
			$sql = "INSERT INTO precios (idCliente, idEstudio, idPaquete, tipoExamen, precio)
				VALUES ('$this->idCliente', '$this->idEstudio', '$this->idPaquete', '$this->tipoExamen', '$this->precio')";
			$this->bd->consulta($sql);
		}
		
		public function estudiosPorAgregarAlCte($str) {
			$sql = "SELECT * FROM estudios 
				WHERE idEstudio NOT IN 
				(SELECT idEstudio FROM precios 
				WHERE precios.idEstudio = estudios.idEstudio AND idCliente = '$str')";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		
		public function paquetesPorAgregarAlCte($str) {
			$sql = "SELECT * FROM paquetesdeestudios 
				WHERE idPaquete NOT IN 
				(SELECT idPaquete FROM precios 
				WHERE precios.idPaquete = paquetesdeestudios.idPaquete AND idCliente = '$str')";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		
		public function borrarEstudioPaqueteDelCte($str){
			$sql = "DELETE FROM precios WHERE idPrecio = '$str'";
			$this->bd->consulta($sql);
		}
		
		public function guardarPrecio($str){
			$sql = "UPDATE precios SET precio = '$this->precio'
				WHERE idPrecio = '$str'";
			$this->bd->consulta($sql);
		}
		
		public function agregarLogoCte($str) {
			$sql = "UPDATE clientes SET logoCte = '$this->logoCte'
				WHERE idCliente = '$str'";
			$this->bd->consulta($sql);
		}
		
		/* PORTAL DE CLIENTES */
		
		public function historialPacientePorFechaPortalCliente ($idCte, $fechaInicial, $fechaFinal) {
			$sql = "SELECT o.idDocumento,o.folioDocto,o.fechaDocto,o.idPaciente,o.claveWebDocto,o.idCliente
				,p.idPaciente,p.nombreCompletoPaciente,p.noIMSS
				FROM ordendeestudio o
				JOIN pacientes p ON p.idPaciente = o.idPaciente
				WHERE o.idCliente = '$idCte'
				AND o.fechaDocto BETWEEN '$fechaInicial' AND '$fechaFinal'
			";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		
		public function historialPacientePorNoIMSSPortalCliente ($idCte, $noAfiliacion) {
			$sql = "SELECT o.idDocumento,o.folioDocto,o.fechaDocto,o.idPaciente,o.claveWebDocto,o.idCliente
				,p.idPaciente,p.nombreCompletoPaciente,p.noIMSS
				FROM ordendeestudio o
				JOIN pacientes p ON p.idPaciente = o.idPaciente
				WHERE o.idCliente = '$idCte'
				AND p.noIMSS = '$noAfiliacion'
			";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		
		public function historialPorNombrePacientePortalCliente ($idCte, $nombrePte) {
			$sql = "SELECT o.idDocumento,o.folioDocto,o.fechaDocto,o.idPaciente,o.claveWebDocto,o.idCliente
				,p.idPaciente,p.nombreCompletoPaciente,p.noIMSS
				FROM ordendeestudio o
				JOIN pacientes p ON p.idPaciente = o.idPaciente
				WHERE o.idCliente = '$idCte'
				AND p.nombreCompletoPaciente LIKE '%$nombrePte%'
			";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		
		public function cambiarPassWebCte ($idCte, $nvoPassWebCte) {
			$sql = "UPDATE clientes SET passWebCte = '$nvoPassWebCte'
				WHERE idCliente = '$idCte'";
			$this->bd->consulta($sql);
		}
		
		# GET´s
		public function getIdCliente(){ return $this->idCliente; }
		public function getNombreCte(){ return $this->nombreCte; }
		public function getRfcCte(){ return $this->rfcCte; }
		public function getDireccionCte(){ return $this->direccionCte; }
		public function getserieCte(){ return $this->serieCte; }
		public function getFolioCte(){ return $this->folioCte; }
		public function getTel1Cte(){ return $this->tel1Cte; }
		public function getTel2Cte(){ return $this->tel2Cte; }
		public function getEmailCte(){ return $this->emailCte; }
		public function getPublicarResultados(){ return $this->publicarResultados; }
		public function getLogoCte(){ return $this->logoCte; }
		public function getLogoEnOrden(){ return $this->logoEnOrden; }
		public function getLogoEnResultado(){ return $this->logoEnResultado; }
		public function getLogoEnReporte(){ return $this->logoEnReporte; }
		public function getCveWebCte(){ return $this->cveWebCte; }
		public function getPassWebCte(){ return $this->passWebCte; }
		
		public function getIdEstudio(){ return $this->idEstudio; }
		public function getIdPaquete(){ return $this->idPaquete; }
		public function getTipoExamen(){ return $this->tipoExamen; }
		public function getPrecio(){ return $this->precio; }
		
		public function getMsj(){ return $this->msj; }
		
		# SET´s
		public function setIdCliente($str){ $this->idCliente = $str; }
		public function setNombreCte($str){ $this->nombreCte = $str; }
		public function setRfcCte($str){ $this->rfcCte = $str; }
		public function setDireccionCte($str){ $this->direccionCte = $str; }
		public function setserieCte($str){ $this->serieCte = $str; }
		public function setFolioCte($str){ $this->folioCte = $str; }
		public function setTel1Cte($str){ $this->tel1Cte = $str; }
		public function setTel2Cte($str){ $this->tel2Cte = $str; }
		public function setEmailCte($str){ $this->emailCte = $str; }
		public function setPublicarResultados($str){ $this->publicarResultados = $str; }
		public function setLogoCte($str){ $this->logoCte = $str; }
		public function setLogoEnOrden($str){ $this->logoEnOrden = $str; }
		public function setLogoEnResultado($str){ $this->logoEnResultado = $str; }
		public function setLogoEnReporte($str){ $this->logoEnReporte = $str; }
		public function setCveWebCte($str){ $this->cveWebCte = $str; }
		public function setPassWebCte($str){ $this->passWebCte = $str; }
		
		public function setIdEstudio($str){ $this->idEstudio = $str; }
		public function setIdPaquete($str){ $this->idPaquete = $str; }
		public function setTipoExamen($str){ $this->tipoExamen = $str; }
		public function setPrecio($str){ $this->precio = $str; }
	}
?>