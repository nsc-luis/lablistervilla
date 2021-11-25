<?php
	date_default_timezone_set('America/Mexico_City');
	error_reporting(E_ALL);
	ini_set("display_errors", 1); 
	include_once ("cClientes.php");
	$cte = new Clientes();
	$cte->bd->setNombreBD("u462865425_lab");
	
	function randomString($n){
		$caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randstring = '';
		for ($i = 0; $i < $n; $i++) {
			$randstring .= $caracteres[rand(0, strlen($caracteres))];
		}
		return $randstring;
	}
	
	$listaClientes = $cte->listaClientes();
	while ($row = mysqli_fetch_assoc($listaClientes)){
		$cveWebCte = date("Ym") . "-" . randomString(5);
		$passWebCte = randomString(10);
		
		$sql = "UPDATE clientes SET cveWebCte = '$cveWebCte', passWebCte = '$passWebCte'
			WHERE idCliente = '$row[idCliente]'";
		
		echo $sql . "<br />";
		$cte->bd->consulta($sql);
	}
	$cte->bd->cerrarBD();
?>