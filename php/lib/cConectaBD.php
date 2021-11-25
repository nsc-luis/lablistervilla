<?php
	/* CLASE PARA LA CONEXION DE PHP CON MYSQL */
	class ConectaBD {
		#Declaracion de variables
		private $bdHost = "localhost:3306";
		private $bdUsr = "lister";
		private $bdPass = "*cUZ73dsb%U";
		private $nombreBD;
		private $conexion;
		
		# Metodos de la clase conectaDB
		public function __construct()
		{
			$this->conexion = mysqli_connect($this->bdHost, $this->bdUsr, $this->bdPass);
			return $this->conexion;
		}
		public function consulta($str) {
			mysqli_set_charset($this->conexion,"utf8");
			$query = mysqli_query($this->conexion, $str);
			return $query;
		}
		public function cerrarBD()
		{
			mysqli_close($this->conexion);
		}
		
		# GET's
		public function getNombreBD() { return $this->nombreBD; }
		public function getConexion() { return $this->conexion; }
		public function getBdUsr() { return $this->bdUsr; }
		public function getBdPass() { return $this->bdPass; }
		public function getBdHost() { return $this->bdHost; }
		
		#SET's
		public function setNombreBD($str)
		{
			$this->nombreBD = $str;
			mysqli_select_db($this->conexion, $str);
		}
	}//fin clase
?>
