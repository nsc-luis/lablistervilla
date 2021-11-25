<?php
	# Incluir librerias de clases
	session_start();
	if (!$_SESSION['idUsuario']) {
		header("location:http://" . $_SERVER['SERVER_NAME'] . "/laboratorio-lister/index.php");
	}
	error_reporting(E_ALL);
	ini_set("display_errors", 1); 
	chdir ("php/lib");
	require_once("dompdf/dompdf_config.inc.php");
	include_once ("cOrdenDeEstudio.php");
	include_once ("cClinicas.php");
	include_once ("cClientes.php");
	// include_once ("cUsuarios.php");
	
	# Parametros del documento
	$idCliente = $_GET['idCliente'];
	// $idUsuario = $_GET['idUsuario'];
	$fechaInicial = $_GET['fechaInicial'];
	$idClinica = $_SESSION['idClinica'];
	$bd = $_SESSION['bd'];
	
	# Obteniendo datos de la clinica
	$clinica = new Clinicas();
	$clinica->bd->setNombreBD($bd);
	
	$datosDeLaClinica = $clinica->getInfoClinica($idClinica);
	foreach ($datosDeLaClinica as $currentClinica) {
		$nombreClinica = $currentClinica['nombreClinica'];
		$rfcClinica = $currentClinica['rfcClinica'];
		$direccionClinica = $currentClinica['direccionClinica'];
		$coloniaClinica = $currentClinica['coloniaClinica'];
		$mupioClinica = $currentClinica['mupioClinica'];
		$estadoClinica = $currentClinica['estadoClinica'];
		$paisClinica = $currentClinica['paisClinica'];
		$cpClinica = $currentClinica['cpClinica'];
		$tel1Clinica = $currentClinica['tel1Clinica'];
		$emailClinica = $currentClinica['emailClinica'];
		$responsableClinica = $currentClinica['responsableClinica'];
		$cedulaDelResponsable = $currentClinica['cedulaDelResponsable'];
	}
	$clinica->bd->cerrarBD();
	
	# Obteniendo datos del usuario
	/* $usr = new Usuarios();
	$usr->bd->setNombreBD($bd);
	
	$datosUsuario = $usr->getInfoUsr($idUsuario);
	while ($row = mysqli_fetch_assoc($datosUsuario)) {
		$cveUsr = $row['cveUsr'];
		$nombreUsr = $row['nombreUsr'];
	}
	$usr->bd->cerrarBD(); */
	
	# Obteniendo datos del cliente
	$cte = new Clientes();
	$cte->bd->setNombreBD($bd);
	
	$datosCte = $cte->getInfoCte($idCliente);
	while ($row = mysqli_fetch_assoc($datosCte)) {
		$nombreCte = $row['nombreCte'];
	}
	$cte->bd->cerrarBD();
	
	$ods = new OrdenDeEstudio();
	$ods->bd->setNombreBD($bd);
	
	$logo = "/php/lib/blobLogoClinica.php";
	
	# Armando el documento (ENCABEZADO)
	$html = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<title>:: Laboratorios Lister ::</title>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<style>
				@page { margin-top: 180px; margin-bottom: 80px; }
				body { font-family: arial; font-size: 12px; }
				p { margin: 0px; padding: 0px; }
				table { font-family: arial; font-size: 12px; margin: 0px; padding: 0px; width: 100%; }
				table th { color: white; background-color: black }
				table .row { vertical-align: top; border-bottom: 1px solid black; }
				table .importeTotal { font-weigth: bold; color: white; background-color: black; text-align: right; }
				#encabezado { position: fixed; left: 0px; top: -170px; right: 0px; width: 100%; height: 170px; padding-top: 40px;}
				#pieDePagina { position: fixed; left: 0px; bottom: -60px; right: 0px; width: 100%; height: 60px; text-align: center; }
				#pieDePagina .pagina:after { content: counter(page) }
				.alignCenter { text-align: center; }
				hr { page-break-after: always; border: 0; }
			</style>
		</head>
		<body>
			<div id="encabezado">
			<table>
				<tr>
					<td width="20%">
						<img src="http://' . $_SERVER['SERVER_NAME'] . $logo . '" height="95" width="95" />
					</td>
					<td width="80%">
						<strong>' . $nombreClinica . '</strong><br /><br />
						<strong style="text-decoration: underline; ">DIARIO DE RECEPCION DE MUESTRAS A: ' . $fechaInicial . '. </strong><br />
						<strong>Cliente: </strong>' . $nombreCte . '
					</td>
				</tr>
			</table>
			</div>
			<div id="pieDePagina">
				<p class="pagina">Página </p>
			</div>
			<table>
				<tr>
					<th width="10%">FOLIO</th>
					<th width="50%">PACIENTE</th>
					<th width="9%">EDAD</th>
					<th width="21%">EXAMENES A PROCESAR</th>
				</tr>
	';
	
	# Obteniendo lista de ordenes de estudio
	$listaDeOrdenes = $ods->rptEstDiariosxCte($idCliente, $fechaInicial);
	$ordenes = array();
	while ($row = mysqli_fetch_assoc($listaDeOrdenes)) {
		$ordenes[] = $row;
		// echo $row['idDocumento'];
	}
	
	# Obteniendo partidas de cada orden
	$todosLosExamenes = array();
	$examenes = array();
	for ($i=0; $i<count($ordenes); $i++) {
		// $listaExamenes = $ods->partidasDeLaOrden($idCliente, $ordenes[$i]['folioCte']);
		$listaExamenes = $ods->partidasDeLaOrden($ordenes[$i]['folioDocto']);
		while ($row = mysqli_fetch_assoc($listaExamenes)) {
			$examenes[] = $row;
		}
		$ordenes[$i] = $ordenes[$i] + array("examenes"=>$examenes);
		array_push($todosLosExamenes, $examenes);	// Acumula todos los examenes en un solo arreglo para proceso de suma de totales.
		$examenes = "";
	}
	$ods->bd->cerrarBD();
	
	# Armando el documento (IMPRIMIENDO DATOS DE LA ORDEN)
	foreach ($ordenes as $orden) {
		$cte = new Clientes();
		$cte->bd->setNombreBD($bd);
		$datosDelCliente = $cte->getInfoCte($orden['idCliente']);
		while ($row = mysqli_fetch_assoc($datosDelCliente)) {
			$nombreCte = $row['nombreCte'];
		}
		$cte->bd->cerrarBD();
		$html .= '
			<tr>
				<td class="row alignCenter">' . $orden['folioDocto'] . '</td>
				<td class="row">' . $orden['nombreCompletoPaciente'] . '</td>
				<td class="row alignCenter">' . $orden['edadDelPaciente'] . '</td>
				<td class="row">
		';
		
		# Armando el documento (IMPRIMIENDO PARTIDAS DE CADA ORDEN)
		foreach ($orden['examenes'] as $examen) {
			$nombreExamen = $examen['nombreEstudio'] == "" ? $examen['nombrePaquete'] : $examen['nombreEstudio'];
			$html .= $nombreExamen . '<br />';
		}
		$html .= '
				</td>
			</tr>
		';
	}
	
	$html .= '
			</table>
		</body>
		</html>
	';
	
	// echo $html;
	libxml_use_internal_errors(TRUE);
	$dompdf=new DOMPDF();
	$dompdf->load_html($html);
	ini_set("memory_limit","128M");
	$dompdf->render();
	$dompdf->stream("RelacionDiaria_" . $fechaInicial . ".pdf");
?>