<?php
	include_once ("cConectaBD.php");
	
	class Paquetes {
		# Declaracion de variables
		private $idPaquete;
		private $nombrePaquete;
		private $cvePaquete;
		private $idEstudio;
		//private $estudiosIncluidos;
		public $bd;
		private $msj;
		
		#Metodos
		public function __construct(){
			$this->bd = new ConectaBD();
			return $this->bd;
		}
		public function listaPaquetes(){
			$sql = "SELECT * FROM paquetesdeestudios
				ORDER BY nombrePaquete";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		public function getInfoPaquete($str){
			$sql = "SELECT * FROM paquetesdeestudios
				INNER JOIN paquetesdeestudios_detalle ON paquetesdeestudios_detalle.idPaquete = paquetesdeestudios.idPaquete
				WHERE paquetesdeestudios.idPaquete = '$str'";
			$datos = mysqli_fetch_assoc($this->bd->consulta($sql));
			$this->idPaquete = $datos['idPaquete'];
			$this->cvePaquete = $datos['cvePaquete'];
			$this->idEstudio = $datos['idEstudio'];
			$this->nombrePaquete = $datos['nombrePaquete'];
		}
		public function estudiosAgregadosAlPaquete($str){
			$sql = "SELECT * FROM paquetesdeestudios_detalle
				JOIN estudios ON estudios.idEstudio = paquetesdeestudios_detalle.idEstudio
				WHERE idPaquete = '$str'
				ORDER BY idPdE_detalle ASC";
			/* $sql = "SELECT * FROM estudios 
				WHERE idEstudio IN 
					(SELECT idEstudio FROM paquetesdeestudios_detalle 
					WHERE idPaquete = '$str')"; */
			$data = $this->bd->consulta($sql);
			return $data;
		}
		public function estudiosPorAgregarAlPaquete($str){
			$sql = "SELECT * FROM estudios 
				WHERE idEstudio NOT IN 
					(SELECT idEstudio FROM paquetesdeestudios_detalle 
					WHERE idPaquete = '$str')";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		public function agregarEstudioAlPaquete($str1,$str2){
			/* $sql = "SELECT * FROM paquetesdeestudios_detalle 
			WHERE idPaquete = '$str1' AND idEstudio = '$str2'";
			$contador = mysqli_num_rows($this->bd->consulta($sql));
			if ($contador > 0) {
				echo "Ya existe este estudio en el paquete.";
			} else {
				$sql = "INSERT INTO paquetesdeestudios_detalle (idPaquete,idEstudio)
					VALUES ('$str1','$str2')";
				$this->bd->consulta($sql);
			} */
			$sql = "INSERT INTO paquetesdeestudios_detalle (idPaquete,idEstudio)
				VALUES ('$str1','$str2')";
			$this->bd->consulta($sql);
		}
		public function borrarEstudioDelPaquete($str1,$str2){
			/*$sql = "SELECT * FROM ordendeestudio_detalle 
			WHERE idEstudio = '$str2'";
			$contador = mysqli_num_rows($this->bd->consulta($sql));
			if ($contador > 0) {
				echo "No se puede borrar estudio porque el paquete tiene movimientos";
			} else {
				$sql = "DELETE FROM paquetesdeestudios_detalle
				WHERE idPaquete = '$str1' AND idEstudio = '$str2'";
				$this->bd->consulta($sql);
			} */
			$sql = "DELETE FROM paquetesdeestudios_detalle
				WHERE idPaquete = '$str1' AND idEstudio = '$str2'";
			$this->bd->consulta($sql);
		}
		
		public function guardarPaquete($str){
			$sql = "SELECT * FROM paquetesdeestudios WHERE cvePaquete = '$this->cvePaquete'";
			$contador = mysqli_num_rows($this->bd->consulta($sql));
			if ($contador > 0) {
				$this->msj = "La clave del paquete ya existe, intente otra diferente.";
			} else {
				$sql = "UPDATE paquetesdeestudios SET nombrePaquete = '$this->nombrePaquete'
				,cvePaquete = '$this->cvePaquete'
				WHERE idPaquete = '$str'";
				$this->bd->consulta($sql);
			}
		}
		public function borrarPaquete($str){
			$sql = "SELECT * FROM ordendeestudio_detalle WHERE idPaquete = '$str'";
			$contador = mysqli_num_rows($this->bd->consulta($sql));
			if ($contador > 0) {
				$this->msj = "No se puede eliminar un paquete que tiene movimientos.";
			} else {
				$sql = "DELETE FROM paquetesdeestudios WHERE idPaquete = '$str'";
				$this->bd->consulta($sql);
				$sql = "DELETE FROM paquetesdeestudios_detalle WHERE idPaquete = '$str'";
				$this->bd->consulta($sql);
			}
		}
		public function nuevoPaquete(){
			$sql = "SELECT * FROM paquetesdeestudios WHERE cvePaquete = '$this->cvePaquete'";
			$contador = mysqli_num_rows($this->bd->consulta($sql));
			if ($contador > 0) {
				$this->msj = "La clave del paquete ya existe, intente otra diferente.";
			} else {
				$sql = "INSERT INTO paquetesdeestudios (nombrePaquete, cvePaquete) 
				VALUES ('$this->nombrePaquete'
				,'$this->cvePaquete')";
				$this->bd->consulta($sql);
			}
		}
		
		# GET´s
		public function getIdPaquete(){ return $this->idPaquete; }
		public function getNombrePaquete(){ return $this->nombrePaquete; }
		public function getCvePaquete(){ return $this->cvePaquete; }
		//public function getEstudiosIncluidos(){ return $this->estudiosIncluidos; }
		public function getMsj(){ return $this->msj; }
		
		# SET´s
		public function setNombrePaquete($str){ $this->nombrePaquete = $str; }
		public function setCvePaquete($str){ $this->cvePaquete = $str; }
		//public function setEstudiosIncluidos($str){ $this->estudiosIncluidos = $str; }
	}
?>