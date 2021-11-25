<?php
	include_once ("cConectaBD.php");
	
	class Clinicas {
		# Declaracion de variables
		private $idClinica;
		private $nombreClinica;
		private $rfcClinica;
		private $direccionClinica;
		private $coloniaClinica;
		private $mupioClinica;
		private $estadoClinica;
		private $paisClinica;
		private $cpClinica;
		private $tel1Clinica;
		private $emailClinica;
		private $responsableClinica;
		private $cedulaDelResponsable;
		private $logoClinica;
		private $firmaDelResponsable;
		private $imgCedulaDelResponsable;
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
		public function getInfoClinica($str){
			$sql = "SELECT idClinica,nombreClinica,rfcClinica,direccionClinica,coloniaClinica,mupioClinica
				,estadoClinica,paisClinica,cpClinica,tel1Clinica,emailClinica,responsableClinica,cedulaDelResponsable
				FROM clinicas 
				WHERE idClinica = '$str'";
			$query = $this->bd->consulta($sql);
			$data = array();
			while ($row = mysqli_fetch_assoc($query)) {
				$data[] = $row;
			}
			return $data;
		}
		public function editarClinica($str){
			$sql = "UPDATE clinicas SET nombreClinica = '$this->nombreClinica'
				,rfcClinica = '$this->rfcClinica'
				,direccionClinica = '$this->direccionClinica'
				,coloniaClinica = '$this->coloniaClinica'
				,mupioClinica = '$this->mupioClinica'
				,estadoClinica = '$this->estadoClinica'
				,paisClinica = '$this->paisClinica'
				,cpClinica = '$this->cpClinica'
				,emailClinica = '$this->emailClinica'
				,tel1Clinica = '$this->tel1Clinica'
				,responsableClinica = '$this->responsableClinica'
				,cedulaDelResponsable = '$this->cedulaDelResponsable'
				WHERE idClinica = '$str'";
			$this->bd->consulta($sql);
		}
		public function agregarLogoClinica($str) {
			$sql = "UPDATE clinicas SET logoClinica = '$this->logoClinica'
				WHERE idClinica = '$str'";
			$this->bd->consulta($sql);
		}
		public function agregarFirmaDelResponsable($str) {
			$sql = "UPDATE clinicas SET firmaDelResponsable = '$this->firmaDelResponsable'
				WHERE idClinica = '$str'";
			$this->bd->consulta($sql);
		}
		public function agregarImgCedulaDelResponsable($str) {
			$sql = "UPDATE clinicas SET imgCedulaDelResponsable = '$this->imgCedulaDelResponsable'
				WHERE idClinica = '$str'";
			$this->bd->consulta($sql);
		}
		
		# GET´s
		public function getIdClinica(){ return $this->idClinica; }
		public function getNombreClinica(){ return $this->nombreClinica; }
		public function getRfcClinica(){ return $this->rfcClinica; }
		public function getDireccionClinica(){ return $this->direccionClinica; }
		public function getColonicaClinica(){ return $this->coloniaClinica; }
		public function getMupioClinica(){ return $this->mupioClinica; }
		public function getEstadoClinica(){ return $this->estadoClinica; }
		public function getPaisClinica(){ return $this->paisClinica; }
		public function getCPClinica(){ return $this->cpClinica; }
		public function getEmailClinica(){ return $this->emailClinica; }
		public function getTel1Clinica(){ return $this->tel1Clinica; }
		public function getResponsableClinica(){ return $this->responsableClinica; }
		public function getCedulaDelResponsable(){ return $this->cedulaDelResponsable; }
		public function getLogoClinica(){ return $this->logoClinica; }
		public function getImgCedulaDelResponsable(){ return $this->imgCedulaDelResponsable; }
		public function getFirmaDelResponsable(){ return $this->firmaDelResponsable; }
		public function getMsj(){ return $this->msj; }
		
		# SET´s
		public function setIdClinica($str){ $this->idClinica = $str; }
		public function setNombreClinica($str){ $this->nombreClinica = $str; }
		public function setRfcClinica($str){ $this->rfcClinica = $str; }
		public function setDireccionClinica($str){ $this->direccionClinica = $str; }
		public function setColonicaClinica($str){ $this->coloniaClinica = $str; }
		public function setMupioClinica($str){ $this->mupioClinica = $str; }
		public function setEstadoClinica($str){ $this->estadoClinica = $str; }
		public function setPaisClinica($str){ $this->paisClinica = $str; }
		public function setCPClinica($str){ $this->cpClinica = $str; }
		public function setEmailClinica($str){ $this->emailClinica = $str; }
		public function setTel1Clinica($str){ $this->tel1Clinica = $str; }
		public function setResponsableClinica($str){ $this->responsableClinica = $str; }
		public function setCedulaDelResponsable($str){ $this->cedulaDelResponsable = $str; }
		public function setLogoClinica($str){ $this->logoClinica = $str; }
		public function setImgCedulaDelResponsable($str){ $this->imgCedulaDelResponsable = $str; }
		public function setFirmaDelResponsable($str){ $this->firmaDelResponsable = $str; }
		public function setMsj($str){ $this->msj = $str; }
	}
?>