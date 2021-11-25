<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1); 
	include_once ("cClinicas.php");
	$clin = new Clinicas();
	$clin->bd->setNombreBD("labliste_1");
	
	$mimeFoto = "png";
	$sql = "SELECT imgCedulaDelResponsable FROM clinicas
		WHERE idClinica = '1'";
	
	$query = $clin->bd->consulta($sql);
	$imgCedulaDelResponsable = mysqli_fetch_assoc($query);

	header("Content-type: $mimeFoto");
	header("Content-transfer-encoding: binary");
	echo $imgCedulaDelResponsable['imgCedulaDelResponsable'];
?>