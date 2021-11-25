<?php
	include_once ("cConectaBD.php");
	
	class Usuarios {
		# Declaracion de variables
		private $idUsuario;
		private $cveUsr;
		private $nombreUsr;
		private $passUsr;
		private $direccionUsr;
		private $tel1Usr;
		private $tel2Usr;
		private $emailUsr;
		private $idPerfil;
		private $idPerfilTMP;
		public $bd;
		private $msj;
		
		#Metodos
		public function __construct(){
			$this->bd = new ConectaBD();
			return $this->bd;
		}
		public function listaUsuarios(){
			$filtrarUsuarios = $this->idPerfil == "1" ? "" : "WHERE usuarios.idUsuario = '$this->idUsuario'";
			$sql = "SELECT * FROM usuarios
				JOIN perfiles ON perfiles.idPerfil = usuarios.idPerfil
				$filtrarUsuarios
				ORDER BY nombreUsr";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		public function getInfoUsr($str){
			$sql = "SELECT * FROM usuarios 
				WHERE idUsuario = '$str'";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		public function guardarUsr($str){
			if ($this->idPerfil == "2" && $this->idPerfil != $this->idPerfilTMP) {
				$this->msj = "
					Un usuario \"estandar\" no se puede cambiar él mismo a usuario \"administrador\". <br />
					Se requiere que un usuario \"administrador\" haga este proceso.";
			} else {
				$sql = "UPDATE usuarios SET nombreUsr = '$this->nombreUsr'
				,passUsr = '$this->passUsr'
				,direccionUsr = '$this->direccionUsr'
				,tel1Usr = '$this->tel1Usr'
				,tel2Usr = '$this->tel2Usr'
				,emailUsr = '$this->emailUsr'
				,idPerfil = '$this->idPerfilTMP'
				WHERE idUsuario = '$str'";
				$this->bd->consulta($sql);
			}
		}
		public function borrarUsr($str){
			$sql = "SELECT * FROM usuarios WHERE idUsuario = '$this->idUsuario'";
			$contador = $this->bd->consulta($sql);
			if (mysqli_num_rows($contador) != 0) {
				$this->msj = "No se puede borrar el usuario con el cual iniciate sesión.";
			} else {
				$sql = "DELETE FROM usuarios WHERE idUsuario = '$str'";
				$this->bd->consulta($sql);
			}
		}
		public function guardarNvoUsr(){
			$sql = "SELECT cveUsr FROM usuarios WHERE cveUsr = '$this->cveUsr'";
			$query = $this->bd->consulta($sql);
			if (mysqli_num_rows($query) != 0) {
				$this->msj = "La clave de usuario ya esta ocupada, intenta con otra clave.";
			} else {
				$sql = "INSERT INTO usuarios (cveUsr,nombreUsr,passUsr,direccionUsr,tel1Usr,tel2Usr,emailUsr,idPerfil)
					VALUES ('$this->cveUsr','$this->nombreUsr','$this->passUsr','$this->direccionUsr','$this->tel1Usr','$this->tel2Usr','$this->emailUsr','$this->idPerfil')
				";
				$this->bd->consulta($sql);
			}
		}
		
		# GET´s
		public function getIdUsuario() { return $this->idUsuario; }
		public function getCveUsr() { return $this->cveUsr; }
		public function getNombreUsr() { return $this->nombreUsr; }
		public function getPassUsr() { return $this->passUsr; }
		public function getDireccionUsr() { return $this->direccionUsr; }
		public function getTel1Usr() { return $this->tel1Usr; }
		public function getTel2Usr() { return $this->tel2Usr; }
		public function getEmailUsr() { return $this->emailUsr; }
		public function getIdPerfil() { return $this->idPerfil; }
		public function getMsj(){ return $this->msj; }
		
		# SET´s
		public function setIdUsuario($str) { $this->idUsuario = $str; }
		public function setCveUsr($str) { $this->cveUsr = $str; }
		public function setNombreUsr($str) { $this->nombreUsr = $str; }
		public function setPassUsr($str) { $this->passUsr = $str; }
		public function setDireccionUsr($str) { $this->direccionUsr = $str; }
		public function setTel1Usr($str) { $this->tel1Usr = $str; }
		public function setTel2Usr($str) { $this->tel2Usr = $str; }
		public function setEmailUsr($str) { $this->emailUsr = $str; }
		public function setIdPerfil($str) { $this->idPerfil = $str; }
		public function setIdPerfilTMP($str) { $this->idPerfilTMP = $str; }
		public function setMsj($str){ $this->msj = $str; }
	}
?>