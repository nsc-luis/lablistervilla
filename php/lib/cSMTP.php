<?php
	include_once ("cConectaBD.php");
	
	class SrvSMTP {
		# Declaracion de variables
		private $idSMTP;
		private $nombreUsrMail;
		private $hostSMTP;
		private $userEmail;
		private $passEmail;
		private $portSMTP;
		private $authSMTP;
		private $encriptacionSMTP;
		public $bd;
		private $msj;
		
		#Metodos
		public function __construct(){
			$this->bd = new ConectaBD();
			return $this->bd;
		}
		/* public function listaClinicas(){
			$sql = "SELECT * FROM clinicas
				ORDER BY nombreClinica";
			$data = $this->bd->consulta($sql);
			return $data;
		} */
		public function getInfoSMTP($str){
			$sql = "SELECT * FROM enviosmtp 
				WHERE idSMTP = '$str'";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		public function editarSMTP($str){
			$sql = "UPDATE enviosmtp SET nombreUsrMail = '$this->nombreUsrMail'
				,hostSMTP = '$this->hostSMTP'
				,userEmail = '$this->userEmail'
				,passEmail = '$this->passEmail'
				,portSMTP = '$this->portSMTP'
				,authSMTP = '$this->authSMTP'
				,encriptacionSMTP = '$this->encriptacionSMTP'
				WHERE idSMTP = '$str'";
			$this->bd->consulta($sql);
		}
		/* public function borrarClinica($str){
			
		}
		public function nuevaClinica(){
			
		} */
		
		# GET´s
		public function getIdSMTP(){ return $this->idSMTP; }
		public function getNombreClinica(){ return $this->nombreUsrMail; }
		public function getHostSMTP(){ return $this->hostSMTP; }
		public function getUserEmail(){ return $this->userEmail; }
		public function getPassEmail(){ return $this->passEmail; }
		public function getPortSMTP(){ return $this->portSMTP; }
		public function getAuthSMTP(){ return $this->authSMTP; }
		public function getEncriptacionSMTP(){ return $this->encriptacionSMTP; }
		public function getMsj(){ return $this->msj; }
		
		# SET´s
		public function setIdSMTP($str){ $this->idSMTP = $str; }
		public function setNombreUsrMail($str){ $this->nombreUsrMail = $str; }
		public function setHostSMTP($str){ $this->hostSMTP = $str; }
		public function setUserEmail($str){ $this->userEmail = $str; }
		public function setPassEmail($str){ $this->passEmail = $str; }
		public function setPortSMTP($str){ $this->portSMTP = $str; }
		public function setAuthSMTP($str){ $this->authSMTP = $str; }
		public function setEncriptacionSMTP($str){ $this->encriptacionSMTP = $str; }
		public function setMsj($str){ $this->msj = $str; }
	}
?>