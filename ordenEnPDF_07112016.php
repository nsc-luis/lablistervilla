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
	
	# Parametros del documento
	$claveWebDocto = $_GET['cveWeb'];
	$idClinica = "1";
	$bd = "u462865425_lab";
	
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
	
	# Obteniendo datos de la orden/paciente
	$ods = new OrdenDeEstudio();
	$ods->bd->setNombreBD($bd);
	
	$datosDeLaOrden = $ods->ordenEnPDF($claveWebDocto);
	while ($row = mysqli_fetch_assoc($datosDeLaOrden)) {
		$folioCte = $row['folioCte'];
		$claveWebDocto = $row['claveWebDocto'];
		$fechaDocto = $row['fechaDocto'];
		$observacionDocto = $row['observacionDocto'];
		$publicarResultado = $row['publicarResultado'];
		$nombreCompletoPaciente = $row['nombreCompletoPaciente'];
		$noIMSS = $row['noIMSS'];
		$genero = $row['genero'];
		$emailPaciente = $row['emailPaciente'];
		$edadDelPaciente = $row['edadDelPaciente'];
		$idCliente = $row['idCliente'];
		$importeDocto = $row['importeDocto'];
		// $nombreCte = $row['nombreCte'];
	}
	
	# Obteniendo datos del cliente
	$cte = new Clientes();
	$cte->bd->setNombreBD($bd);
	
	$datosDelCliente = $cte->getInfoCte($idCliente);
	while ($row = mysqli_fetch_assoc($datosDelCliente)) {
		$rfcCte = $row['rfcCte'];
		$direccionCte = $row['direccionCte'];
		$nombreCte = $row['nombreCte'];
		$tel1Cte = $row['tel1Cte'];
		$emailCte = $row['emailCte'];
	}
	$cte->bd->cerrarBD();
	
	# Estudio y paquetes incluidos en la orden
	$partidasDeLaOrden = $ods->partidasDeLaOrden($idCliente, $folioCte);
	$partidas = array();
	if (mysqli_num_rows($partidasDeLaOrden) !=0) {
		while ($row = mysqli_fetch_assoc($partidasDeLaOrden)) {
			$partidas[] = $row;
		}
	}
	
	# Armando el documento
	$html = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<title>:: Laboratorios Lister ::</title>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<style>
				@page { margin-top: 290px; margin-bottom: 80px; }
				body { font-family: arial; font-size: 12px; }
				p { margin: 0px; padding: 0px; }
				table { font-family: arial; font-size: 12px; margin: 0px; padding: 0px; width: 100%; }
				.titulo1 { text-decoration: underline; font-style: italic; font-weight: bold; }
				.titulo2 { font-size: 14px; font-weight: bold; margin-top: 0px; padding: 0px; letter-spacing: 20px; width: 100%; background-color: black; color: white; clear: both; text-align: center; display: block}
				.titulo3 { font-style: italic; font-weight: bold; font-size: 14px; font-family: monospace; }
				table .tdEstudio { border-bottom: 1px solid black; font-family: monospace; }
				#encabezado { position: fixed; left: 0px; top: -280px; right: 0px; width: 100%; height: 280px; padding-top: 40px; }
				#pieDePagina { position: fixed; left: 0px; bottom: -60px; right: 0px; width: 100%; height: 60px; text-align: center; }
				#pieDePagina .pagina:after { content: counter(page) }
				#datosDeLaOrden { width: 49%; }
				#datosDelCliente { width: 49%; }
				#observacionDocto { width: 100%; margin: 20px 0 20px 0; }
				#responsable { border: 1px solid black; width: 80%; margin: auto; padding: 15px; }
			</style>
		</head>
		<body>
			<div id="encabezado">
			<table>
				<tr>
					<td width="20%">
						<img src="../../images/logo_tmp.png" />
					</td>
					<td width="80%">
						<strong>' . $nombreClinica . '</strong><br />
						' . $direccionClinica . ', ' . $coloniaClinica . ' C.P.: ' . $cpClinica . '<br />
						' . $mupioClinica . ', ' . $estadoClinica . ', ' . $paisClinica . '<br />
						Tel: ' . $tel1Clinica . ' e-mail: ' . $emailClinica . '<br />
						R.F.C: ' . $rfcClinica . '
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td id="datosDeLaOrden">
						<span class="titulo1">Datos de la orden / paciente </span><br />
						<strong>Folio: </strong>' . $folioCte . '   <strong>Clave web: </strong>' . $claveWebDocto . '<br />
						<strong>Paciente: </strong> ' . $nombreCompletoPaciente . '<br />
						<strong>Numero de seguro social (IMSS): </strong> ' . $noIMSS . '<br />
						<strong>Edad del paciente: </strong> ' . $edadDelPaciente . ' <strong>Genero: </strong> ' . $genero . '<br />
						<strong>e-mail del paciente: </strong> ' . $emailPaciente . '<br />
						<strong>Fecha de la orden: </strong> ' . $fechaDocto . '
					</td>
					<td id="datosDelCliente">
						<span class="titulo1">Datos del cliente </span><br />
						<strong>Nombre del cliente: </strong> ' . $nombreCte . '<br />
						<strong>Direccion cliente: </strong> ' . $direccionCte . '<br />
						<strong>e-mail: </strong> ' . $emailCte . '<br />
						<strong>Tel: </strong> ' . $tel1Cte . '<br />
						<strong>R.F.C.: </strong> ' . $rfcCte . '
					</td>
				<tr>
			</table>
			<span class="titulo2">FOLIO: ' . $folioCte . '</span>
			<table>
				<tr>
					<th width="15%">Clave</th>
					<th width="45%">Estudio / Paquete</th>
					<th width="15%">Tipo de examen</th>
					<th width="25%">Precio</th>
				</tr>
			</table>
			</div>
			<div id="pieDePagina">
				<p class="pagina">Página </p>
			</div>
			<table>
	';
	foreach ($partidas as $partida) {
		if ($partida['tipoExamen'] == "Estudio") {
			$descipcion = $partida['nombreEstudio'];
			$clave = $partida['cveEstudio'];
		} else {
			$descipcion = $partida['nombrePaquete'];
			$clave = $partida['cvePaquete'];
		}
		$html .= '
			<tr>
				<td class="tdEstudio" style="text-align: center;">' . $clave . '</td>
				<td class="tdEstudio" style="text-align: left;">' . $descipcion . '</td>
				<td class="tdEstudio" style="text-align: center;">' . $partida['tipoExamen'] . '</td>
				<td class="tdEstudio" style="text-align: right;">' . $partida['precio'] . '</td>
			</tr>
		';
	}
	$html .= '
			<tr>
				<td></td>
				<td></td>
				<td style="text-align: right;font-size:16;">TOTAL</td>
				<td style="text-align: right;font-size:16;">' . $importeDocto . '</td>
			</tr>
		</table>
		<br /><br />
		<span style="letter-spacing: 10px;">***NOTA***</span><br />
		Resultados a partir de las 16:00 horas.
	';
	
	$ods->bd->cerrarBD();
	
	//echo $html;
	libxml_use_internal_errors(TRUE);
	$dompdf=new DOMPDF();
	$dompdf->load_html($html);
	ini_set("memory_limit","128M");
	$dompdf->render();
	$dompdf->stream("folio-" . $folioDocto . ".pdf");
?>