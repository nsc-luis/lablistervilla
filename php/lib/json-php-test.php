<?php
	include_once ("cOrdenDeEstudio.php");
	$ods = new OrdenDeEstudio();
	$ods->bd->setNombreBD('laboratorio_lister');
	
	$ods->setFolioDocto('1');
	$paquetesParaCapturaDeResultados= $ods->paquetesParaCapturaDeResultados();
	
	$paquetes = array();
	if (mysqli_num_rows($paquetesParaCapturaDeResultados) !=0) {
		while ($row = mysqli_fetch_assoc($paquetesParaCapturaDeResultados)) {
			$paquetes[] = $row;
		}
	}
	
	$estudios = array();
	for ($i = 0; $i < count($paquetes); $i++) {
	
		$ods->setCvePaquete($paquetes[$i]['cvePaquete']);
		$estudiosParaCapturaDeResultados = $ods->estudiosParaCapturaDeResultados();
		
		if (mysqli_num_rows($estudiosParaCapturaDeResultados) !=0) {
			while ($row = mysqli_fetch_assoc($estudiosParaCapturaDeResultados)) {
				$estudios[] = $row;
			}
		}
		$paquetes[$i] = $paquetes[$i] + array("estudios"=>$estudios);
		$estudios = "";
	}
	
	echo "<pre>";
	print_r($paquetes);
	echo "</pre> <hr />";
	
	echo $info_json = json_encode($paquetes);
	
	echo "<hr /><br/><br/>";
	
	$test = json_decode($info_json, true);
	echo $test[1]['estudios'][1]['nombreEstudio'];
	
?>