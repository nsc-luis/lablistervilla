<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1); 
	include_once ("cClientes.php");
	$cte = new Clientes();
	$cte->bd->setNombreBD("labliste_1");
	
	$idCliente = $_GET['idCliente'];
	
	$mimeFoto = "png";
	$sql = "SELECT logoCte FROM clientes
		WHERE idCliente = '$idCliente'";
	
	$query = $cte->bd->consulta($sql);
	$logoCte = mysqli_fetch_assoc($query);

	header("Content-type: $mimeFoto");
	header("Content-transfer-encoding: binary");
	echo $logoCte['logoCte'];
?>