<?php
	include_once ("cConectaBD.php");
	date_default_timezone_set('UTC');
	
	class Pacientes {
		# Declaracion de variables
		private $idPaciente;
		private $nombrePaciente;
		private $apellidoPaternoPaciente;
		private $apellidoMaternoPaciente;
		private $nombreCompletoPaciente;
		private $direccionPaciente;
		private $genero;
		private $fechaDeNacimiento;
		private $edadDelPaciente;
		private $emailPaciente;
		private $noIMSS;
		private $cvePaciente;
		private $passPaciente;
		private $idCliente;
		private $altaPaciente;
		private $idPerfil;
		private $idUsuario;
		public $bd;
		private $msj;
		
		#Metodos
		public function __construct(){
			$this->bd = new ConectaBD();
			return $this->bd;
		}
		public function listaPacientes(){
			date_default_timezone_set('America/Mexico_City');
			$fechaFinal = date("Y-m-d");
			// $fechaInicial = date("Y-m-d", strtotime("-7 days"));
			
			$fechaInicial = date("Y-m-d");
			$filtrarPacientes = $this->idPerfil == "1" ? "" : "AND idUsuario = '$this->idUsuario'";
			
			/* $sql = "SELECT * FROM pacientes
				INNER JOIN clientes ON clientes.idCliente = pacientes.idCliente
				WHERE altaPaciente BETWEEN '$fechaInicial' AND '$fechaFinal'
				ORDER BY nombrePaciente"; */
				
			$sql = "SELECT p.idPaciente,p.nombrePaciente,p.apellidoPaternoPaciente,p.apellidoMaternoPaciente,
				p.nombreCompletoPaciente,p.direccionPaciente,p.genero,p.fechaDeNacimiento,p.edadDelPaciente,p.emailPaciente,p.noIMSS,
				p.cvePaciente,p.passPaciente,p.idCliente,p.altaPaciente,c.idCliente,c.nombreCte,c.rfcCte,c.direccionCte,
				c.serieCte,c.publicarResultados,c.tel1Cte,c.tel2Cte,c.emailCte,c.folioCte,c.logoEnOrden,c.logoEnResultado,c.logoEnReporte
				FROM pacientes p
				JOIN clientes c ON c.idCliente = p.idCliente
				WHERE altaPaciente = '$fechaInicial'
				$filtrarPacientes
				ORDER BY nombrePaciente";
				
			$data = $this->bd->consulta($sql);
			return $data;
		}
		public function getInfoPaciente($str,$filtro){
			
			$filtrarPacientes = $this->idPerfil == "1" ? "" : "AND p.idUsuario = '$this->idUsuario'";
			
			$sql = "SELECT p.idPaciente,p.nombrePaciente,p.apellidoPaternoPaciente,p.apellidoMaternoPaciente,
				p.nombreCompletoPaciente,p.direccionPaciente,p.genero,p.fechaDeNacimiento,p.edadDelPaciente,p.emailPaciente,p.noIMSS,
				p.cvePaciente,p.passPaciente,p.idCliente,p.altaPaciente,p.idUsuario,c.idCliente,c.nombreCte,c.rfcCte,c.direccionCte,
				c.serieCte,c.publicarResultados,c.tel1Cte,c.tel2Cte,c.emailCte,c.folioCte,c.logoEnOrden,c.logoEnResultado,c.logoEnReporte
				FROM pacientes p
				JOIN clientes c ON c.idCliente = p.idCliente
				WHERE $filtro LIKE '%$str%'
				$filtrarPacientes
				ORDER BY nombrePaciente";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		
		public function infoPaciente($idPte){
			
			$sql = "SELECT p.idPaciente,p.nombrePaciente,p.apellidoPaternoPaciente,p.apellidoMaternoPaciente,
				p.nombreCompletoPaciente,p.direccionPaciente,p.genero,p.fechaDeNacimiento,p.edadDelPaciente,p.emailPaciente,p.noIMSS,
				p.cvePaciente,p.passPaciente,p.idCliente,p.altaPaciente,p.idUsuario,c.idCliente,c.nombreCte,c.rfcCte,c.direccionCte,
				c.serieCte,c.publicarResultados,c.tel1Cte,c.tel2Cte,c.emailCte,c.folioCte,c.logoEnOrden,c.logoEnResultado,c.logoEnReporte
				FROM pacientes p
				JOIN clientes c ON c.idCliente = p.idCliente
				WHERE idPaciente = '$idPte'";
			$data = $this->bd->consulta($sql);
			return $data;
			// echo $sql;
		}
		
		public function editaPaciente($str){
			$nombreCompletoPaciente = $this->nombrePaciente . " " . $this->apellidoPaternoPaciente . " " . $this->apellidoMaternoPaciente;
			$sql = "UPDATE pacientes SET nombrePaciente = '$this->nombrePaciente'
				,apellidoPaternoPaciente = '$this->apellidoPaternoPaciente'
				,apellidoMaternoPaciente = '$this->apellidoMaternoPaciente'
				,nombreCompletoPaciente = '$nombreCompletoPaciente'
				,direccionPaciente = '$this->direccionPaciente'
				,genero = '$this->genero'
				,fechaDeNacimiento = '$this->fechaDeNacimiento'
				,edadDelPaciente = '$this->edadDelPaciente'
				,emailPaciente = '$this->emailPaciente'
				,noIMSS = '$this->noIMSS'
				,idCliente = '$this->idCliente'
				WHERE idPaciente = '$str'";
			$this->bd->consulta($sql);
		}
		public function borraPaciente($str){
			$sql = "SELECT * FROM ordendeestudio WHERE idPaciente = '$str'";
			$contador = mysqli_num_rows($this->bd->consulta($sql));
			if ($contador > 0) {
				$this->msj = "No se puede eliminar el paciente porque tiene movimientos.";
			} else {
				$sql = "DELETE FROM pacientes WHERE idPaciente = '$str'";
				$this->bd->consulta($sql);
			}
		}
		public function nuevoPaciente(){
			date_default_timezone_set('America/Mexico_City');
			function randomString($n){
				$caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$randstring = '';
				for ($i = 0; $i < $n; $i++) {
					$randstring .= $caracteres[rand(0, strlen($caracteres))];
				}
				return $randstring;
			}
			$cvePaciente = date("Ym") . "-" . randomString(5);
			$nombreCompletoPaciente = $this->nombrePaciente . " " . $this->apellidoPaternoPaciente . " " . $this->apellidoMaternoPaciente;
			$passPaciente = randomString(10);
			$altaPaciente = date("Y-m-d");
			
			$contador = 1;
			
			while ($contador != 0) {
				$cvePaciente = date("Ym") . "-" . randomString(5);
				$sql = "SELECT * FROM pacientes WHERE cvePaciente = '$cvePaciente'";
				$contador = mysqli_num_rows($this->bd->consulta($sql));
			}
			
			$sql = "INSERT INTO pacientes (nombrePaciente,apellidoPaternoPaciente,apellidoMaternoPaciente
			,nombreCompletoPaciente,direccionPaciente,genero,fechaDeNacimiento,edadDelPaciente,emailPaciente,noIMSS
			,cvePaciente,passPaciente,idCliente,altaPaciente,idUsuario) 
			VALUES ('$this->nombrePaciente'
			,'$this->apellidoPaternoPaciente'
			,'$this->apellidoMaternoPaciente'
			,'$nombreCompletoPaciente'
			,'$this->direccionPaciente'
			,'$this->genero'
			,'$this->fechaDeNacimiento'
			,'$this->edadDelPaciente'
			,'$this->emailPaciente'
			,'$this->noIMSS'
			,'$cvePaciente'
			,'$passPaciente'
			,'$this->idCliente'
			,'$altaPaciente'
			,'$this->idUsuario')";
			$this->bd->consulta($sql);
		}
		
		public function cambiarOpcionesDelPaciente() {
			$sql = "UPDATE pacientes SET passPaciente = '$this->passPaciente'
				,emailPaciente = '$this->emailPaciente'
				WHERE idPaciente = '$this->idPaciente'";
			$this->bd->consulta($sql);
		}
		
		public function historialDeEstudiosDelPaciente($idPte) {
			$sql = "SELECT o.idDocumento,o.folioDocto,o.fechaDocto,o.idPaciente,o.edadDelPaciente,o.claveWebDocto,
				o.idCliente,o.folioCte,o.importeDocto,o.observacionDocto,o.publicarResultado,o.idUsuario,
				p.idPaciente,p.nombrePaciente,p.apellidoPaternoPaciente,p.apellidoMaternoPaciente,
				p.nombreCompletoPaciente,p.direccionPaciente,p.genero,p.fechaDeNacimiento,p.edadDelPaciente,p.emailPaciente,p.noIMSS,
				p.cvePaciente,p.passPaciente,p.idCliente,p.altaPaciente,c.idCliente,c.nombreCte,c.rfcCte,c.direccionCte,
				c.serieCte,c.publicarResultados,c.tel1Cte,c.tel2Cte,c.emailCte,c.folioCte,c.logoEnOrden,c.logoEnResultado,c.logoEnReporte
				FROM ordendeestudio o
				JOIN pacientes p ON p.idPaciente = o.idPaciente
				JOIN clientes c ON c.idCliente = o.idCliente
				AND o.idPaciente = '$idPte'
				ORDER BY o.fechaDocto DESC";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		
		/* public function historialDeEstudiosDelPaciente($idPte, $mes, $year) {
			$fecha = $year . "-" . $mes;
			$sql = "SELECT * FROM ordendeestudio
				JOIN pacientes ON pacientes.idPaciente = ordendeestudio.idPaciente
				JOIN clientes ON clientes.idCliente = ordendeestudio.idCliente
				WHERE fechaDocto LIKE '%$fecha%'
				AND publicarResultado = '1'
				AND ordendeestudio.idPaciente = '$idPte'";
			$data = $this->bd->consulta($sql);
			return $data;
		} */
		
		# GET´s
		public function getIdPaciente(){ return $this->idPaciente; }
		public function getNombrePaciente(){ return $this->nombrePaciente; }
		public function getApellidoPaternoPaciente(){ return $this->apellidoPaternoPaciente; }
		public function getApellidoMaternoPaciente(){ return $this->apellidoMaternoPaciente; }
		public function getNombreCompletoPaciente(){ return $this->nombreCompletoPaciente; }
		public function getDireccionPaciente(){ return $this->direccionPaciente; }
		public function getGenero(){ return $this->genero; }
		public function getFechaDeNacimiento(){ return $this->fechaDeNacimiento; }
		public function getEdadDelPaciente(){ return $this->edadDelPaciente; }
		public function getEmailPaciente(){ return $this->emailPaciente; }
		public function getNoIMSS(){ return $this->noIMSS; }
		public function getCvePaciente(){ return $this->cvePaciente; }
		public function getPassPaciente(){ return $this->passPaciente; }
		public function getIdCliente(){ return $this->idCliente; }
		public function getAltaPaciente(){ return $this->altaPaciente; }
		public function getMsj(){ return $this->msj; }
		
		# SET´s
		public function setIdPaciente($str){ $this->idPaciente = $str; }
		public function setNombrePaciente($str){ $this->nombrePaciente = $str; }
		public function setApellidoPaternoPaciente($str){ $this->apellidoPaternoPaciente = $str; }
		public function setApellidoMaternoPaciente($str){ $this->apellidoMaternoPaciente = $str; }
		public function setNombreCompletoPaciente($str){ $this->nombreCompletoPaciente = $str; }
		public function setDireccionPaciente($str){ $this->direccionPaciente = $str; }
		public function setGenero($str){ $this->genero = $str; }
		public function setFechaDeNacimiento($str){ $this->fechaDeNacimiento = $str; }
		public function setEdadDelPaciente($str){ $this->edadDelPaciente = $str; }
		public function setEmailPaciente($str){ $this->emailPaciente = $str; }
		public function setNoIMSS($str){ $this->noIMSS = $str; }
		public function setCvePaciente($str){ $this->cvePaciente = $str; }
		public function setPassPaciente($str){ $this->passPaciente = $str; }
		public function setIdCliente($str){ $this->idCliente = $str; }
		public function setAltaPaciente($str){ $this->altaPaciente = $str; }
		public function setIdPerfil($str) { $this->idPerfil = $str; }
		public function setIdUsuario($str) { $this->idUsuario = $str; }
	}
?>