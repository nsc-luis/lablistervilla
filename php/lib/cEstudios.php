<?php
	include_once ("cConectaBD.php");
	
	class Estudios {
		# Declaracion de variables
		private $idEstudio;
		private $cveEstudio;
		private $nombreEstudio;
		private $precioEstudio;
		private $limiteInferiorEstudio;
		private $limiteSuperiorEstudio;
		private $unidadDeMedida;
		private $tipoDeParametro;
		private $valorDeReferencia;
		public $bd;
		private $msj;
		
		#Metodos
		public function __construct(){
			$this->bd = new ConectaBD();
			return $this->bd;
		}
		
		/* FUNCIONES PARA ESTUDIOS */
		public function listaEstudios(){
			$sql = "SELECT * FROM estudios
				ORDER BY nombreEstudio";
			$data = $this->bd->consulta($sql);
			return $data;
		}
		public function getInfoEstudio($str){
			$sql = "SELECT * FROM estudios
				WHERE idEstudio = '$str'";
			$info = mysqli_fetch_assoc($this->bd->consulta($sql));
			$data = array();
			while ($row = $info) {
				$data[] = $row;
			}
			return $data;
		}
		public function editaEstudio($str){
			$sql = "UPDATE estudios SET cveEstudio = '$this->cveEstudio'
				,nombreEstudio = '$this->nombreEstudio'
				,limiteInferiorEstudio = '$this->limiteInferiorEstudio'
				,limiteSuperiorEstudio = '$this->limiteSuperiorEstudio'
				,unidadDeMedida = '$this->unidadDeMedida'
				,tipoDeParametro = '$this->tipoDeParametro'
				,valorDeReferencia = '$this->valorDeReferencia'
				WHERE idEstudio = '$str'";
			$this->bd->consulta($sql);
		}
		public function borraEstudio($str){
			$sql1 = "SELECT * FROM ordendeestudio_detalle WHERE idEstudio = '$str'";
			$sql2 = "SELECT * FROM paquetesdeestudios_detalle WHERE idEstudio = '$str'";
			$contador1 = mysqli_num_rows($this->bd->consulta($sql1));
			$contador2 = mysqli_num_rows($this->bd->consulta($sql2));
			if ($contador1 > 0 || $contador2 > 0) {
				$this->msj = "No se puede eliminar el estudio porque tiene movimientos <br />";
				$this->msj .="o pertenece a algun paquete de estudios.";
			} else {
				$sql = "DELETE FROM estudios WHERE idEstudio = '$str'";
				$this->bd->consulta($sql);
			}
		}
		public function nuevoEstudio(){
			$sql = "SELECT * FROM estudios WHERE cveEstudio = '$this->cveEstudio'";
			$contador = mysqli_num_rows($this->bd->consulta($sql));
			if ($contador > 0) {
				$this->msj = "La clave del estudio ya existe, intente otra diferente.";
			} else {			
				$sql = "INSERT INTO estudios (cveEstudio,nombreEstudio,
				limiteInferiorEstudio,limiteSuperiorEstudio
				,unidadDeMedida,tipoDeParametro,valorDeReferencia) 
				VALUES ('$this->cveEstudio'
				,'$this->nombreEstudio'
				,'$this->limiteInferiorEstudio'
				,'$this->limiteSuperiorEstudio'
				,'$this->unidadDeMedida'
				,'$this->tipoDeParametro'
				,'$this->valorDeReferencia')";
				$this->bd->consulta($sql);
			}
		}
		
		# GET´s
		public function getIdEstudio(){ return $this->idEstudio; }
		public function getCveEstudio(){ return $this->cveEstudio; }
		public function getNombreEstudio(){ return $this->nombreEstudio; }
		public function getPrecioEstudio(){ return $this->precioEstudio; }
		public function getLimiteInferiorEstudio(){ return $this->limiteInferiorEstudio; }
		public function getLimiteSuperiorEstudio(){ return $this->limiteSuperiorEstudio; }
		public function getUnidadDeMedida(){ return $this->unidadDeMedida; }
		public function getTipoDeParametro(){ return $this->tipoDeParametro; }
		public function getValorDeReferencia(){ return $this->valorDeReferencia; }
		public function getMsj(){ return $this->msj; }
		
		# SET´s
		public function setIdEstudio($str){ $this->idEstudio = $str; }
		public function setCveEstudio($str){ $this->cveEstudio = $str; }
		public function setNombreEstudio($str){ $this->nombreEstudio = $str; }
		public function setPrecioEstudio($str){ $this->precioEstudio = $str; }
		public function setLimiteInferiorEstudio($str){ $this->limiteInferiorEstudio = $str; }
		public function setLimiteSuperiorEstudio($str){ $this->limiteSuperiorEstudio = $str; }
		public function setUnidadDeMedida($str){ $this->unidadDeMedida = $str; }
		public function setTipoDeParametro($str){ $this->tipoDeParametro = $str; }
		public function setValorDeReferencia($str){ $this->valorDeReferencia = $str; }
	}
?>